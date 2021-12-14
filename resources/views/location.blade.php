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