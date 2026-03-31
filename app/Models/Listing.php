<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    // Hapa ndipo unaruhusu data kuingia kwenye hizi column
    protected $fillable = [
        'user_id', 
        'category_id', 
        'region_id', 
        'title', 
        'slug', 
        'description', 
        'price', 
        'thumbnail', 
        'status'
    ];

    // Mahusiano (Relationships) - Hakikisha pia haya yapo
    public function user() { return $this->belongsTo(User::class); }
    public function category() { return $this->belongsTo(Category::class); }
    public function region() { return $this->belongsTo(Region::class); }
    public function images() { return $this->hasMany(ListingImage::class); }
}