<ul class="breadcrumb">
    @foreach ($breadcrumbItems as $item)
        @if ($loop->last)
            <li class="active">{{ $item->displayName }}</li>
        @else
            <li><a href="{{ $item->link }}">{{ $item->displayName }}</a></li>
        @endif
    @endforeach
</ul>
