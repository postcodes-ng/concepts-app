@extends('layouts.canopy')

@section('title', 'Nigerian States Directory')

@section('description', '')

@section('body')

@include('nav.nav')

<div id="npc-page">
    <div class="npc-section-wrapper default-wrapper npc-text">
        <section class="row">
            <div class="col-md-8 col-md-offset-2">
                <h2>Nigerian states and the Federal Capital Territory</h2>
                <div class="npc-overflow">
                    <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Capital</th>
                            <th>Region</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($states as $state)
                            <tr>
                                <td>{{ $state->stateName }}</td>
                                <td>{{ $state->stateCode }}</td>
                                <td>{{ $state->stateCapital }}</td>
                                <td>{{ $state->stateRegion }}</td>
                                <td><a href="{{route('lgasDirectory', ['stateSlug' => $state->stateSlug])}}">View LGAs</a></td>
                                <td><a href="{{route('urbanTownsDirectory', ['stateSlug' => $state->stateSlug])}}">View Urban Towns</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection