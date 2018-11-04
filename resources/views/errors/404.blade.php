@extends('layouts.canopy')

@section('title') 404 - Page Not Found. @endsection

@section('description', '')

@section('body')

@include('nav.nav')

<div id="npc-page" class="">
    <div class="npc-section-wrapper npc-text">
        <section class="row">
            <div class="col-md-8 col-md-offset-2">
                <h2>Nawa for you o!</h2>
                <p>That pin is way off, please try again.</p>
                <img src="/img/postcodes_ng_404.png" alt="404" class="npc-404-page-img"/>
            </div>
        </section>
    </div>
</div>
@endsection
