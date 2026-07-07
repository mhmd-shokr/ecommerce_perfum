<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
            'code',
            'type',
            'value',
            'usage_limit',
            'used_count',
            'expires_at',
            'is_active',
    ];

    protected $casts = [
        'is_active'=>'boolean',
        'applies_to_all'=>'boolean',
        'expires_at'=>'datetime',
        'value'=>'decimal:2',
    ];

    public function getIsValidAttribute(){
        if(!$this->is_active)return false;
        if ($this->expires_at && now()->gt($this->expires_at)) return false;
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) return false;
        return true;
    }
}
