<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/font-awesome.css') }}" rel="stylesheet">
    {{--<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">    <link rel="stylesheet" href="{{ asset('/css/ace-fonts.css') }}" />--}}
    <link rel="stylesheet" href="{{ asset('/css/ace.css') }}" class="ace-main-stylesheet" id="main-ace-style" />
    <link rel="stylesheet" href="{{ asset('/css/ace-ie.css') }}" />
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet" type="text/css">
    @yield('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/tecnointel.css') }}" />
    <link href="{{ asset('assets/css/sg-01.css') }}" rel="stylesheet">
    <link href="{{ asset('css/my_style_sheet.css') }}" rel="stylesheet">
    <script src="{{ asset('/js/ace-extra.min.js') }}"></script>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
</head>