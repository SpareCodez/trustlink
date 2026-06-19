<?php

namespace App\Services;

use App\Contracts\SmsSender;
use App\Models\PhoneVerificationChallenge;
use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class PhoneVerificationService
{
    public const CODE_LENGTH = 6;

    public const EXPIRES_IN_MINUTES = 10;

    public const MAX_ATTEMPTS = 5;

    public const RESEND_DELAY_SECONDS = 60;

    public function __construct(private readonly SmsSender $smsSender) {}

    public function send(string $phoneNumber): void
    {
        $code = (string) random_int(10 ** (self::CODE_LENGTH - 1), (10 ** self::CODE_LENGTH) - 1);

        DB::transaction(function () use ($phoneNumber, $code): void {
            $challenge = PhoneVerificationChallenge::query()
                ->where('phone_number', $phoneNumber)
                ->lockForUpdate()
                ->first();

            if ($challenge?->resend_available_at?->isFuture()) {
                throw ValidationException::withMessages([
                    'phone_number' => 'Please wait before requesting another code.',
                ]);
            }

            PhoneVerificationChallenge::query()->updateOrCreate(
                ['phone_number' => $phoneNumber],
                [
                    'code_hash' => Hash::make($code),
                    'failed_attempts' => 0,
                    'expires_at' => now()->addMinutes(self::EXPIRES_IN_MINUTES),
                    'resend_available_at' => now()->addSeconds(self::RESEND_DELAY_SECONDS),
                    'verified_at' => null,
                    'consumed_at' => null,
                ],
            );
        });

        $this->smsSender->sendOtp($phoneNumber, $code, self::EXPIRES_IN_MINUTES);
    }

    public function consume(string $phoneNumber, string $code, Closure $afterVerification): mixed
    {
        $validationException = null;

        $result = DB::transaction(function () use (
            $phoneNumber,
            $code,
            $afterVerification,
            &$validationException,
        ): mixed {
            $challenge = PhoneVerificationChallenge::query()
                ->where('phone_number', $phoneNumber)
                ->lockForUpdate()
                ->first();

            if (! $challenge || $challenge->consumed_at || $challenge->expires_at->isPast()) {
                $validationException = ValidationException::withMessages([
                    'otp' => 'This verification code has expired. Request a new code.',
                ]);

                return null;
            }

            if ($challenge->failed_attempts >= self::MAX_ATTEMPTS) {
                $validationException = ValidationException::withMessages([
                    'otp' => 'Too many incorrect attempts. Request a new code.',
                ]);

                return null;
            }

            if (! Hash::check($code, $challenge->code_hash)) {
                $challenge->increment('failed_attempts');
                $validationException = ValidationException::withMessages([
                    'otp' => 'The verification code is incorrect.',
                ]);

                return null;
            }

            $challenge->update([
                'verified_at' => now(),
                'consumed_at' => now(),
            ]);

            return $afterVerification();
        });

        if ($validationException) {
            throw $validationException;
        }

        return $result;
    }
}
