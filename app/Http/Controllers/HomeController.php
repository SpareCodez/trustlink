<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        return view('home', [
            'user' => auth()->user(),

            'escrows' => [
                ['item' => 'iPhone 13 (128GB)',    'icon' => 'smartphone',  'buyer' => 'Kofi Mensah',   'handle' => 'kofi_jay',    'amount' => 1200.00, 'status' => 'in_transit'],
                ['item' => 'Leather Artisan Boots', 'icon' => 'styler',      'buyer' => 'Efua Owusu',    'handle' => 'efua_style',  'amount' => 850.00,  'status' => 'paid'],
                ['item' => 'DJI Drone Mini',       'icon' => 'toys',        'buyer' => 'Kwame Boateng', 'handle' => 'kb_media',    'amount' => 3400.00, 'status' => 'locked'],
            ],

            'weeklySales' => [
                ['label' => 'MON', 'value' => '800',   'pct' => 50, 'active' => false],
                ['label' => 'TUE', 'value' => '1,100', 'pct' => 67, 'active' => false],
                ['label' => 'WED', 'value' => '2,200', 'pct' => 100, 'active' => true],
                ['label' => 'THU', 'value' => '1,400', 'pct' => 75, 'active' => false],
                ['label' => 'FRI', 'value' => '600',   'pct' => 33, 'active' => false],
                ['label' => 'SAT', 'value' => '900',   'pct' => 50, 'active' => false],
                ['label' => 'SUN', 'value' => '1,200', 'pct' => 67, 'active' => false],
            ],
        ]);
    }
}
