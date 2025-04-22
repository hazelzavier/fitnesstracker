@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <div class="flex justify-center space-x-8">

            <!-- Clothing categories section -->
            <div class="flex-1 grid grid-cols-1 gap-8">
                <!-- Petten / Hoeden Category -->
                <div id="category1" class="mb-8 flex justify-center">
                    <h2 class="text-2xl font-semibold mb-4 text-center">Petten / Hoeden</h2>
                    <div class="grid grid-cols-1 gap-4">
                        @foreach ($clothings as $clothing)
                            @if($clothing->category->name == 'Petten/Hoeden')
                                <div class="relative flex justify-center">
                                    <img src="{{ asset('storage/' . $clothing->file_path) }}" alt="{{ $clothing->name }}" class="w-64 h-64 object-cover rounded-md">
                                    <h3 class="absolute bottom-4 left-4 text-white bg-black bg-opacity-50 px-2 py-1">{{ $clothing->name }}</h3>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- T-shirts / Jassen Category -->
                <div id="category2" class="mb-8 flex justify-center">
                    <h2 class="text-2xl font-semibold mb-4 text-center">T-shirts / Jassen</h2>
                    <div class="grid grid-cols-1 gap-4">
                        @foreach ($clothings as $clothing)
                            @if($clothing->category->name == 'T-shirts / Jassen')
                                <div class="relative flex justify-center">
                                    <img src="{{ asset('storage/' . $clothing->file_path) }}" alt="{{ $clothing->name }}" class="w-64 h-64 object-cover rounded-md">
                                    <h3 class="absolute bottom-4 left-4 text-white bg-black bg-opacity-50 px-2 py-1">{{ $clothing->name }}</h3>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Broeken Category -->
                <div id="category3" class="mb-8 flex justify-center">
                    <h2 class="text-2xl font-semibold mb-4 text-center">Broeken</h2>
                    <div class="grid grid-cols-1 gap-4">
                        @foreach ($clothings as $clothing)
                            @if($clothing->category->name == 'Broeken')
                                <div class="relative flex justify-center">
                                    <img src="{{ asset('storage/' . $clothing->file_path) }}" alt="{{ $clothing->name }}" class="w-64 h-64 object-cover rounded-md">
                                    <h3 class="absolute bottom-4 left-4 text-white bg-black bg-opacity-50 px-2 py-1">{{ $clothing->name }}</h3>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Schoenen Category -->
                <div id="category4" class="mb-8 flex justify-center">
                    <h2 class="text-2xl font-semibold mb-4 text-center">Schoenen</h2>
                    <div class="grid grid-cols-1 gap-4">
                        @foreach ($clothings as $clothing)
                            @if($clothing->category->name == 'Schoenen')
                                <div class="relative flex justify-center">
                                    <img src="{{ asset('storage/' . $clothing->file_path) }}" alt="{{ $clothing->name }}" class="w-64 h-64 object-cover rounded-md">
                                    <h3 class="absolute bottom-4 left-4 text-white bg-black bg-opacity-50 px-2 py-1">{{ $clothing->name }}</h3>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Buttons Section -->
            <div class="flex flex-col items-center justify-center space-y-4">
                <button id="randomize" class="bg-blue-500 text-white py-2 px-4 rounded-md w-32">Randomize</button>
                <button id="save" class="bg-green-500 text-white py-2 px-4 rounded-md w-32">Save</button>
            </div>
        </div>
    </div>

    <script>
        // Randomize Button Logic
        document.getElementById('randomize').addEventListener('click', function () {
            fetch('/randomize-clothes')
                .then(response => response.json())
                .then(data => {
                    // Populate the clothing items with randomized data
                    console.log(data);
                    // Update the UI with random clothes
                });
        });

        // Save Button Logic
        document.getElementById('save').addEventListener('click', function () {
            const selectedClothes = [/* Array of selected/randomized clothing item IDs */];
            
            fetch('/save-randomized-clothes', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    clothing_ids: selectedClothes
                })
            })
            .then(response => response.json())
            .then(data => {
                alert('Clothes saved successfully!');
            });
        });
    </script>
@endsection
