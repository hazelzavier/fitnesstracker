@extends('layouts.app')

@section('content')

<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        @foreach($clothingItems as $clothing)
            <div class="border rounded-lg overflow-hidden">
                <img src="{{ asset('storage/' . $clothing->image) }}" alt="{{ $clothing->name }}" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="text-lg font-semibold">{{ $clothing->name }}</h3>
                </div>
            </div>
        @endforeach
        <div class="border rounded-lg flex items-center justify-center">
            <form action="{{ route('clothing.store') }}" method="POST" enctype="multipart/form-data" class="w-full h-48 flex items-center justify-center">
                @csrf
                <label for="image" class="cursor-pointer flex flex-col items-center justify-center">
                    <svg class="w-12 h-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <a href="{{ route('clothing.create') }}">Upload New Clothing</a>
                    <input type="file" name="image" id="image" class="hidden">
                </label>
            </form>
        </div>
    </div>
</div>
@endsection