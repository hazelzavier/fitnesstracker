@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-semibold text-gray-800 mb-4">Workout History</h1>

    @if ($workouts->isNotEmpty())
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-md">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Workout Name</th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Exercises</th>
                        <th class="py-3 px-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($workouts as $workout)
                        <tr>
                            <td class="py-3 px-4 whitespace-nowrap text-gray-700">{{ $loop->iteration }}</td>
                            <td class="py-3 px-4 whitespace-nowrap text-gray-700">{{ $workout->name }}</td>
                            <td class="py-3 px-4 whitespace-nowrap text-gray-700">{{ $workout->date }}</td>
                            <td class="py-3 px-4 whitespace-nowrap">
                                @foreach($workout->exercises as $exercise)
                                    <span class="inline-block bg-indigo-200 text-indigo-700 px-2 py-1 rounded-full text-xs font-semibold mr-2">
                                        {{ $exercise->name }} ({{ $exercise->pivot->weight }}kg, {{ $exercise->pivot->reps }} reps, {{ $exercise->pivot->sets }} sets)
                                    </span>
                                @endforeach
                            </td>
                            <td class="py-3 px-4 whitespace-nowrap text-right space-x-2">
                                <a href="{{ route('workouts.show', $workout->id) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded text-xs focus:outline-none focus:shadow-outline">View</a>
                                <a href="{{ route('workouts.edit', $workout->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded text-xs focus:outline-none focus:shadow-outline">Edit</a>
                                <form action="{{ route('workouts.destroy', $workout->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-xs focus:outline-none focus:shadow-outline" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-gray-600 mt-4">No workouts have been added yet.</p>
    @endif
</div>
@endsection
