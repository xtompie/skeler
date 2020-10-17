@extends('admin.layout.default')

@section('content')

    <h1>Index</h1>

    <p>Hi {{ Auth::user()->name }}</p>

    <a href="{{ route('admin.logout') }}" class="btn btn-outline-secondary">logout</a>

@endsection
