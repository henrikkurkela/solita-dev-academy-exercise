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
					Processed a total of {{ $rowCount }} rows. {{ $acceptedRows }} measurements were accepted, {{ $declinedRows }} measurements were declined.<br>
        			Declined measurement points:<br>
        			<table>
						<tr>
    						<th>Measurement</th>
    						<th>Reason</th>
  						</tr>
  						@foreach ($declinedRowsData as $row)
            				<tr>
								<td>{{ $row[0] }}</td>
								<td>{{ $row[1] }}</td>
							</tr>
        				@endforeach
					</table>
					<a href="/dashboard">Back to dashboard</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
