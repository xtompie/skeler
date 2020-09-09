@extends('admin.layout.default')

@section('content')

    <h1>Create</h1>

    @include('admin.common.actions', $resource)

    <form method="POST">
        @csrf
        @foreach ($resource['fields'] as $field)
            @include($field['view'], $field)
        @endforeach
        @include('admin.common.submits', [
            'name' => $resource['name'],
            'context' => $resource['context'],
        ])
    </form>

@endsection
