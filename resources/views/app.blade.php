<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <title>Laravel</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />

        <link href="{{ asset('/vendor/apidocs/css/app.css') }}?t={{ time() }}" rel="stylesheet" />
        <script src="{{ asset('/vendor/apidocs/js/app.js') }}?t={{ time() }}" defer></script>
    </head>
    <body>

        <script>
            window.root = '{{ request()->root() }}';
            window.header_name = '{{ config("apidocs.header_name") }}';
            window.info = {!! json_encode(config("apidocs.info")) !!};
            window.apidocs = {!! $apidocs !!};
        </script>

        <div id="app"></div>

    </body>
</html>
