<div class="input-group mr-sm-2">
    <select
        type="text"
        class="
            form-control
            @if ($value !== null)
                border-right-0
                border-secondary
            @endif
        "
        name="filter[{{ $name }}]"
        value="{{ $value }}"
        placeholder="{{ $label }}"
    >
        <option
            value=""
            @if ($value === null)
                selected
            @endif
        >
            {{ $label }}
        </option>
        @foreach ($options as $option_value => $option_title)
            <option
                value="{{ $option_value }}"
                @if ($value === $option_value)
                    selected
                @endif
            >
                {{ $option_title }}
            </option>
        @endforeach
    </select>
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
