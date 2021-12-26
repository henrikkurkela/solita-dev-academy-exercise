<link href="{{ asset('css/app.css') }}" rel="stylesheet">

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
                    <x-success-message />
                    <x-error-message />
                    <div class="flex flex-row">
                        <div
                            class="w-full sm:max-w-md m-6 p-6 bg-gray-100 shadow-md overflow-hidden sm:rounded-lg flex flex-row items-center">
                            <i class="fas fa-temperature-high fa-2x mr-1"></i>
                            <div>
                                <h2 class="font-semibold text-l leading-tight">
                                    {{ $temperature->value ?? '-' }} °C
                                </h2>
                                <p>{{ $temperature->datetime ?? '-' }}</p>
                            </div>
                        </div>
                        <div
                            class="w-full sm:max-w-md m-6 p-6 bg-gray-100 shadow-md overflow-hidden sm:rounded-lg flex flex-row items-center">
                            <i class="fas fa-flask fa-2x mr-1"></i>
                            <div>
                                <h2 class="font-semibold text-l leading-tight">
                                    pH {{ $pH->value ?? '-' }}
                                </h2>
                                <p>{{ $pH->datetime ?? '-' }}</p>
                            </div>
                        </div>
                        <div
                            class="w-full sm:max-w-md m-6 p-6 bg-gray-100 shadow-md overflow-hidden sm:rounded-lg flex flex-row items-center">
                            <i class="fas fa-cloud-rain fa-2x mr-1"></i>
                            <div>
                                <h2 class="font-semibold text-l leading-tight">
                                    {{ $rainFall->value ?? '-' }} mm
                                </h2>
                                <p>{{ $rainFall->datetime ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="w-auto m-6 p-6 bg-gray-100 shadow-md overflow-hidden sm:rounded-lg">
                        <form action="/locations/{{ $location->id }}" method="GET">
                            {{ csrf_field() }}
                            <div class="flex flex-row">
                                <div class="m-1">
                                    <x-label for="from">From</x-label>
                                    <x-input type="date" name="from" id="from" value="{{ $from ?? '' }}" />
                                </div>
                                <div class="m-1">
                                    <x-label for="end">To</x-label>
                                    <x-input type="date" name="to" id="to" value="{{ $to ?? '' }}" />
                                </div>
                                <div class="m-1">
                                    <x-label for="sensor">Sensor</x-label>
                                    <x-select id="sensor" name="sensor">
                                        @foreach (array(
                                        array('Temperature', 'temperature'),
                                        array('pH', 'pH'),
                                        array('Rainfall', 'rainFall')
                                        ) as $item)
                                        @if(isset($sensor) && $sensor == $item[1])
                                        <option value="{{ $sensor }}" selected="true">{{ $item[0] }}</option>
                                        @else
                                        <option value="{{ $item[1] }}">{{ $item[0] }}</option>
                                        @endif
                                        @endforeach
                                    </x-select>
                                </div>
                            </div>
                            <x-button class="block m-1" type="submit">
                                Apply
                            </x-button>
                            <x-button class="block m-1" type="submit"
                                formaction="/locations/{{ $location->id }}/datapoints">
                                Data points
                            </x-button>
                        </form>
                        <div>
                            <canvas class="bg-white rounded-lg" id="canvas"></canvas>
                        </div>
                    </div>
                    <div class="flex flex-row">
                        <div class="w-full sm:max-w-md m-6 p-6 bg-gray-100 shadow-md overflow-hidden sm:rounded-lg">
                            <form class="flex flex-col items-center" action="/locations/{{ $location->id }}"
                                method="POST">
                                <h2 class="font-semibold text-l leading-tight">Delete location</h2>
                                @method('DELETE')
                                {{ csrf_field() }}
                                <div class="flex flex-row">
                                    <x-input type="checkbox" class="m-1" name="location" required></x-input>
                                    <x-label class="block m-1 w-full" for="location" value="Delete location"></x-label>
                                </div>
                                <x-button class="block m-1" type=submit>Delete location</x-button>
                            </form>
                        </div>
                        <div class="w-full sm:max-w-md m-6 p-6 bg-gray-100 shadow-md overflow-hidden sm:rounded-lg">
                            <form class="flex flex-col items-center" action="/locations/{{ $location->id }}/datapoints"
                                method="POST">
                                <h2 class="font-semibold text-l leading-tight">Delete measurements</h2>
                                @method('DELETE')
                                {{ csrf_field() }}
                                <div class="flex flex-row">
                                    <x-input type="checkbox" class="m-1" name="location" required></x-input>
                                    <x-label class="block m-1 w-full" for="location" value="Delete measurements"></x-label>
                                </div>
                                <x-button class="block m-1" type=submit>Delete measurements</x-button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script src="{{ asset('chart.js/chart.js') }}"></script>
<script>
    const dataPoints = JSON.parse(`{!! json_encode($dataPoints) !!}`);
    const labels = {
        temperature: 'Temperature °C',
        pH: 'pH',
        rainFall: 'Rainfall mm'
    }

    const chart = new Chart(
        document.getElementById('canvas'),
        {
            type: 'line',
            data: {
                datasets: [{
                    label: labels[`{{ $sensor ?? 'temperature' }}`],
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: dataPoints
                }
                ]
            },
            options: {}
        }
    );
</script>