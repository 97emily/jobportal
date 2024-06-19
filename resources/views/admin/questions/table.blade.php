<!-- Assuming this is within a Blade template file -->
<table id="question-datatable" class="resources-datatable table-middle table-hover table-responsive table">
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
            <th>Question</th>
            <th>Allocated Marks</th>
            <th>Allocated Time</th>
            <th>Assessment</th>
            <th class="no-sort text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($questions as $key => $question)
            <tr class="item">
                <td>{{ ++$key }}</td>
                {{-- <td>
                    <label class="custom-checkbox">
                        <input type="checkbox" class="child-checkbox" data-id="{{ $question->id }}">
                        <span></span>
                    </label>
                </td> --}}
                <td><a href="{{ route('questions.show', $question->id) }}"><i style="color: #00AAD0" class="fa fa-eye"
                            data-bs-original-title="View" data-bs-toggle="tooltip"></i></a></td>
                <td> {!! $question->question !!}</td>
                <td>{{ $question->allocated_marks }}</td>
                <td>{{ $question->allocated_time }}</td>
                <td>
                    <span class="badge bg-success">{{ $question->assessment->title }}</span>
                </td>
                <td>
                    <ul class="list-unstyled table-actions">
                        @can('question-edit')
                            <li>
                                <x-admin.edit-button href="{{ route('questions.edit', $question->id) }}" />
                            </li>
                        @endcan
                        @can('question-delete')
                            <li>
                                <x-admin.delete-button data-url="{{ route('questions.destroy', $question->id) }}" />
                            </li>
                        @endcan
                    </ul>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
