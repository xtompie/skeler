@if ($context === 'create')
    <div class="form-group row">
        <div class="col-sm-10 offset-md-2">
            <button type="submit" class="btn btn-primary">Create</button>
            <a href="{{ route('admin.resource.' . $name . '.index') }}" class="btn btn-outline-primary">Cancel</a>
        </div>
    </div>
@elseif ($context === 'update')
    <div class="form-group row">
        <div class="col-sm-10 offset-md-2">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.resource.' . $name . '.detail', ['id' => $id]) }}" class="btn btn-outline-primary">Cancel</a>
        </div>
    </div>
@elseif ($context === 'delete')
    <div class="form-group row">
        <div class="col-sm-12">
            <button type="submit" class="btn btn-danger">Delete</button>
            <a href="{{ route('admin.resource.' . $name . '.detail', ['id' => $id]) }}" class="btn btn-outline-primary">Cancel</a>
        </div>
    </div>
@endif
