<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'fitnesstracker') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Vite (CSS & JS) -->
   @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Smooth Scroll -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let scrollLinks = document.querySelectorAll("a[href^='#']");
            for (let link of scrollLinks) {
                link.addEventListener("click", function(e) {
                    e.preventDefault();
                    let targetId = link.getAttribute("href").substring(1);
                    let targetElement = document.getElementById(targetId);
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                });
            }
        });
    </script>
</head>

{{-- Verander hier bg-white naar bg-gray-100 dark:bg-gray-900 of verwijder het --}}
<body class="font-sans text-gray-900 bg-gray-100 dark:bg-gray-900">

    <div class="flex flex-col min-h-screen">

        <!-- Top Navigation Bar -->
        @include('layouts.navigation')

        <!-- Main Content Area -->
        {{-- Zorg dat de padding-bottom hier blijft of wordt toegevoegd --}}
        <main class="flex-grow pb-20">
            {{-- De div met shadow-md en py-8 kan hier blijven of weg, afhankelijk van je gewenste layout --}}
            {{-- Als je de grijze achtergrond direct wilt zien, haal je deze div weg --}}
            {{-- <div class="shadow-md py-8"> --}}
                {{-- De container kan ook weg als je full-width wilt voor alle content --}}
                {{-- <div class="container mx-auto px-6 lg:px-8"> --}}
                    @yield('content')
                {{-- </div> --}}
            {{-- </div> --}}
        </main>

    </div> {{-- Einde main container --}}


    {{-- *** START: Bottom Navigation Bar *** --}}
<nav class="fixed bottom-0 left-0 w-full bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 shadow-lg z-40">
    <div class="flex justify-around items-center h-16 px-2">

        {{-- Dashboard Link (blijft hetzelfde) --}}
        <a href="{{ route('home') }}" class="flex flex-col items-center text-center px-2 {{ request()->routeIs('home') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400' }} hover:text-blue-600 dark:hover:text-blue-300 transition duration-150 ease-in-out">
            <i class="fas fa-tachometer-alt text-xl mb-1"></i>
            <span class="text-xs font-medium">Dashboard</span>
        </a>

        {{-- Add Workout Link (blijft hetzelfde) --}}
        <a href="{{ route('workouts.create') }}" class="flex flex-col items-center text-center px-2 {{ request()->routeIs('workouts.create') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400' }} hover:text-blue-600 dark:hover:text-blue-300 transition duration-150 ease-in-out">
            <i class="fas fa-plus-square text-xl mb-1"></i>
            <span class="text-xs font-medium">Add Workout</span>
        </a>

        {{-- *** AANGEPASTE LINK: Wijst nu naar Workout History *** --}}
        <a href="{{ route('workouts.list') }}" class="flex flex-col items-center text-center px-2 {{ request()->routeIs('workouts.list') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 dark:text-gray-400' }} hover:text-blue-600 dark:hover:text-blue-300 transition duration-150 ease-in-out">
            <i class="fas fa-history text-xl mb-1"></i> {{-- Icoon aangepast naar geschiedenis --}}
            <span class="text-xs font-medium">History</span> {{-- Tekst aangepast naar History --}}
        </a>
        {{-- *** EINDE AANGEPASTE LINK *** --}}

    </div>
</nav>
{{-- *** EINDE: Bottom Navigation Bar *** --}}


</body>
</html>
