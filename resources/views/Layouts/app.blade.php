<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="author" content="adelezzatl">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>Bills System</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('styles')

</head>


<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
    <a class="navbar-brand" href="{{ route('bill.items.view') }}">Bills System</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a class="nav-item nav-link active" href="{{ route('bill.items.add') }}">Add Bill</a>
            <a class="nav-item nav-link" href="{{ route('bill.items.view') }}">All Bills</a>
        </div>
    </div>
</nav>
@yield('content')

<footer class="my-5 pt-5 text-muted text-center text-small">
    <center style="font-size: 16px;">
        Made With ❤️ By
        <a id="copyright" href="https://twitter.com/adelezzatl">@adelezzatl</a></center>
</footer>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
@yield('scripts')
</body>


</html>


