<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    // Display a listing of the exercises.
    public function index()
    {
        $exercises = Exercise::all();
        return view('exercises.index', compact('exercises')); // You might not need a separate index view for exercises.
    }

    // Show the form to create a new exercise.
    public function create()
    {
        return view('exercises.create');
    }

    // Store a newly created exercise in storage.
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:exercises',
            'description' => 'nullable|string',
        ]);

        Exercise::create($request->only(['name', 'description']));

        return redirect()->route('workouts.index')->with('success', 'Exercise created successfully.'); // Redirect to workouts index
    }

    // Display the specified exercise.
    public function show(Exercise $exercise)
    {
        return view('exercises.show', compact('exercise'));  //Show individual exercise.
    }

    // Show the form for editing the specified exercise.
    public function edit(Exercise $exercise)
    {
        // Controleer of de gebruiker de eigenaar is van de oefening
        if ($exercise->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        return view('exercises.edit', compact('exercise'));
    }

    // Update the specified exercise in storage.
    public function update(Request $request, Exercise $exercise)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:exercises,name,' . $exercise->id,
            'description' => 'nullable|string',
        ]);

        $exercise->update($request->only(['name', 'description']));

        return redirect()->route('exercises.index')->with('success', 'Exercise updated successfully.');
    }

    // Remove the specified exercise from storage.
    public function destroy(Exercise $exercise)
    {
        $exercise->delete();
        return redirect()->route('exercises.index')->with('success', 'Exercise deleted successfully.');
    }
}