<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Jobs\SendOtpVerificationEmail;
use App\Mail\OtpVerificationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
public function show(){
    if(!Auth::check()){
        return redirect()->route('login');
    }
    /** @var \App\Models\User $user */
    $user=Auth::user();

    if($user->hasVerifiedEmail()){
        return redirect()->route('home');
    }
    return view('auth.verify-otp');
}

    public function send(){
        /** @var \App\Models\User $user */
        $user=Auth::user();
        if ($user->hasVerifiedEmail()) {
            return redirect()->route('home');
        }
        $otp=$user->generateOtp();
        SendOtpVerificationEmail::dispatch($user,$otp);

        return back()->with('success', __('Verification code sent to your email.'));
    }


    public function verify(Request $request){
        $request->validate([
            'otp'=>'required|string|size:6',
        ]);
        /** @var \App\Models\User $user */
        $user=Auth::user();
        if(!$user->verifyOtp($request->otp)){
            return back()->withErrors([
                'otp' => __('Invalid or expired verification code.')
            ]);
        }
        $user->markEmailAsVerified();
        $user->clearOtp();
        return redirect()->route('home')
            ->with('success', __('Email verified successfully!'));
    }

    public function resend()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('home');
        }

        $otp = $user->generateOtp();
        SendOtpVerificationEmail::dispatch($user, $otp);

        return back()->with('success', __('New verification code sent.'));
    }
}
