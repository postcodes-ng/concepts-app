<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>Nigeria Postcodes Finder - @yield('title')</title>
<meta name="ROBOTS" content="INDEX,FOLLOW"/>
<meta name="description" content="Nigeria Postcode Finder. Lookup the postcode to your area, village, or street. You can also reverse lookup a postcode to find out what area, town or village it represents."/>
<meta name="keywords" content="nigeria postcode,nigeria zipcode,nigeria state postcode,nigeria rural postcode,nigeria urban postcode,nigeria facility postcode"/>
<link rel="alternate" href="http://nigeriapostcodes.naijaz.com" hreflang="en-us" />

<!-- Styles -->
<link href="{{ asset('css/app.css') }}" rel="stylesheet">

<!-- Scripts -->
<script>
window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
]) !!};
</script>
<script src="{{ asset('js/npc-polyfills.js') }}"></script>
<script src="{{ asset('js/npc-declarations.js') }}"></script>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-105002949-1', 'auto');
  ga('send', 'pageview');

</script>
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
