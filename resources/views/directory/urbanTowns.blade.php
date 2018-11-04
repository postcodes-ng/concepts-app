@extends('layouts.canopy')

@section('title') Urban Towns in {{ $state }} state @endsection

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
                <h2>Urban Towns in {{ $state }} state.</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($urbanTowns as $urbanTown)
                            <tr>
                                <td>{{ $urbanTown->urbanTownName }}</td>
                                <td><a href="{{route('urbanAreasDirectory', ['stateSlug' => $urbanTown->stateSlug, 'urbanTownSlug' => $urbanTown->urbanTownSlug])}}">View Urban Areas</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>
@endsection
