<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index()
    {
        try {
            $pageTitle = 'Dashboard';
            $sales = DB::table('orders')
                ->select(
                    DB::raw('DATE(created_at) as date'),
                    DB::raw('SUM(total_amount) as total')
                )
                ->where('status', 'paid')
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            $labels = $sales->pluck('date');
            $data = $sales->pluck('total');

            return view('dashboard.index', compact('labels', 'data', 'pageTitle'));
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
