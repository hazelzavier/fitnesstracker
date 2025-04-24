@php
use Illuminate\Support\Str; // <-- VOEG DEZE REGEL TOE
@endphp

@extends('layouts.app')

@section('content')
{{-- BUITENSTE DIV --}}
<div class="bg-gray-100 dark:bg-gray-900 min-h-screen py-8">

    {{-- INNERLIJKE DIV met x-data --}}
    <div class="px-4 sm:px-6 lg:px-8" x-data="{ showConfirmModal: false, targetFormId: null }">

        {{-- Titel en Add Workout knop --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">Workout History</h1>
            <a href="{{ route('workouts.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                <i class="fas fa-plus mr-1"></i> Add Workout
            </a>
        </div>

        @if ($workouts->isNotEmpty())
            {{-- Tabel kaart --}}
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        {{-- Table Head --}}
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">#</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Workout Name</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Exercises</th>
                                {{-- *** AANGEPASTE HEADER VOOR NOTES *** --}}
                                <th scope="col" class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    Notes Preview {{-- Tekst aangepast --}}
                                </th>
                                {{-- *** EINDE AANGEPASTE HEADER *** --}}
                                <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        {{-- Table Body --}}
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($workouts as $workout)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                                    {{-- Andere cellen --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500 dark:text-gray-400">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 dark:text-white">{{ $workout->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                        {{ \Carbon\Carbon::parse($workout->date)->format('d-m-Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-normal text-sm text-gray-700 dark:text-gray-300">
                                        {{-- Exercise badges --}}
                                        <div class="flex flex-wrap gap-1">
                                            @forelse($workout->exercises as $exercise)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                                    <i class="fas fa-dumbbell mr-1 opacity-75"></i>
                                                    <span class="mr-1.5">{{ $exercise->name }}</span>
                                                    <span class="inline-flex items-center space-x-1 text-blue-600 dark:text-blue-400 font-medium">
                                                        <span class="inline-flex items-baseline">
                                                            <i class="fas fa-weight-hanging text-xs mr-0.5 opacity-60" title="Weight"></i>
                                                            <span>{{ $exercise->pivot->weight }}</span>
                                                            <span class="text-[0.65rem] opacity-75 ml-0.5">kg</span>
                                                        </span>
                                                        <span class="text-gray-400 dark:text-gray-500 text-opacity-50">&middot;</span>
                                                        <span class="inline-flex items-baseline">
                                                            <i class="fas fa-redo-alt text-xs mr-0.5 opacity-60" title="Reps"></i>
                                                            <span>{{ $exercise->pivot->reps }}</span>
                                                            <span class="text-[0.65rem] opacity-75 ml-0.5">reps</span>
                                                        </span>
                                                        <span class="text-gray-400 dark:text-gray-500 text-opacity-50">&middot;</span>
                                                        <span class="inline-flex items-baseline">
                                                            <i class="fas fa-layer-group text-xs mr-0.5 opacity-60" title="Sets"></i>
                                                            <span>{{ $exercise->pivot->sets }}</span>
                                                            <span class="text-[0.65rem] opacity-75 ml-0.5">sets</span>
                                                        </span>
                                                    </span>
                                                </span>
                                            @empty
                                                <span class="text-xs text-gray-500 italic">No exercises recorded</span>
                                            @endforelse
                                        </div>
                                    </td>
                                    {{-- *** AANGEPASTE CEL VOOR NOTES INDICATOR & PREVIEW *** --}}
                                    <td class="px-4 py-4 text-left text-sm text-gray-500 dark:text-gray-400"> {{-- Padding en uitlijning aangepast --}}
                                        {{-- Toon alleen als er notities zijn --}}
                                        @if (!empty($workout->notes))
                                            <div class="flex items-start space-x-1" title="{{ $workout->notes }}"> {{-- Tooltip op de container --}}
                                                <i class="fas fa-sticky-note text-yellow-500 dark:text-yellow-400 mt-0.5 flex-shrink-0"></i> {{-- Icoon blijft --}}
                                                <span class="text-xs italic"> {{-- Preview tekst --}}
                                                    {{ Str::limit($workout->notes, 40, '...') }} {{-- Inkorten tot 40 tekens --}}
                                                </span>
                                            </div>
                                        @endif
                                        {{-- Anders blijft de cel leeg --}}
                                    </td>
                                    {{-- *** EINDE AANGEPASTE CEL *** --}}
                                    {{-- Actions cel (met delete form) --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                        {{-- View en Edit links --}}
                                        <a href="{{ route('workouts.show', $workout->id) }}" class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 transition duration-150 ease-in-out" title="View">
                                            <i class="fas fa-eye fa-fw"></i>
                                        </a>
                                        <a href="{{ route('workouts.edit', $workout->id) }}" class="text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-300 transition duration-150 ease-in-out" title="Edit">
                                            <i class="fas fa-pencil-alt fa-fw"></i>
                                        </a>
                                        {{-- Delete Formulier --}}
                                        <form id="delete-form-{{ $workout->id }}" action="{{ route('workouts.destroy', $workout->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                    @click.prevent="targetFormId = 'delete-form-{{ $workout->id }}'; showConfirmModal = true"
                                                    class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition duration-150 ease-in-out"
                                                    title="Delete">
                                                <i class="fas fa-trash-alt fa-fw"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            {{-- 'Geen workouts' melding --}}
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-12 text-center">
                {{-- ... inhoud ... --}}
            </div>
        @endif

        {{-- Confirmation Modal --}}
        {{-- ... (modal code blijft hetzelfde) ... --}}
        <div x-show="showConfirmModal" style="display: none;" class="fixed inset-0 bg-gray-900 bg-opacity-50 dark:bg-opacity-70 flex items-center justify-center z-50 px-4" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-6 max-w-md mx-auto" @click.outside="showConfirmModal = false" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-90" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-90">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Confirm Deletion</h3>
                    <button @click="showConfirmModal = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    Are you sure you want to delete this workout? This action cannot be undone.
                </p>
                <div class="flex justify-end space-x-3">
                    <button @click="showConfirmModal = false" type="button" class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                        Cancel
                    </button>
                    <button @click="document.getElementById(targetFormId).submit(); showConfirmModal = false" type="button" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg shadow focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                        Delete Workout
                    </button>
                </div>
            </div>
        </div>
        {{-- EINDE Confirmation Modal --}}

    </div> {{-- Einde innerlijke div met x-data --}}
</div> {{-- Einde buitenste div --}}
@endsection
