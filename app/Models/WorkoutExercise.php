<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Represents the pivot table entry connecting a Workout and an Exercise.
 */
class WorkoutExercise extends Pivot
{
    /**
     * The table associated with the pivot model.
     * Explicitly define the table name as it's a pivot table.
     *
     * @var string
     */
    protected $table = 'workout_exercise';

    /**
     * Indicates if the IDs are auto-incrementing.
     * Your pivot table has an 'id' column.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The attributes that are mass assignable.
     * Include foreign keys and pivot attributes if you ever plan to create/update
     * records directly using this model via mass assignment.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'workout_id',
        'exercise_id',
        'weight',
        'reps',
        'sets',
    ];

    /**
     * Indicates if the model should be timestamped.
     * Pivot tables often don't need timestamps unless explicitly added.
     * Set to true if you have created_at/updated_at columns in workout_exercise table.
     *
     * @var bool
     */
    public $timestamps = false; // Zet op true als je timestamps hebt in de pivot tabel

    /**
     * Get the workout associated with this pivot entry.
     * Defines the inverse relationship back to the Workout model.
     */
    public function workout()
    {
        // Assuming the foreign key in workout_exercise table is 'workout_id'
        return $this->belongsTo(Workout::class, 'workout_id');
    }

    /**
     * Get the exercise associated with this pivot entry.
     * Defines the inverse relationship back to the Exercise model.
     */
    public function exercise()
    {
        // Assuming the foreign key in workout_exercise table is 'exercise_id'
        return $this->belongsTo(Exercise::class, 'exercise_id');
    }
}
