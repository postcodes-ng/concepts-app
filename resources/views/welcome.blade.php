@extends('layouts.canopy')

@section('title', 'Home')

@section('body')
        <div id="home" class="container full-height">


            <div class="content">
                <div class="title m-b-md">
                    Nigerian Postcodes Finder
                </div>

                <div class="row">
                    <div class="col-sm-6 col-md-4">
                        <div class="thumbnail">
                        <div class="caption npc-thumbnail-caption">
                            <a href="{{route('postcodeFinder')}}">
                                <h3>Postcode Lookup</h3>
                                <p>Lookup Urban, Rural, and Facility postcodes.</p>
                            </a>
                        </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="thumbnail">
                        <div class="caption npc-thumbnail-caption">
                            <a href="{{route('postcodeReverseLookup')}}">
                                <h3>Reverse Lookup</h3>
                                <p>Find the Area, or Streets, or Village associated with a given postcode.</p>
                            </a>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @include('footer.footer')
@endsection