@if ($filters)

    <div class="card bg-light border-0 mb-3">
        <div class="card-body">
            <form class="form-inline">
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

        </div>
    </div>

@endif
