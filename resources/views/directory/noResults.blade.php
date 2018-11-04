@extends('layouts.canopy')

@section('title') @endsection

@section('description', '')

@section('body')

@include('nav.nav')

<div id="npc-page">
    <div class="npc-section-wrapper default-wrapper npc-text">
        <section class="row">
            <div class="col-md-8 col-md-offset-2">
                @component('components.breadcrumbs', ['breadcrumbItems' => $breadcrumbItems]) @endcomponent
            </div>
        </section>
        <section class="row">
            <div class="col-md-8 col-md-offset-2">
                <h2>Apologies!</h2>
                <p>No <b>{{ $targetEntity }}</b> were found for {{ $that }}.</p>
            </div>
        </section>
    </div>
</div>
@endsection
