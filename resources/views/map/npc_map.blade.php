@extends('layouts.canopy')

@section('title', 'Nigerian Postcode Reverse Lookup')

@section('description', 'Lookup area, street, town, or village for a given Nigerian postcode')

@section('body')

@include('nav.nav')

<div id="npc-map">
    
</div>

@endsection

@push('scripts')
<script src="{{ asset('js/npc-google-map-functions.js') }}"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWK1anKqIUcrCgBERz7BxWWcrdxpKbYGs&callback=initW3wMap"></script>
@endpush