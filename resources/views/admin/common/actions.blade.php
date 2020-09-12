@if ($actions)

    @if ($context !== 'index' || !isset($id))
        <div class="row my-3">
            <div class="col">
    @endif

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

    @if ($context !== 'index' || !isset($id))
            </div>
        </div>
    @endif

@endif
