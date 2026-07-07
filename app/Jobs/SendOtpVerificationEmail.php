<?php

namespace App\Jobs;


use App\Mail\OtpVerificationMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendOtpVerificationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    
    public int $tries   = 3;
    public int $backoff = 30;
    public function __construct(public User $user,public string $otp)
    {
        $this->onQueue('high');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if(!$this->user)return;
        Mail::to($this->user->email)
            ->send(new OtpVerificationMail ($this->user,$this->otp));
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('OTP email failed', [
            'user_id' => $this->user->id,
            'error'   => $exception->getMessage(),
        ]);
    }
}
