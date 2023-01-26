<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>
            Go Team - Exam
        </title>
    </head>
    <body>
        <div id="app">
            @vite(['resources/js/app.js', 'resources/css/app.css'])
        </div>
    </body>
</html>
