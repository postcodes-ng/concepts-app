@extends('layouts.canopy')

@section('title', 'Postcode Reverse Lookup')

@section('body')

@include('nav.nav')
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-2">
            <p>
                You have a postcode and you want to find the area, or town, or village it represents then use the form below.
            </p>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Reverse Lookup Postcode</h3>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="rlkp-postcode" class="col-md-4 control-label">Postcode</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input name="rlkp-postcode" id="rlkp-postcode" class="form-control" type="text" autocomplete="off" placeholder="Paste your Postcode here">
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
