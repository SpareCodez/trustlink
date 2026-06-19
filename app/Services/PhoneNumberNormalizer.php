<?php

namespace App\Services;

use Illuminate\Validation\ValidationException;

class PhoneNumberNormalizer
{
    public function normalize(string $phoneNumber): string
    {
        $digits = preg_replace('/\D+/', '', $phoneNumber);

        if (str_starts_with($digits, '0')) {
            $digits = '233'.substr($digits, 1);
        }

        if (! preg_match('/^233[25]\d{8}$/', $digits)) {
            throw ValidationException::withMessages([
                'phone_number' => 'Enter a valid Ghana mobile number.',
            ]);
        }

        return '+'.$digits;
    }
}
