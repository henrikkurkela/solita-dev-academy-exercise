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
                    <x-success-message />
                    <x-error-message />
                    <form action="/location/{{ $location->id }}/datapoints" method="GET">
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
                                    array('All', 'all'),
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
                            <div class="m-1">
                                <x-label for="pagination">Results per page</x-label>
                                <x-select id="pagination" name="pagination">
                                    @foreach ([100, 25, 10] as $item)
                                    @if(isset($pagination) && $pagination == $item)
                                    <option value="{{ $item }}" selected="true">{{ $item }}</option>
                                    @else
                                    <option value="{{ $item }}">{{ $item }}</option>
                                    @endif
                                    @endforeach
                                </x-select>
                            </div>
                        </div>
                        <x-button class="block m-1" type="submit">
                            Apply
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
                    {{ $dataPoints->appends($_GET)->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>