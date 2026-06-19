@extends('layouts.auth')
@section('title', 'Confirm Password')

@section('content')
    <div class="w-full max-w-[440px] flex flex-col">

        <div class="w-14 h-14 rounded-full bg-secondary-container flex items-center justify-center mb-stack-lg">
            <span class="material-symbols-outlined text-primary text-[28px] filled-icon">shield_lock</span>
        </div>

        <div class="mb-stack-lg">
            <h1 class="font-headline-md text-headline-md font-black text-on-surface mb-1">Confirm your password</h1>
            <p class="font-body-md text-body-md text-on-surface-variant">This area is protected. Please re-enter your password to continue.</p>
        </div>

        <form class="space-y-stack-md" method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div class="space-y-1">
                <div class="relative flex items-center">
                    <span class="absolute left-3 material-symbols-outlined text-[20px] {{ $errors->has('password') ? 'text-error' : 'text-outline' }}">lock</span>
                    <input class="w-full pl-10 pr-10 py-3 bg-white rounded-xl font-body-md text-body-md focus:ring-2 transition-all outline-none {{ $errors->has('password') ? 'border border-error focus:ring-error/10 focus:border-error' : 'border border-outline-variant focus:ring-primary/10 focus:border-primary' }}"
                        id="password-input" name="password" placeholder="Your password" type="password"
                        required autocomplete="current-password" autofocus/>
                    <button class="absolute right-3 text-outline hover:text-on-surface transition-colors" onclick="togglePassword()" type="button">
                        <span class="material-symbols-outlined text-[20px]" id="password-toggle-icon">visibility</span>
                    </button>
                </div>
                @error('password')
                    <p class="font-body-sm text-body-sm text-error flex items-center gap-1 pl-1">
                        <span class="material-symbols-outlined text-[14px]">error</span> {{ $message }}
                    </p>
                @enderror
            </div>

            <button class="w-full bg-[#1D9E75] hover:bg-[#168a65] active:scale-[0.98] text-white font-headline-sm text-headline-sm font-bold py-4 rounded-xl flex items-center justify-center gap-2 transition-all group" type="submit">
                Confirm &amp; continue
                <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
            </button>
        </form>

        @if (Route::has('password.request'))
            <div class="mt-stack-lg text-center">
                <a class="font-body-sm text-body-sm text-primary hover:underline" href="{{ route('password.request') }}">Forgot your password?</a>
            </div>
        @endif

    </div>
@endsection

@push('scripts')
<script>
    function togglePassword() {
        const input = document.getElementById('password-input');
        const icon  = document.getElementById('password-toggle-icon');
        input.type  = input.type === 'password' ? 'text' : 'password';
        icon.textContent = input.type === 'password' ? 'visibility' : 'visibility_off';
    }
</script>
@endpush
