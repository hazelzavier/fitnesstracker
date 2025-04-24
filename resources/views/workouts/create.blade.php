@extends('layouts.app')

@section('content')
{{-- Buitenste container met achtergrondkleur --}}
<div class="bg-gray-100 dark:bg-gray-900 min-h-screen py-8">
    {{-- Innerlijke container met max breedte --}}
    {{-- VOEG showWarningModal TOE AAN x-data --}}
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8" x-data="{ showWarningModal: false }">

        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-gray-100 mb-6 text-center sm:text-left">
            Log a New Workout
        </h2>

        {{-- Formulier kaart --}}
        {{-- Verwijder x-data hier als je het op de parent div hierboven hebt gezet --}}
        <form method="POST" action="{{ route('workouts.store') }}" class="relative bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 md:p-8 space-y-6">
            @csrf

            {{-- Workout Details Sectie (blijft hetzelfde) --}}
            <fieldset class="space-y-4">
                {{-- ... (legend, naam, datum, notities) ... --}}
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

            {{-- Exercises Sectie (blijft hetzelfde) --}}
            <fieldset class="space-y-4">
                {{-- ... (legend, exercise-fields div, eerste blok) ... --}}
                 <legend class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2 border-b border-gray-200 dark:border-gray-700 pb-1">Exercises</legend>
                <div id="exercise-fields" class="space-y-6">
                    {{-- Eerste Oefening Blok --}}
                    <div class="exercise-field bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-md p-4 space-y-3">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Exercise #1</p>
                        {{-- Naam, Weight, Reps, Sets velden blijven hetzelfde --}}
                        <div>
                            <label for="exercise_name_0" class="block text-xs font-medium text-gray-600 dark:text-gray-300">Name:</label>
                            <input type="text" name="exercise_name[]" id="exercise_name_0" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 dark:focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 rounded-md shadow-sm text-sm" required>
                            @error('exercise_name.0') <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                        </div>
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
                    </div>
                </div>
                {{-- Knop om extra oefeningen toe te voegen (blijft hetzelfde) --}}
                <div class="text-right">
                    <button type="button" id="add-exercise-button" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-md shadow focus:outline-none focus:shadow-outline text-sm inline-flex items-center">
                        <i class="fas fa-plus mr-1"></i> Add Another Exercise
                    </button>
                </div>
            </fieldset>

            {{-- Submit & Cancel Knoppen (blijft hetzelfde) --}}
            <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ url()->previous(route('home')) }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-5 rounded-lg shadow focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                    Save Workout
                </button>
            </div>
        </form>

        {{-- *** START: Warning Modal *** --}}
        {{-- Gebruik showWarningModal state variabele --}}
        <div x-show="showWarningModal"
             style="display: none;" {{-- Voorkomt FOUC --}}
             class="fixed inset-0 bg-gray-900 bg-opacity-50 dark:bg-opacity-70 flex items-center justify-center z-50 px-4"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">

            {{-- Modal Content (gebaseerd op delete modal, maar aangepast) --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-6 max-w-md mx-auto"
                 @click.outside="showWarningModal = false" {{-- Sluit modal bij klikken buiten --}}
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform scale-90"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-90">

                {{-- Modal Header --}}
                <div class="flex justify-between items-center mb-4">
                    {{-- Titel aangepast --}}
                    <h3 class="text-xl font-semibold text-yellow-600 dark:text-yellow-400 flex items-center">
                         <i class="fas fa-exclamation-triangle mr-2"></i> Warning
                    </h3>
                    {{-- Sluitknop --}}
                    <button @click="showWarningModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                {{-- Modal Body --}}
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    You must have at least one exercise listed in your workout.
                </p>

                {{-- Modal Footer (Alleen OK knop) --}}
                <div class="flex justify-end space-x-3">
                    {{-- OK knop die de modal sluit --}}
                    <button @click="showWarningModal = false"
                            type="button"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                        OK
                    </button>
                    {{-- Tweede knop (Delete) verwijderd --}}
                </div>
            </div>
        </div>
        {{-- *** EINDE: Warning Modal *** --}}

    </div> {{-- Einde innerlijke container met x-data --}}
</div> {{-- Einde buitenste container --}}

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const addExerciseButton = document.getElementById('add-exercise-button');
        const exerciseFieldsContainer = document.getElementById('exercise-fields');
        let exerciseCounter = 1;

        // Functie om de waarschuwingsMODAL te tonen
        function showWarningModal() {
            // Vind de root div met x-data
            const alpineComponentRoot = document.querySelector('div[x-data]');
            if (alpineComponentRoot && alpineComponentRoot.__x) {
                 alpineComponentRoot.__x.data.showWarningModal = true;
            } else {
                // Fallback naar alert als Alpine niet gevonden wordt
                console.error("Alpine component not found for warning modal.");
                alert("You must have at least one exercise.");
            }
        }

        if (addExerciseButton && exerciseFieldsContainer) {
            addExerciseButton.addEventListener('click', function () {
                const newExerciseField = document.createElement('div');
                newExerciseField.className = 'exercise-field bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-md p-4 space-y-3';
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
                exerciseCounter++;

                // Event listener voor de nieuwe remove knop
                const removeButton = newExerciseField.querySelector('.remove-exercise-field');
                if(removeButton) {
                    removeButton.addEventListener('click', function () {
                        if (exerciseFieldsContainer.children.length > 1) {
                            newExerciseField.remove();
                        } else {
                            // *** GEBRUIK DE NIEUWE MODAL FUNCTIE ***
                            showWarningModal();
                        }
                    });
                }
            });
        }

        // Event listener voor remove knoppen (delegatie)
        exerciseFieldsContainer.addEventListener('click', function (event) {
            const removeButton = event.target.closest('.remove-exercise-field');
            if (removeButton) {
                const exerciseField = removeButton.closest('.exercise-field');
                if (exerciseField) {
                    if (exerciseFieldsContainer.children.length > 1) {
                        exerciseField.remove();
                    } else {
                        // *** GEBRUIK DE NIEUWE MODAL FUNCTIE ***
                        showWarningModal();
                    }
                }
            }
        });
    });
</script>
@endsection
