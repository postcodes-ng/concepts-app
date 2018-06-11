@extends('layouts.canopy')

@section('title', 'Home')

@section('description', 'Your one stop destination for all things postcodes in Nigeria')

@section('body')


<div itemscope itemtype="http://schema.org/WebSite">
    <link itemprop="url" href="http://www.postcodes.ng/"/>
    <meta itemprop="name" content="Home"/>
    <meta itemprop="description" content="Your one stop destination for all things postcodes in Nigeria"/>
</div>
        <div id="npc-page">
            <div id="header">
                @include('nav.nav')
                <div class="container">
                    <div class="header-title">
                        Nigerian Postcodes
                    </div>
                    <div  class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="header-content">
                                <p>Your one stop destination for all things postcodes in Nigeria</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="npc-section-wrapper default-wrapper">
                <section class="row">
                    <div class="col-md-8 col-md-offset-2">
                            <h2>Postcode Lookup</h2>
                            <p>Lookup Nigerian Urban, Rural, and Facility postcodes.</p>
                        <div>
                            <a href="{{route('lookup')}}" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Lookup </a>
                        </div>
                    </div>
                </section>
            </div>
            <div class="npc-section-wrapper alternate-wrapper">
                <section class="row">
                    <div class="col-md-8 col-md-offset-2">
                            <h2>Search By Postcode</h2>
                            <p>Find the Area, or Streets, or Villages associated with a given Nigerian postcode.</p>
                        <div>
                            <a href="{{route('postcodeSearch')}}" class="btn btn-warning"><span class="glyphicon glyphicon-search"></span> Search By Postcode </a>
                        </div>
                    </div>
                </section>
            </div>
            <div class="npc-section-wrapper default-wrapper npc-map-background">
                <section class="row">
                    <div class="col-md-8 col-md-offset-2">
                            <h2>Map Search</h2>
                            <p>Use the Map feature to easily locate your what3words address.</p>
                        <div>
                            <a href="{{route('map')}}" class="btn btn-primary"><span class="glyphicon glyphicon-map-marker"></span> Map Search </a>
                        </div>
                    </div>
                </section>
            </div>
        </div>
@endsection