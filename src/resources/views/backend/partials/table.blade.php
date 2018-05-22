@table
    @slot('thead')
        <th>
            <a href="{{ route($routes['create']) }}">
                <i class="btn btn-icon" data-feather="plus"></i>
                <span class="sr-only">{{ __('New') }}</span>
            </a>
        </th>
        @foreach($thead as $th)
            <th>{{ $th }}</th>
        @endforeach
        <th>
            <span class="sr-only">{{ __('Actions') }}</span>
        </th>
    @endslot

    @slot('tbody')
        @foreach($data as $object)
            <tr>
                <td>
                    <a href="{{ route($routes['edit'], ['id' => $object->id]) }}">
                        <i class="icon icon--card" data-feather="{{ $icon }}"></i>
                    </a>
                </td>
                @foreach($object->toArray() as $propertyName => $property)
                    @if (!isset($ignoreData) || !in_array($propertyName, $ignoreData))
                        <td>{{ $property }}</td>
                    @endif
                @endforeach
                @isset($relatedData)
                    @foreach($relatedData as $method => $property)
                        <td>{{ $object->$method->$property }}</td>
                    @endforeach
                @endisset
                <td>
                    <a href="{{ route($routes['edit'], ['id' => $object->id]) }}" class="btn btn-icon">
                        <i data-feather="edit-2"></i>
                    </a>
                    <a href="{{ route($routes['delete'], ['id' => $object->id]) }}" class="btn btn-icon" data-modal="confirm-delete">
                        <i data-feather="trash-2"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    @endslot
@endtable