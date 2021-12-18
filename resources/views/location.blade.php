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
                                    {{ end($temperatures)['y'] ?? '-' }} °C
                                </h2>
                                <p>{{ end($temperatures)['x'] ?? '-' }}</p>
                            </div>
                        </div>
                        <div
                            class="w-full sm:max-w-md m-6 p-6 bg-gray-100 shadow-md overflow-hidden sm:rounded-lg flex flex-row items-center">
                            <i class="fas fa-flask fa-2x mr-1"></i>
                            <div>
                                <h2 class="font-semibold text-l leading-tight">
                                    pH {{ end($phs)['y'] ?? '-' }}
                                </h2>
                                <p>{{ end($phs)['x'] ?? '-' }}</p>
                            </div>
                        </div>
                        <div
                            class="w-full sm:max-w-md m-6 p-6 bg-gray-100 shadow-md overflow-hidden sm:rounded-lg flex flex-row items-center">
                            <i class="fas fa-cloud-rain fa-2x mr-1"></i>
                            <div>
                                <h2 class="font-semibold text-l leading-tight">
                                    {{ end($rainfalls)['y'] ?? '-' }} mm
                                </h2>
                                <p>{{ end($rainfalls)['x'] ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <canvas id="temperature"></canvas>
                    </div>
                    <div>
                        <canvas id="ph"></canvas>
                    </div>
                    <div>
                        <canvas id="rainfall"></canvas>
                    </div>
                    <form action="/location/{{ $location->id }}/datapoints" method="GET">
                        {{ csrf_field() }}
                        <x-button class="block m-1" type="submit">Data points</x-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script src="{{ asset('chart.js/chart.js') }}"></script>
<script>
    const temperatures = JSON.parse(`{!! json_encode($temperatures) !!}`);
    const phs = JSON.parse(`{!! json_encode($phs) !!}`);
    const rainFalls = JSON.parse(`{!! json_encode($rainfalls) !!}`);

    const temperatureChart = new Chart(
        document.getElementById('temperature'),
        {
            type: 'line',
            data: {
                datasets: [{
                    label: 'Temperature',
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: temperatures
                }
                ]
            },
            options: {}
        }
    );

    const phChart = new Chart(
        document.getElementById('ph'),
        {
            type: 'line',
            data: {
                datasets: [{
                    label: 'pH',
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: phs
                }
                ]
            },
            options: {}
        }
    );

    const rainFallChart = new Chart(
        document.getElementById('rainfall'),
        {
            type: 'line',
            data: {
                datasets: [{
                    label: 'Rainfall',
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: rainFalls
                }
                ]
            },
            options: {}
        }
    );
</script>