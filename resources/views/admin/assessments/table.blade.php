
    <table id="assessment-datatable" class="resources-datatable table-middle table-hover table-responsive table">
        <thead>
            <tr>
                <th>No</th>
                <th>View</th>
                <th>Name</th>
                <th>Description</th>
                <th>Questions</th>
                {{-- <th>Status</th> --}}
                <th class="no-sort text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($assessments as $index => $assessment)
                <tr class="item">
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <a href="{{ route('assessments.show', $assessment->id) }}">
                            <i class="fa fa-eye" data-bs-original-title="View" data-bs-toggle="tooltip"></i>
                        </a>
                    </td>
                    <td><a href="{{ route('assessments.edit', $assessment->id) }}">{{ $assessment->title }}</a></td>
                    <td>{{ $assessment->description }}</td>
                    <td>{{ $assessment->questions_count }}</td>
                    {{-- <td>{!! $assessment->status ? 'Active' : 'Inactive' !!}</td> --}}
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

        {{-- <table id="assessment-datatable" class="resources-datatable table-middle table-hover table-responsive table">
            <thead>
                <tr>

                    <th>No</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($assessments as $key => $assessment)
                    <tr class="item">
                        <td>{{ ++$key }}</td>
                        <td>{{ $assessment->title }}</td>
                        <td>{{ $assessment->description }}</td>
                        <td>
                            <a href="{{ route('assessments.show', $assessment->id) }}" class="btn btn-info">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
 --}}

