<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\DashboardResource;
use App\Servicies\DashboardService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use ApiResponse;

    public function __construct(
        protected DashboardService $dashboardService
    ) {}

    public function index()
    {
        return $this->successResponse(
            new DashboardResource(
                $this->dashboardService->getDashboardData()
            ),
            'Dashboard retrieved successfully.'
        );
    }
}
