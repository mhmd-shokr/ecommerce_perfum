<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Jobs\NotifyAdminNewOrder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifyAdminNewOrderListener implements ShouldQueue


{
    use InteractsWithQueue;

    public string $queue = 'low';

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderPlaced $event): void
    {
        NotifyAdminNewOrder::dispatch($event->order);

    }
}
