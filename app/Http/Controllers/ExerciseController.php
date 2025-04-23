<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExerciseController extends Controller
{
    /**
     * Display a listing of the exercises.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Haal alle oefeningen op, gesorteerd op naam
        $exercises = Exercise::orderBy('name')->get();
        // Geef de index view weer en geef de oefeningen door
        return view('exercises.index', compact('exercises'));
    }

    /**
     * Show the form for editing the specified exercise.
     *
     * @param  \App\Models\Exercise  $exercise
     * @return \Illuminate\Http\Response
     */
    public function edit(Exercise $exercise)
    {
        // Controleer of de ingelogde gebruiker de eigenaar is van de oefening
        // if ($exercise->user_id !== Auth::id()) {  // Verwijder deze regel
        //     abort(403, 'Unauthorized action.');
        // }
        // Geef de edit view weer en geef de oefening door
        return view('exercises.edit', compact('exercise'));
    }

    /**
     * Update the specified exercise in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Exercise  $exercise
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Exercise $exercise)
{
    // Valideer de request data
    $request->validate([
        'name' => 'required|string|max:255|unique:exercises,name,' . $exercise->id,
    ]);

    $exercise->name = $request->name;
    $exercise->save();

    // Redirect de gebruiker naar de index pagina met een succesmelding
    return redirect()->route('exercises.index')->with('success', 'Exercise updated successfully!');
}

}