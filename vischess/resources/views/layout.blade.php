<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/chessboard-1.0.0.min.css') }}">
    <link rel="icon" href="{{ asset("favicon-32.png") }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset("favicon-32.png") }}" type="image/x-icon">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('js/chessboard-1.0.0.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chess.js/0.10.3/chess.min.js"></script>

    <title>VisChess</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>


<body>
    @include('nav')
    @yield('content')
</body>

