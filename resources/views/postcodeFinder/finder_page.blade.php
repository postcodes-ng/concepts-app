@extends('layouts.canopy')

@section('title', 'Postcode Lookup')

@section('body')

@include('nav.nav')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#rural" aria-controls="rural" role="tab" data-toggle="tab">Rural</a></li>
                <li role="presentation"><a href="#urban" aria-controls="urban" role="tab" data-toggle="tab">Urban</a></li>
                <li role="presentation"><a href="#facility" aria-controls="facility" role="tab" data-toggle="tab">Facility</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="rural">
                    <div class="npc-tab-content">
                        @include('postcodeFinder.partialViews.rural_postcode_finder')
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="urban">
                    <div class="npc-tab-content">
                        @include('postcodeFinder.partialViews.urban_postcode_finder')
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="facility">
                    <div class="npc-tab-content">
                        @include('postcodeFinder.partialViews.facility_postcode_finder')
                    </div>
                </div>
            </div>
			
        </div>
        <!-- spinner -->
        <div id="page-loading" class="npc-spinner npc-hidden"></div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/npc-postcodeFinder-page-functions.js') }}"></script>
@endpush
