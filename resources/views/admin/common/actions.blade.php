@if ($actions)
    @foreach ($actions as $action)
        <a class="btn btn-link" href="{{ $action['url'] }}">{{ $action['name'] }}</a>
    @endforeach
@endif
