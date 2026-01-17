<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetReportRequest;
use App\Services\ReportService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function index(GetReportRequest $request)
    {
        $data = $this->reportService->getDashboardData($request->validated());
        
        return view('admin.reports.index', [
            'data' => $data,
            'filters' => $request->validated()
        ]);
    }
}
