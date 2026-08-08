<?php
namespace  App\Servicies;

use App\Jobs\SendOrderStatusEmail;
use App\Models\Order;
use App\Helpers\CacheHelper;
use App\Interfaces\OrderInterface;
use App\Notifications\OrderStatusChangedNotification;

class OrderService{
    public function __construct(protected OrderInterface $orderRepository){}

    public function getOrders(array $filters){
        return $this->orderRepository->filterOrders($filters,$filters['per_page'] ?? 10 );
    }
    public function getUserOrders(int $userId){
        return $this->orderRepository->getUserOrders($userId);
    }

    public function getUserOrder(int $userId,int $orderId){
        return $this->orderRepository->findUserOrder($userId,$orderId);
    }

    public function getAllOrders(){
        return $this->orderRepository->getAllOrders();
    }
    public function findOrder(int $orderId){
        return $this->orderRepository->findOrder($orderId);
    }

    public function updateStatus(Order $order,array $data){
        $oldStatus= $order->status;
        $updatedOrder =$this->orderRepository->updateStatus($order,$data);
        $updatedOrder->load('user');
        if ($oldStatus !== $updatedOrder->status &&$updatedOrder->user) {
            SendOrderStatusEmail::dispatch($updatedOrder);
            $updatedOrder->user->notify(new OrderStatusChangedNotification($updatedOrder));
        }
        CacheHelper::clearDashboardCache();
                return $updatedOrder;
    }
    public function ordersCount(int $userId){
        return $this->orderRepository->OrdersCount($userId);
    }

    public function getOrdersCount(){
        return $this->orderRepository->getOrdersCount();
    }

    public function pendingOrdersCount(){
        return $this->orderRepository->pendingOrdersCount();
    }
    public function updatePaymentStatus(Order $order, string $status)
{
    $allowedTransitions = [
        'pending'  => ['paid', 'failed'],
        'paid'     => ['refunded'],
        'failed'   => ['pending', 'paid'],
        'refunded' => [], 
    ];

    if (!in_array($status, $allowedTransitions[$order->payment_status] ?? [], true)) {
        throw new \Exception(__('Invalid payment status transition.'));
    }

    $updated = $this->orderRepository
    ->updatePaymentStatus($order, $status);
        if ($updated) {
        CacheHelper::clearDashboardCache();
    }
        return $updated;
    }
    
}
