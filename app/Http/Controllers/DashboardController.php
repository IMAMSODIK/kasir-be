<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'pageTitle' => 'Dashboard'
        ];

        try {

            return view('dashboard.index', $data);
        } catch (Exception $e) {
            return redirect('/dashboard')->with('error', $e->getMessage());
        }
    }
}
