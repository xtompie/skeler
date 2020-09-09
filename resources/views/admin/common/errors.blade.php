@if ($errors)
    @foreach ($errors as $error)
        <div class="invalid-feedback">
            {{ $error }}
        </div>
    @endforeach
@endif
