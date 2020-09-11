@if ($actions)
    @if ($context !== 'index' || !isset($id))
        <div class="row my-3">
            <div class="col">
                @include('admin.common.actions-content', $__data)
            </div>
        </div>
    @else
        @include('admin.common.actions-content', $__data)
    @endif
@endif
