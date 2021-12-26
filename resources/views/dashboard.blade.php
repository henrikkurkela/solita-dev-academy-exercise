<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-success-message />
                    <x-error-message />
                    @if(isset($farms))
                    <div class="w-auto m-6 p-6 bg-gray-100 shadow-md overflow-hidden sm:rounded-lg">
                        <h2 class="font-semibold text-l leading-tight">Your locations</h2>
                        @foreach( $farms as $farm )
                        <div class="flex flex-row justify-between">
                            <p>{{ $farm->location }}</p>
                            <form action="/locations/{{ $farm->id }}" method="GET">
                                {{ csrf_field() }}
                                <x-button class="block m-1" type="submit">Open location</x-button>
                            </form>
                        </div>
                        @endforeach
                    </div>
                    @endif
                    <div class="flex flex-row">
                        <div class="w-full sm:max-w-md m-6 p-6 bg-gray-100 shadow-md overflow-hidden sm:rounded-lg">
                            <form class="flex flex-col items-center" action="/locations" method="POST">
                                <h2 class="font-semibold text-l leading-tight">Add new location</h2>
                                {{ csrf_field() }}
                                <x-label class="block m-1 w-full" for="location" value="Location"></x-label>
                                <x-input class="block m-1 w-full" id="location" name="location" required></x-input>
                                <x-button class="block m-1" type=submit>Add location</x-button>
                            </form>
                        </div>
                        <div class="w-full sm:max-w-md m-6 p-6 bg-gray-100 shadow-md overflow-hidden sm:rounded-lg">
                            <form class="flex flex-col items-center" action="/upload" enctype="multipart/form-data"
                                method="POST">
                                <h2 class="font-semibold text-l leading-tight">Upload measurement data</h2>
                                {{ csrf_field() }}
                                <x-label class="block m-1 w-full" for="file" value="File"></x-label>
                                <x-input class="block m-1 w-full" type="file" name="file" required></x-input>
                                <x-button class="block m-1" type=submit>Send</x-button>
                            </form>
                        </div>
                        <div class="w-full sm:max-w-md m-6 p-6 bg-gray-100 shadow-md overflow-hidden sm:rounded-lg">
                            <h2 class="font-semibold text-l leading-tight text-center">Developer options</h2>
                            <form class="flex flex-col items-center" action="/locations/removeall" method="POST">
                                {{ csrf_field() }}
                                <x-button class="block m-1" type=submit>Nuke DB</x-button>
                            </form>
                            <form class="flex flex-col items-center" action="/tokens/create" method="POST">
                                {{ csrf_field() }}
                                <x-button class="block m-1" type=submit>Create API token</x-button>
                            </form>
                            <form class="flex flex-col items-center" action="/tokens/revokeall" method="POST">
                                {{ csrf_field() }}
                                <x-button class="block m-1" type=submit>Revoke all API tokens</x-button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>