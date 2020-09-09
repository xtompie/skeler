@extends('admin.layout.default')

@section('content')

    <h1>#{{ $resource['id'] }} {{ $resource['title'] }}</h1>

    @include('admin.common.actions', $resource)

    @foreach ($resource['fields'] as $field)
        @include($field['view'], $field)
    @endforeach

@endsection
