<div class="input-group mr-sm-2">
    <input
        type="text"
        class="
            form-control
            @if ($value !== null)
                border-right-0
                border-secondary
            @endif
        "
        size="12"
        name="filter[{{ $name }}]"
        value="{{ $value }}"
        placeholder="{{ $label }}"
    />
    @if ($value !== null)
        <span class="input-group-append ">
            <a
                href="{{ $reset }}"
                class="btn btn-outline-secondary border-left-0 border border-secondary"
            >
                &times;
            </a>
        </span>
    @endif
</div>
