<?php

namespace App\Http\Controllers;

use App\Models\Workout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Exercise;

class WorkoutController extends Controller
{
    /**
     * Display the workouts for the logged-in user.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $workouts = Workout::where('user_id', Auth::id())->orderBy('date', 'desc')->get();
        $exercises = Exercise::all();
        $lastWorkout = Workout::with('exercises')->orderBy('date', 'desc')->first();
        return view('workouts.index', compact('workouts', 'exercises', 'lastWorkout'));
    }

    /**
     * Show the form to create a new workout.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $exercises = Exercise::all();
        return view('workouts.create', compact('exercises'));
    }

    /**
     * Store a new workout.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date|before_or_equal:today',
            'exercise_name' => 'required|array',
            'exercise_name.*' => 'string|max:255',
            'weight' => 'required|array',
            'weight.*' => 'numeric|min:0',
            'reps' => 'required|array',
            'reps.*' => 'integer|min:1',
            'sets' => 'required|array',
            'sets.*' => 'integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            $workout = Workout::create([
                'name' => $request->name,
                'date' => $request->date,
                'user_id' => Auth::id(),
            ]);

            $exerciseData = [];
            foreach ($request->exercise_name as $key => $exerciseName) {
                $exercise = Exercise::firstOrCreate(['name' => $exerciseName]);
                $exerciseData[$exercise->id] = [
                    'weight' => $request->weight[$key],
                    'reps' => $request->reps[$key],
                    'sets' => $request->sets[$key],
                ];
            }
            $workout->exercises()->attach($exerciseData);
        });

        return redirect()->route('workouts.index')->with('success', 'Workout added successfully!');
    }

    /**
     * Show the form to edit a specific workout.
     *
     * @param  \App\Models\Workout  $workout
     * @return \Illuminate\Http\Response
     */
    public function edit(Workout $workout)
    {
        if ($workout->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $exercises = Exercise::all();
        return view('workouts.edit', compact('workout', 'exercises'));
    }

    /**
     * Update the workout.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Workout  $workout
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Workout $workout)
    {
        if ($workout->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

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
            $workout->exercises()->sync($exerciseData);
        });

        return redirect()->route('workouts.index')->with('success', 'Workout updated successfully!');
    }

    /**
     * Destroy the workout.
     *
     * @param  \App\Models\Workout  $workout
     * @return \Illuminate\Http\Response
     */
    public function destroy(Workout $workout)
    {
        if ($workout->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $workout->delete();

        return redirect()->route('workouts.index')->with('success', 'Workout deleted successfully!');
    }
}
