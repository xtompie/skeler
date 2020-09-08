@extends('admin.layout.default')

@section('content')

    <h1>Create</h1>

    <form method="POST">
        @csrf
        @foreach ($vm as $field)
            @include($field['view'], $field)
        @endforeach
        @include('admin.resource.resource.submits', [
            'name' => $name,
            'context' => $context,
        ])
    </form>
    @php
        print_r($errors);
    @endphp
@endsection
