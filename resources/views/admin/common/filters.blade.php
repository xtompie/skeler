@if ($filters)

    <form class="form-inline mb-3">
        <input type="hidden" name="sort" value="{{ $sort }}" />
        @foreach ($filters as $filter)
            @include($filter['view'], $filter)
        @endforeach
        <div class="form-group row">
            <div class="col-sm-12">
                <button type="submit" class="btn btn-outline-secondary">
                    Filter
                </button>
            </div>
        </div>
    </form>

@endif
