@extends('admin.layout.default')

@section('content')
<v-simple-table>
    <template v-slot:default>
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
            @foreach ($resources as $fields)
                <tr>
                    @foreach ($fields as $field)
                        <td>
                            @include($field['view'], $field)
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </template>
</v-simple-table>
@endsection
