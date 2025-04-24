@extends('layouts.app')

@section('content')
{{-- BUITENSTE DIV: Blijft hetzelfde, zorgt voor achtergrond en verticale padding --}}
<div class="bg-gray-100 dark:bg-gray-900 min-h-screen py-8">

    {{-- INNERLIJKE DIV: Verwijder 'container' en 'mx-auto' --}}
    <div class="px-4 sm:px-6 lg:px-8"> {{-- Alleen padding blijft over --}}

        {{-- De rest van je content blijft hierbinnen --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">Workout History</h1>
            <a href="{{ route('workouts.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                <i class="fas fa-plus mr-1"></i> Add Workout
            </a>
        </div>

        @if ($workouts->isNotEmpty())
            {{-- De kaart met de tabel zal nu de volledige breedte (minus padding) innemen --}}
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
                                <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        {{-- Table Body --}}
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($workouts as $workout)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500 dark:text-gray-400">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 dark:text-white">{{ $workout->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                        {{ \Carbon\Carbon::parse($workout->date)->format('d-m-Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-normal text-sm text-gray-700 dark:text-gray-300">
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
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                        <a href="{{ route('workouts.show', $workout->id) }}" class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300 transition duration-150 ease-in-out" title="View">
                                            <i class="fas fa-eye fa-fw"></i>
                                        </a>
                                        <a href="{{ route('workouts.edit', $workout->id) }}" class="text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-300 transition duration-150 ease-in-out" title="Edit">
                                            <i class="fas fa-pencil-alt fa-fw"></i>
                                        </a>
                                        <form action="{{ route('workouts.destroy', $workout->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this workout?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition duration-150 ease-in-out" title="Delete">
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
            {{-- De 'geen workouts' kaart zal nu ook de volledige breedte (minus padding) innemen --}}
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg p-12 text-center">
                <i class="fas fa-folder-open text-gray-400 dark:text-gray-500 text-4xl mb-4"></i>
                <p class="text-xl font-semibold text-gray-700 dark:text-gray-200 mb-2">No workouts found yet.</p>
                <p class="text-gray-500 dark:text-gray-400 mb-6">Start tracking your progress by adding your first workout!</p>
                <a href="{{ route('workouts.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-5 rounded-lg shadow focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                    <i class="fas fa-plus mr-1"></i> Add Your First Workout
                </a>
            </div>
        @endif

    </div> {{-- Einde van de innerlijke div (nu zonder container/mx-auto) --}}
</div> {{-- Einde van de buitenste div --}}

{{-- Font Awesome link blijft nodig --}}
@endsection
