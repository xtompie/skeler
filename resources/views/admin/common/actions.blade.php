@if ($actions)

    @if ($context !== 'list')
        <div class="row my-3">
            <div class="col">
    @endif

    @foreach ($actions as $action)
        <a
            class="
                btn btn-outline-primary
                <?= $context == 'list' ? 'btn-sm' : '' ?>
            "
            href="{{ $action['url'] }}"
        >
            {{ $action['name'] }}
        </a>
    @endforeach

    @if ($context !== 'list')
            </div>
        </div>
    @endif

@endif
