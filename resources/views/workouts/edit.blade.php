@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <div class="flex justify-center">
        <div class="flex flex-col items-center w-full sm:w-4/5 lg:w-3/5">
            <h3 class="text-2xl font-semibold mb-4">Edit Clothing</h3>

            <!-- Edit Form -->
            <form action="{{ route('clothing.update', $clothing) }}" method="POST" enctype="multipart/form-data" class="w-full sm:w-3/4 lg:w-1/2">
                @csrf
                @method('PUT')

                <!-- Category Selection -->
                <div class="mb-4">
                    <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                    <select name="category_id" id="category_id" class="w-full p-2 mt-1 border border-gray-300 rounded-md">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $category->id == $clothing->category_id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Name Input -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Clothing Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $clothing->name) }}" class="w-full p-2 mt-1 border border-gray-300 rounded-md">
                    @error('name')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Color Input -->
                <div class="mb-4">
                    <label for="color" class="block text-sm font-medium text-gray-700">Color</label>
                    <input type="text" name="color" id="color" value="{{ old('color', $clothing->color) }}" class="w-full p-2 mt-1 border border-gray-300 rounded-md">
                    @error('color')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Image Input -->
                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-700">Clothing Image</label>
                    <input type="file" name="image" id="image" class="w-full p-2 mt-1 border border-gray-300 rounded-md">
                    @error('image')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex justify-center">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
