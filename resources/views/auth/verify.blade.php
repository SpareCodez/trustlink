@extends('layouts.auth')
@section('title', 'Verify Email')

@section('content')
    <div class="w-full max-w-[440px] flex flex-col items-center text-center">

        <div class="w-16 h-16 rounded-full bg-secondary-container flex items-center justify-center mb-6">
            <span class="material-symbols-outlined text-primary text-[32px] filled-icon">forward_to_inbox</span>
        </div>

        <h1 class="font-headline-md text-headline-md font-black text-on-surface mb-2">Check your email</h1>
        <p class="font-body-md text-body-md text-on-surface-variant mb-stack-lg">
            We sent a verification link to your email address. Click it to activate your account.
        </p>

        @if (session('resent'))
            <div class="w-full flex items-center gap-3 bg-secondary-container text-on-secondary-container rounded-xl px-4 py-3 mb-stack-lg">
                <span class="material-symbols-outlined text-primary text-[20px] filled-icon shrink-0">check_circle</span>
                <p class="font-body-sm text-body-sm text-left">A fresh verification link has been sent to your email address.</p>
            </div>
        @endif

        <div class="w-full bg-surface-container-low rounded-xl p-4 mb-stack-lg text-left space-y-3">
            <div class="flex items-start gap-3">
                <div class="mt-0.5 w-5 h-5 rounded-full bg-primary flex items-center justify-center shrink-0">
                    <span class="font-label-caps text-label-caps text-white">1</span>
                </div>
                <p class="font-body-sm text-body-sm text-on-surface-variant">Open the email from TrustLink in your inbox</p>
            </div>
            <div class="flex items-start gap-3">
                <div class="mt-0.5 w-5 h-5 rounded-full bg-primary flex items-center justify-center shrink-0">
                    <span class="font-label-caps text-label-caps text-white">2</span>
                </div>
                <p class="font-body-sm text-body-sm text-on-surface-variant">Click the <strong class="text-on-surface font-medium">Verify email address</strong> button</p>
            </div>
            <div class="flex items-start gap-3">
                <div class="mt-0.5 w-5 h-5 rounded-full bg-primary flex items-center justify-center shrink-0">
                    <span class="font-label-caps text-label-caps text-white">3</span>
                </div>
                <p class="font-body-sm text-body-sm text-on-surface-variant">You'll be redirected back and signed in automatically</p>
            </div>
        </div>

        <form class="w-full" method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="w-full bg-[#1D9E75] hover:bg-[#168a65] active:scale-[0.98] text-white font-headline-sm text-headline-sm font-bold py-4 rounded-xl flex items-center justify-center gap-2 transition-all group">
                Resend verification email
                <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">send</span>
            </button>
        </form>

        <div class="mt-stack-lg">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="font-body-sm text-body-sm text-on-surface-variant hover:text-on-surface transition-colors flex items-center gap-1 mx-auto">
                    <span class="material-symbols-outlined text-[16px]">logout</span>
                    Sign out and use a different account
                </button>
            </form>
        </div>

    </div>
@endsection
