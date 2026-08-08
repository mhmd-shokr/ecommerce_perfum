<?php
namespace App\Repositries;

use App\Interfaces\NotificationInterface;
use App\Models\User;
use Override;

class NotificationRepository implements NotificationInterface{

    #[Override]
    public function getUserNotifications(int $userId, int $perPage = 10)
    {
        return User::findOrFail($userId)->Notifications()->latest()->paginate($perPage);
    }
    
    public function getUnreadNotifications(int $userId,int $perPage=10){
        return User::findOrFail($userId)->unreadNotifications()->latest()->paginate($perPage);
    }

    #[Override]
    public function markAsRead(int $userId, string $notificationId): bool
    {
        $notification=user::findOrFail($userId)->notifications()->
        where('id',$notificationId)->firstOrFail();

        $notification->markAsRead();
        return true;
    }

    public function markAllAsRead(int $userId): int
    {
        return user::findOrFail($userId)->notifications()->update([
            'read_at'=>now(),
        ]);
    }

    public function delete(int $userId, string $notificationId): bool
{
    return User::findOrFail($userId)
        ->notifications()
        ->where('id', $notificationId)
        ->delete();
}
}