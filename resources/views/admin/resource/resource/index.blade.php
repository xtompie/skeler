@extends('admin.layout.default')

@section('content')
    <table class="table">
        <thead>
            <tr>
                @foreach ($labels as $label)
                    <th class="text-left">
                        {{ $label }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($vm as $item)
                <tr>
                    @foreach ($item as $field)
                        <td>
                            @include($field['view'], $field)
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
