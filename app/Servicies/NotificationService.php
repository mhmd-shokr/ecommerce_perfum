<?php
namespace App\Servicies;

use App\Interfaces\NotificationInterface;

class NotificationService{
    public function __construct(protected NotificationInterface $notificationRepo)
    {
    }

    public function getNotifications(int $userId ,int $perPage=10){
        return $this->notificationRepo->getUserNotifications($userId,$perPage);
    }

    public function getUnreadNotifications(int $userId,int $perPage){
        return $this->notificationRepo->getUnreadNotifications($userId,$perPage);
    }

    public function markAsRead(int $userId, string $notificationId)
    {
        return $this->notificationRepo->markAsRead(
            $userId,
            $notificationId
        );
    }

    public function markAllAsRead(int $userId)
    {
        return $this->notificationRepo->markAllAsRead($userId);
    }

    public function delete(int $userId, string $notificationId)
    {
        return $this->notificationRepo->delete(
            $userId,
            $notificationId
        );
    }

}