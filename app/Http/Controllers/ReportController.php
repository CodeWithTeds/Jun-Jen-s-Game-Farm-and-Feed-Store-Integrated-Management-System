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
        $filters = $request->validated();
        if (isset($filters['period'])) {
            if ($filters['period'] === 'today') {
                $filters['date_from'] = now()->startOfDay()->toDateString();
                $filters['date_to'] = now()->endOfDay()->toDateString();
            } elseif ($filters['period'] === 'this_month') {
                $filters['date_from'] = now()->startOfMonth()->toDateString();
                $filters['date_to'] = now()->endOfMonth()->toDateString();
            } elseif ($filters['period'] === 'this_year') {
                $filters['date_from'] = now()->startOfYear()->toDateString();
                $filters['date_to'] = now()->endOfYear()->toDateString();
            }
        }

        $data = $this->reportService->getDashboardData($filters);
        
        return view('admin.reports.index', [
            'data' => $data,
            'filters' => $filters
        ]);
    }

    public function export(GetReportRequest $request)
    {
        $filters = $request->validated();
        if (isset($filters['period'])) {
            if ($filters['period'] === 'today') {
                $filters['date_from'] = now()->startOfDay()->toDateString();
                $filters['date_to'] = now()->endOfDay()->toDateString();
            } elseif ($filters['period'] === 'this_month') {
                $filters['date_from'] = now()->startOfMonth()->toDateString();
                $filters['date_to'] = now()->endOfMonth()->toDateString();
            } elseif ($filters['period'] === 'this_year') {
                $filters['date_from'] = now()->startOfYear()->toDateString();
                $filters['date_to'] = now()->endOfYear()->toDateString();
            }
        }

        $data = $this->reportService->getDashboardData($filters);

        return response()->streamDownload(function () use ($data) {
            $file = fopen('php://output', 'w');

            // Sales Summary
            fputcsv($file, ['Sales Summary']);
            fputcsv($file, ['Total Sales', 'Total Orders', 'Average Order Value']);
            fputcsv($file, [
                $data['sales_report']['total_sales'],
                $data['sales_report']['total_orders'],
                $data['sales_report']['average_order_value']
            ]);
            fputcsv($file, []);

            // Top Products
            fputcsv($file, ['Top Selling Products']);
            fputcsv($file, ['Product Name', 'Quantity Sold', 'Revenue']);
            foreach ($data['top_products'] as $product) {
                fputcsv($file, [
                    $product->feed->feed_name ?? 'Unknown',
                    $product->total_quantity,
                    $product->total_revenue
                ]);
            }
            fputcsv($file, []);

            // Top Chickens
            fputcsv($file, ['Top Selling Chickens']);
            fputcsv($file, ['Chicken Name', 'Quantity Sold', 'Revenue']);
            foreach ($data['top_chickens'] as $chicken) {
                fputcsv($file, [
                    $chicken->gameFowl->name ?? 'Unknown',
                    $chicken->total_quantity,
                    $chicken->total_revenue
                ]);
            }
            fputcsv($file, []);

            // Inventory
            fputcsv($file, ['Inventory Summary']);
            fputcsv($file, ['Total Products', 'Low Stock', 'Out of Stock', 'Total Inventory Value']);
            fputcsv($file, [
                $data['inventory_summary']['total_products'],
                $data['inventory_summary']['low_stock'],
                $data['inventory_summary']['out_of_stock'],
                $data['inventory_summary']['total_inventory_value']
            ]);

            fclose($file);
        }, 'dashboard_summary_report_' . date('Y-m-d_H-i-s') . '.csv');
    }
}
