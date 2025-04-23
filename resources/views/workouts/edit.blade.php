@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Edit Workout</h2>

        <form method="POST" action="{{ route('workouts.update', $workout->id) }}" class="bg-white shadow-md rounded-md p-6 space-y-4">
            @csrf
            @method('PUT') {{--  method directive voor Laravel om aan te geven dat dit een update request is  --}}

            <div>
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Workout Name:</label>
                <input type="text" name="name" id="name" value="{{ $workout->name }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                @error('name')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="date" class="block text-gray-700 text-sm font-bold mb-2">Date:</label>
                <input type="date" name="date" id="date" value="{{ $workout->date }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                 @error('date')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div id="exercise-fields">
                @foreach ($workout->exercises as $exercise)
                    <div class="exercise-field mt-4 p-4 border rounded-md">
                        <label for="exercise_name" class="block text-gray-700 text-sm font-bold mb-2">Exercise Name:</label>
                         <input type="text" name="exercise_name[]" value="{{ $exercise->name }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>

                        <label for="weight" class="block text-gray-700 text-sm font-bold mb-2">Weight (kg):</label>
                        <input type="number" name="weight[]" value="{{ $exercise->pivot->weight }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>

                        <label for="reps" class="block text-gray-700 text-sm font-bold mb-2">Repetitions:</label>
                        <input type="number" name="reps[]" value="{{ $exercise->pivot->reps }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>

                        <label for="sets" class="block text-gray-700 text-sm font-bold mb-2">Sets:</label>
                        <input type="number" name="sets[]" value="{{ $exercise->pivot->sets }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>

                        <button type="button" class="add-exercise-field bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded text-xs focus:outline-none focus:shadow-outline mt-2">Add Exercise</button>
                        <button type="button" class="remove-exercise-field bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-xs focus:outline-none focus:shadow-outline mt-2">Remove Exercise</button>
                    </div>
                @endforeach
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Update Workout
            </button>
             <a href="{{ route('workouts.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Cancel
            </a>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const addExerciseFieldButton = document.querySelector('.add-exercise-field');
            const exerciseFieldsContainer = document.getElementById('exercise-fields');

            if (addExerciseFieldButton && exerciseFieldsContainer) {
                addExerciseFieldButton.addEventListener('click', function () {
                    const newExerciseField = document.createElement('div');
                    newExerciseField.className = 'exercise-field mt-4 p-4 border rounded-md';
                    newExerciseField.innerHTML = `
                            <label for="exercise_name" class="block text-gray-700 text-sm font-bold mb-2">Exercise Name:</label>
                            <input type="text" name="exercise_name[]"  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            <label for="weight" class="block text-gray-700 text-sm font-bold mb-2">Weight (kg):</label>
                            <input type="number" name="weight[]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            <label for="reps" class="block text-gray-700 text-sm font-bold mb-2">Repetitions:</label>
                            <input type="number" name="reps[]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            <label for="sets" class="block text-gray-700 text-sm font-bold mb-2">Sets:</label>
                            <input type="number" name="sets[]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            <button type="button" class="remove-exercise-field bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-xs focus:outline-none focus:shadow-outline mt-2">Remove Exercise</button>
                        `;
                    exerciseFieldsContainer.appendChild(newExerciseField);

                    const removeButton = newExerciseField.querySelector('.remove-exercise-field');
                    removeButton.addEventListener('click', function () {
                        newExerciseField.remove();
                    });
                });
            }

             exerciseFieldsContainer.addEventListener('click', function (event) {
                if (event.target.classList.contains('remove-exercise-field')) {
                    const exerciseField = event.target.closest('.exercise-field');
                    if (exerciseField) {
                        exerciseField.remove();
                    }
                }
            });
        });
    </script>
@endsection
