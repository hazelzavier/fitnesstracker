@extends('layouts.app')

@section('content')
{{-- Buitenste container met achtergrondkleur --}}
<div class="bg-gray-100 dark:bg-gray-900 min-h-screen py-8">
    {{-- Innerlijke container --}}
    <div class="px-4 sm:px-6 lg:px-8">

        {{-- Gebruik max-w-xl of max-w-2xl voor een niet te brede weergave --}}
        <div class="max-w-2xl mx-auto space-y-6">

            {{-- Kaart voor Profielinformatie --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow-lg rounded-lg">
                <div class="max-w-xl">
                    {{-- Sectie voor het bijwerken van profielinformatie --}}
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Profile Information') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __("Update your account's profile information and email address.") }}
                            </p>
                        </header>

                        {{-- Formulier voor naam en e-mail --}}
                        <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                            @csrf
                            @method('patch') {{-- Gebruik PATCH voor updates --}}

                            {{-- Naam veld --}}
                            <div>
                                <label for="name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Name') }}</label>
                                <input id="name" name="name" type="text" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                                @error('name', 'updateProfileInformation') {{-- Specificeer de error bag --}}
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- E-mail veld --}}
                            <div>
                                <label for="email" class="block font-medium text-sm text-gray-700 dark:text-gray-300">{{ __('Email') }}</label>
                                <input id="email" name="email" type="email" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" value="{{ old('email', $user->email) }}" required autocomplete="username" />
                                @error('email', 'updateProfileInformation') {{-- Specificeer de error bag --}}
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror

                                {{-- E-mail verificatie status --}}
                                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                    <div>
                                        <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                                            {{ __('Your email address is unverified.') }}
                                            {{-- Link om verificatie opnieuw te sturen (vereist aparte logica/route) --}}
                                            {{-- <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                                {{ __('Click here to re-send the verification email.') }}
                                            </button> --}}
                                        </p>
                                        @if (session('status') === 'verification-link-sent')
                                            <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                                {{ __('A new verification link has been sent to your email address.') }}
                                            </p>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            {{-- Opslaan knop en succesmelding --}}
                            <div class="flex items-center gap-4">
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">{{ __('Save') }}</button>

                                {{-- Toon 'Saved.' bericht met Alpine.js --}}
                                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-600 dark:text-gray-400">
                                    @if (session('status') === 'profile-updated')
                                        {{ __('Saved.') }}
                                    @endif
                                </p>
                            </div>
                        </form>
                    </section>
                </div>
            </div>

            {{-- Kaart voor Wachtwoord Wijzigen (Optioneel, maar standaard in Breeze) --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow-lg rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form') {{-- Verwijst naar een aparte partial --}}
                </div>
            </div>

            {{-- Kaart voor Account Verwijderen (Optioneel, maar standaard in Breeze) --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow-lg rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form') {{-- Verwijst naar een aparte partial --}}
                </div>
            </div>

        </div> {{-- Einde max-w-2xl --}}
    </div> {{-- Einde innerlijke container --}}
</div> {{-- Einde buitenste container --}}
@endsection
