@extends('layouts.app')

@section('content')
{{-- Buitenste container met achtergrondkleur --}}
<div class="bg-gray-100 dark:bg-gray-900 min-h-screen py-8">
    {{-- Innerlijke container - VOEG x-data TOE --}}
    <div class="px-4 sm:px-6 lg:px-8" x-data="{ showConfirmModal: false, targetFormId: null }">

        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6 md:p-8">
            {{-- Titel en Datum --}}
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 border-b border-gray-200 dark:border-gray-700 pb-4">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-gray-100 mb-2 sm:mb-0">
                    {{ $workout->name }}
                </h1>
                <span class="text-sm text-gray-500 dark:text-gray-400">
                    <i class="far fa-calendar-alt mr-1"></i> {{ \Carbon\Carbon::parse($workout->date)->format('l, d F Y') }}
                </span>
            </div>

            {{-- Notities --}}
            @if ($workout->notes)
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">Notes</h3>
                    <p class="text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-700 p-3 rounded-md whitespace-pre-wrap">{{ $workout->notes }}</p>
                </div>
            @endif

            {{-- Oefeningen --}}
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">Exercises</h3>
            @if ($workout->exercises->isNotEmpty())
                <div class="space-y-4">
                    @foreach ($workout->exercises as $exercise)
                        <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-md border border-gray-200 dark:border-gray-600">
                            <h4 class="font-semibold text-blue-800 dark:text-blue-300 mb-2">{{ $exercise->name }}</h4>
                            <div class="grid grid-cols-3 gap-4 text-sm">
                                <div class="text-center">
                                    <span class="block text-xs text-gray-500 dark:text-gray-400 uppercase">Weight</span>
                                    <span class="font-medium text-gray-800 dark:text-gray-200">{{ $exercise->pivot->weight }} kg</span>
                                </div>
                                <div class="text-center">
                                    <span class="block text-xs text-gray-500 dark:text-gray-400 uppercase">Reps</span>
                                    <span class="font-medium text-gray-800 dark:text-gray-200">{{ $exercise->pivot->reps }}</span>
                                </div>
                                <div class="text-center">
                                    <span class="block text-xs text-gray-500 dark:text-gray-400 uppercase">Sets</span>
                                    <span class="font-medium text-gray-800 dark:text-gray-200">{{ $exercise->pivot->sets }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 italic">No exercises recorded for this workout.</p>
            @endif

            {{-- Knoppen onderaan --}}
            <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
                <a href="{{ route('workouts.list') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 transition duration-150 ease-in-out">
                    <i class="fas fa-arrow-left mr-1"></i> Back to History
                </a>
                <div class="flex space-x-3">
                    {{-- Edit knop blijft hetzelfde --}}
                    <a href="{{ route('workouts.edit', $workout->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded-lg shadow focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                        <i class="fas fa-pencil-alt mr-1"></i> Edit Workout
                    </a>

                    {{-- *** AANPASSING DELETE FORMULIER *** --}}
                    {{-- Verwijder onsubmit, voeg ID toe --}}
                    <form id="delete-form-{{ $workout->id }}" action="{{ route('workouts.destroy', $workout->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        {{-- Verander type naar button, voeg @click toe --}}
                        <button type="button"
                                @click.prevent="targetFormId = 'delete-form-{{ $workout->id }}'; showConfirmModal = true"
                                class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg shadow focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                            <i class="fas fa-trash-alt mr-1"></i> Delete Workout
                        </button>
                    </form>
                    {{-- *** EINDE AANPASSING DELETE FORMULIER *** --}}
                </div>
            </div>

        </div> {{-- Einde witte kaart --}}

        {{-- *** START: Confirmation Modal (gekopieerd van list.blade.php) *** --}}
        <div x-show="showConfirmModal"
             style="display: none;" {{-- Voorkomt FOUC --}}
             class="fixed inset-0 bg-gray-900 bg-opacity-50 dark:bg-opacity-70 flex items-center justify-center z-50 px-4"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">

            {{-- Modal Content --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-6 max-w-md mx-auto"
                 @click.outside="showConfirmModal = false" {{-- Sluit modal bij klikken buiten --}}
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform scale-90"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-90">

                {{-- Modal Header --}}
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Confirm Deletion</h3>
                    <button @click="showConfirmModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                {{-- Modal Body --}}
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    Are you sure you want to delete this workout? This action cannot be undone.
                </p>

                {{-- Modal Footer (Buttons) --}}
                <div class="flex justify-end space-x-3">
                    <button @click="showConfirmModal = false"
                            type="button"
                            class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                        Cancel
                    </button>
                    <button @click="document.getElementById(targetFormId).submit(); showConfirmModal = false"
                            type="button"
                            class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg shadow focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                        Delete Workout
                    </button>
                </div>
            </div>
        </div>
        {{-- *** EINDE: Confirmation Modal *** --}}

    </div> {{-- Einde innerlijke container met x-data --}}
</div> {{-- Einde buitenste container --}}
@endsection
