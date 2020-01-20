@extends('layouts.canopy')

@section('title') Villages in {{$ruralArea}} Rural Area @endsection

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
                <h2>Villages in {{ $ruralArea }} Rural Area.</h2>
                <div class="npc-overflow">
                    <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Postcode</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($villages as $village)
                            <tr>
                                <td>{{ $village->villageName }}</td>
                                <td>{{ $village->postcode }}</td>
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
