<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Solita Dev Academy Exercise</title>
    </head>
    <body>
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
    </body>
</html>
