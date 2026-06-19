@extends('layouts.auth')
@section('title', 'Create Account')

{{-- Register needs a scrollable layout --}}
@section('body-class', '')
@section('main-class', 'min-h-screen')
@section('aside-class', 'sticky top-0 h-screen')
@section('section-class', 'py-10')

@section('content')
    <div class="w-full max-w-[440px] flex flex-col">
        <div class="mb-stack-lg">
            <h1 class="font-headline-md text-headline-md font-black text-on-surface mb-1">Create account</h1>
            <p class="font-body-md text-body-md text-on-surface-variant">Apply for merchant access</p>
        </div>

        <form class="space-y-stack-md" method="POST" action="{{ route('register') }}">
            @csrf

            <div class="space-y-1">
                <div class="relative flex items-center">
                    <span class="absolute left-3 material-symbols-outlined text-[20px] {{ $errors->has('name') ? 'text-error' : 'text-outline' }}">person</span>
                    <input class="w-full pl-10 pr-4 py-3 bg-white rounded-xl font-body-md text-body-md focus:ring-2 transition-all outline-none {{ $errors->has('name') ? 'border border-error focus:ring-error/10 focus:border-error' : 'border border-outline-variant focus:ring-primary/10 focus:border-primary' }}"
                        name="name" placeholder="Full name" type="text"
                        value="{{ old('name') }}" required autocomplete="name" autofocus/>
                </div>
                @error('name')
                    <p class="font-body-sm text-body-sm text-error flex items-center gap-1 pl-1">
                        <span class="material-symbols-outlined text-[14px]">error</span> {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="space-y-1">
                <div class="flex items-stretch gap-2">
                    <div class="relative flex items-center min-w-0 flex-1">
                        <span class="absolute left-3 material-symbols-outlined text-[20px] {{ $errors->has('phone_number') ? 'text-error' : 'text-outline' }}">phone</span>
                        <input class="w-full min-w-0 pl-10 pr-4 py-3 bg-white rounded-xl font-body-md text-body-md focus:ring-2 transition-all outline-none {{ $errors->has('phone_number') ? 'border border-error focus:ring-error/10 focus:border-error' : 'border border-outline-variant focus:ring-primary/10 focus:border-primary' }}"
                            id="phone-number" name="phone_number" placeholder="Mobile number" type="tel"
                            value="{{ old('phone_number') }}" required autocomplete="tel" inputmode="tel"/>
                    </div>
                    <button class="shrink-0 px-4 bg-surface-container-low hover:bg-surface-container text-primary border border-outline-variant rounded-xl font-body-sm text-body-sm font-bold transition-colors disabled:cursor-not-allowed disabled:opacity-50"
                        id="send-otp" type="button">
                        Send code
                    </button>
                </div>
                @error('phone_number')
                    <p class="font-body-sm text-body-sm text-error flex items-center gap-1 pl-1">
                        <span class="material-symbols-outlined text-[14px]">error</span> {{ $message }}
                    </p>
                @enderror
                <p class="font-body-sm text-body-sm pl-1 hidden" id="otp-status" role="status" aria-live="polite"></p>
            </div>

            <div class="space-y-1">
                <div class="relative flex items-center">
                    <span class="absolute left-3 material-symbols-outlined text-[20px] {{ $errors->has('otp') ? 'text-error' : 'text-outline' }}">password</span>
                    <input class="w-full pl-10 pr-4 py-3 bg-white rounded-xl font-body-md text-body-md tracking-widest focus:ring-2 transition-all outline-none {{ $errors->has('otp') ? 'border border-error focus:ring-error/10 focus:border-error' : 'border border-outline-variant focus:ring-primary/10 focus:border-primary' }}"
                        id="otp" name="otp" placeholder="6-digit verification code" type="text"
                        value="{{ old('otp') }}" required autocomplete="one-time-code" inputmode="numeric" maxlength="6" pattern="[0-9]{6}"/>
                </div>
                @error('otp')
                    <p class="font-body-sm text-body-sm text-error flex items-center gap-1 pl-1">
                        <span class="material-symbols-outlined text-[14px]">error</span> {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="space-y-1">
                <div class="relative flex items-center">
                    <span class="absolute left-3 material-symbols-outlined text-[20px] {{ $errors->has('email') ? 'text-error' : 'text-outline' }}">alternate_email</span>
                    <input class="w-full pl-10 pr-4 py-3 bg-white rounded-xl font-body-md text-body-md focus:ring-2 transition-all outline-none {{ $errors->has('email') ? 'border border-error focus:ring-error/10 focus:border-error' : 'border border-outline-variant focus:ring-primary/10 focus:border-primary' }}"
                        name="email" placeholder="Email address" type="email"
                        value="{{ old('email') }}" required autocomplete="email"/>
                </div>
                @error('email')
                    <p class="font-body-sm text-body-sm text-error flex items-center gap-1 pl-1">
                        <span class="material-symbols-outlined text-[14px]">error</span> {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="space-y-1">
                <div class="relative flex items-center">
                    <span class="absolute left-3 material-symbols-outlined text-[20px] {{ $errors->has('password') ? 'text-error' : 'text-outline' }}">lock</span>
                    <input class="w-full pl-10 pr-10 py-3 bg-white rounded-xl font-body-md text-body-md focus:ring-2 transition-all outline-none {{ $errors->has('password') ? 'border border-error focus:ring-error/10 focus:border-error' : 'border border-outline-variant focus:ring-primary/10 focus:border-primary' }}"
                        id="password-input" name="password" placeholder="Password" type="password"
                        required autocomplete="new-password"/>
                    <button class="absolute right-3 text-outline hover:text-on-surface transition-colors" onclick="togglePassword('password-input','password-toggle-icon')" type="button">
                        <span class="material-symbols-outlined text-[20px]" id="password-toggle-icon">visibility</span>
                    </button>
                </div>
                @error('password')
                    <p class="font-body-sm text-body-sm text-error flex items-center gap-1 pl-1">
                        <span class="material-symbols-outlined text-[14px]">error</span> {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="space-y-1">
                <div class="relative flex items-center">
                    <span class="absolute left-3 material-symbols-outlined text-[20px] text-outline">lock_reset</span>
                    <input class="w-full pl-10 pr-10 py-3 bg-white border border-outline-variant rounded-xl font-body-md text-body-md focus:ring-2 focus:ring-primary/10 focus:border-primary transition-all outline-none"
                        id="password-confirm-input" name="password_confirmation" placeholder="Confirm password"
                        type="password" required autocomplete="new-password"/>
                    <button class="absolute right-3 text-outline hover:text-on-surface transition-colors" onclick="togglePassword('password-confirm-input','confirm-toggle-icon')" type="button">
                        <span class="material-symbols-outlined text-[20px]" id="confirm-toggle-icon">visibility</span>
                    </button>
                </div>
            </div>

            <button class="w-full bg-[#1D9E75] hover:bg-[#168a65] active:scale-[0.98] text-white font-headline-sm text-headline-sm font-bold py-4 rounded-xl flex items-center justify-center gap-2 transition-all group mt-stack-lg" type="submit">
                Create account
                <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
            </button>
        </form>

        <div class="mt-stack-lg flex flex-col items-center gap-6">
            <div class="flex items-center w-full gap-4">
                <div class="h-[0.5px] bg-outline-variant flex-1"></div>
                <span class="font-label-caps text-label-caps text-outline uppercase">Or sign in</span>
                <div class="h-[0.5px] bg-outline-variant flex-1"></div>
            </div>
            <p class="font-body-sm text-body-sm text-on-surface-variant text-center">
                Already have an account? <a class="text-primary font-bold hover:underline" href="{{ route('login') }}">Sign in</a>
            </p>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
        input.type  = input.type === 'password' ? 'text' : 'password';
        icon.textContent = input.type === 'password' ? 'visibility' : 'visibility_off';
    }

    const sendOtpButton = document.getElementById('send-otp');
    const phoneInput = document.getElementById('phone-number');
    const otpInput = document.getElementById('otp');
    const otpStatus = document.getElementById('otp-status');

    function showOtpStatus(message, isError = false) {
        otpStatus.textContent = message;
        otpStatus.classList.remove('hidden', 'text-error', 'text-primary');
        otpStatus.classList.add(isError ? 'text-error' : 'text-primary');
    }

    function startOtpCountdown(seconds) {
        sendOtpButton.disabled = true;
        let remaining = seconds;
        sendOtpButton.textContent = `Resend in ${remaining}s`;

        const timer = window.setInterval(() => {
            remaining -= 1;
            sendOtpButton.textContent = remaining > 0 ? `Resend in ${remaining}s` : 'Resend code';

            if (remaining <= 0) {
                window.clearInterval(timer);
                sendOtpButton.disabled = false;
            }
        }, 1000);
    }

    sendOtpButton.addEventListener('click', async () => {
        sendOtpButton.disabled = true;
        sendOtpButton.textContent = 'Sending...';

        try {
            const response = await fetch(@json(route('register.otp')), {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ phone_number: phoneInput.value }),
            });
            const data = await response.json();

            if (! response.ok) {
                const message = data.errors?.phone_number?.[0] ?? data.message ?? 'Unable to send the code.';
                throw new Error(message);
            }

            phoneInput.value = data.phone_number;
            showOtpStatus(data.message);
            otpInput.focus();
            startOtpCountdown(60);
        } catch (error) {
            showOtpStatus(error.message, true);
            sendOtpButton.disabled = false;
            sendOtpButton.textContent = 'Send code';
        }
    });
</script>
@endpush
