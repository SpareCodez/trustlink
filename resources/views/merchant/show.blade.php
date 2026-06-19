@extends('layouts.main')
@section('title', $user->name)

@section('content')
    {{-- Merchant Profile Header --}}
    <section class="flex flex-col items-center text-center mb-stack-lg">
        <div class="w-24 h-24 rounded-full bg-secondary-container flex items-center justify-center mb-stack-md border-hairline border-secondary">
            @php
                $parts    = explode(' ', trim($user->name));
                $initials = strtoupper(substr($parts[0], 0, 1));
                if (count($parts) > 1) $initials .= strtoupper(substr(end($parts), 0, 1));
            @endphp
            <span class="text-on-secondary-container font-headline-md text-headline-md font-bold">{{ $initials }}</span>
        </div>
        <div class="flex items-center gap-stack-xs mb-1">
            <h1 class="font-headline-md text-headline-md text-on-surface font-bold">{{ $user->name }}</h1>
            @if($user->email_verified_at)
                <span class="material-symbols-outlined text-primary text-[20px] filled-icon">verified</span>
            @endif
        </div>
        <p class="text-on-surface-variant font-body-md text-body-md mb-stack-sm">
            @{{ strtolower(str_replace(' ', '_', $user->name)) }}
        </p>
        @if($user->email_verified_at)
            <div class="flex items-center gap-stack-sm bg-secondary-fixed/20 px-3 py-1 rounded-full border-hairline border-secondary-fixed-dim">
                <span class="material-symbols-outlined text-[16px] text-primary filled-icon">shield</span>
                <span class="text-primary font-label-caps text-label-caps uppercase">Verified Vendor</span>
            </div>
        @else
            <div class="flex items-center gap-stack-sm bg-surface-container px-3 py-1 rounded-full border-hairline border-outline-variant">
                <span class="material-symbols-outlined text-[16px] text-outline">shield</span>
                <span class="text-outline font-label-caps text-label-caps uppercase">Unverified</span>
            </div>
        @endif
        <p class="text-outline font-body-sm text-body-sm mt-stack-md">
            Member since {{ $user->created_at->format('F Y') }}
        </p>
    </section>

    {{-- Stats Row --}}
    <section class="grid grid-cols-3 gap-stack-sm mb-stack-lg">
        <div class="bg-surface-container-lowest border-hairline border-outline-variant p-stack-sm rounded-xl text-center">
            <p class="text-on-surface font-headline-sm text-headline-sm font-bold">214</p>
            <p class="text-outline font-label-muted text-label-muted mt-1 leading-tight">Successful Transactions</p>
        </div>
        <div class="bg-surface-container-lowest border-hairline border-outline-variant p-stack-sm rounded-xl text-center">
            <p class="text-on-surface font-headline-sm text-headline-sm font-bold">0</p>
            <p class="text-outline font-label-muted text-label-muted mt-1 leading-tight">Active Disputes</p>
        </div>
        <div class="bg-surface-container-lowest border-hairline border-outline-variant p-stack-sm rounded-xl text-center">
            <div class="flex items-center justify-center gap-1">
                <p class="text-on-surface font-headline-sm text-headline-sm font-bold">4.9</p>
                <span class="material-symbols-outlined text-[14px] text-tertiary filled-icon">star</span>
            </div>
            <p class="text-outline font-label-muted text-label-muted mt-1 leading-tight">Trust Rating</p>
        </div>
    </section>

    {{-- Transaction History --}}
    <section class="mb-stack-lg">
        <h2 class="font-label-caps text-label-caps text-outline uppercase mb-stack-md">Recent Trust Activity</h2>
        <div class="bg-surface-container-lowest border-hairline border-outline-variant rounded-xl overflow-hidden">
            <div class="flex justify-between items-center p-stack-md border-b-hairline border-outline-variant">
                <div class="flex flex-col">
                    <span class="font-body-md text-body-md text-on-surface font-medium">Vintage Apparel</span>
                    <span class="font-body-sm text-body-sm text-outline">Oct 24, 2023</span>
                </div>
                <div class="text-right flex flex-col items-end gap-1">
                    <span class="font-body-md text-body-md text-on-surface font-bold">GHS 450.00</span>
                    <span class="bg-secondary-container/50 text-on-secondary-container px-2 py-0.5 rounded-full font-label-caps text-[9px] uppercase tracking-wider">Completed</span>
                </div>
            </div>
            <div class="flex justify-between items-center p-stack-md border-b-hairline border-outline-variant">
                <div class="flex flex-col">
                    <span class="font-body-md text-body-md text-on-surface font-medium">Footwear</span>
                    <span class="font-body-sm text-body-sm text-outline">Oct 19, 2023</span>
                </div>
                <div class="text-right flex flex-col items-end gap-1">
                    <span class="font-body-md text-body-md text-on-surface font-bold">GHS 1,200.00</span>
                    <span class="bg-secondary-container/50 text-on-secondary-container px-2 py-0.5 rounded-full font-label-caps text-[9px] uppercase tracking-wider">Completed</span>
                </div>
            </div>
            <div class="flex justify-between items-center p-stack-md">
                <div class="flex flex-col">
                    <span class="font-body-md text-body-md text-on-surface font-medium">Designer Accessories</span>
                    <span class="font-body-sm text-body-sm text-outline">Oct 12, 2023</span>
                </div>
                <div class="text-right flex flex-col items-end gap-1">
                    <span class="font-body-md text-body-md text-on-surface font-bold">GHS 890.00</span>
                    <span class="bg-secondary-container/50 text-on-secondary-container px-2 py-0.5 rounded-full font-label-caps text-[9px] uppercase tracking-wider">Completed</span>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Card --}}
    <section class="bg-secondary-container border-hairline border-secondary-fixed-dim rounded-xl p-stack-lg text-center">
        <h3 class="font-headline-sm text-headline-sm text-on-secondary-container mb-stack-sm font-bold">Ready to buy from this seller?</h3>
        <p class="text-on-secondary-container/80 font-body-md text-body-md mb-stack-md">Ensure your payment is protected by asking them for a TrustLink escrow link before paying.</p>
        <button class="bg-primary text-on-primary w-full py-3 rounded-lg font-body-md text-body-md font-bold transition-transform active:scale-95 flex items-center justify-center gap-2">
            <span class="material-symbols-outlined">chat</span>
            Message Vendor
        </button>
    </section>
@endsection
