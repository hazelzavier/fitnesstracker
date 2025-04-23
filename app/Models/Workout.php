<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', // Make sure 'name' is in this array
        'date',
        'user_id',
    ];

    public function exercises()
    {
        return $this->belongsToMany(Exercise::class, 'workout_exercise')
                    ->withPivot('weight', 'reps', 'sets');
    }
}
