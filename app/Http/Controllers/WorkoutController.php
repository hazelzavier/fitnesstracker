<?php

namespace App\Http\Controllers;

use App\Models\Workout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkoutController extends Controller
{
    // Display the workouts
    public function index()
    {
        $workouts = Workout::where('user_id', Auth::id())->get(); // Get all workouts for the logged-in user
        return view('workouts.index', compact('workouts'));
    }

    // Show the form to create new workout
    public function create()
    {
        return view('workouts.create');
    }

    // Store new workout
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'exercise' => 'required|string|max:255',
            'weight' => 'required|numeric|min:0',
            'repetitions' => 'required|integer|min:1',
            'date' => 'required|date',
        ]);
    
        // Create the new workout and associate it with the logged-in user
        Workout::create([
            'exercise' => $request->exercise,
            'weight' => $request->weight,
            'repetitions' => $request->repetitions,
            'date' => $request->date,
            'user_id' => Auth::id(),
        ]);
    
        // Redirect the user back to the workouts index page with success message
        return redirect()->route('workouts.index')->with('success', 'Workout added successfully!');
    }

    // Show the form to edit a specific workout
    public function edit(Workout $workout)
    {
        return view('workouts.edit', compact('workout'));
    }

    // Update the workout
    public function update(Request $request, Workout $workout)
    {
        // Validate the incoming request
        $request->validate([
            'exercise' => 'required|string|max:255',
            'weight' => 'required|numeric|min:0',
            'repetitions' => 'required|integer|min:1',
            'date' => 'required|date',
        ]);

        // Update the workout
        $workout->update([
            'exercise' => $request->exercise,
            'weight' => $request->weight,
            'repetitions' => $request->repetitions,
            'date' => $request->date,
        ]);

        // Redirect the user back to the workouts index page with success message
        return redirect()->route('workouts.index')->with('success', 'Workout updated successfully!');
    }

    // Destroy the workout
    public function destroy(Workout $workout)
    {
        // Delete the workout
        $workout->delete();

        // Redirect back to the workouts index page with success message
        return redirect()->route('workouts.index')->with('success', 'Workout deleted successfully!');
    }
}
