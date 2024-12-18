<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OfficeSpacePhoto extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['photo', 'office_space_photo'];
}
