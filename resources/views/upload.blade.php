<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Solita Dev Academy Exercise</title>
    </head>
    <body>
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
    </body>
</html>
