<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Jobs\SendOrderConfirmationEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOrderConfirmationListener implements ShouldQueue
{

    use InteractsWithQueue;
    public string $queue='default';
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
        SendOrderConfirmationEmail::dispatch($event->order->id);

    }
}
