@if ($context === 'index')
    <td>
        {{ $value }}
    </td>
@elseif ($context === 'detail')
    <div class="row">
        <div class="col-sm-2">
            {{ $label }}
        </div>
        <div class="col-sm-10">
            {{ $value }}
        </div>
    </div>
@elseif ($context === 'create' || $context === 'update')
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">{{ $label }}</label>
        <div class="col-sm-10">
            <input
                type="text"
                name="{{ $name }}"
                value="{{ $value }}"
                class="
                    form-control
                    @if ($errors)
                        is-invalid
                    @endif
                "
            />
            @include('admin.common.errors', ['errors' => $errors])
        </div>
    </div>
@endif
