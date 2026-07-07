<?php

namespace App\Jobs;
use App\Mail\WelcomeEmail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * Create a new job instance.
     */
    public function __construct(public User $user)
    {
        $this->onQueue('default');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user=User::find($this->user->id);
        if(!$user) return;
        if($user->hasRole('customer')){
            Mail::to($this->user->email)
            ->send(new WelcomeEmail($user));
        }
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('Welcome email failed', [
            'user_id' => $this->user->id,
            'error'   => $exception->getMessage(),
        ]);
    }
}
