@if ($breadcrumb)
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            @foreach ($breadcrumb as $i)
                <li
                    class="
                        breadcrumb-item
                        @if (isset($i['active']) && $i['active'])
                            active
                        @endif
                    "
                    @if (isset($i['active']) && $i['active'])
                        aria-current="page"
                    @endif
                >
                    <a
                        @if (isset($i['url']))
                            href="{{ $i['url'] }}"
                        @endif
                    >
                        {{ $i['title'] }}
                    </a>
                </li>
            @endforeach
        </ol>
    </nav>
@endif


