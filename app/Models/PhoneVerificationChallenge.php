<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'phone_number',
    'code_hash',
    'failed_attempts',
    'expires_at',
    'resend_available_at',
    'verified_at',
    'consumed_at',
])]
class PhoneVerificationChallenge extends Model
{
    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'resend_available_at' => 'datetime',
            'verified_at' => 'datetime',
            'consumed_at' => 'datetime',
        ];
    }
}
