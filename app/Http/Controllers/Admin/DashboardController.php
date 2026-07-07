<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Servicies\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(protected DashboardService $dashboardService)
    {
    }
    public function index()
{
    $data = $this->dashboardService->getDashboardData();

    return view('admin.dashboard', compact('data'));
}
}
