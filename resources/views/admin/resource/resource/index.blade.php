@extends('admin.layout.default')

@section('content')

    @include('admin.common.breadcrumb', $resource)

    <h1>{{ ucfirst($resource['name']) }}</h1>

    @include('admin.common.actions', $resource)

    @include('admin.common.filters', $resource)

    <table class="table">
        <thead class="thead-light">
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
                        @include($field['view'], $field)
                    @endforeach
                    <td>
                        @include('admin.common.actions', $resource)
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $pagination->links() }}

@endsection
