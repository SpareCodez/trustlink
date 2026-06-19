@extends('layouts.auth')
@section('title', 'Reset Password')

@section('content')
    <div class="w-full max-w-[440px] flex flex-col">

        <a href="{{ route('login') }}" class="flex items-center gap-1 text-on-surface-variant hover:text-on-surface transition-colors mb-stack-lg w-fit">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            <span class="font-body-sm text-body-sm">Back to sign in</span>
        </a>

        @if (session('status'))
            <div class="flex flex-col items-center text-center gap-4 py-6">
                <div class="w-14 h-14 rounded-full bg-secondary-container flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary text-[28px] filled-icon">mark_email_read</span>
                </div>
                <div>
                    <h1 class="font-headline-md text-headline-md font-black text-on-surface mb-2">Check your inbox</h1>
                    <p class="font-body-md text-body-md text-on-surface-variant">{{ session('status') }}</p>
                </div>
                <a href="{{ route('login') }}" class="w-full bg-[#1D9E75] hover:bg-[#168a65] active:scale-[0.98] text-white font-headline-sm text-headline-sm font-bold py-4 rounded-xl flex items-center justify-center gap-2 transition-all group mt-2">
                    Back to sign in
                    <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </a>
            </div>
        @else
            <div class="mb-stack-lg">
                <h1 class="font-headline-md text-headline-md font-black text-on-surface mb-1">Reset password</h1>
                <p class="font-body-md text-body-md text-on-surface-variant">Enter your email and we'll send a reset link.</p>
            </div>

            <form class="space-y-stack-md" method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="space-y-1">
                    <div class="relative flex items-center">
                        <span class="absolute left-3 material-symbols-outlined text-[20px] {{ $errors->has('email') ? 'text-error' : 'text-outline' }}">alternate_email</span>
                        <input class="w-full pl-10 pr-4 py-3 bg-white rounded-xl font-body-md text-body-md focus:ring-2 transition-all outline-none {{ $errors->has('email') ? 'border border-error focus:ring-error/10 focus:border-error' : 'border border-outline-variant focus:ring-primary/10 focus:border-primary' }}"
                            name="email" placeholder="Email address" type="email"
                            value="{{ old('email') }}" required autocomplete="email" autofocus/>
                    </div>
                    @error('email')
                        <p class="font-body-sm text-body-sm text-error flex items-center gap-1 pl-1">
                            <span class="material-symbols-outlined text-[14px]">error</span> {{ $message }}
                        </p>
                    @enderror
                </div>

                <button class="w-full bg-[#1D9E75] hover:bg-[#168a65] active:scale-[0.98] text-white font-headline-sm text-headline-sm font-bold py-4 rounded-xl flex items-center justify-center gap-2 transition-all group" type="submit">
                    Send reset link
                    <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </button>
            </form>
        @endif

    </div>
@endsection
