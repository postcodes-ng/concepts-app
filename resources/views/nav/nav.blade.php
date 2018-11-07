<div>
    <nav class="navbar navbar-inverse">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#npc-collapsable-menu" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{route('home')}}">
                    <img src="{{ asset('img/postcodes_ng_logo_small.png') }}" width="180" height="20" alt="postcodes.ng pin logo"/>
                    
                </a>
            </div>

            <div class="collapse navbar-collapse" id="npc-collapsable-menu">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="{{route('home')}}">Home</a></li>
                    <li><a href="{{route('about')}}">About</a></li>
                    <li><a href="{{route('directory')}}">Directory</a></li>
                    <li><a href="{{route('lookup')}}">Lookup</a></li>
                    <li><a href="{{route('postcodeSearch')}}">Search</a></li>
                    <li><a href="{{route('map')}}">Map</a></li>
                </ul>
            </div>
    </div>
    </nav>
</div>