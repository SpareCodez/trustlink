@extends('layouts.admin')
@section('title', 'Overview')
@section('page-title', 'Operations overview')
@section('page-section', 'Overview')

@section('header-actions')
    <button type="button"
            class="hidden h-9 items-center gap-2 rounded-admin border border-admin-border bg-white px-3 text-admin-sm font-semibold text-admin-text hover:bg-admin-subtle sm:flex">
        <span class="material-symbols-outlined text-[17px]">download</span>
        Export
    </button>
    <button type="button"
            class="flex h-9 items-center gap-2 rounded-admin bg-admin-green px-3 text-admin-sm font-semibold text-white hover:bg-admin-greenDark">
        <span class="material-symbols-outlined text-[18px]">add</span>
        <span class="hidden sm:inline">New escrow</span>
    </button>
@endsection

@section('content')
    <div class="space-y-5">
        <section aria-labelledby="summary-heading">
            <div class="mb-3 flex items-center justify-between gap-4">
                <div>
                    <h2 id="summary-heading" class="text-admin-lg font-semibold text-admin-text">Settlement summary</h2>
                    <p class="mt-0.5 text-admin-sm text-admin-muted">Updated {{ now()->format('g:i A') }}</p>
                </div>
                <div class="flex items-center gap-2 text-admin-sm text-admin-muted">
                    <span class="h-2 w-2 rounded-admin bg-admin-green"></span>
                    Systems operational
                </div>
            </div>

            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 xl:grid-cols-4">
                <article class="min-h-[108px] rounded-admin border border-admin-border bg-white p-4 shadow-admin">
                    <div class="flex items-start justify-between gap-3">
                        <div class="text-admin-sm font-medium text-admin-muted">Funds in escrow</div>
                        <div class="flex h-8 w-8 items-center justify-center rounded-admin bg-admin-greenSoft text-admin-green">
                            <span class="material-symbols-outlined text-[18px]">account_balance</span>
                        </div>
                    </div>
                    <div class="mt-3 text-admin-metric font-semibold text-admin-text">GH&#8373; 48,320</div>
                    <div class="mt-1 flex items-center gap-1 text-admin-xs font-medium text-admin-green">
                        <span class="material-symbols-outlined text-[15px]">trending_up</span>
                        12.5% from last month
                    </div>
                </article>

                <article class="min-h-[108px] rounded-admin border border-admin-border bg-white p-4 shadow-admin">
                    <div class="flex items-start justify-between gap-3">
                        <div class="text-admin-sm font-medium text-admin-muted">Completed today</div>
                        <div class="flex h-8 w-8 items-center justify-center rounded-admin bg-admin-cyanSoft text-admin-cyan">
                            <span class="material-symbols-outlined text-[18px]">task_alt</span>
                        </div>
                    </div>
                    <div class="mt-3 text-admin-metric font-semibold text-admin-text">37</div>
                    <div class="mt-1 text-admin-xs text-admin-muted">Average 3.4 settlements per hour</div>
                </article>

                <article class="min-h-[108px] rounded-admin border border-admin-border bg-white p-4 shadow-admin">
                    <div class="flex items-start justify-between gap-3">
                        <div class="text-admin-sm font-medium text-admin-muted">Platform fees</div>
                        <div class="flex h-8 w-8 items-center justify-center rounded-admin bg-admin-amberSoft text-admin-amber">
                            <span class="material-symbols-outlined text-[18px]">payments</span>
                        </div>
                    </div>
                    <div class="mt-3 text-admin-metric font-semibold text-admin-text">GH&#8373; 3,140</div>
                    <div class="mt-1 text-admin-xs text-admin-muted">65% of {{ now()->format('F') }} target</div>
                </article>

                <article class="min-h-[108px] rounded-admin border border-admin-red/30 bg-white p-4 shadow-admin">
                    <div class="flex items-start justify-between gap-3">
                        <div class="text-admin-sm font-medium text-admin-muted">Open disputes</div>
                        <div class="flex h-8 w-8 items-center justify-center rounded-admin bg-admin-redSoft text-admin-red">
                            <span class="material-symbols-outlined text-[18px]">gavel</span>
                        </div>
                    </div>
                    <div class="mt-3 text-admin-metric font-semibold text-admin-red">{{ $disputeCount }}</div>
                    <div class="mt-1 text-admin-xs font-medium text-admin-red">Review queue requires attention</div>
                </article>
            </div>
        </section>

        <div class="grid grid-cols-1 gap-5 xl:grid-cols-12">
            <section class="overflow-hidden rounded-admin border border-admin-border bg-white shadow-admin xl:col-span-8" aria-labelledby="transactions-heading">
                <div class="flex flex-wrap items-center justify-between gap-3 border-b border-admin-border px-4 py-3">
                    <div>
                        <h2 id="transactions-heading" class="text-admin-lg font-semibold text-admin-text">Transaction activity</h2>
                        <p class="mt-0.5 text-admin-xs text-admin-muted">Volume and latest settlement events</p>
                    </div>
                    <label class="flex items-center gap-2 text-admin-xs text-admin-muted">
                        <span>Period</span>
                        <select class="h-8 rounded-admin border-admin-border py-1 pl-2 pr-7 text-admin-xs text-admin-text focus:border-admin-green focus:ring-1 focus:ring-admin-green">
                            <option>Last 7 days</option>
                            <option>Last 30 days</option>
                            <option>This quarter</option>
                        </select>
                    </label>
                </div>

                <div class="border-b border-admin-border px-4 pb-3 pt-4">
                    @php
                        $chart = [
                            ['day' => 'Mon', 'height' => 42], ['day' => 'Tue', 'height' => 58],
                            ['day' => 'Wed', 'height' => 37], ['day' => 'Thu', 'height' => 76],
                            ['day' => 'Fri', 'height' => 51], ['day' => 'Sat', 'height' => 66],
                            ['day' => 'Sun', 'height' => 88],
                        ];
                    @endphp
                    <div class="grid h-28 grid-cols-7 items-end gap-3" aria-label="Seven day transaction volume chart">
                        @foreach($chart as $bar)
                            <div class="flex h-full min-w-0 flex-col justify-end gap-1.5">
                                <div class="w-full rounded-t-admin bg-admin-green/80" style="height: {{ $bar['height'] }}%" title="{{ $bar['day'] }}: {{ $bar['height'] }}% relative volume"></div>
                                <div class="text-center text-admin-xs text-admin-muted">{{ $bar['day'] }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="admin-scrollbar overflow-x-auto">
                    <table class="w-full min-w-[680px] table-fixed text-left">
                        <thead class="bg-admin-subtle text-admin-xs font-semibold text-admin-muted">
                            <tr>
                                <th class="w-[31%] px-4 py-2.5">Customer / reference</th>
                                <th class="w-[25%] px-4 py-2.5">Merchant</th>
                                <th class="w-[21%] px-4 py-2.5">Amount</th>
                                <th class="w-[23%] px-4 py-2.5">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-admin-border">
                            @foreach($recentTransactions as $tx)
                                @php
                                    $badge = match($tx['status']) {
                                        'completed' => 'bg-admin-greenSoft text-admin-greenDark',
                                        'dispatched' => 'bg-admin-cyanSoft text-admin-cyan',
                                        'disputed' => 'bg-admin-redSoft text-admin-red',
                                        'locked' => 'bg-admin-amberSoft text-admin-amber',
                                        default => 'bg-admin-subtle text-admin-muted',
                                    };
                                @endphp
                                <tr class="hover:bg-admin-subtle/60">
                                    <td class="px-4 py-3">
                                        <div class="truncate text-admin-sm font-semibold text-admin-text">{{ $tx['name'] }}</div>
                                        <div class="mt-0.5 truncate font-mono text-admin-xs text-admin-muted">{{ $tx['ref'] }}</div>
                                    </td>
                                    <td class="truncate px-4 py-3 text-admin-sm text-admin-muted">{{ $tx['merchant'] }}</td>
                                    <td class="px-4 py-3 text-admin-sm font-semibold tabular-nums text-admin-text">GH&#8373; {{ number_format($tx['amount']) }}</td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex min-h-6 items-center rounded-admin px-2 py-1 text-admin-xs font-semibold {{ $badge }}">{{ ucfirst($tx['status']) }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            <div class="space-y-5 xl:col-span-4">
                <section class="rounded-admin border border-admin-border bg-white shadow-admin" aria-labelledby="live-heading">
                    <div class="flex items-center justify-between gap-3 border-b border-admin-border px-4 py-3">
                        <div>
                            <h2 id="live-heading" class="text-admin-lg font-semibold text-admin-text">Live settlement</h2>
                            <p class="mt-0.5 font-mono text-admin-xs text-admin-muted">{{ $liveTransaction['ref'] }}</p>
                        </div>
                        <span class="inline-flex items-center gap-1.5 rounded-admin bg-admin-greenSoft px-2 py-1 text-admin-xs font-semibold text-admin-greenDark">
                            <span class="h-1.5 w-1.5 rounded-admin bg-admin-green"></span>
                            Active
                        </span>
                    </div>
                    <div class="px-4 py-3">
                        <div class="flex items-start justify-between gap-3 border-b border-admin-border pb-3">
                            <div class="min-w-0">
                                <div class="truncate text-admin-sm font-semibold text-admin-text">{{ $liveTransaction['item'] }}</div>
                                <div class="mt-0.5 text-admin-xs text-admin-muted">Current delivery workflow</div>
                            </div>
                            <div class="shrink-0 text-admin-sm font-semibold tabular-nums text-admin-text">GH&#8373; {{ number_format($liveTransaction['amount']) }}</div>
                        </div>
                        <ol class="relative mt-3 space-y-3 before:absolute before:bottom-3 before:left-[9px] before:top-3 before:w-px before:bg-admin-border">
                            @foreach($liveTransaction['steps'] as $step)
                                <li class="relative flex gap-3 {{ $step['state'] === 'pending' ? 'text-admin-muted' : '' }}">
                                    <div class="z-10 flex h-5 w-5 shrink-0 items-center justify-center rounded-admin border
                                        {{ $step['state'] === 'done' ? 'border-admin-green bg-admin-green text-white' : '' }}
                                        {{ $step['state'] === 'active' ? 'border-admin-green bg-white text-admin-green' : '' }}
                                        {{ $step['state'] === 'pending' ? 'border-admin-border bg-white text-admin-muted' : '' }}">
                                        @if($step['state'] === 'done')
                                            <span class="material-symbols-outlined text-[13px]">check</span>
                                        @elseif($step['state'] === 'active')
                                            <span class="h-1.5 w-1.5 rounded-admin bg-admin-green"></span>
                                        @endif
                                    </div>
                                    <div class="min-w-0 flex-1 pt-0.5">
                                        <div class="flex items-start justify-between gap-2">
                                            <div class="text-admin-sm font-medium {{ $step['state'] === 'active' ? 'text-admin-greenDark' : 'text-admin-text' }}">{{ $step['label'] }}</div>
                                            @if($step['eta'])
                                                <div class="shrink-0 text-admin-xs font-medium text-admin-greenDark">{{ $step['eta'] }}</div>
                                            @endif
                                        </div>
                                        @if($step['sub'])
                                            <div class="mt-0.5 text-admin-xs text-admin-muted">{{ $step['sub'] }}</div>
                                        @endif
                                        @if($step['pin'])
                                            <div class="mt-1.5 font-mono text-admin-sm font-semibold text-admin-text">PIN {{ $step['pin'] }}</div>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ol>
                    </div>
                </section>

                <section class="rounded-admin border border-admin-red/30 bg-white shadow-admin" aria-labelledby="disputes-heading">
                    <div class="flex items-center justify-between border-b border-admin-border px-4 py-3">
                        <div>
                            <h2 id="disputes-heading" class="text-admin-lg font-semibold text-admin-text">Priority disputes</h2>
                            <p class="mt-0.5 text-admin-xs text-admin-muted">Oldest unresolved cases</p>
                        </div>
                        <span class="text-admin-sm font-semibold text-admin-red">{{ $disputeCount }} open</span>
                    </div>
                    <div class="divide-y divide-admin-border">
                        @foreach($disputes as $dispute)
                            <button type="button" class="flex min-h-14 w-full items-center gap-3 px-4 py-3 text-left hover:bg-admin-redSoft/40">
                                <span class="material-symbols-outlined shrink-0 text-[18px] text-admin-red">warning</span>
                                <span class="min-w-0 flex-1">
                                    <span class="block truncate text-admin-sm font-semibold text-admin-text">{{ $dispute['item'] }}</span>
                                    <span class="mt-0.5 block truncate text-admin-xs text-admin-muted">{{ $dispute['reason'] }}</span>
                                </span>
                                <span class="material-symbols-outlined shrink-0 text-[17px] text-admin-muted">chevron_right</span>
                            </button>
                        @endforeach
                    </div>
                </section>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 xl:grid-cols-2">
            <section class="overflow-hidden rounded-admin border border-admin-border bg-white shadow-admin" aria-labelledby="merchants-heading">
                <div class="flex items-center justify-between border-b border-admin-border px-4 py-3">
                    <div>
                        <h2 id="merchants-heading" class="text-admin-lg font-semibold text-admin-text">Top merchants</h2>
                        <p class="mt-0.5 text-admin-xs text-admin-muted">Ranked by settled volume</p>
                    </div>
                    <button type="button" class="text-admin-xs font-semibold text-admin-greenDark hover:underline">View all</button>
                </div>
                <div class="admin-scrollbar overflow-x-auto">
                    <table class="w-full min-w-[520px] text-left">
                        <thead class="bg-admin-subtle text-admin-xs font-semibold text-admin-muted">
                            <tr>
                                <th class="px-4 py-2.5">Rank</th>
                                <th class="px-4 py-2.5">Merchant</th>
                                <th class="px-4 py-2.5">Links</th>
                                <th class="px-4 py-2.5">Volume</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-admin-border">
                            @foreach($topMerchants as $index => $merchant)
                                <tr class="hover:bg-admin-subtle/60">
                                    <td class="px-4 py-3 text-admin-sm font-semibold text-admin-muted">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2">
                                            <div class="flex h-7 w-7 items-center justify-center rounded-admin bg-admin-greenSoft text-admin-green">
                                                <span class="material-symbols-outlined text-[16px]">store</span>
                                            </div>
                                            <span class="text-admin-sm font-semibold text-admin-text">{{ $merchant['handle'] }}</span>
                                            <span class="material-symbols-outlined filled-icon text-[15px] text-admin-green">verified</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-admin-sm tabular-nums text-admin-muted">{{ number_format($merchant['links']) }}</td>
                                    <td class="px-4 py-3 text-admin-sm font-semibold tabular-nums text-admin-text">GH&#8373; {{ $merchant['volume'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="rounded-admin border border-admin-border bg-white shadow-admin" aria-labelledby="capacity-heading">
                <div class="flex items-center justify-between gap-3 border-b border-admin-border px-4 py-3">
                    <div>
                        <h2 id="capacity-heading" class="text-admin-lg font-semibold text-admin-text">Merchant capacity</h2>
                        <p class="mt-0.5 text-admin-xs text-admin-muted">Tier distribution and limit exposure</p>
                    </div>
                    <button type="button" class="flex h-8 w-8 items-center justify-center rounded-admin text-admin-muted hover:bg-admin-subtle" aria-label="Capacity options" title="Capacity options">
                        <span class="material-symbols-outlined text-[18px]">more_horiz</span>
                    </button>
                </div>
                <div class="p-4">
                    <div class="space-y-4">
                        @foreach($tiers as $tier)
                            <div>
                                <div class="mb-1.5 flex justify-between gap-4 text-admin-sm">
                                    <span class="font-medium text-admin-text">{{ $tier['label'] }}</span>
                                    <span class="font-semibold tabular-nums text-admin-greenDark">{{ $tier['pct'] }}%</span>
                                </div>
                                <div class="h-2 overflow-hidden rounded-admin bg-admin-subtle">
                                    <div class="h-full rounded-admin bg-admin-green" style="width: {{ $tier['pct'] }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <dl class="mt-5 grid grid-cols-3 divide-x divide-admin-border border-t border-admin-border pt-4">
                        <div class="pr-3">
                            <dt class="text-admin-xs text-admin-muted">Below 50%</dt>
                            <dd class="mt-1 text-admin-lg font-semibold tabular-nums text-admin-text">{{ $capacityStats['under50'] }}</dd>
                        </div>
                        <div class="px-3">
                            <dt class="text-admin-xs text-admin-muted">50-90%</dt>
                            <dd class="mt-1 text-admin-lg font-semibold tabular-nums text-admin-text">{{ $capacityStats['mid'] }}</dd>
                        </div>
                        <div class="pl-3">
                            <dt class="text-admin-xs text-admin-muted">Near limit</dt>
                            <dd class="mt-1 text-admin-lg font-semibold tabular-nums text-admin-red">{{ $capacityStats['nearLimit'] }}</dd>
                        </div>
                    </dl>
                </div>
            </section>
        </div>
    </div>
@endsection
