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
                postcodes.ng
                &nbsp;<span><i class="glyphicon glyphicon-map-marker"></i></span>
            </a>
        </div>

        <div class="collapse navbar-collapse" id="npc-collapsable-menu">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{route('lookup')}}">Postcode Lookup</a></li>
                <li><a href="{{route('postcodeSearch')}}">Search By Postcode</a></li>
                <li><a href="{{route('map')}}">Map</a></li>
            </ul>
        </div>
  </div>
</nav>