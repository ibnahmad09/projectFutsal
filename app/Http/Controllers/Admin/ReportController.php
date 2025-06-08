<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Payment;
use App\Models\Booking;

class ReportController extends Controller
{
    public function create()
    {
        $recentReports = Report::latest()->take(5)->get();
        return view('admin.reports.create', compact('recentReports'));

    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:financial,booking,user',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'format' => 'required|in:pdf,excel,csv'
        ]);

        // Generate report data based on type
        $reportData = $this->generateReportData($request->type, $request->start_date, $request->end_date);

        // Save report to database
        $report = Report::create([
            'title' => $request->title,
            'type' => $request->type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'content' => $reportData,
        ]);

        // Generate PDF if selected
        if ($request->format === 'pdf') {
            $pdf = \PDF::loadView('admin.reports.pdf', [
                'report' => $report,
                'data' => $reportData
            ]);

            // Save PDF to storage
            $fileName = 'report_'.$report->id.'_'.time().'.pdf';
            $filePath = 'reports/'.$fileName;
            Storage::put($filePath, $pdf->output());

            // Update report with file path
            $report->update(['file_path' => $filePath]);

            return $pdf->download($fileName);
        }

        return redirect()->route('admin.reports.index')
            ->with('success', 'Report generated successfully');
    }

    private function generateReportData($type, $startDate, $endDate)
    {
        switch ($type) {
            case 'financial':
                return $this->generateFinancialReport($startDate, $endDate);
            case 'booking':
                return $this->generateBookingReport($startDate, $endDate);
            case 'user':
                return $this->generateUserReport($startDate, $endDate);
            default:
                return [];
        }
    }

    private function generateFinancialReport($startDate, $endDate)
    {
        // Hitung total revenue dari payments (booking online)
        $onlineRevenue = Payment::whereBetween('payment_date', [$startDate, $endDate])
            ->where('status', 'success')
            ->sum('amount');

        // Hitung total revenue dari booking manual
        $manualRevenue = Booking::whereBetween('booking_date', [$startDate, $endDate])
            ->where('is_manual_booking', true)
            ->where('status', 'confirmed')
            ->sum('total_price');

        // Total revenue adalah jumlah dari kedua sumber
        $totalRevenue = $onlineRevenue + $manualRevenue;

        // Ambil semua transaksi untuk detail
        $payments = Payment::whereBetween('payment_date', [$startDate, $endDate])
            ->get()
            ->groupBy('status');

        // Tambahkan booking manual ke dalam transaksi
        $manualBookings = Booking::whereBetween('booking_date', [$startDate, $endDate])
            ->where('is_manual_booking', true)
            ->where('status', 'confirmed')
            ->get()
            ->map(function($booking) {
                return (object)[
                    'payment_date' => $booking->booking_date,
                    'amount' => $booking->total_price,
                    'status' => 'success',
                    'is_manual' => true
                ];
            });

        // Gabungkan transaksi online dan manual
        $allTransactions = $payments->flatten()->concat($manualBookings);

        return [
            'total_revenue' => $totalRevenue,
            'online_revenue' => $onlineRevenue,
            'manual_revenue' => $manualRevenue,
            'payment_statuses' => $payments->map->count(),
            'transactions' => $allTransactions->sortByDesc('payment_date')
        ];
    }

    private function generateBookingReport($startDate, $endDate)
    {
        // Query data booking
        $totalBookings = Booking::whereBetween('booking_date', [$startDate, $endDate])->count();

        // Query field paling populer
        $mostPopularField = Booking::whereBetween('booking_date', [$startDate, $endDate])
            ->select('field_id', \DB::raw('count(*) as total'))
            ->groupBy('field_id')
            ->orderByDesc('total')
            ->first();

        // Hitung total revenue dari payments (booking online)
        $onlineRevenue = Payment::whereBetween('payment_date', [$startDate, $endDate])
        ->where('status', 'success')
        ->sum('amount');

        // Hitung total revenue dari booking manual
        $manualRevenue = Booking::whereBetween('booking_date', [$startDate, $endDate])
            ->where('is_manual_booking', true)
            ->where('status', 'confirmed')
            ->sum('total_price');


        // Query total revenue dari booking
        $totalRevenue = $totalRevenue = $onlineRevenue + $manualRevenue;

        return [
            'total_bookings' => $totalBookings,
            'most_popular_field' => $mostPopularField ? $mostPopularField->field->name : 'Tidak ada data',
            'total_revenue' => $totalRevenue,
            'online_revenue' => $onlineRevenue,
            'manual_revenue' => $manualRevenue,
        ];
    }

    // Add similar methods for user reports

    public function index()
    {
        $reports = Report::latest()->paginate(10);
        return view('admin.reports.index', compact('reports'));
    }

    public function show(Report $report)
    {
        return view('admin.reports.show', compact('report'));
    }

    public function destroy(Report $report)
    {
        // Hapus file report jika ada
        if ($report->file_path && file_exists(public_path($report->file_path))) {
            unlink(public_path($report->file_path));
        }

        $report->delete();

        return redirect()->route('admin.reports.index')
            ->with('success', 'Report berhasil dihapus');
    }
}