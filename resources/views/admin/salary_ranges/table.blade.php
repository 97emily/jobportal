<table class="resources-datatable table-middle table-hover table-responsive table">
    <thead>
        <tr>
            <th>{{ _('No') }}</th>
            {{-- <th class="no-sort">
                <label class="custom-checkbox">
                    <input type="checkbox" class="parent-checkbox">
                    <span></span>
                </label>
            </th>
            <th>{{ _('ID') }}</th>
            <th>{{ _('Image') }}</th> --}}
            <th>{{ _('Minimum Salary') }}</th>
            <th>{{ _('Maximum Salary') }}</th>
            <th class="no-sort text-center">{{ _('Action') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($collection as $salaryRange)
            <tr class="item">
                <td>{{ ++$i }}</td>
                {{-- <td>
                    <label class="custom-checkbox">
                        <input type="checkbox" class="child-checkbox" data-id="{{ $salaryRange->id }}">
                        <span></span>
                    </label>
                </td>
                <td>{{ $salaryRange->id }}</td>
                <td>
                    <img class="img-thumbnail" alt="{{ $salaryRange->name }}" src="{{ resource_image_url($salaryRange) }}"
                        width="48">
                </td> --}}
                <td>{{ $salaryRange->minimum }}</td>
                <td>{{ $salaryRange->maximum }}</td>
                <td>
                    <ul class="list-unstyled table-actions">
                        @can('salary-edit')
                        <li>
                            <x-admin.edit-button data-modal="true"
                                href="{{ route('salary_ranges.edit', $salaryRange->id) }}" />
                        </li>
                        @endcan
                        @can('salary-delete')
                        <li>
                            <x-admin.delete-button data-url="{{ route('salary_ranges.destroy', $salaryRange->id) }}" />
                        </li>
                        @endcan
                    </ul>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
