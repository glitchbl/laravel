@foreach ($columns as $code => $nom)
    @continue (isset($hide) && in_array($code, $hide))
    @php
        $new_direction = 'asc';
        if ($code == $orderby && $direction == 'asc')
            $new_direction = 'desc';
    @endphp
    <th>
        @if (!isset($no_sorting) || !in_array($code, $no_sorting))
        @php
            $data = ['orderby' => $code, 'direction' => $new_direction];
            if (isset($appends))
                $data = array_merge($data, $appends);
        @endphp
            <a href="{{ route($route, $data) }}">{{ $nom }}</a>
            @if ($code == $orderby)
                @if ($direction == 'asc')
                    <i class="fa fa-chevron-up" aria-hidden="true"></i>
                @else
                    <i class="fa fa-chevron-down" aria-hidden="true"></i>
                @endif
            @endif
        @else
            {{ $nom }}
        @endif
    </th>
@endforeach
