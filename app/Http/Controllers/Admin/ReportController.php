<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function create()
    {
        $recentReports = Report::latest()->take(5)->get();
        return view('admin.report', compact('recentReports'));

    }

    public function store(Request $request)
    {
        // Validasi dan logika untuk generate report
    }

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