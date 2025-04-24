@extends('layouts.app')

@section('content')
{{-- Buitenste container met achtergrondkleur --}}
<div class="bg-gray-100 dark:bg-gray-900 min-h-screen py-8">
    {{-- Innerlijke container met max breedte voor betere leesbaarheid --}}
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-gray-100 mb-6 text-center sm:text-left">
            Log a New Workout
        </h2>

        {{-- Formulier kaart --}}
        <form method="POST" action="{{ route('workouts.store') }}" class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 md:p-8 space-y-6">
            @csrf

            {{-- Workout Details Sectie --}}
            <fieldset class="space-y-4">
                <legend class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2 border-b border-gray-200 dark:border-gray-700 pb-1">Workout Details</legend>
                {{-- Naam --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Workout Name:</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 dark:focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 rounded-md shadow-sm text-sm" required>
                    @error('name')
                        <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                {{-- Datum --}}
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date:</label>
                    <input type="date" name="date" id="date" value="{{ old('date', date('Y-m-d')) }}" class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 dark:focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 rounded-md shadow-sm text-sm" required>
                    @error('date')
                        <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                {{-- Notities --}}
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Notes (Optional):</label>
                    <textarea name="notes" id="notes" rows="3" class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 dark:focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 rounded-md shadow-sm text-sm">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </fieldset>

            {{-- Exercises Sectie --}}
            <fieldset class="space-y-4">
                <legend class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2 border-b border-gray-200 dark:border-gray-700 pb-1">Exercises</legend>

                <div id="exercise-fields" class="space-y-6">
                    {{-- Eerste Oefening Blok (zonder Add/Remove knoppen) --}}
                    <div class="exercise-field bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-md p-4 space-y-3">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Exercise #1</p>
                        {{-- Oefening Naam --}}
                        <div>
                            <label for="exercise_name_0" class="block text-xs font-medium text-gray-600 dark:text-gray-300">Name:</label>
                            <input type="text" name="exercise_name[]" id="exercise_name_0" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 dark:focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 rounded-md shadow-sm text-sm" required>
                            @error('exercise_name.0') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                        </div>
                        {{-- Grid voor Weight, Reps, Sets --}}
                        <div class="grid grid-cols-3 gap-3">
                            <div>
                                <label for="weight_0" class="block text-xs font-medium text-gray-600 dark:text-gray-300">Weight (kg):</label>
                                <input type="number" step="0.1" name="weight[]" id="weight_0" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 dark:focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 rounded-md shadow-sm text-sm" required>
                                @error('weight.0') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="reps_0" class="block text-xs font-medium text-gray-600 dark:text-gray-300">Reps:</label>
                                <input type="number" name="reps[]" id="reps_0" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 dark:focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 rounded-md shadow-sm text-sm" required>
                                @error('reps.0') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="sets_0" class="block text-xs font-medium text-gray-600 dark:text-gray-300">Sets:</label>
                                <input type="number" name="sets[]" id="sets_0" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 dark:focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 rounded-md shadow-sm text-sm" required>
                                @error('sets.0') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        {{-- Knoppen hier verwijderd --}}
                    </div>
                    {{-- Einde Eerste Oefening Blok --}}
                </div>

                {{-- Knop om extra oefeningen toe te voegen --}}
                <div class="text-right">
                    <button type="button" id="add-exercise-button" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-md shadow focus:outline-none focus:shadow-outline text-sm inline-flex items-center">
                        <i class="fas fa-plus mr-1"></i> Add Another Exercise
                    </button>
                </div>
            </fieldset>

            {{-- Submit & Cancel Knoppen --}}
            <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ url()->previous(route('home')) }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-5 rounded-lg shadow focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                    Save Workout
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const addExerciseButton = document.getElementById('add-exercise-button'); // Target de nieuwe knop ID
        const exerciseFieldsContainer = document.getElementById('exercise-fields');
        let exerciseCounter = 1; // Start teller voor unieke IDs

        if (addExerciseButton && exerciseFieldsContainer) {
            addExerciseButton.addEventListener('click', function () {
                const newExerciseField = document.createElement('div');
                newExerciseField.className = 'exercise-field bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-md p-4 space-y-3'; // Consistent styling

                // Gebruik teller voor unieke IDs
                const currentId = exerciseCounter;

                newExerciseField.innerHTML = `
                    <div class="flex justify-between items-center">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Exercise #${currentId + 1}</p>
                        <button type="button" class="remove-exercise-field text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 text-xs" title="Remove Exercise">
                            <i class="fas fa-times-circle"></i> Remove
                        </button>
                    </div>
                    <div>
                        <label for="exercise_name_${currentId}" class="block text-xs font-medium text-gray-600 dark:text-gray-300">Name:</label>
                        <input type="text" name="exercise_name[]" id="exercise_name_${currentId}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 dark:focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 rounded-md shadow-sm text-sm" required>
                    </div>
                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label for="weight_${currentId}" class="block text-xs font-medium text-gray-600 dark:text-gray-300">Weight (kg):</label>
                            <input type="number" step="0.1" name="weight[]" id="weight_${currentId}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 dark:focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 rounded-md shadow-sm text-sm" required>
                        </div>
                        <div>
                            <label for="reps_${currentId}" class="block text-xs font-medium text-gray-600 dark:text-gray-300">Reps:</label>
                            <input type="number" name="reps[]" id="reps_${currentId}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 dark:focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 rounded-md shadow-sm text-sm" required>
                        </div>
                        <div>
                            <label for="sets_${currentId}" class="block text-xs font-medium text-gray-600 dark:text-gray-300">Sets:</label>
                            <input type="number" name="sets[]" id="sets_${currentId}" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 dark:focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 rounded-md shadow-sm text-sm" required>
                        </div>
                    </div>
                `;
                exerciseFieldsContainer.appendChild(newExerciseField);
                exerciseCounter++; // Verhoog teller voor volgende blok

                // Event listener voor de nieuwe remove knop (direct toegevoegd)
                const removeButton = newExerciseField.querySelector('.remove-exercise-field');
                if(removeButton) {
                    removeButton.addEventListener('click', function () {
                        newExerciseField.remove();
                        // Optioneel: Update de # nummers als je wilt
                    });
                }
            });
        }

        // Event listener voor remove knoppen (blijft nodig voor het geval de eerste listener niet pakt)
        exerciseFieldsContainer.addEventListener('click', function (event) {
            if (event.target.closest('.remove-exercise-field')) { // Gebruik closest om ook op icoon te reageren
                const exerciseField = event.target.closest('.exercise-field');
                if (exerciseField && exerciseFieldsContainer.children.length > 1) { // Verwijder alleen als er meer dan 1 is
                    exerciseField.remove();
                    // Optioneel: Update de # nummers als je wilt
                } else if (exerciseField && exerciseFieldsContainer.children.length === 1) {
                    // Optioneel: Geef een melding of maak velden leeg ipv verwijderen
                    alert("You must have at least one exercise.");
                }
            }
        });
    });
</script>
@endsection
