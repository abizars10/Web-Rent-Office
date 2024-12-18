<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OfficeSpace extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'thumbnail',
        'address',
        'is_open',
        'is_full_booked',
        'price',
        'duration',
        'about',
        'slug',
        'city_id', //foreignkey dari city
    ];

    // untuk membuat slug otomatis
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    // Membuat relasi antar table
    // belongsto karna 1 officespace hanya berada di 1 city 
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
    // hasMany karna 1 officespace memiliki banyak photo(s) 
    public function photos(): HasMany
    {
        return $this->hasMany(OfficeSpacePhoto::class);
    }
    // hasMany karna 1 officespace memiliki banyak benefit(s) 
    public function benefits(): HasMany
    {
        return $this->hasMany(OfficeSpaceBenefit::class);
    }
}
