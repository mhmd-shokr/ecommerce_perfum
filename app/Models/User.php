<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes; 
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable,HasApiTokens,HasRoles,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verification_code',
        'code_expires_at',
        'is_active',
        'password_reset_code',
        'password_reset_expires_at',
        'password_reset_token',
        'password_reset_token_expires_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function generateOtp(){
        $otp=str_pad(random_int(0,999999),6,'0',STR_PAD_LEFT);
        $this->update([
            'email_verification_code'=>$otp,
            'code_expires_at'=>now()->addMinutes(10),
        ]);
        return $otp;
    }

    public function verifyOtp(string $otp){
        if($this->email_verification_code !==$otp)return false;
        if(!$this->code_expires_at || now()->gt($this->code_expires_at))return false;
        return true;
    }

    public function clearOtp(){
        $this->update([
            'email_verification_code'=>null,
            'code_expires_at'=>null,
        ]);
    }
    public function generatePasswordResetOtp(){
        $otp=str_pad(random_int(0,999999),6,'0',STR_PAD_LEFT);
        $this->update([
            'password_reset_code' => $otp,
            'password_reset_expires_at' => now()->addMinutes(10),
        ]);
        return $otp;
    }
    public function verifyPasswordResetOtp(string $otp){
        if($this->password_reset_code !==$otp) return false;
        if(!$this->password_reset_expires_at || now()->gt($this->password_reset_expires_at)) return false;
        return true;
    }
    public function generatePasswordResetToken(){
        $token=hash('sha256',Str::random(64));
        $this->update([
        'password_reset_token' => $token,
        'password_reset_token_expires_at' => now()->addMinutes(15),
        ]);
        return $token;
    }

    public function clearPasswordResetOtp(): void
        {
            $this->update([
                'password_reset_code' => null,
                'password_reset_expires_at' => null,
            ]);
        }
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'code_expires_at' => 'datetime',
            'password_reset_expires_at' => 'datetime',
            'password' => 'hashed',
            'password_reset_token_expires_at' => 'datetime',
        ];
    }

    public function Wishlists(){
        return $this->hasMany(Wishlist::class);
    }
    public function carts(){
        return $this->hasMany(CarT::class);
    }
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }

}
