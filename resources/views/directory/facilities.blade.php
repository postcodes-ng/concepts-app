@extends('layouts.canopy')

@section('title') Facilities in {{ $lga }} L.G.A. @endsection

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
                <h2>Facilities in {{ $lga }} L.G.A.</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Facility Type</th>
                            <th>Postcode</th>
                            <th>Street</th>
                            <th>Area</th>
                            <th>Town</th>
                            <th>Range of P.M.B</th>
                            <th>Range of P.O. Box</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($facilities as $facility)
                            <tr>
                                <td>{{ $facility->facilityName }}</td>
                                <td>{{ $facility->facilityType }}</td>
                                <td>{{ $facility->postcode }}</td>
                                <td>{{ $facility->street }}</td>
                                <td>{{ $facility->area }}</td>
                                <td>{{ $facility->town }}</td>
                                <td>{{ $facility->rangeOfPMB }}</td>
                                <td>{{ $facility->rangeOfPOB }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>
@endsection