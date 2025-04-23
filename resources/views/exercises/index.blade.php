@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Manage Exercises</h2>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Succes!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white shadow-md rounded-md p-6">
            @if($exercises->isNotEmpty())
                <ul class="space-y-3">
                    @foreach($exercises as $exercise)
                        <li class="bg-gray-50 border border-gray-200 rounded-md p-4 flex justify-between items-center">
                            <span class="text-gray-700">{{ $exercise->name }}</span>
                            <div class="flex space-x-2">
                                <a href="{{ route('exercises.edit', $exercise->id) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded text-xs focus:outline-none focus:shadow-outline">
                                    Bewerk
                                </a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500">Geen oefeningen gevonden.</p>
            @endif
        </div>
    </div>
@endsection