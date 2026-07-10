<?php

namespace App\Jobs;

use App\Mail\OrderStatusUpdatedMail;
use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendOrderStatusEmail implements ShouldQueue
{
    use Queueable;

    public int $tries = 5;
    public int $backoff = 60;
    /**
     * Create a new job instance.
     */
    public function __construct(public Order $order)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    { 
        $order = Order::with('user')->find($this->order->id);

        if (!$order) {
            return;
        }

        if (!$order->user?->email) {
            return;
        }

        Mail::to($order->user->email)
            ->send(new OrderStatusUpdatedMail($order));
    }

    public function failed(\Throwable $e): void
    {
        Log::error('Order status email failed', [
            'order_id' => $this->order->id,
            'error'    => $e->getMessage(),
        ]);
    }
}
