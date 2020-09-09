@extends('admin.layout.default')

@section('content')
    <h1>{{ $resource['name'] }}</h1>

    @include('admin.common.actions', $resource)

    <table class="table">
        <thead>
            <tr>
                @foreach ($resource['labels'] as $label)
                    <th class="text-left">
                        {{ $label }}
                    </th>
                @endforeach
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($resources as $resource)
                <tr>
                    @foreach ($resource['fields'] as $field)
                        <td>
                            @include($field['view'], $field)
                        </td>
                    @endforeach
                    <td>
                        @include('admin.common.actions', $resource)
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
