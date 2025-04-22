<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    use HasFactory;

    /**
     * Mass assignable attributes.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'exercise',    // Name of the exercise
        'weight',      // Weight used in the exercise
        'repetitions', // Number of repetitions
        'date',        // Date of the workout
        'user_id',     // Foreign key for the user who performed the workout
    ];

    /**
     * Define the relationship between Workout and User.
     * Each workout belongs to a specific user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
