@table
    @slot('thead')
        <th>
            @if(!isset($hideButtons) || strpos($hideButtons, 'new') === false)
                <a href="{{ route($routes['create']) }}">
                    <i class="btn btn-icon" data-feather="plus"></i>
                    <span class="sr-only">{{ __('New') }}</span>
                </a>
            @endif
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
                    @if(!isset($hideButtons) || strpos($hideButtons, 'edit') === false)
                        <a href="{{ route($routes['edit'], ['id' => $object->id]) }}">
                            <i class="icon icon--card" data-feather="{{ $icon }}"></i>
                        </a>
                    @endif
                </td>
                @foreach($object->toArray() as $propertyName => $property)
                    @if (!isset($ignoreData) || !in_array($propertyName, $ignoreData))
                        <td>{{ $property }}</td>
                    @endif
                @endforeach
                @isset($relatedData)
                    @foreach($relatedData as $method => $property)
                        @isset($object->$method->$property)
                            <td>{{ $object->$method->$property }}</td>
                        @else
                            <td></td>
                        @endisset
                    @endforeach
                @endisset
                @isset($methodData)
                    @foreach($methodData as $method => $rendering)
                        <td>{{ sprintf($rendering, $object->$method()) }}</td>
                    @endforeach
                @endisset
                <td class="controlls">
                    @if(!isset($hideButtons) || strpos($hideButtons, 'edit') === false)
                    <a href="{{ route($routes['edit'], ['id' => $object->id]) }}" class="btn btn-icon">
                        <i data-feather="edit-2"></i>
                    </a>
                    @endif
                    @if(!isset($hideButtons) || strpos($hideButtons, 'delete') === false)
                    <a href="{{ route($routes['delete'], ['id' => $object->id]) }}" class="btn btn-icon" data-modal="confirm-delete">
                        <i data-feather="trash-2"></i>
                    </a>
                    @endif
                </td>
            </tr>
        @endforeach
    @endslot
@endtable