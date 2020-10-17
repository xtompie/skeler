@if ($context === 'list')
    <td>
        @if ($escape)
            {{ $value }}
        @else
            {!! $value !!}
        @endif
    </td>
@elseif ($context === 'detail')
    <div class="row">
        <div class="col-sm-2">
            {{ $label }}
        </div>
        <div class="col-sm-10">
            @if ($escape)
                {{ $value }}
            @else
                {!! $value !!}
            @endif
        </div>
    </div>
@endif
