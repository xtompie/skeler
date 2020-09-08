@extends('admin.layout.default')

@section('content')

    <h1>#{{ $id }} {{ $title }}</h1>

    @foreach ($vm as $field)
        @include($field['view'], $field)
    @endforeach

@endsection
