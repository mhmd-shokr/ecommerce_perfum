<?php

namespace App\Jobs;


use App\Mail\OrderConfirmationMail;
use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendOrderConfirmationEmail implements ShouldQueue
{
    use Queueable,Dispatchable,SerializesModels;

    /**
     * Create a new job instance.
     */
    public int $tries=5;
    public int $backoff=60;
    public function __construct(public int $orderId)
    {
        $this->onQueue('default');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $order=Order::with(['items','address','user'])->find($this->orderId);
        if(!$order || !$order->user?->email) return;

        Mail::to($order->user->email)->send(new OrderConfirmationMail($order));

    }

    public function failed(\Throwable $e){
        Log::error('Order Confirmation email failed',['order_id'=>$this->orderId,'error'=>$e->getMessage()]);
    }
}
