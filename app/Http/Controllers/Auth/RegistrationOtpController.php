<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\PhoneNumberNormalizer;
use App\Services\PhoneVerificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RegistrationOtpController extends Controller
{
    public function __invoke(
        Request $request,
        PhoneNumberNormalizer $phoneNumberNormalizer,
        PhoneVerificationService $phoneVerificationService,
    ): JsonResponse {
        $request->validate([
            'phone_number' => ['required', 'string', 'max:30'],
        ]);

        $phoneNumber = $phoneNumberNormalizer->normalize($request->string('phone_number')->toString());

        validator(
            ['phone_number' => $phoneNumber],
            ['phone_number' => [Rule::unique(User::class, 'phone_number')]],
            ['phone_number.unique' => 'An account already uses this phone number.'],
        )->validate();

        $phoneVerificationService->send($phoneNumber);

        return response()->json([
            'message' => 'Verification code sent.',
            'phone_number' => $phoneNumber,
        ]);
    }
}
