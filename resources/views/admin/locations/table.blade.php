<table class="resources-datatable table-middle table-hover table-responsive table">
    <thead>
        <tr>
            <th>{{ __('No') }}</th>
            {{-- <th class="no-sort">
                <label class="custom-checkbox">
                    <input type="checkbox" class="parent-checkbox">
                    <span></span>
                </label>
            </th> --}}
            <th>{{ _('View')}}</th>
            <th>{{ _('Name') }}</th>
            <th class="no-sort text-center">{{ __('Action') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($collection as $location)
            <tr class="item">
                <td>{{ ++$i }}</td>
                {{-- <td>
                    <label class="custom-checkbox">
                        <input type="checkbox" class="child-checkbox" data-id="{{ $location->id }}">
                        <span></span>
                    </label>
                </td> --}}
                <td><a href="{{ route('locations.show', $location->id) }}"><i style="color: #00AAD0" class="fa fa-eye" data-bs-original-title="View"
                    data-bs-toggle="tooltip"></i></a></td>

                <td>{{ $location->name }}</td>
                <td>
                    <ul class="list-unstyled table-actions">
                        @can('location-edit')
                        <li>
                          <x-admin.edit-button data-modal="true" href="{{ route('locations.edit', $location->id) }}" />
                        </li>
                        @endcan
                        @can('location-edit')
                        <li>
                          <x-admin.delete-button data-url="{{ route('locations.destroy', $location->id) }}" />
                        </li>
                        @endcan
                    </ul>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
