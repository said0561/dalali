<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Listing;
use App\Models\Category;
use App\Models\Role;
use App\Models\Region;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role_id == 1 || auth()->user()->role_id == 2) {
                return $next($request);
            }
            return redirect('/home')->with('error', 'Huna mamlaka ya kuingia eneo hili.');
        });
    }

    // Dashboard
    public function index()
    {
        $user = auth()->user();
        $isRegional = ($user->role_id == 2);

        $stats = [
            'total_users' => User::when($isRegional, function($q) use($user) {
                return $q->where('region_id', $user->region_id);
            })->count(),
            'pending_users' => User::where('is_approved', false)
                ->when($isRegional, function($q) use($user) {
                    return $q->where('region_id', $user->region_id);
                })->count(),
            'total_listings' => Listing::when($isRegional, function($q) use($user) {
                return $q->whereHas('user', function($u) use($user) {
                    $u->where('region_id', $user->region_id);
                });
            })->count(),
            'active_listings' => Listing::where('status', 'active')
                ->when($isRegional, function($q) use($user) {
                    return $q->whereHas('user', function($u) use($user) {
                        $u->where('region_id', $user->region_id);
                    });
                })->count(),
        ];

        $newUsers = User::where('is_approved', false)
            ->when($isRegional, function($q) use($user) {
                return $q->where('region_id', $user->region_id);
            })->latest()->take(5)->get();

        $pendingListings = Listing::where('status', 'pending')
            ->when($isRegional, function($q) use($user) {
                return $q->whereHas('user', function($u) use($user) {
                    $u->where('region_id', $user->region_id);
                });
            })->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'newUsers', 'pendingListings'));
    }

    // BROKERS APPROVAL (From your original code)
    public function pendingBrokers()
    {
        $user = auth()->user();
        $brokers = User::where('is_approved', false)
            ->where('role_id', 3)
            ->when($user->role_id == 2, function($q) use($user) {
                return $q->where('region_id', $user->region_id);
            })
            ->latest()
            ->paginate(10);

        return view('admin.brokers.pending', compact('brokers'));
    }

    public function approveUser($id)
    {
        $user = User::findOrFail($id);
        $user->is_approved = true;
        $user->save();
        return back()->with('success', 'Mtumiaji amethibitishwa!');
    }

    // CATEGORIES
    public function categoryIndex()
    {
        $categories = Category::withCount('listings')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function categoryStore(Request $request)
    {
        $request->validate(['name' => 'required|unique:categories,name']);
        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'icon' => $request->icon ?? 'bi-tag',
        ]);
        return back()->with('success', 'Kundi limeongezwa!');
    }

    public function categoryUpdate(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $request->validate(['name' => 'required|unique:categories,name,'.$id]);
        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'icon' => $request->icon
        ]);
        return back()->with('success', 'Kundi limesasishwa!');
    }

    public function categoryDelete($id)
    {
        $category = Category::findOrFail($id);
        if($category->listings()->count() > 0) {
            return back()->with('error', 'Kundi lina bidhaa, huwezi kufuta.');
        }
        $category->delete();
        return back()->with('success', 'Kundi limefutwa!');
    }

    // USERS MANAGEMENT
    public function userIndex() {
        $user = auth()->user();
        $users = User::with(['role', 'region'])
            ->when($user->role_id == 2, function($q) use($user) {
                return $q->where('region_id', $user->region_id);
            })->latest()->paginate(20);

        $roles = Role::all();
        $regions = Region::all();
        return view('admin.users.index', compact('users', 'roles', 'regions'));
    }

    public function userStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|unique:users,phone',
            'role_id' => 'required|exists:roles,id',
            'password' => 'required|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'role_id' => $request->role_id,
            'region_id' => $request->region_id,
            'password' => Hash::make($request->password),
            'is_approved' => true,
        ]);
        return back()->with('success', 'Mtumiaji amesajiliwa!');
    }

    public function userUpdate(Request $request, $id) {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'phone' => 'required|unique:users,phone,'.$id,
        ]);

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->role_id = $request->role_id;
        if(auth()->user()->role_id == 1) $user->region_id = $request->region_id;
        
        if($request->filled('password')) $user->password = Hash::make($request->password);
        
        $user->save();
        return back()->with('success', 'Mtumiaji amesasishwa.');
    }

    public function toggleUserStatus($id) {
        $user = User::findOrFail($id);
        $user->is_approved = !$user->is_approved;
        $user->save();
        return back()->with('success', 'Hali imebadilishwa.');
    }

    public function deleteUser($id) {
        $user = User::findOrFail($id);
        if(auth()->id() == $user->id) return back()->with('error', 'Huwezi kujifuta!');
        $user->delete();
        return back()->with('success', 'Mtumiaji amefutwa.');
    }

    // SUBSCRIPTION LOGIC
    public function activateSubscription($id)
    {
        $user = User::findOrFail($id);
        $startDate = ($user->subscription_until && $user->subscription_until->isFuture()) 
                    ? $user->subscription_until 
                    : now();

        $user->update([
            'subscription_until' => $startDate->addDays(30)
        ]);

        return back()->with('success', 'Akaunti ya ' . $user->name . ' imeongezewa siku 30 za huduma!');
    }

    // ROLES (Hapa ndipo palipokosekana)
    public function roleIndex()
    {
        $roles = Role::all();
        return view('admin.roles.index', compact('roles'));
    }

    public function roleStore(Request $request)
    {
        $request->validate(['name' => 'required|unique:roles,name']);
        Role::create([
            'name' => Str::slug($request->name),
            'display_name' => $request->name,
        ]);
        return back()->with('success', 'Cheo kimeongezwa!');
    }

    public function roleUpdate(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $request->validate(['name' => 'required|unique:roles,name,'.$id]);
        $role->update([
            'name' => Str::slug($request->name),
            'display_name' => $request->name,
        ]);
        return back()->with('success', 'Cheo kimesasishwa!');
    }

    // LISTINGS APPROVAL
    public function pendingListings()
    {
        $user = auth()->user();
        $listings = Listing::where('status', 'pending')
            ->when($user->role_id == 2, function($q) use($user) {
                return $q->whereHas('user', function($u) use($user) {
                    $u->where('region_id', $user->region_id);
                });
            })->latest()->paginate(15);

        return view('admin.listings.pending', compact('listings'));
    }

    public function approveListing($id)
    {
        Listing::findOrFail($id)->update(['status' => 'active']);
        return back()->with('success', 'Bidhaa imethibitishwa!');
    }

    public function rejectListing($id)
    {
        Listing::findOrFail($id)->update(['status' => 'rejected']);
        return back()->with('success', 'Bidhaa imekataliwa.');
    }
}