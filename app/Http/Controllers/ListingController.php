<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\ListingImage;
use App\Models\Category;
use App\Models\Region; 
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ListingController extends Controller
{
    public function index()
    {
        // Dalali anaona bidhaa zake zote (hata kama ni pending)
        $listings = Listing::where('user_id', auth()->id())->latest()->get();
        return view('listings.index', compact('listings'));
    }

    public function create()
    {
        // ULINZI: Kama hana malipo, asifungue fomu ya kupost
    if (!auth()->user()->hasActiveSubscription()) {
        return redirect()->route('home')->with('error', 'Huna ruhusa ya kupost. Tafadhali lipia kwanza Tsh 2,000.');
    }
        $categories = Category::all();
        return view('listings.create', compact('categories'));
    }

    public function store(Request $request)
    {
            // ULINZI: Kama hana malipo, asifungue fomu ya kupost
        if (!auth()->user()->hasActiveSubscription()) {
            return redirect()->route('home')->with('error', 'Huna ruhusa ya kupost. Tafadhali lipia kwanza Tsh 2,000.');
        }
        $request->validate([
            'title' => 'required|string|min:10|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'required|string|min:20',
        ]);

        $thumbName = time().'_thumbnail.'.$request->thumbnail->extension();
        $request->thumbnail->move(public_path('uploads/thumbnails'), $thumbName);

        $listing = Listing::create([
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'region_id' => auth()->user()->region_id, 
            'title' => $request->title,
            'slug' => Str::slug($request->title).'-'.time(),
            'description' => $request->description,
            'price' => $request->price,
            'thumbnail' => 'uploads/thumbnails/'.$thumbName,
            'status' => 'pending', 
        ]);

        if($request->hasFile('images')) {
            foreach($request->file('images') as $image) {
                $imgName = time().'_'.rand(100,999).'.'.$image->extension();
                $image->move(public_path('uploads/gallery'), $imgName);
                ListingImage::create([
                    'listing_id' => $listing->id,
                    'image_path' => 'uploads/gallery/'.$imgName
                ]);
            }
        }

        return redirect()->route('listings.index')->with('success', 'Bidhaa imepokelewa! Inasubiri uhakiki wa Admin.');
    }

    public function show($slug)
    {
        $listing = Listing::with(['user', 'category', 'region', 'images'])
                ->where('slug', $slug)
                ->firstOrFail();

        if ($listing->status !== 'active') {
            if (!auth()->check() || 
            (!in_array(auth()->user()->role_id, [1, 2]) && auth()->id() !== $listing->user_id)) {
                abort(404);
            }
        }
        
        $whatsappNumber = "255743434305"; 
        $message = "Habari, nahitaji bidhaa hii:\n\n" . 
                    "*Bidhaa:* " . $listing->title . "\n" .
                    "*Bei:* Tsh " . number_format($listing->price) . "\n" .
                    "Link: " . url()->current();
        
        $whatsappUrl = "https://wa.me/" . $whatsappNumber . "?text=" . urlencode($message);

        return view('listings.show', compact('listing', 'whatsappUrl'));
    }

    public function edit($id)
    {
        $listing = Listing::where('user_id', auth()->id())->findOrFail($id);
        $categories = Category::all();
        return view('listings.edit', compact('listing', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $listing = Listing::where('user_id', auth()->id())->findOrFail($id);

        $request->validate([
            'title' => 'required|string|min:10|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'required|string|min:20',
        ]);

        $data = $request->only(['title', 'category_id', 'price', 'description']);
        
        if ($request->hasFile('thumbnail')) {
            // Futa picha ya zamani
            if (File::exists(public_path($listing->thumbnail))) {
                File::delete(public_path($listing->thumbnail));
            }
            $thumbName = time().'_thumbnail.'.$request->thumbnail->extension();
            $request->thumbnail->move(public_path('uploads/thumbnails'), $thumbName);
            $data['thumbnail'] = 'uploads/thumbnails/'.$thumbName;
        }

        // Akiedit, inarudi kuwa pending ili admin ahakiki tena
        $data['status'] = 'pending';
        $listing->update($data);

        return redirect()->route('listings.index')->with('success', 'Bidhaa imesasishwa na inasubiri uhakiki upya.');
    }

    public function destroy($id)
    {
        $listing = Listing::findOrFail($id);

        // Ulinzi: Mmiliki au Admin tu ndio wafute
        if (auth()->id() !== $listing->user_id && !in_array(auth()->user()->role_id, [1, 2])) {
            return back()->with('error', 'Huna mamlaka ya kufuta bidhaa hii.');
        }

        // Futa thumbnail
        if (File::exists(public_path($listing->thumbnail))) {
            File::delete(public_path($listing->thumbnail));
        }

        // Futa picha za gallery
        foreach ($listing->images as $img) {
            if (File::exists(public_path($img->image_path))) {
                File::delete(public_path($img->image_path));
            }
        }

        $listing->delete();
        return back()->with('success', 'Bidhaa imefutwa kabisa.');
    }

    public function search(Request $request)
    {
        $query = Listing::with(['category', 'region'])
        ->where('status', 'active')
        ->whereHas('user', function($q) {
            $q->where('subscription_until', '>=', now())
              ->orWhereIn('role_id', [1, 2]); // Admin wasizuiliwe
        });

        if ($request->filled('region')) {
            $query->where('region_id', $request->region);
        }
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        if ($request->filled('keyword')) {
            $query->where('title', 'LIKE', '%' . $request->keyword . '%');
        }

        $listings = $query->latest()->paginate(12);
        $categories = Category::all();
        $regions = Region::all();

        return view('frontend.search_results', compact('listings', 'categories', 'regions'));
    }
}