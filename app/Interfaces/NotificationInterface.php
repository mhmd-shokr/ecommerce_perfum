<?php
namespace App\Interfaces;

Interface NotificationInterface{
    public function getUserNotifications(int $userId, int $perPage = 10);

public function getUnreadNotifications(int $userId, int $perPage = 10);

public function markAsRead(int $userId, string $notificationId): bool;

public function markAllAsRead(int $userId): int;

public function delete(int $userId, string $notificationId): bool;
}