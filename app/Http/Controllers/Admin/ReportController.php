<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Payment;

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
        // Query financial data
        $totalRevenue = Payment::whereBetween('payment_date', [$startDate, $endDate])
            ->where('status', 'success')
            ->sum('amount');

        $payments = Payment::whereBetween('payment_date', [$startDate, $endDate])
            ->get()
            ->groupBy('status');

        return [
            'total_revenue' => $totalRevenue,
            'payment_statuses' => $payments->map->count(),
            'transactions' => $payments->flatten()
        ];
    }

    // Add similar methods for booking and user reports

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