@if ($context === 'create')
    <div class="form-group row">
        <div class="col-sm-10 offset-md-2">
            <button type="submit" class="btn btn-primary">Create</button>
            <a href="{{ route('admin.resource.' . $name . '.index') }}" type="button" class="btn btn-link">Cancel</a>
        </div>
    </div>
@endif
