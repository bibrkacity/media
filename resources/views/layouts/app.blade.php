<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Media</title>
  @section('css')
    <link rel="stylesheet" href="/css/app.css" />
  @show
</head>
<body>
<header>
    <h1>Test task</h1>
    @if( \Illuminate\Support\Facades\Auth::check() )
        <div id="hello">
            Hello {{ Illuminate\Support\Facades\Auth::user()->name }}
        </div>
    @endif
</header>

<main>
    @yield('content')
</main>

<footer>
    2023
</footer>

</body>
</html>
