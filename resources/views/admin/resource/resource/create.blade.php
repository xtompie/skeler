@extends('admin.layout.default')

@section('content')

    @include('admin.common.breadcrumb', $resource)

    <h1>Create</h1>

    @include('admin.common.actions', $resource)

    <form method="post" enctype="multipart/form-data">
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
