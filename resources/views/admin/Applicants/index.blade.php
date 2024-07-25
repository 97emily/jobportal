<x-admin.app-layout>

    <x-admin.page-header />
    <x-admin.index-toolbar>
        <x-slot:mainactions>
            {{-- @can('job-create')
                <a class="btn btn-highlight waves-effect" href="{{ route('jobs.create') }}" style="background-color: #00AAD0">
                    <i class="fa fa-plus-circle"></i>
                    <span class="d-none d-md-inline">{{ _('Create New Job') }}</span>
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
                        <!-- resources/views/admin/applicants/index.blade.php -->
                        <style>
                            .table th, .table td {
                                text-align: center; /* Center align text in table cells */
                                vertical-align: middle; /* Vertically center align */
                            }

                            .btn {
                                display: inline-flex; /* Use inline-flex for buttons */
                                align-items: center; /* Center align icons vertically */
                                justify-content: center; /* Center align icons horizontally */
                                padding: 0.3rem; /* Adjust padding for smaller buttons */
                                border: none; /* Remove button borders */
                                background: none; /* Remove button background */
                            }

                            .btn i {
                                font-size: 1.25em; /* Adjust icon size */
                                color: #007bff; /* Default icon color */
                            }

                            .btn-primary i {
                                color: #007bff; /* Primary color */
                            }

                            .btn-success i {
                                color: #28a745; /* Success color */
                            }

                            .btn-warning i {
                                color: #ffc107; /* Warning color */
                            }

                            .btn-info i {
                                color: #17a2b8; /* Info color */
                            }

                            .btn-dark i {
                                color: #343a40; /* Dark color */
                            }
                            .btn-danger i {
                                color:darkred; /* Error color */
                            }
                        </style>

                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Job Title</th>
                                                <th>All Applicants</th>
                                                <th>Shortlisted Applicants</th>
                                                <th>Not Shortlisted Applicants</th>
                                                <th>Applicant Interviews</th>
                                                <th>Final Shortlist</th>
                                                <th>Rejections</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($jobs as $key => $job)
                                                <tr>
                                                    {{-- <td>{{ $job->id }}</td> --}}
                                                    <td>{{ ++$key }}</td>
                                                    <td>{{ $job->title }}</td>
                                                    <td>
                                                        <a href="{{ route('applicants.all', $job->id) }}" class="btn btn-primary">
                                                            <i class="fas fa-users"></i>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('applicants.shortlisted', $job->id) }}" class="btn btn-success">
                                                            <i class="fas fa-thumbs-up"></i>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('applicants.not-shortlisted', $job->id) }}" class="btn btn-warning">
                                                            <i class="fas fa-user-times"></i>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('applicants.interviews', $job->id) }}" class="btn btn-info">
                                                            <i class="fas fa-briefcase"></i>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('applicants.final-shortlist', $job->id) }}" class="btn btn-dark">
                                                            <i class="fas fa-street-view"></i>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('applicants.rejections', $job->id) }}" class="btn btn-danger">
                                                            <i class="fas fa-thumbs-down"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- {!! $jobs->links('pagination::bootstrap-5') !!} --}}
</x-admin.app-layout>
