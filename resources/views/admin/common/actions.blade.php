@if ($actions)
    @foreach ($actions as $name => $url)
        <a class="btn btn-link" href="{{ $url }}">{{ $name }}</a>
    @endforeach
@endif
