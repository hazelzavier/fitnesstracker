@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-8">
        <h2 class="text-2xl font-semibold mb-4">Add New Clothing</h2>

        <form action="{{ route('clothing.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                <select name="category_id" id="category_id" class="w-full p-2 mt-2 border border-gray-300 rounded-md">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" id="name" class="w-full p-2 mt-2 border border-gray-300 rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="color" class="block text-sm font-medium text-gray-700">Color</label>
                <input type="text" name="color" id="color" class="w-full p-2 mt-2 border border-gray-300 rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                <input type="file" name="image" id="image" class="w-full p-2 mt-2 border border-gray-300 rounded-md" required>
            </div>

            <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded-md">Add Clothing</button>
        </form>
    </div>
@endsection