@extends('layouts.canopy')

@section('title') Urban Areas in {{ $urbanTown }} Town @endsection

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
                <h2>Urban Areas in {{ $urbanTown }} Town</h2>
                <div class="npc-overflow">
                    <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Postcodes</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($urbanAreas as $urbanArea)
                            <tr>
                                <td>{{ $urbanArea->urbanAreaName }}</td>
                                <td>
                                    @foreach ($urbanArea->postcodes as $postcode)
                                        @if (!$loop->first && !$loop->last)
                                            , 
                                        @endif
                                        {{ $postcode }}
                                    @endforeach
                                </td>
                                <td><a href="{{route('streetsDirectory', ['stateSlug' => $urbanArea->stateSlug, 'lgaSlug' => $urbanArea->urbanTownSlug, 'urbanAreaSlug' => $urbanArea->urbanAreaSlug])}}">View Streets</a></td>
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
