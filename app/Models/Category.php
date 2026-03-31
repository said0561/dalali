<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

   
    protected $fillable = ['name', 'icon', 'slug'];

    /**
     * Uhusiano na Listings
     */
    public function listings()
    {
        return $this->hasMany(Listing::class);
    }
}