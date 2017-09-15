@extends('layouts.canopy')

@section('title', 'Postcode Lookup')

@section('body')

@include('nav.nav')
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "WebSite",
    "url": "http://nigeriapostcodes.naijaz.com/postcodeFinder",
    "name": "Nigeria Postcode Lookup",
    "description": "Lookup postcode for an area, street, town, or village"
}
</script>
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

            <div>
                <p>
                    It is important to understand that Nigeria's postcode system is grouped into 3 categories;
                    <ul>
                        <li>Urban Postcodes</li>
                        <li>Rural Postcodes</li>
                        <li>Facility Postcodes</li>
                    </ul>
                </p>
                <p>
                    The category names are pretty much self explanotary in that '<strong>Urban Postcodes</strong>' represents postcodes allocated to the 
                    urban areas, '<strong>Rural Postcodes</strong>' represents those postcodes allocated to the rural areas, whilst '<strong>Facility Postcodes</strong>'
                     represents postcodes assigned to a NiPost Office Facility.
                </p>
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
