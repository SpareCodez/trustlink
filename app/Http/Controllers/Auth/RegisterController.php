<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\PhoneNumberNormalizer;
use App\Services\PhoneVerificationService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        private readonly PhoneNumberNormalizer $phoneNumberNormalizer,
        private readonly PhoneVerificationService $phoneVerificationService,
    ) {
        $this->middleware('guest');
    }

    public function register(Request $request)
    {
        $request->merge([
            'phone_number' => $this->phoneNumberNormalizer->normalize(
                $request->string('phone_number')->toString(),
            ),
        ]);

        $this->validator($request->all())->validate();

        $user = $this->phoneVerificationService->consume(
            $request->string('phone_number')->toString(),
            $request->string('otp')->toString(),
            fn (): User => $this->create($request->all()),
        );

        event(new Registered($user));

        Auth::guard()->login($user);

        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect($this->redirectPath());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone_number' => [
                'required',
                'string',
                Rule::unique(User::class, 'phone_number'),
            ],
            'otp' => ['required', 'digits:'.PhoneVerificationService::CODE_LENGTH],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'phone_verified_at' => now(),
            'password' => Hash::make($data['password']),
        ]);

        $user->assignRole(UserRole::Merchant);

        return $user;
    }
}
