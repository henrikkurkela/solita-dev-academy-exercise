<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="/location/{{ $location->id }}">{{ $location->location }}</a> → Measurements
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-success-message :success="$success ?? ''" />
                    <x-error-message />
                    <form action="/location/{{ $location->id }}/datapoints/all" method="GET">
                        {{ csrf_field() }}
                        <div class="flex flex-row">
                            <div class="m-1">
                                <x-label for="from">From</x-label>
                                <input type="date" name="from" id="from" value="{{ $from ?? '' }}">
                            </div>
                            <div class="m-1">
                                <x-label for="end">To</x-label>
                                <input type="date" name="to" id="to" value="{{ $to ?? '' }}">
                            </div>
                        </div>
                        <x-button class="block m-1" type="submit"
                            formaction="/location/{{ $location->id }}/datapoints/all">
                            All measurements
                        </x-button>
                        <x-button class="block m-1" type="submit"
                            formaction="/location/{{ $location->id }}/datapoints/temperature">
                            Temperatures
                        </x-button>
                        <x-button class="block m-1" type="submit"
                            formaction="/location/{{ $location->id }}/datapoints/pH">
                            pH measurements
                        </x-button>
                        <x-button class="block m-1" type="submit"
                            formaction="/location/{{ $location->id }}/datapoints/rainFall">
                            Rainfall measurements
                        </x-button>
                    </form>
                    <table class="w-full whitespace-no-wrap">
                        <tr>
                            <th class="border">Sensor</th>
                            <th class="border">Value</th>
                            <th class="border">Time</th>
                        </tr>
                        @foreach ($dataPoints as $dataPoint)
                        <tr>
                            <td class="border">{{ $dataPoint->sensortype }}</td>
                            <td class="border">{{ $dataPoint->value }}</td>
                            <td class="border">{{ $dataPoint->datetime }}</td>
                        </tr>
                        @endforeach
                    </table>
                    {{ $dataPoints->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>