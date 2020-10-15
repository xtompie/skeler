@extends('admin.layout.default')

@section('content')

    <h1>Login</h1>

    @if ($error)
        <div class="alert alert-danger" role="alert">
            Invalid login data
        </div>
    @endif

    <form method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Login</label>
            <div class="col-sm-10">
                <input type="email" name="email" value="{{ $email }}" class="form-control" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Pass</label>
            <div class="col-sm-10">
                <input type="password" name="password" value="{{ $password }}" class="form-control" />
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-10 offset-md-2">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </div>
    </form>

@endsection
