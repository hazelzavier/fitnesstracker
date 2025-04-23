<?php

namespace App\Http\Controllers;

use App\Models\Workout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Exercise;

class WorkoutController extends Controller
{
    // Display the workouts for the logged-in user
    public function index()
    {
        $workouts = Workout::where('user_id', Auth::id())->orderBy('date', 'desc')->get();
        $exercises = Exercise::all();
        return view('workouts.index', compact('workouts', 'exercises'));
    }

    // Show the form to create a new workout
    public function create()
    {
        $exercises = Exercise::all();
        return view('workouts.create', compact('exercises'));
    }

    // Store a new workout
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date|before_or_equal:today',
            'exercise_name' => 'required|array',  // Changed from exercise_id
            'exercise_name.*' => 'string|max:255', // Validate exercise name
            'weight' => 'required|array',
            'weight.*' => 'numeric|min:0',
            'reps' => 'required|array',
            'reps.*' => 'integer|min:1',
            'sets' => 'required|array',
            'sets.*' => 'integer|min:1',
        ]);

        // Use a transaction to ensure data consistency
        DB::transaction(function () use ($request) {
            // Create the new workout and associate it with the logged-in user
            $workout = Workout::create([
                'name' => $request->name,
                'date' => $request->date,
                'user_id' => Auth::id(),
            ]);

            // Attach the exercises to the workout with the pivot data (weight, reps, sets)
            $exerciseData = [];
            foreach ($request->exercise_name as $key => $exerciseName) {
                // Check if the exercise name exists, if not create a new exercise
                $exercise = Exercise::firstOrCreate(['name' => $exerciseName]);
                $exerciseData[$exercise->id] = [
                    'weight' => $request->weight[$key],
                    'reps' => $request->reps[$key],
                    'sets' => $request->sets[$key],
                ];
            }
            $workout->exercises()->attach($exerciseData);
        });

        // Redirect the user back to the home page with a success message
        return redirect()->route('home')->with('success', 'Workout added successfully!');
    }

    // Show the form to edit a specific workout
    public function edit(Workout $workout)
    {
        if ($workout->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.'); // Ensure user can only edit their own workouts
        }

        $exercises = Exercise::all(); // Fetch all exercises for the dropdown
        return view('workouts.edit', compact('workout', 'exercises'));
    }

    // Update the workout
    public function update(Request $request, Workout $workout)
    {
        if ($workout->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.'); // Ensure user can only update their own workouts
        }

        // Validate the incoming request
         $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date|before_or_equal:today',
            'exercise_id' => 'required|array',
            'exercise_id.*' => 'exists:exercises,id', 
            'weight' => 'required|array',
            'weight.*' => 'numeric|min:0',
            'reps' => 'required|array',
            'reps.*' => 'integer|min:1',
            'sets' => 'required|array',
            'sets.*' => 'integer|min:1',
        ]);

        DB::transaction(function () use ($request, $workout) {
            // Update the workout
            $workout->update([
                'name' => $request->name,
                'date' => $request->date,
            ]);

            $exerciseData = [];
            foreach ($request->exercise_id as $key => $exerciseId) {
                $exerciseData[$exerciseId] = [
                    'weight' => $request->weight[$key],
                    'reps' => $request->reps[$key],
                    'sets' => $request->sets[$key],
                ];
            }
            // Sync the exercises.  This will delete any existing ones, and add the new ones.
            $workout->exercises()->sync($exerciseData);
        });

        // Redirect the user back to the workouts index page with a success message
        return redirect()->route('workouts.index')->with('success', 'Workout updated successfully!');
    }

    // Destroy the workout
    public function destroy(Workout $workout)
    {
        if ($workout->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.'); // Ensure user can only delete their own workouts
        }

        // Delete the workout
        $workout->delete();

        // Redirect back to the workouts index page with a success message
        return redirect()->route('workouts.index')->with('success', 'Workout deleted successfully!');
    }
}

