@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-semibold text-gray-800 mb-4">Workout Dashboard</h1>

        @if ($workouts->isEmpty())
            <div class="bg-white p-6 rounded-lg shadow-sm text-center">
                <p class="text-gray-600">Welcome to FitTrack! Add your first workout to get started.</p>
                <a href="{{ route('workouts.create') }}" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 inline-block">
                    Add Workout
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <i class="fas fa-chart-bar text-blue-600 mr-3 text-lg"></i>
                        <div>
                            <p class="text-sm text-gray-500">Total Workouts</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $workouts->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <i class="fas fa-dumbbell text-green-600 mr-3 text-lg"></i>
                        <div>
                            <p class="text-sm text-gray-500">Unique Exercises</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $uniqueExercisesPerformedCount }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <i class="far fa-calendar-alt text-purple-600 mr-3 text-lg"></i>
                        <div>
                            <p class="text-sm text-gray-500">Last Workout</p>
                            <p class="text-2xl font-bold text-gray-800">
                                {{ $lastWorkout ? ($lastWorkout->date instanceof \Carbon\Carbon ? $lastWorkout->date->format('d-m-Y') : \Carbon\Carbon::parse($lastWorkout->date)->format('d-m-Y'))  : 'No workouts' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-700">Voortgangsoverzicht</h3>
                <div class="space-x-2">
                    <a href="{{ route('workouts.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Add Workout
                    </a>
                    <a href="{{ route('workouts.list') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Oefeningen beheren
                    </a>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm">

                @if ($exerciseProgress->isNotEmpty())
                    <div class="space-y-6">
                        @foreach ($exerciseProgress as $progress)
                            <div>
                                <div class="flex justify-between items-baseline mb-1">
                                    <h4 class="font-semibold text-lg text-gray-700">{{ $progress->exerciseName }}</h4>
                                    <span class="text-xs text-gray-500">{{ $progress->performanceCount }} session(s)</span>
                                </div>
                                <div class="relative pt-1">
                                    <div class="overflow-hidden h-3 mb-2 text-xs flex rounded bg-gray-200">
                                        @php
                                            // Bepaal progressie percentage (bijv. gebaseerd op gewichtstoename)
                                            $progressBarWidth = 0;
                                            if ($progress->performanceCount > 1 && $progress->firstWeight > 0) {
                                                $progressBarWidth = max(0, min(100, ($progress->weightDiff / $progress->firstWeight) * 100));
                                            } elseif ($progress->performanceCount > 1 && $progress->weightDiff > 0) {
                                                $progressBarWidth = 100; // Gestart op 0, nu > 0
                                            }
                                        @endphp
                                        <div style="width:{{ $progressBarWidth }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center {{ $progress->weightDiff >= 0 ? 'bg-green-500' : 'bg-red-500' }} transition-all duration-500 ease-out"></div>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center mt-1 text-sm">
                                    <span class="text-gray-600">Started: <span class="font-medium">{{ number_format($progress->firstWeight, 1) }} kg</span> ({{ \Carbon\Carbon::parse($progress->firstDate)->format('d-m-Y') }})</span>
                                    @if ($progress->performanceCount > 1)
                                        <span class="font-medium {{ $progress->weightDiff >= 0 ? 'text-green-600' : 'text-red-600' }}">{{ $progress->weightDiff >= 0 ? '+' : '' }}{{ number_format($progress->weightDiff, 1) }} kg ({{ $progress->weightDiff >= 0 ? '+' : '' }}{{ number_format($progress->percentageChange, 0) }}%)</span>
                                    @else
                                        <span class="text-gray-500 italic">First entry</span>
                                    @endif
                                    <span class="text-gray-600">Current: <span class="font-medium">{{ number_format($progress->lastWeight, 1) }} kg</span> ({{ \Carbon\Carbon::parse($progress->lastDate)->format('d-m-Y') }})</span>
                                </div>
                            </div>
                            @if (!$loop->last)
                                <hr class="border-gray-200 my-4">
                            @endif
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600 mt-4">No progress data available yet. Add more workouts to see your progress!</p>
                @endif
            </div>
        @endif
    </div>
@endsection