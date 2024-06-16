
<!-- Assuming this is within a Blade template file -->
<table id="assessment-datatable" class="resources-datatable table-middle table-hover table-responsive table">
    <thead>
        <tr>
            <th>No</th>
            {{-- <th class="no-sort">
                <label class="custom-checkbox">
                    <input type="checkbox" class="parent-checkbox">
                    <span></span>
                </label>
            </th> --}}
            <th>View</th>
            <th>Title</th>
            <th>Category</th>
            <th>Description</th>
            <th>Passmark</th>
            <th class="no-sort text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($assessments as $key => $assessment)
            <tr class="item">
                <td>{{ ++$key }}</td>
                {{-- <td>
                    <label class="custom-checkbox">
                        <input type="checkbox" class="child-checkbox" data-id="{{ $assessment->id }}">
                        <span></span>
                    </label>
                </td> --}}
                <td><a href="{{ route('assessments.show', $assessment->id) }}"><i class="fa fa-eye" data-bs-original-title="View"
                            data-bs-toggle="tooltip"></i></a></td>
                <td><a href="{{ route('assessments.edit', $assessment->id) }}">{{ $assessment->title }}</a></td>
                <td>
                    <span class="badge bg-success">{{ $assessment->category->name }}</span>
                </td>
                <td>{{$assessment->description }} </td>
                <td>{{ number_format($assessment->pass_mark, 0) }} </td>
                <td>
                    <ul class="list-unstyled table-actions">
                        @can('assessment-edit')
                            <li>
                                <x-admin.edit-button href="{{ route('assessments.edit', $assessment->id) }}" />
                            </li>
                        @endcan
                        @can('assessment-delete')
                            <li>
                                <x-admin.delete-button data-url="{{ route('assessments.destroy', $assessment->id) }}" />
                            </li>
                        @endcan
                    </ul>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
