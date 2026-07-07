<?php

namespace App\Jobs;

use App\Mail\NewOrderAdminMail;
use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class NotifyAdminNewOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public int $tries=3;
    public int $backoff=60;
    public function __construct(public Order $order)
    {
        $this->onQueue('low');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $order=Order::with(['items','address','user'])->find($this->order->id);
        if(!$order) return;
        Mail::to(config('mail.admin_email'))
            ->send(new NewOrderAdminMail($order));
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('Admin new order notification failed', [
            'order_id' => $this->order->id,
            'error'    => $exception->getMessage(),
        ]);
    }
}
