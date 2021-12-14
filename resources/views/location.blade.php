<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $location->location }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-success-message :success="$success ?? ''" />
                    <x-error-message />
                    <form action="/location/{{ $location->id }}/datapoints" method="GET">
                        <x-button class="block m-1" type="submit">Data points</x-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>