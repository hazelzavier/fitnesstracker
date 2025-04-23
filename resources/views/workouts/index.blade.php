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
                            <p class="text-2xl font-bold text-gray-800">{{ $exercises->count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <i class="far fa-calendar-alt text-purple-600 mr-3 text-lg"></i>
                        <div>
                            <p class="text-sm text-gray-500">Last Workout</p>
                            <p class="text-2xl font-bold text-gray-800">
                                {{ $lastWorkout ? $lastWorkout->date->format('d-m-Y') : 'No workouts' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-sm">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Progress Overview</h3>
                {{--  Stats Component replacement  --}}
                @if ($workouts->isNotEmpty())
                    @foreach ($exercises as $exercise)
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-2">
                                <h4 class="font-medium text-gray-800">{{ $exercise->name }}</h4>
                                 <span class="text-sm text-gray-500">{{ $workouts->where('exercise_id', $exercise->id)->count() }} workouts</span>
                            </div>
                            <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                                {{--  TODO:  calculate progress  --}}
                                <div class="h-full bg-green-500" style="width: 50%"></div>
                            </div>
                            <div class="flex justify-between mt-1 text-sm">
                                <span class="text-gray-600">Started: 100 kg</span>
                                <span class="font-medium text-green-600">+10 kg (+10%)</span>
                                 <span class="text-gray-600">Current: 110 kg</span>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-gray-600 mt-4">No workouts have been added yet.</p>
                @endif
            </div>
        @endif
    </div>
@endsection
