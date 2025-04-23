@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Bewerk Oefening</h2>

        <form method="POST" action="{{ route('exercises.update', $exercise->id) }}" class="bg-white shadow-md rounded-md p-6 space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Oefening Naam:</label>
                <input type="text" name="name" id="name" value="{{ $exercise->name }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                @error('name')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Update Oefening
            </button>
            <a href="{{ route('exercises.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Annuleren
            </a>
        </form>
    </div>
@endsection