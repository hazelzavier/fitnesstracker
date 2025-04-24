@extends('layouts.app')

@section('content')
{{-- Buitenste container met achtergrondkleur --}}
<div class="bg-gray-100 dark:bg-gray-900 min-h-screen py-8">
    {{-- Innerlijke container --}}
    <div class="px-4 sm:px-6 lg:px-8">

        

        {{-- Success message (kleuren zijn al ok) --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if ($workouts->isEmpty())
            {{-- Uitgebreide 'lege staat' kaart MET ACHTERGROND AFBEELDING --}}
            <div class="relative p-8 sm:p-12 rounded-lg shadow-lg overflow-hidden
                        bg-[url('{{ asset('images/backgrounds/dashboard-empty-bg.jpg') }}')]
                        bg-cover bg-center bg-no-repeat">

                {{-- Semi-transparante overlay --}}
                <div class="absolute inset-0 bg-black/60 dark:bg-gray-900/70 rounded-lg z-10"></div>

                {{-- Container voor de inhoud, BOVEN de overlay --}}
                <div class="relative z-20">

                    {{-- Sectie 1: Welkom & Directe Actie (blijft hetzelfde) --}}
                    <div class="text-center mb-10">
                        <i class="fas fa-tachometer-alt text-blue-400 dark:text-blue-300 text-5xl mb-4"></i>
                        <h2 class="text-2xl font-bold text-white dark:text-gray-100 mb-2">
                            Welcome to Your Fitness Dashboard!
                        </h2>
                        <p class="text-gray-200 dark:text-gray-300 mb-6 max-w-lg mx-auto">
                            This is where your hard work pays off. Track your workouts, see your progress, and stay motivated. Let's get started!
                        </p>
                        <a href="{{ route('workouts.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow focus:outline-none focus:shadow-outline transition duration-150 ease-in-out inline-flex items-center text-lg">
                            <i class="fas fa-plus mr-2"></i>
                            Log Your First Workout
                        </a>
                    </div>

                    {{-- Scheidingslijn --}}
                    <hr class="border-gray-500 dark:border-gray-600 my-8 opacity-50">

                    {{-- Sectie 2: Motivatie (blijft hetzelfde) --}}
                    <div class="md:flex md:items-center md:space-x-8 mb-10">
                        <div class="md:w-1/2 text-center md:text-left mb-6 md:mb-0">
                             <img src="{{ asset('images/motivation/motivational-image.jpg') }}"
                                  alt="Motivational Fitness Image"
                                  class="rounded-lg shadow-md max-h-64 w-auto inline-block">
                        </div>
                        <div class="md:w-1/2 text-center md:text-left">
                            <blockquote class="relative">
                                <i class="fas fa-quote-left text-5xl text-gray-400 dark:text-gray-600 absolute -top-4 -left-4 opacity-30 -z-10"></i>
                                <p class="text-xl italic font-medium text-gray-100 dark:text-gray-200 mb-2">
                                    "Strength does not come from winning. Your struggles develop your strengths. When you go through hardships and decide not to surrender, that is strength."
                                </p>
                                <footer class="text-sm text-gray-300 dark:text-gray-400">- Arnold Schwarzenegger</footer>
                            </blockquote>
                        </div>
                    </div>

                    {{-- Scheidingslijn --}}
                    <hr class="border-gray-500 dark:border-gray-600 my-8 opacity-50">

                    {{-- Sectie 3: Vooruitblik (Iets aangepast) --}}
                    <div class="text-center mb-10">
                        <h3 class="text-xl font-semibold text-white dark:text-gray-100 mb-6">Unlock Your Potential</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 text-sm text-gray-300 dark:text-gray-400">
                            {{-- Voorbeeld 1: Stats --}}
                            <div class="bg-white/10 dark:bg-gray-700/50 backdrop-blur-sm p-4 rounded-lg border border-white/20 dark:border-gray-600/50 transform hover:scale-105 transition-transform duration-200">
                                <i class="fas fa-chart-line text-blue-400 dark:text-blue-300 text-2xl mb-2"></i>
                                <h4 class="font-semibold mb-1 text-white dark:text-gray-100">See Your Stats</h4>
                                <p>Get instant insights into your workout frequency and volume.</p>
                            </div>
                            {{-- Voorbeeld 2: Progress --}}
                            <div class="bg-white/10 dark:bg-gray-700/50 backdrop-blur-sm p-4 rounded-lg border border-white/20 dark:border-gray-600/50 transform hover:scale-105 transition-transform duration-200">
                                <i class="fas fa-chart-bar text-green-400 dark:text-green-300 text-2xl mb-2"></i>
                                <h4 class="font-semibold mb-1 text-white dark:text-gray-100">Track Your Growth</h4>
                                <p>Visualize your strength gains with the progress overview per exercise.</p>
                            </div>
                            {{-- Voorbeeld 3: History --}}
                            <div class="bg-white/10 dark:bg-gray-700/50 backdrop-blur-sm p-4 rounded-lg border border-white/20 dark:border-gray-600/50 transform hover:scale-105 transition-transform duration-200">
                                <i class="fas fa-history text-purple-400 dark:text-purple-300 text-2xl mb-2"></i>
                                <h4 class="font-semibold mb-1 text-white dark:text-gray-100">Review Your History</h4>
                                <p>Look back at past workouts, including exercises, weights, and notes.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Scheidingslijn --}}
                    <hr class="border-gray-500 dark:border-gray-600 my-8 opacity-50">

                    {{-- Sectie 4: Extra Tips / Volgende Stappen --}}
                    <div class="text-center">
                        <h3 class="text-xl font-semibold text-white dark:text-gray-100 mb-6">Need Inspiration?</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-sm text-gray-300 dark:text-gray-400">

                            {{-- Workout Idee --}}
                            <div class="bg-white/10 dark:bg-gray-700/50 backdrop-blur-sm p-6 rounded-lg border border-white/20 dark:border-gray-600/50 text-left">
                                <div class="flex items-center mb-3">
                                    <i class="fas fa-dumbbell text-green-400 dark:text-green-300 text-2xl mr-3"></i>
                                    <h4 class="font-semibold text-lg text-white dark:text-gray-100">Beginner Workout Idea</h4>
                                </div>
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Bodyweight Squats: 3 sets of 10-12 reps</li>
                                    <li>Push-ups (on knees if needed): 3 sets of as many reps as possible (AMRAP)</li>
                                    <li>Walking Lunges: 3 sets of 10-12 reps per leg</li>
                                    <li>Plank: 3 sets, hold for 30-60 seconds</li>
                                </ul>
                                <p class="text-xs italic mt-3 text-gray-400 dark:text-gray-500">Remember to warm up first and listen to your body!</p>
                            </div>

                            {{-- Fitness Tip --}}
                            <div class="bg-white/10 dark:bg-gray-700/50 backdrop-blur-sm p-6 rounded-lg border border-white/20 dark:border-gray-600/50 text-left">
                                <div class="flex items-center mb-3">
                                    <i class="fas fa-lightbulb text-yellow-400 dark:text-yellow-300 text-2xl mr-3"></i>
                                    <h4 class="font-semibold text-lg text-white dark:text-gray-100">Pro Tip: Consistency is Key</h4>
                                </div>
                                <p class="mb-2">
                                    Don't worry about lifting heavy or doing complex exercises right away. Focus on building a consistent routine.
                                </p>
                                <p>
                                    Even short, regular workouts are more effective than occasional intense sessions. Use the <span class="font-semibold text-white">Notes</span> section when adding workouts to track how you feel and stay mindful!
                                </p>
                                <div class="flex items-center text-gray-400 dark:text-gray-500 mt-4 text-xs">
                                     <i class="fas fa-tint mr-1"></i> Stay hydrated!
                                     <i class="fas fa-moon ml-4 mr-1"></i> Get enough sleep!
                                </div>
                            </div>
                
                    

                </div> {{-- Einde relative z-20 content container --}}

            </div>
        @else
        

       
        {{-- VOEG dark:text-gray-100 TOE --}}
        <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-6">Workout Dashboard</h1>

            {{-- Top Stats Cards (kleuren lijken al ok binnen de kaarten) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                {{-- Total Workouts Card --}}
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900 mr-4">
                            <i class="fas fa-chart-line text-blue-600 dark:text-blue-300 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Workouts</p>
                            {{-- Zorg dat $workouts hier correct is, mogelijk $userWorkouts gebruiken? --}}
                            <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $workouts->count() }}</p>
                        </div>
                    </div>
                </div>
                {{-- Unique Exercises Card --}}
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                    <div class="flex items-center">
                         <div class="p-3 rounded-full bg-green-100 dark:bg-green-900 mr-4">
                            <i class="fas fa-dumbbell text-green-600 dark:text-green-300 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Unique Exercises Done</p>
                            <p class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $uniqueExercisesPerformedCount }}</p>
                        </div>
                    </div>
                </div>
                {{-- Last Workout Card --}}
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 dark:bg-purple-900 mr-4">
                            <i class="far fa-calendar-check text-purple-600 dark:text-purple-300 text-xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Workout</p>
                            <p class="text-xl font-bold text-gray-800 dark:text-gray-100">
                                @if ($lastWorkout)
                                    {{ \Carbon\Carbon::parse($lastWorkout->date)->format('d M Y') }}
                                @else
                                    No workouts yet
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Voortgangsoverzicht Kaart --}}
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                {{-- VOEG dark:text-gray-100 TOE --}}
                <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-6">Progress Overview (by Weight)</h3>

                @if ($exerciseProgress->isNotEmpty())
                    <div class="space-y-6">
                        @foreach ($exerciseProgress as $progress)
                            <div>
                                {{-- Kleuren hier lijken al ok --}}
                                <div class="flex justify-between items-baseline mb-1">
                                    <h4 class="font-semibold text-lg text-gray-700 dark:text-gray-200">{{ $progress->exerciseName }}</h4>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ $progress->performanceCount }} session(s)</span>
                                </div>
                                {{-- Progress bar (kleuren zijn ok) --}}
                                <div class="relative pt-1">
                                    <div class="overflow-hidden h-3 mb-2 text-xs flex rounded bg-gray-200 dark:bg-gray-700">
                                        @php
                                            $progressBarWidth = 0;
                                            if ($progress->performanceCount > 1 && $progress->firstWeight > 0) {
                                                $progressBarWidth = max(0, min(100, ($progress->weightDiff / $progress->firstWeight) * 100));
                                            } elseif ($progress->performanceCount > 1 && $progress->weightDiff > 0) {
                                                 $progressBarWidth = 100;
                                            }
                                        @endphp
                                        <div style="width:{{ $progressBarWidth }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center {{ $progress->weightDiff >= 0 ? 'bg-green-500' : 'bg-red-500' }} transition-all duration-500 ease-out"></div>
                                    </div>
                                </div>
                                {{-- Stats onder balk (kleuren lijken al ok) --}}
                                <div class="flex justify-between items-center mt-1 text-sm">
                                    <div class="text-left text-gray-600 dark:text-gray-400">
                                        Started: <span class="font-medium text-gray-800 dark:text-gray-200">{{ number_format($progress->firstWeight, 1) }} kg</span>
                                        <span class="text-xs text-gray-500">({{ \Carbon\Carbon::parse($progress->firstDate)->format('d M Y') }})</span>
                                    </div>
                                    @if ($progress->performanceCount > 1)
                                        <div class="text-center font-medium {{ $progress->weightDiff >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $progress->weightDiff >= 0 ? '+' : '' }}{{ number_format($progress->weightDiff, 1) }} kg
                                            @if ($progress->firstWeight > 0 || $progress->weightDiff > 0)
                                             ({{ $progress->weightDiff >= 0 ? '+' : '' }}{{ number_format($progress->percentageChange, 0) }}%)
                                            @endif
                                        </div>
                                    @else
                                         <div class="text-center text-gray-500 text-xs italic">First entry</div>
                                    @endif
                                    <div class="text-right text-gray-600 dark:text-gray-400">
                                        Current: <span class="font-medium text-gray-800 dark:text-gray-200">{{ number_format($progress->lastWeight, 1) }} kg</span>
                                         <span class="text-xs text-gray-500">({{ \Carbon\Carbon::parse($progress->lastDate)->format('d M Y') }})</span>
                                    </div>
                                </div>
                            </div>
                            @if (!$loop->last)
                                <hr class="border-gray-200 dark:border-gray-700">
                            @endif
                        @endforeach
                    </div>
                @else
                    {{-- Lege staat voortgang (kleuren lijken ok) --}}
                    <div class="text-center py-10">
                        <i class="fas fa-chart-pie text-gray-400 dark:text-gray-500 text-4xl mb-4"></i>
                        <p class="text-gray-600 dark:text-gray-300">No progress data available yet.</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Add more workouts to see your progress!</p>
                    </div>
                @endif
            </div>
        @endif

    </div> {{-- Einde innerlijke container --}}
</div> {{-- Einde buitenste container --}}
@endsection
