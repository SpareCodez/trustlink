@extends('layouts.auth')
@section('title', 'Set New Password')

@section('content')
    <div class="w-full max-w-[440px] flex flex-col">

        <a href="{{ route('login') }}" class="flex items-center gap-1 text-on-surface-variant hover:text-on-surface transition-colors mb-stack-lg w-fit">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            <span class="font-body-sm text-body-sm">Back to sign in</span>
        </a>

        <div class="mb-stack-lg">
            <h1 class="font-headline-md text-headline-md font-black text-on-surface mb-1">Set new password</h1>
            <p class="font-body-md text-body-md text-on-surface-variant">Choose a strong password for your account.</p>
        </div>

        <form class="space-y-stack-md" method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="space-y-1">
                <div class="relative flex items-center">
                    <span class="absolute left-3 material-symbols-outlined text-[20px] {{ $errors->has('email') ? 'text-error' : 'text-outline' }}">alternate_email</span>
                    <input class="w-full pl-10 pr-4 py-3 bg-surface rounded-xl font-body-md text-body-md outline-none cursor-default {{ $errors->has('email') ? 'border border-error' : 'border border-outline-variant' }}"
                        name="email" type="email" value="{{ $email ?? old('email') }}" required autocomplete="email" readonly/>
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
                        id="password-input" name="password" placeholder="New password" type="password"
                        required autocomplete="new-password" autofocus/>
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
                        id="password-confirm-input" name="password_confirmation" placeholder="Confirm new password"
                        type="password" required autocomplete="new-password"/>
                    <button class="absolute right-3 text-outline hover:text-on-surface transition-colors" onclick="togglePassword('password-confirm-input','confirm-toggle-icon')" type="button">
                        <span class="material-symbols-outlined text-[20px]" id="confirm-toggle-icon">visibility</span>
                    </button>
                </div>
            </div>

            <button class="w-full bg-[#1D9E75] hover:bg-[#168a65] active:scale-[0.98] text-white font-headline-sm text-headline-sm font-bold py-4 rounded-xl flex items-center justify-center gap-2 transition-all group" type="submit">
                Reset password
                <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
            </button>
        </form>

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
</script>
@endpush
