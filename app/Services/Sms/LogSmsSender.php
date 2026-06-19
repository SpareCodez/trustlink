<?php

namespace App\Services\Sms;

use App\Contracts\SmsSender;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class LogSmsSender implements SmsSender
{
    public function sendOtp(string $phoneNumber, string $code, int $expiresInMinutes): void
    {
        if (app()->isProduction()) {
            throw new RuntimeException('A production SMS provider has not been configured.');
        }

        Log::info('Registration OTP', [
            'phone_number' => $phoneNumber,
            'code' => $code,
            'expires_in_minutes' => $expiresInMinutes,
        ]);
    }
}
