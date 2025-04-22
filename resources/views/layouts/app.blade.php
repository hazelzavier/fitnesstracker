<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

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

<body class="font-sans text-gray-900 bg-white">

    <!-- Main container -->
    <div class="flex flex-col min-h-screen bg-gray-50">

        <!-- Navigation Bar -->
        @include('layouts.navigation')

        <!-- Main Content Area -->
        <main class="flex-grow">
            <div class="bg-white shadow-md py-8">
                <div class="container mx-auto px-6 lg:px-8">
                    @yield('content')
                </div>
            </div>
        </main>

    </div>

</body>
</html>
