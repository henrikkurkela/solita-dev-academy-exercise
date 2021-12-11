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
                    @isset($message)
                        <p>{{ $message }}</p>
                    @endisset
                    <form action="/location/add" method="post">
                        {{ csrf_field() }}
                        <input type="text" id="location" name="location">
                        <br>
                        <button type=submit>Add location</button>
                    </form>
                    <form action="/upload" enctype="multipart/form-data" method="post">
                        {{ csrf_field() }}
                        <input type="file" id="file" name="file">
                        <br>
                        <button type=submit>Send</button>
                    </form>
                    <form action="/location/removeall" method="post">
                        {{ csrf_field() }}
                        <button type=submit>Nuke DB</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
