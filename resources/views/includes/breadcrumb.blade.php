<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
        @foreach ($breadcrumb as $name => $url)
            @if ($url)
                <li class="breadcrumb-item {{ $loop->last? 'active': '' }}"><a href="{{ $url }}">{{ $name }}</a></li>
            @else
                <li class="breadcrumb-item {{ $loop->last? 'active': '' }}">{{ $name }}</li>
            @endif
        @endforeach
    </ol>
</nav>