
<!-- Assuming this is within a Blade template file -->
<table id="job-datatable" class="resources-datatable table-middle table-hover table-responsive table">
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
            <th>Applicants</th>
            <th class="no-sort">Closing</th>
            <th>Title</th>
            <th>Category</th>
            <th>Tag</th>
            <th>Location</th>
            <th>Salary Range</th>
            <th>Status</th>
            <th class="no-sort text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($jobs as $key => $job)
            <tr class="item">
                <td>{{ ++$key }}</td>
                {{-- <td>
                    <label class="custom-checkbox">
                        <input type="checkbox" class="child-checkbox" data-id="{{ $job->id }}">
                        <span></span>
                    </label>
                </td> --}}
                <td>
                    <a href="{{ route('jobs.show', $job->id) }}"><i style="color: #00AAD0" class="fa fa-eye" data-bs-original-title="View"
                            data-bs-toggle="tooltip"></i></a>
                </td>
                <td>
                    <a href="{{ route('jobs.shortlisted', ['id'=>$job->id]) }}"><i style="color: #00AAD0" class="fa fa-users" data-bs-original-title="All Applicants"
                            data-bs-toggle="tooltip"></i></a>
                </td>
                <td>
                    {{ \Carbon\Carbon::parse($job->closing_date)->format('d-m-Y') }}
                </td>
                <td><a href="{{ route('jobs.edit', $job->id) }}">{{ $job->title }}</a></td>
                <td>
                    <span class="badge bg-info">{{ $job->category->name }}</span>
                </td>
                <td>
                    <span class="badge bg-success">{{ $job->tag->name }}</span>
                </td>
                <td>
                    <span class="badge bg-info">{{ $job->location->name }}</span>
                </td>
                <td>
                    <span class="badge bg-black">  Ksh. {{ number_format($job->salaryRange->minimum, 0) }} - Ksh. {{ number_format($job->salaryRange->maximum, 0) }}</span>
                </td>
                <td>
                    {!! job_status($job) !!}
                </td>
                <td>
                    <ul class="list-unstyled table-actions">
                        @can('job-edit')
                            <li>
                                <x-admin.edit-button href="{{ route('jobs.edit', $job->id) }}" />
                            </li>
                        @endcan
                        @can('job-delete')
                            <li>
                                <x-admin.delete-button data-url="{{ route('jobs.destroy', $job->id) }}" />
                            </li>
                        @endcan
                    </ul>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
