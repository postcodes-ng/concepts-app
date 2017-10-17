@extends('layouts.canopy')

@section('title', 'Home')

@section('description', 'Your one stop destination for all things postcodes in Nigeria')

@section('body')
<div itemscope itemtype="http://schema.org/WebSite">
    <link itemprop="url" href="http://nigeriapostcodes.naijaz.com/"/>
    <meta itemprop="name" content="Home"/>
    <meta itemprop="description" content="Your one stop destination for all things postcodes in Nigeria"/>    
</div>
        <div id="home" class="container">


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
                                <p>Lookup Nigerian Urban, Rural, and Facility postcodes.</p>
                            </a>
                            <div>
                                <a href="{{route('postcodeFinder')}}" class="btn btn-primary btn-primary"><span class="glyphicon glyphicon-search"></span> ... </a>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                        <div class="thumbnail">
                        <div class="caption npc-thumbnail-caption">
                            <a href="{{route('postcodeReverseLookup')}}">
                                <h3>Reverse Lookup</h3>
                                <p>Find the Area, or Streets, or Village associated with a given Nigerian postcode.</p>
                            </a>
                            <div>
                                <a href="{{route('postcodeReverseLookup')}}" class="btn btn-primary btn-primary"><span class="glyphicon glyphicon-search"></span> ... </a>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection