@extends('layouts.canopy')

@section('title') Rural Areas in {{ $lga }} L.G.A. @endsection

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
                <h2>Rural Areas in {{ $lga }} L.G.A.</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Postcodes</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ruralAreas as $ruralArea)
                            <tr>
                                <td>{{ $ruralArea->ruralAreaName }}</td>
                                <td>
                                    @foreach ($ruralArea->postcodes as $postcode)
                                        @if (!$loop->first)
                                            , 
                                        @endif
                                        {{ $postcode }}
                                    @endforeach
                                </td>
                                <td><a href="{{route('villagesDirectory', ['stateSlug' => $ruralArea->stateSlug, 'lgaSlug' => $ruralArea->lgaSlug, 'ruralAreaSlug' => $ruralArea->ruralAreaSlug])}}">View Villages</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>
@endsection
