<!DOCTYPE html>
<html lang='en'>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Japan Travel Information</title>

        @vite('resources/css/app.css')
    </head>

    <body>
        <div id="app"></div>
    </body>

    <!--Scripts-->
    @vite('resources/js/app.js')

</html>