<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'photo',
    ];

    // untuk membuat slug otomatis
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    // membuat relasi antar table
    // hasMany karna 1 kota bisa memiliki banyak officeSpace(s)
    public function officeSpaces(): HasMany
    {
        return $this->hasMany(OfficeSpace::class);
    }
}
