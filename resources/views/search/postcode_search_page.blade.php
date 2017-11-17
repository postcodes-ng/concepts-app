@extends('layouts.canopy')

@section('title', 'Nigerian Postcode Reverse Lookup')

@section('description', 'Lookup area, street, town, or village for a given Nigerian postcode')

@section('body')

@include('nav.nav')
<div itemscope itemtype="http://schema.org/WebSite">
    <link itemprop="url" href="http://www.postcodes.ng/search/postcode"/>
    <meta itemprop="name" content="Search By Postcode"/>
    <meta itemprop="description" content="Lookup area, street, town, or village for a given Nigerian postcode"/>
    
</div>
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-2">
            <div class="npc-section-content">
                <p>
                    More often than not you will have a Nigerian postcode and you don't know where it represents.
                    Well we've got you covered. Use the form below to find the area, or town, or village, or street it represents.
                </p>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Reverse Lookup Postcode</h3>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="rlkp-postcode" class="col-md-4 control-label">Postcode</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input name="rlkp-postcode" id="rlkp-postcode" class="form-control" type="number" autocomplete="off" placeholder="Paste your Postcode here">
                                    <span class="input-group-btn">
                                        <button id="rlkp-button" class="btn btn-default" type="button">Go!</button>
                                    </span>
                                </div>
                            </div>
                            
                        </div>
                    </form>
                    <!-- spinner -->
                    <div id="rlkp-loading" class="npc-spinner npc-hidden"></div>
                </div>
                <div id="rlkp-result" class="panel-footer npc-hidden">
                    <div id="rlkp-error" class="alert alert-danger npc-hidden" role="alert">
                        <span></span>
                    </div>
                    <div id="rlkp-success" class="alert alert-success npc-hidden" role="alert">
                        <span></span>
                    </div>
                </div>
                
            </div>

        </div>

        <div id="rlkp-result-summary" class="col-md-8 col-md-offset-2 npc-hidden">
        </div>
        
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/npc-postcodeReverse-page-functions.js') }}"></script>
@endpush
