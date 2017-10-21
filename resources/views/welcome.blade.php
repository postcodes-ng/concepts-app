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

                <div class="row npc-section">
                    <div class="col-md-8 col-md-offset-2 npc-section-content">
                        <p>
                        A postcode, for all intents and purposes, is a basic spatial unit that represents a group of addresses thereby giving context to a given geographical location. Postcodes are used in many parts of the world in steering mail from an origin to a final destination, but the implementation differs slightly from country to country.
                        </p>

                        <p>
                        In Nigeria postcodes were introduced by NIPOST (Nigerian Postal Agency) in the year 2000, but despite NIPOST’s efforts in creating awareness and even creating a <a href="http://www.nigeriapostcode.com.ng/" target="_blank" >postcode finder site</a>, just like this one, that would help citizens in searching for and finding their postcode the Nigerian postcode system has not gained ground. 
                        </p>

                        <p>
                        This failure of adoption is largely attributed to a couple of reasons;
                            <ul>
                                <li><strong>Inaccurate and incomplete data:</strong> Some of the postcodes data on the NIPOST's postcode finder site are inaccurate, some are duplicated while some are conflicting. NIPOST maintains a physical postcode  directory, which is far more up  to date and complete than what is available on the NIPOST site, but many people are not aware of the existence of the directory and it is not readily available.</li>
                                <li><strong>Undefined mapping of the postcodes:</strong> The Nigerian postcodes which represent a basic spatial unit (BSU) have not been geographically mapped, if they have the data has not been made public. Mapping of the post codes will go a long way in increasing the adoption of the postcode system. With a geographically mapped postcode system the postcode of a location can be easily determined by just providing the latitude and longitude of any point within that location.</li>
                                <li><strong>Inaccessible data:</strong> It is wonderful that NIPOST has a site that lets you search for postcodes but that is not enough, without access to the raw data there is no room to evolve. </li>
                            </ul>
                        </p>

                        <p>
                        The above reasons are why <strong>postcodes.ng</strong> have come to be, and those are the problems that we intend to solve. 
                        </p>

                        <p>
                        First and foremost we have replicated the NIPOST site because we want to ensure that Nigerians have a reliable online source, not one that goes offline several months at a time (for example the NIPOST site just came back online on June of 2017 after being offline for about 9 months).
                        </p>

                        <p>
                        Secondly we are working diligently on updating the data we have using the NIPOST postcode directory, and ensuring that we eliminate conflicts and duplicates as best as we can.
                        </p>

                        <p>
                        Thirdly we are also working on a public facing API that will enable and allow developers and the likes to query the postcodes data to make use of it in analysis, aggregation, and even web applications.
                        </p>

                        <p>
                        And lastly we intend to physically map each and every postcode and make the geo data accessible through our API.
                        </p>

                        <p>
                        We believe that by the time we overcome these challenges we would have opened doors to the enormous possibilities that the Nigerian postcodes system has to offer.
                        </p>

                        <p>Watch this space!</p>
                    </div>
                </div>
            </div>
        </div>
@endsection