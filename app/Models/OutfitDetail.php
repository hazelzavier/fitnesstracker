<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutfitDetail extends Model
{
    use HasFactory;

    protected $fillable = ['outfit_id', 'clothing_id'];
}
