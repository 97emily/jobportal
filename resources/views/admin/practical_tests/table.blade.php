{{-- <div class="container">
    <h1>Practical Tests</h1>
    <a href="{{ route('practical_tests.create') }}" class="btn btn-primary">Create New Test</a> --}}
    <table id="assessment-datatable" class="resources-datatable table-middle table-hover table-responsive table">
        <thead>
            <tr>
                <th>No</th>
                <th>View</th>
                <th>Title</th>
                <th>Category</th>
                <th>Description</th>
                <th>Instructions</th>
                <th>Deadline</th>
                <th class="no-sort text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tests as $key => $test)
            <tr class="item">
                <td>{{ ++$key }}</td>
                <td><a href="{{ route('practical_tests.show', $test->id) }}"><i style="color: #00AAD0" class="fa fa-eye" data-bs-original-title="View" data-bs-toggle="tooltip"></i></a></td>
                <td><a href="{{ route('practical_tests.edit', $test->id) }}">{{ $test->title }}</a></td>
                <td>
                    <span class="badge bg-info">{{ $test->category->name }}</span>
                </td>
                <td>{!! $test->description !!}</td>
                <td>{!! $test->instructions !!}</td>
                <td>{{ $test->deadline }}</td>
                <td>
                    <ul class="list-unstyled table-actions">
                        <li>
                            <a href="{{ route('practical_tests.edit', $test->id) }}" class="btn btn-warning">Edit</a>
                        </li>
                        <li>
                            <form action="{{ route('practical_tests.destroy', $test->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </li>
                    </ul>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
{{-- </div> --}}
