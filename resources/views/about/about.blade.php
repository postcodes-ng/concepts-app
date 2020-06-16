@extends('layouts.canopy')

@section('title', 'About')

@section('description', 'Your one stop destination for all things postcodes in Nigeria')

@section('body')


<div itemscope itemtype="http://schema.org/WebSite">
    <link itemprop="url" href="http://www.postcodes.ng/about"/>
    <meta itemprop="name" content="About"/>
    <meta itemprop="description" content="Your one stop destination for all things postcodes in Nigeria"/>
</div>
<div id="npc-page">
    <div id="header">
        @include('nav.nav')
        <div class="container">
            <div class="header-title">
                &nbsp;&nbsp;
            </div>
            <div  class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="header-content">
                        <p>Who we are . What we do . Why we do it</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="npc-section-wrapper default-wrapper npc-text">
        <section class="row">
            <div class="col-md-8 col-md-offset-2">
                <p>
                A postcode, for all intents and purposes, is a basic spatial unit that represents a group of addresses thereby giving context to a given geographical location. Postcodes are used in many parts of the world in steering mail from an origin to a final destination, but the implementation differs slightly from country to country.
                </p>

                <p>
                In Nigeria the postcodes system was introduced by NIPOST (Nigerian Postal Service) in the year 2000, and since then has not fully  gained ground.
                </p>

                <p>
                This slowness of adoption is largely attributed to a couple of reasons;
                    <ul>
                        <li><strong>Lack of Awareness:</strong> NIPOST maintains a physical postcode  directory, but many people are not aware of the existence of the directory.</li>
                        <li><strong>Undefined mapping of the postcodes:</strong> The Nigerian postcodes which represent a basic spatial unit (BSU) have not been geographically mapped, if they have the data has not been made public. Mapping of the post codes will go a long way in increasing the adoption of the postcode system. With a geographically mapped postcode system the postcode of a location can be easily determined by just providing the latitude and longitude of any point within that location.</li>
                        <li><strong>Inaccessible data:</strong> It is wonderful that NIPOST has a site that lets you search for postcodes but that is not enough, without access to the raw digital data there is no room to evolve. </li>
                    </ul>
                </p>

                <p>
                The above reasons are why <strong>postcodes.ng</strong> have come to be, and those are the problems that we intend to help solve.
                </p>

                <p>
                First and foremost we have created a postcode look up site because we want to ensure that Nigerians have an additional online source.
                </p>

                <p>
                Secondly we are working diligently on updating the data we have using the NIPOST postcode directory.
                </p>

                <p>
                Thirdly we are also working on a public facing API that will enable and allow developers and the likes to query the postcodes data to make use of it in analysis, aggregation, and even web applications.
                </p>

                <p>
                And lastly we intend to help physically map each and every postcode and make the geo data accessible through our API.
                </p>

                <p>
                We believe that by the time we overcome these challenges we would have opened doors to the enormous possibilities that the Nigerian postcodes system has to offer.
                </p>

                <p>Watch this space!</p>
            </div>
        </section>
    </div>
    <div class="npc-section-wrapper alternate-wrapper">
        <section class="row">
            <div class="col-md-8 col-md-offset-2">
                    <h2>Our Mission</h2>
                    <p>Make Nigerian postcodes recognized and used nationwide.</p>
            </div>
        </section>
    </div>
</div>
@endsection