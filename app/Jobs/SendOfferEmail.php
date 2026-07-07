<?php

namespace App\Jobs;

use App\Mail\OfferEmail;
use App\Models\Offer;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendOfferEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries=3;
    public int $backoff=60;
    public function __construct(public Offer $offer,public User $user)
    {
        $this->onQueue('low');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user=User::find($this->user->id);
        $offer=Offer::find($this->offer->id);
        if(!$user || !$offer) return;
        if(!$user->hasVerifiedEmail()) return;
        if($offer->is_expired)return;

        if(!$offer->coupon || !$offer->coupon->is_active) {
            return;
        }

        Mail::to($user->email)
            ->send(new OfferEmail($offer,$user));
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('Offer email failed', [
            'offer_id' => $this->offer->id,
            'user_id'  => $this->user->id,
            'error'    => $exception->getMessage(),
        ]);
    }
}
