<x-admin.app-layout>

    <x-admin.page-header />
    <x-admin.index-toolbar>
        <x-slot:mainactions>
            {{-- @can('job-create')
                <a class="btn btn-highlight waves-effect" href="{{ route('interviews.create') }}" style="background-color: #00AAD0">
                    <i class="fa fa-plus-circle"></i>
                    <span class="d-none d-md-inline">{{ _('Schedule New Interview') }}</span>
                </a>
            @endcan --}}
        </x-slot>
    </x-admin.index-toolbar>

    <x-flash-message />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="container">
                            {{-- <h2>Job Listings</h2> --}}
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        {{-- <th>Nummber</th> --}}
                                        <th>Job ID</th>
                                        <th>Job Title</th>
                                        <th>Job Category</th>
                                        <th>View Interviews</th>
                                        <th>Final Shortlist</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($jobs as $key => $job)
                                        @if(in_array($job->id, $interviewJobIds))
                                            <tr>
                                                {{-- <td>{{ ++$key }}</td> --}}
                                                <td>{{ $job->id }}</td>
                                                <td>{{ $job->title }}</td>
                                                <td>
                                                    <span class="badge bg-info">{{ $job->category->name }}</span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.interviews.showJobInterviews', $job->id) }}" title="View Interviews">
                                                        <i class="fa fa-briefcase" style="color: #17a2b8;"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.interviews.showShortlistedApplicants', $job->id) }}" title="View Shortlisted Applicants">
                                                        <i class="fa fa-street-view" style="color: #070807;"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- {!! $interviews->links('pagination::bootstrap-5') !!} --}}
</x-admin.app-layout>
