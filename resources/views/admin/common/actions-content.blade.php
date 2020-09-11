@foreach ($actions as $action)
    <a
        class="
            btn btn-outline-primary
            <?= $context == 'index' && isset($id) ? 'btn-sm' : '' ?>
        "
        href="{{ $action['url'] }}"
    >
        {{ $action['name'] }}
    </a>
@endforeach
