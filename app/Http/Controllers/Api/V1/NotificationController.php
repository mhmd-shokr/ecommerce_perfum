<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Customer\NotificationResource;
use App\Servicies\NotificationService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    use ApiResponse;
    public function __construct(protected NotificationService $notificationService)
    {
    }

    public function index(Request $request)
    {
        $notifications = $this->notificationService->getNotifications(
            Auth::id(),
            $request->integer('per_page', 10)
        );

        return $this->successResponse(
            NotificationResource::collection($notifications),
            'Notifications retrieved successfully.'
        );
    }

    public function unread(Request $request)
    {
        $notifications = $this->notificationService->getUnreadNotifications(
            Auth::id(),
            $request->integer('per_page', 10)
        );

        return $this->successResponse(
            NotificationResource::collection($notifications),
            'Unread notifications retrieved successfully.'
        );
    }

    public function markAsRead(string $notification)
    {
        $this->notificationService->markAsRead(
            Auth::id(),
            $notification
        );

        return $this->successResponse(
            null,
            'Notification marked as read.'
        );
    }

    public function markAllAsRead()
    {
        $this->notificationService->markAllAsRead(
            Auth::id()
        );

        return $this->successResponse(
            null,
            'All notifications marked as read.'
        );
    }

    public function destroy(string $notification)
    {
        $this->notificationService->delete(
            Auth::id(),
            $notification
        );

        return $this->successResponse(
            null,
            'Notification deleted successfully.'
        );
    }
}
