@extends('layouts.merchant')
@section('title', 'Dashboard')

@section('content')

    {{-- Welcome Header --}}
    <section class="flex flex-col md:flex-row md:items-end justify-between gap-4 min-w-0">
        <div class="min-w-0">
            @php $firstName = explode(' ', trim($user->name))[0]; @endphp
            <h2 class="font-headline-lg text-headline-lg text-on-background">Welcome back, {{ $firstName }}</h2>
            <div class="flex flex-wrap items-center gap-3 mt-2">
                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 bg-secondary-container text-on-secondary-fixed-variant text-[10px] font-bold uppercase rounded-md">
                    <span class="material-symbols-outlined text-sm filled-icon">verified</span>
                    Verified Merchant
                </span>
                <div class="flex items-center gap-1 text-amber-600">
                    <span class="material-symbols-outlined text-sm filled-icon">star</span>
                    <span class="font-body-sm font-bold">4.9</span>
                    <span class="text-outline font-normal">(128 reviews)</span>
                </div>
            </div>
        </div>
        <div class="md:text-right">
            <p class="text-outline text-body-sm">Last login: Today, {{ now()->format('g:i A') }}</p>
        </div>
    </section>

    {{-- Financial Overview --}}
    <section class="grid grid-cols-1 lg:grid-cols-12 gap-gutter min-w-0">

        {{-- Balance Card --}}
        <div class="min-w-0 lg:col-span-6 bg-white hairline-border rounded-xl p-stack-lg flex flex-col justify-between min-h-[180px]">
            <div>
                <p class="text-outline font-label-caps text-label-caps uppercase tracking-wider mb-2">Total Available Balance</p>
                <h3 class="text-[30px] sm:text-[36px] font-bold text-primary tracking-tight break-words">GH¢ 2,450.00</h3>
            </div>
            <div class="flex flex-wrap items-center gap-3 sm:gap-4 mt-6">
                <button class="px-5 py-2 bg-primary text-white rounded-xl text-body-md font-medium hover:bg-primary-container transition-all flex items-center gap-2 active:scale-[0.98]">
                    <span class="material-symbols-outlined text-sm">account_balance_wallet</span>
                    Withdraw Funds
                </button>
                <button class="px-5 py-2 border-[0.5px] border-outline-variant text-on-surface hover:bg-surface-container-low rounded-xl text-body-md font-medium transition-all active:scale-[0.98]">
                    View Statement
                </button>
            </div>
        </div>

        {{-- Stat Cards --}}
        <div class="min-w-0 lg:col-span-6 grid grid-cols-1 md:grid-cols-3 gap-gutter">
            <div class="bg-white hairline-border rounded-xl p-stack-md flex flex-col justify-between">
                <p class="text-outline font-label-caps text-label-caps uppercase">Pending Release</p>
                <div>
                    <p class="text-[15px] font-bold mt-2">GH¢ 1,200</p>
                    <p class="text-blue-600 text-[10px] font-medium flex items-center gap-0.5 mt-1">
                        <span class="material-symbols-outlined text-[12px]">schedule</span> 4 transactions
                    </p>
                </div>
            </div>
            <div class="bg-white hairline-border rounded-xl p-stack-md flex flex-col justify-between">
                <p class="text-outline font-label-caps text-label-caps uppercase">Sales this month</p>
                <div>
                    <p class="text-[15px] font-bold mt-2">GH¢ 8,500</p>
                    <p class="text-primary text-[10px] font-medium flex items-center gap-0.5 mt-1">
                        <span class="material-symbols-outlined text-[12px]">trending_up</span> +12% vs last
                    </p>
                </div>
            </div>
            <div class="bg-white hairline-border rounded-xl p-stack-md flex flex-col justify-between">
                <p class="text-outline font-label-caps text-label-caps uppercase">Active Escrows</p>
                <div>
                    <p class="text-[15px] font-bold mt-2">12</p>
                    <p class="text-outline text-[10px] mt-1">8 items in transit</p>
                </div>
            </div>
        </div>

    </section>

    {{-- Table + Chart/Actions --}}
    <section class="grid grid-cols-1 lg:grid-cols-12 gap-gutter min-w-0">

        {{-- Active Escrows Table --}}
        <div class="min-w-0 lg:col-span-8 bg-white hairline-border rounded-xl overflow-hidden">
            <div class="p-container-margin border-b-[0.5px] border-outline-variant flex justify-between items-center">
                <h4 class="font-headline-sm text-headline-sm">Active Escrows</h4>
                <a class="text-primary font-body-sm font-medium hover:underline" href="#">View All</a>
            </div>
            <div class="max-w-full overflow-x-auto">
                <table class="min-w-[640px] w-full text-left text-body-md">
                    <thead class="bg-surface-container-low border-b-[0.5px] border-outline-variant">
                        <tr>
                            <th class="px-5 py-3 font-label-caps text-label-caps text-outline uppercase">Item Details</th>
                            <th class="px-5 py-3 font-label-caps text-label-caps text-outline uppercase">Buyer</th>
                            <th class="px-5 py-3 font-label-caps text-label-caps text-outline uppercase">Amount</th>
                            <th class="px-5 py-3 font-label-caps text-label-caps text-outline uppercase">Status</th>
                            <th class="px-5 py-3 font-label-caps text-label-caps text-outline uppercase text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-[0.5px] divide-outline-variant">
                        @foreach($escrows as $escrow)
                        <tr class="hover:bg-surface-container-lowest transition-colors">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-secondary-container flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined text-primary text-[18px]">{{ $escrow['icon'] }}</span>
                                    </div>
                                    <span class="font-body-md font-medium">{{ $escrow['item'] }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-3.5">
                                <div class="flex flex-col">
                                    <span class="text-body-md">{{ $escrow['buyer'] }}</span>
                                    <span class="text-label-muted text-outline">{{ '@' . $escrow['handle'] }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 font-body-md font-semibold text-on-surface">GH¢ {{ number_format($escrow['amount'], 2) }}</td>
                            <td class="px-5 py-3.5">
                                @php
                                    $badge = match($escrow['status']) {
                                        'in_transit' => 'bg-blue-50 text-blue-700',
                                        'paid'       => 'bg-green-50 text-green-700',
                                        'locked'     => 'bg-amber-50 text-amber-700',
                                        'disputed'   => 'bg-error-container text-on-error-container',
                                        default      => 'bg-surface-container text-on-surface-variant',
                                    };
                                    $label = str_replace('_', ' ', $escrow['status']);
                                @endphp
                                <span class="px-2 py-1 {{ $badge }} text-[11px] font-bold uppercase rounded-md">{{ $label }}</span>
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                <button class="material-symbols-outlined text-outline hover:text-primary">more_vert</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Right Column --}}
        <div class="min-w-0 lg:col-span-4 space-y-gutter">

            {{-- Weekly Sales Chart --}}
            <div class="bg-white hairline-border rounded-xl p-stack-md">
                <div class="flex justify-between items-center mb-6">
                    <h4 class="font-body-md font-bold">Weekly Sales</h4>
                    <select class="text-[11px] font-label-caps border-none bg-surface-container rounded p-1 outline-none">
                        <option>Last 7 Days</option>
                        <option>Last 30 Days</option>
                    </select>
                </div>
                <div class="h-40 w-full flex items-end justify-between gap-2 px-2">
                    @foreach($weeklySales as $day)
                    <div class="flex-1 rounded-t-sm relative group cursor-pointer transition-all
                                {{ $day['active'] ? 'bg-primary hover:bg-opacity-80' : 'bg-surface-container-high hover:bg-primary/20' }}"
                         style="height: {{ $day['pct'] }}%">
                        <div class="hidden group-hover:block absolute -top-8 left-1/2 -translate-x-1/2 bg-on-background text-white text-[10px] py-1 px-2 rounded whitespace-nowrap">
                            GH¢ {{ $day['value'] }}
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="flex justify-between mt-4 px-2">
                    @foreach($weeklySales as $day)
                        <span class="text-[10px] font-label-caps {{ $day['active'] ? 'text-primary font-bold' : 'text-outline' }}">
                            {{ $day['label'] }}
                        </span>
                    @endforeach
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="grid grid-cols-2 gap-4">
                <button class="bg-white hairline-border rounded-xl p-4 flex flex-col items-center justify-center gap-3 hover:bg-surface-container-low transition-all text-on-surface active:scale-[0.98]">
                    <div class="w-10 h-10 rounded-full bg-primary-container flex items-center justify-center text-on-primary-container">
                        <span class="material-symbols-outlined">add_link</span>
                    </div>
                    <span class="font-body-sm font-medium">Link</span>
                </button>
                <button class="bg-white hairline-border rounded-xl p-4 flex flex-col items-center justify-center gap-3 hover:bg-surface-container-low transition-all text-on-surface active:scale-[0.98]">
                    <div class="w-10 h-10 rounded-full bg-secondary-container flex items-center justify-center text-on-secondary-container">
                        <span class="material-symbols-outlined">qr_code_scanner</span>
                    </div>
                    <span class="font-body-sm font-medium">Scan QR</span>
                </button>
                <button class="bg-white hairline-border rounded-xl p-4 flex flex-col items-center justify-center gap-3 hover:bg-surface-container-low transition-all text-on-surface active:scale-[0.98]">
                    <div class="w-10 h-10 rounded-full bg-tertiary-container flex items-center justify-center text-on-tertiary-container">
                        <span class="material-symbols-outlined">forum</span>
                    </div>
                    <span class="font-body-sm font-medium">Messages</span>
                </button>
                <button class="bg-white hairline-border rounded-xl p-4 flex flex-col items-center justify-center gap-3 hover:bg-surface-container-low transition-all text-on-surface active:scale-[0.98]">
                    <div class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center text-on-surface">
                        <span class="material-symbols-outlined">support_agent</span>
                    </div>
                    <span class="font-body-sm font-medium">Support</span>
                </button>
            </div>

        </div>
    </section>

@endsection
