<div>
    <table id="interview-datatable" class="resources-datatable table-middle table-hover table-responsive table">
        <thead>
            <tr>
                <th>No</th>
                <th>View</th>
                <th>Date</th>
                <th>Time</th>
                <th>Title</th>
                <th>Job Title</th>
                <th>Location</th>
                <th class="no-sort text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($interviews as $key => $interview)
                <tr class="item">
                    <td>{{ ++$key }}</td>
                    <td>
                        <a href="{{ route('interviews.show', $interview->id) }}">
                            <i style="color: #00AAD0" class="fa fa-eye" data-bs-original-title="View" data-bs-toggle="tooltip"></i>
                        </a>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($interview->interview_date)->format('d-m-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($interview->interview_time)->format('H:i') }}</td>
                    <td><a href="{{ route('interviews.edit', $interview->id) }}">{{ $interview->title }}</a></td>

                    <td>{{ $interview->job ? $interview->job->title : 'No Job Title' }}</td>
                    <td>{{ $interview->location ? $interview->location->name : 'No Location' }}</td>

                    <td>
                        <ul class="list-unstyled table-actions">
                            {{-- @can('interview-edit') --}}
                                <li>
                                    <a href="{{ route('interviews.edit', $interview->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                </li>
                            {{-- @endcan
                            @can('interview-delete') --}}
                                <li>
                                    <form action="{{ route('interviews.destroy', $interview->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </li>
                            {{-- @endcan --}}
                        </ul>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

