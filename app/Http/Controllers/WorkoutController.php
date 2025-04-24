<?php

namespace App\Http\Controllers;

use App\Models\Workout;
use App\Models\Exercise;
use App\Models\WorkoutExercise; // Import WorkoutExercise (was al aanwezig in de tweede code)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WorkoutController extends Controller
{
    /**
     * Display a listing of the workouts and progress overview.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = Auth::id();

        // Basis workout data voor de lijstweergave (uit je originele code)
        $workouts = Workout::where('user_id', $userId)->orderBy('date', 'desc')->get();
        $exercises = Exercise::all();
        $lastWorkout = Workout::with('exercises')->orderBy('date', 'desc')->first();

        // --- START: Voortgangsdata verzamelen (uit je tweede code) ---
        $exerciseProgress = WorkoutExercise::whereHas('workout', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->with(['exercise', 'workout' => function($query) {
                $query->orderBy('date', 'asc'); // Zorg dat workouts gesorteerd zijn op datum
            }])
            ->get()
            ->groupBy('exercise_id') // Groepeer alle prestaties per oefening
            ->map(function ($performances, $exerciseId) {
                // Sorteer de prestaties binnen de groep op datum (via de workout relatie)
                $sortedPerformances = $performances->sortBy(function($performance) {
                    return $performance->workout->date;
                });

                $firstPerformance = $sortedPerformances->first();
                $lastPerformance = $sortedPerformances->last();

                if (!$firstPerformance) {
                    return null; // Zou niet moeten gebeuren als gegroepeerd, maar voor de zekerheid
                }

                $firstWeight = $firstPerformance->weight;
                $lastWeight = $lastPerformance->weight;
                $weightDiff = 0;
                $percentageChange = 0;

                // Bereken alleen verschil als er meer dan één prestatie is
                if ($sortedPerformances->count() > 1) {
                    $weightDiff = $lastWeight - $firstWeight;
                    if ($firstWeight > 0) { // Voorkom delen door nul
                        $percentageChange = ($weightDiff / $firstWeight) * 100;
                    } elseif ($lastWeight > 0) {
                        $percentageChange = 100; // Als gestart op 0 en nu > 0, is het effectief 100% progressie
                    }
                }

                return (object) [ // Gebruik een object voor duidelijkere toegang in de view
                    'exerciseId' => $exerciseId,
                    'exerciseName' => $firstPerformance->exercise->name, // Naam van de oefening
                    'performanceCount' => $sortedPerformances->count(), // Aantal keer uitgevoerd
                    'firstDate' => $firstPerformance->workout->date,
                    'firstWeight' => $firstWeight,
                    'lastDate' => $lastPerformance->workout->date,
                    'lastWeight' => $lastWeight,
                    'weightDiff' => $weightDiff,
                    'percentageChange' => $percentageChange,
                ];
            })
            ->filter() // Verwijder eventuele null waarden
            ->sortByDesc(function($progress) { // Sorteer op laatste datum (nieuwste bovenaan)
                return $progress->lastDate;
            });
        // --- EINDE: Voortgangsdata verzamelen ---


        // Haal unieke oefeningen op die de gebruiker heeft gedaan (voor de top card)
        $uniqueExercisesPerformedCount = $exerciseProgress->count();


        return view('workouts.index', compact(
            'workouts', // Basis workouts lijst
            'exercises', // Alle oefeningen
            'lastWorkout', // Laatste workout
            'exerciseProgress', // Nieuwe data voor voortgang
            'uniqueExercisesPerformedCount' // Nieuwe data voor top card
        ));
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

{

}

        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date|before_or_equal:today',
            'notes' => 'nullable|string',
            'exercise_name' => 'required|array',
            'exercise_name.*' => 'required|string|max:255',
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
                'date' => Carbon::parse($request->date)->format('Y-m-d'), // Correcte notatie afdwingen
                'notes' => $request->notes,
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
     * Display the specified workout.
     *
     * @param  \App\Models\Workout  $workout
     * @return \Illuminate\Http\Response
     */
    public function show(Workout $workout)
    {
        $workout->load('exercises');
        return view('workouts.show', compact('workout'));
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
            'notes' => 'nullable|string',
            'exercise_name' => 'required|array',
            'exercise_name.*' => 'required|string|max:255',
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
                'date' => Carbon::parse($request->date)->format('Y-m-d'), // Correcte notatie afdwingen
                'notes' => $request->notes,
            ]);

            // Sync the exercises
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

    public function listHistory() // <-- NIEUWE METHODE (ongewijzigd)
    {
        $workouts = Workout::where('user_id', Auth::id())
                            ->with('exercises') // Eager load exercises for efficiency
                            ->orderBy('date', 'desc')
                            ->get();

        // Gebruik de bestaande list view
        return view('workouts.list', compact('workouts'));
    }
}