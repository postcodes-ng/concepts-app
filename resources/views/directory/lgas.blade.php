@extends('layouts.canopy')

@section('title') Local Governemnt Areas in {{ $state }} state @endsection

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
                <h2>Local Governemnt Areas in {{ $state }} state.</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lgas as $lga)
                            <tr>
                                <td>{{ $lga->lgaName }}</td>
                                <td><a href="{{route('ruralAreasDirectory', ['stateSlug' => $lga->stateSlug, 'lgaSlug' => $lga->lgaSlug])}}">View Rural Areas</a></td>
                                <td><a href="{{route('facilitiesDirectory', ['stateSlug' => $lga->stateSlug, 'lgaSlug' => $lga->lgaSlug])}}">View Facilities</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>
@endsection
