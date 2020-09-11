@extends('admin.layout.default')

@section('content')

    @include('admin.common.breadcrumb', $resource)

    <h1>#{{ $resource['id'] }} {{ $resource['title'] }}</h1>

    @include('admin.common.actions', $resource)

    <form method="POST">
        @csrf
        @include('admin.common.submits', [
            'name' => $resource['name'],
            'context' => $resource['context'],
            'id' => $resource['id'],
        ])
    </form>
@endsection
