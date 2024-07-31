
<div class="container">
    <table id="assessment-datatable" class="resources-datatable table-middle table-hover table-responsive table">
        <thead>
            <tr>
                <th>No</th>
                <th>View</th>
                <th>Test </th>
                <th>Question</th>
                <th class="no-sort text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($questions as $key => $question)
            <tr class="item">
                <td>{{ ++$key }}</td>
                <td><a href="{{ route('practical_questions.show', $question->id) }}"><i style="color: #00AAD0" class="fa fa-eye" data-bs-original-title="View" data-bs-toggle="tooltip"></i></a></td>
                <td><a href="{{ route('practical_questions.edit', $question->id) }}">{{ $question->test->title }}</a></td>
                <td>{!! $question->question !!}</td>
                {{-- <td>
                    <ul class="list-unstyled table-actions">
                        <li>
                            <a href="{{ route('practical_questions.edit', $question->id) }}" class="btn btn-warning">Edit</a>
                        </li>
                        <li>
                            <form action="{{ route('practical_questions.destroy', $question->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </li>
                    </ul>
                </td> --}}
                <td>
                    <ul class="list-unstyled table-actions">

                            <li>
                                <x-admin.edit-button href="{{ route('practical_questions.edit', $question->id) }}" />
                            </li>
                            <li>
                                <x-admin.delete-button data-url="{{ route('practical_questions.destroy', $question->id) }}" />
                            </li>
                    </ul>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

