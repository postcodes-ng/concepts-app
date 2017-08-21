<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>Nigerian Postcodes Finder - @yield('title')</title>
<meta name="ROBOTS" content="INDEX, FOLLOW">
<meta name="description" content="Nigeria Postcode Finder. Lookup the postcode to your area, village, or street. You can also reverse lookup a postcode to find out what area, town or village it represents.">

<!-- Styles -->
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<link href="{{ asset('css/style.css') }}" rel="stylesheet">

<!-- Scripts -->
<script>
window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
]) !!};
</script>
<script src="{{ asset('js/spin.js') }}"></script>
<script src="{{ asset('js/npc-polyfills.js') }}"></script>
<script src="{{ asset('js/npc-declarations.js') }}"></script>
</head>
<body>
<div id="app">

@yield('body')
<!-- spinner -->
<!-- <div id="mdl-spinner-global" class="mdl-spinner mdl-spinner--single-color mdl-js-spinner global-spinner nsh-hide"></div> -->
</div>
<div class="npc-footer-wrapper">
@include('footer.footer')
</div>

<!-- Scripts -->
<script src="{{ asset('js/npc-common-functions.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="https://code.getmdl.io/1.3.0/material.min.js"></script>
@stack('scripts')
</body>
</html>
