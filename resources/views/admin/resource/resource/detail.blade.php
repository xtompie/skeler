@extends('admin.layout.default')

@section('content')

    @include('admin.common.breadcrumb', $resource)

    <h1>#{{ $resource['id'] }} {{ $resource['title'] }}</h1>

    @include('admin.common.actions', $resource)

    @foreach ($resource['fields'] as $field)
        @include($field['view'], $field)
    @endforeach

@endsection
