<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;
use App\Models\User;
use App\Models\Category;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // Muhimu: Inaruhusu 'welcome' ionekane na wote, lakini 'index' inahitaji login
        $this->middleware('auth')->except('welcome');
    }

    /**
     * Ukurasa wa mwanzo kwa kila mtu (Public Welcome Page)
     */
    public function welcome()
    {
        $listingsCount = Listing::where('status', 'active')->count();
        $brokersCount = User::where('role_id', 3)->count(); 
        $categories = Category::all();
        
        $latestListings = Listing::with(['category', 'region'])
                            ->where('status', 'active')
                            ->latest()
                            ->take(8)
                            ->get();

        return view('welcome', compact('listingsCount', 'brokersCount', 'categories', 'latestListings'));
    }

    /**
     * Dashboard ya Dalali (Baada ya Login)
     */
    public function index()
    {
        return view('home');
    }
}