<?php

namespace App\Http\Controllers;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        return view('admin.dashboard', [
            'disputeCount' => 3,

            'recentTransactions' => [
                ['name' => 'Abena Owusu',  'ref' => 'TX-90214-KM', 'merchant' => 'GadgetZone',    'amount' => 1200, 'status' => 'completed'],
                ['name' => 'Kwesi Arthur', 'ref' => 'TX-88321-LL', 'merchant' => 'RideHub Ghana',  'amount' => 450,  'status' => 'dispatched'],
                ['name' => 'Eunice Baah',  'ref' => 'TX-77420-ZX', 'merchant' => 'Luxe Boutique',  'amount' => 3500, 'status' => 'disputed'],
                ['name' => 'Samuel Obeng', 'ref' => 'TX-66512-QQ', 'merchant' => 'TechMarket',     'amount' => 2100, 'status' => 'locked'],
                ['name' => 'Naa Lamley',   'ref' => 'TX-55401-PP', 'merchant' => 'Kitchen Hub',    'amount' => 890,  'status' => 'completed'],
            ],

            'liveTransaction' => [
                'item' => 'iPhone 14 (Blue)',
                'ref' => 'TL-20240617-R9XQBA',
                'amount' => 4200,
                'steps' => [
                    ['state' => 'done',    'label' => 'Payment Received', 'sub' => 'Confirmed at 10:15 AM', 'pin' => null, 'eta' => null],
                    ['state' => 'done',    'label' => 'PIN Generated',    'sub' => '',                      'pin' => '7429', 'eta' => null],
                    ['state' => 'active',  'label' => 'Rider en route',   'sub' => 'Location: Circle, Interchange', 'pin' => null, 'eta' => 'Est. 18 min'],
                    ['state' => 'pending', 'label' => 'PIN Verified',     'sub' => 'Awaiting delivery',     'pin' => null, 'eta' => null],
                    ['state' => 'pending', 'label' => 'Funds Released',   'sub' => 'Finalizing transaction', 'pin' => null, 'eta' => null],
                ],
            ],

            'disputes' => [
                ['item' => 'PS5 Digital Edition',  'reason' => 'Damaged on arrival'],
                ['item' => 'Samsung 65" TV',       'reason' => 'Incorrect item'],
                ['item' => 'JBL PartyBox 110',     'reason' => 'Missing components'],
            ],

            'topMerchants' => [
                ['handle' => 'GadgetZone',   'links' => 1240, 'volume' => '145K'],
                ['handle' => 'LuxeBoutique', 'links' => 890,  'volume' => '98K'],
            ],

            'tiers' => [
                ['label' => 'Tier 1 (Emerging)', 'pct' => 78],
                ['label' => 'Tier 2 (Pro)',       'pct' => 22],
            ],

            'capacityStats' => [
                'under50' => 412,
                'mid' => 84,
                'nearLimit' => 12,
            ],
        ]);
    }
}
