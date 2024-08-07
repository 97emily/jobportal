<x-admin.app-layout>
    <x-admin.page-header />
    <x-admin.index-toolbar>
        <x-slot:mainactions></x-slot>
    </x-admin.index-toolbar>
    <div class="card p-5">
        <div class="card-body">
            <!-- Job Details and Applicants Information (same as before) -->
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="product-detail">
                        <!-- Job Title and Salary Range -->
                        <h2 class="product-title" style="color:#00AAD0">{{ $job->title }}</h2>
                        <div class="product-price mb-2">
                            @if ($job->salaryRange->minimum . '-' . $job->salaryRange->maximum)
                                <span class="price text-highlight fs-lg fw-700">KES.
                                    {{ number_format($job->salaryRange->minimum, 0) }} -
                                    KES. {{ number_format($job->salaryRange->maximum, 0) }}</span>
                            @else
                                <span class="price text-highlight fs-lg fw-700">Salary: Not specified</span>
                            @endif
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="product-meta list-unstyled">
                                <li class="mb-2">
                                    <strong>Category:</strong>
                                    <span class="badge bg-info">{{ $job->category->name }}</span>
                                </li>
                                <li class="mb-2">
                                    <strong>Tag:</strong>
                                    <span class="badge bg-success">{{ $job->tag->name }}</span>
                                </li>
                                <li class="mb-2">
                                    <strong>Assessment Test:</strong>
                                    <span class="badge bg-info">{{ $job->assessment->title }}</span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <strong>Applicants Statistics:</strong>
                                <p class="badge bg-info">All Applicants: {{ count($shorListedApplicants) }}</p>
                                <p class="badge bg-success">Shortlisted Applicants:
                                    {{ count(array_filter($shorListedApplicants, fn($applicant) => $applicant['applicant']['state'] === 'Shortlisted')) }}
                                </p>
                            </div>
                            <div>
                                <strong class="fw-700">Job Created Date:</strong>
                                <span
                                    class="badge bg-black">{{ \Carbon\Carbon::parse($job->created_at)->format('d-m-Y') }}</span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <h5 class="fw-700">Work Location:</h5>
                            <p class="lh-150 text-sm">{{ $job->location->name ?? 'Not specified' }}</p>
                        </div>
                        <div class="col-md-4">
                            <h5 class="fw-700">Closing Date:</h5>
                            <p class="lh-150 text-sm">
                                {{ \Carbon\Carbon::parse($job->closing_date)->format('d-m-Y') ?: 'Not specified' }}
                            </p>
                        </div>
                        <div class="col-md-4">
                            <h5 class="fw-700">Status:</h5>
                            <p class="lh-150 text-sm">
                                {!! job_status($job) !!}
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Error and Success Messages -->
    {{-- @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif --}}

    @if (Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('message') }}
        </div>
    @endif


    @if (Session::has('error'))
    <div class="alert alert-danger">
        {{ Session::get('error') }}
    </div>
@endif


    <div class="card p-5">
        <div class="col-lg-12 col-md-12">
            <div class="row">
                {{-- <div class="row border-bottom mb-3"> --}}
                <div class="col-12">
                    <div class="form-group mb-3">
                        <label for="practical_tests_id">Send Practical Test</label>
                        @if ($practicalTests->isNotEmpty())
                            <select name="practical_tests_id" id="practical_tests_id_select" class="form-control"
                                required>
                                <option value="">Select Practical Test</option>
                                @foreach ($practicalTests as $practicalTest)
                                    <option value="{{ $practicalTest->id }}">{{ $practicalTest->title }}
                                    </option>
                                @endforeach
                            </select>
                        @else
                            <p>No practical tests available for this category.</p>
                        @endif
                    </div>
                    @if ($practicalTests->isNotEmpty())
                        <div class="btn-group" role="group">
                            <form id="practical-test-form" action="{{ route('jobs.sendPracticalTest', $job->id) }}"
                                method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="selected_applicants" id="selected_applicants">
                                <input type="hidden" name="practical_tests_id" id="practical_tests_id_hidden">
                                <button type="button" id="send-practical-test" class="btn btn-primary me-2"
                                    style="background-color: #00AAD0;"
                                    {{ $job->status == 'Open' ? 'disabled' : '' }}>Send Practical Test</button>
                            </form>
                            <form id="preview-practical-test-form"
                                action="{{ route('practical-test.preview', $practicalTest->id) }}" method="GET"
                                target="_blank" class="d-inline">
                                @csrf
                                <input type="hidden" name="practical_tests_id" id="preview_practical_tests_id">
                                <button type="button" id="preview-practical-test" class="btn btn-secondary">Preview
                                    Practical Test</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
            <hr>

            <!-- Applicant Table -->
            <div class="col-lg-12 col-md-12">
                <div class="table-responsive">
                    <table id="job-datatable" class="table-middle table-hover table-responsive table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th><input type="checkbox" id="select-all"></th>
                                <th>View</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Assessment Score</th>
                                <th>Status</th>
                                <th>Practical Score</th>
                                <th>Application State</th>
                                <th>Application Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($shorListedApplicants as $key => $applicant)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td><input type="checkbox" class="applicant-checkbox" name="applicants[]"
                                            value="{{ $applicant['applicant']['user_id'] }}"></td>
                                    <td>
                                        <a
                                            href="{{ route('jobs.shortlisted.applicant', ['user_id' => $applicant['applicant']['user_id']]) }}">
                                            <i style="color: #00AAD0" class="fa fa-eye" data-bs-original-title="View"
                                                data-bs-toggle="tooltip"></i>
                                        </a>
                                    </td>
                                    <td>{{ $applicant['applicant']['name'] }}</td>
                                    <td>{{ $applicant['applicant']['email'] }}</td>
                                    {{-- <td>{{ $applicant['applicant']['assessment_score'] }}</td> --}}
                                    <td><span
                                            class="badge bg-black">{{ $applicant['applicant']['assessment_score'] }}</span>
                                    </td>
                                    <td>{{ $applicant['applicant']['status'] }}</td>
                                    {{-- <td>{{ $applicant['applicant']['practical_score'] }}</td> --}}
                                    <td><span
                                            class="badge bg-info">{{ $applicant['applicant']['practical_score'] }}</span>
                                    </td>
                                    <td><span class="badge bg-success">{{ $applicant['applicant']['state'] }}</span>
                                    </td>
                                    <td>{{ $applicant['applicant']['application_date'] }}</td>
                                    <td>
                                        @can('job-edit')
                                            <a href="javascript:void(0)" class="edit-button"
                                                data-applicant-id="{{ $applicant['applicant']['id'] }}"
                                                data-applicant-name="{{ $applicant['applicant']['name'] }}"
                                                data-applicant-assessment-score="{{ $applicant['applicant']['assessment_score'] }}"
                                                data-applicant-status="{{ $applicant['applicant']['status'] }}"
                                                data-applicant-practical-score="{{ $applicant['applicant']['practical_score'] }}"
                                                data-applicant-interview-score="{{ $applicant['applicant']['interview_score'] }}">
                                                <i class="fa fa-edit" style="color: #00AAD0"></i>
                                            </a>
                                            <a href="javascript:void(0)" class="interview-button"
                                                data-applicant-id="{{ $applicant['applicant']['id'] }}"
                                                data-applicant-user_id="{{ $applicant['applicant']['user_id'] }}"
                                                data-applicant-name="{{ $applicant['applicant']['name'] }}"
                                                data-job-id="{{ $job->id }}">
                                                <i class="fa fa-calendar" style="color: #00d01f"
                                                    data-bs-original-title="Schedule Interview"
                                                    data-bs-toggle="tooltip"></i>
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirm Reschedule</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to reschedule this interview?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="confirm-reschedule" class="btn btn-primary">Confirm</button>
                </div>
            </div>
        </div>
    </div> --}}


    <script>
        document.getElementById('practical_tests_id_select').addEventListener('change', function() {
            var selectedTestId = this.value;
            document.getElementById('practical_tests_id_hidden').value = selectedTestId;
            document.getElementById('preview_practical_tests_id').value = selectedTestId;
        });

        document.getElementById('send-practical-test').addEventListener('click', function() {
            var selectedTestId = document.getElementById('practical_tests_id_select').value;
            var selectedApplicants = Array.from(document.querySelectorAll('input[name="applicants[]"]:checked'))
                .map(checkbox => checkbox.value);

            // Log values for debugging
            console.log('Selected Test ID:', selectedTestId);
            console.log('Selected Applicants:', selectedApplicants);

            // Set values to hidden fields
            document.getElementById('selected_applicants').value = selectedApplicants.join(',');
            document.getElementById('practical_tests_id_hidden').value = selectedTestId;

            // Ensure practical test is selected
            if (!selectedTestId) {
                alert('Please select a practical test.');
            } else {
                document.getElementById('practical-test-form').submit();
            }
        });

        document.getElementById('preview-practical-test').addEventListener('click', function() {
            var selectedTestId = document.getElementById('practical_tests_id_select').value;
            if (!selectedTestId) {
                alert('Please select a practical test.');
            } else {
                document.getElementById('preview-practical-test-form').submit();
            }
        });

        document.getElementById('select-all').addEventListener('change', function() {
            var checkboxes = document.querySelectorAll('input[name="applicants[]"]');
            for (var checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        });
    </script>


    <!-- Modal -->
    <div>
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="updateForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Update Applicant Details</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" id="applicant_id">
                            <div class="form-group">
                                <label for="applicant_name">Name</label>
                                <input type="text" class="form-control" id="applicant_name" name="applicant_name"
                                    readonly>
                            </div>
                            <div class="form-group">
                                <label for="assessment_score">Assessment Score</label>
                                <input type="number" class="form-control" id="assessment_score"
                                    name="assessment_score" readonly>
                            </div>
                            <div class="form-group">
                                <label for="practical_score">Practical Score</label>
                                <input type="number" class="form-control" id="practical_score"
                                    name="practical_score" required>
                            </div>
                            {{-- <div class="form-group">
                                <label for="interview_score">Interview Score</label>
                                <input type="number" class="form-control" id="interview_score" name="interview_score"
                                    required>
                            </div> --}}
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="In Review">In Review</option>
                                    <option value="Approved">Approved</option>
                                    <option value="Rejected">Rejected</option>
                                    <option value="Hired">Hired</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-admin.app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle edit button click
        document.querySelectorAll('.edit-button').forEach(button => {
            button.addEventListener('click', function() {
                const applicantId = this.getAttribute('data-applicant-id');
                const applicantName = this.getAttribute('data-applicant-name');
                const assessmentScore = this.getAttribute('data-applicant-assessment-score');
                const practicalScore = this.getAttribute('data-applicant-practical-score');
                // const interviewScore = this.getAttribute('data-applicant-interview-score');
                const status = this.getAttribute('data-applicant-status');

                document.getElementById('applicant_id').value = applicantId;
                document.getElementById('applicant_name').value = applicantName;
                document.getElementById('assessment_score').value = assessmentScore;
                document.getElementById('practical_score').value = practicalScore;
                // document.getElementById('interview_score').value = interviewScore;
                document.getElementById('status').value = status;

                // Show modal
                var editModal = new bootstrap.Modal(document.getElementById('editModal'));
                editModal.show();
            });
        });

        // Handle form submission
        document.getElementById('updateForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const applicantId = document.getElementById('applicant_id').value;
            const assessmentScore = document.getElementById('assessment_score').value;
            const practicalScore = document.getElementById('practical_score').value;
            // const interviewScore = document.getElementById('interview_score').value;
            const status = document.getElementById('status').value;
            const url = "{{ route('updateshortlistedapplicantdetails') }}";

            fetch(url, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        id: applicantId,
                        assessment_score: assessmentScore,
                        practical_score: practicalScore,
                        // interview_score: interviewScore,
                        status: status
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    if (data.success) {
                        location.reload(); // Reload the page to reflect changes
                    } else {
                        alert('Failed to update applicant details.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while updating applicant details.');
                });
        });
    });
</script>

<!-- Interview Modal -->
<div class="modal fade" id="interviewModal" tabindex="-1" aria-labelledby="interviewModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="interviewModalLabel">Schedule/Reschedule Interview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="scheduleInterviewForm" method="POST" action="{{ route('scheduleInterview') }}">
                    @csrf
                    <input type="hidden" id="interview_applicant_user_id" name="applicant_user_id">
                    <input type="hidden" id="interview_applicant_id" name="applicant_id">
                    <input type="hidden" id="interview_job_id" name="job_listings_id">
                    <input type="hidden" id="is_reschedule" name="is_reschedule" value="false">
                    <div class="mb-3">
                        <label for="interview_applicant_name" class="form-label">Applicant Name</label>
                        <input type="text" class="form-control" id="interview_applicant_name" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="interview_date" class="form-label">Interview Date</label>
                        <input type="date" class="form-control" id="interview_date" name="interview_date"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="interview_time" class="form-label">Interview Time</label>
                        <input type="time" class="form-control" id="interview_time" name="interview_time"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="interview_title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="interview_title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="interview_requirements" class="form-label">Requirements</label>
                        <textarea class="form-control" id="interview_requirements" name="requirements" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="interview_location_id" class="form-label">Location</label>
                        <select class="form-select" id="interview_location_id" name="location_id" required>
                            <option value="">Select Location</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
{{-- <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirm Reschedule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to reschedule the interview?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmReschedule">Yes, Reschedule</button>
            </div>
        </div>
    </div>
</div> --}}

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle interview button click
        document.querySelectorAll('.interview-button').forEach(button => {
            button.addEventListener('click', function() {
                // const applicantId = this.dataset.applicantId;
                // const applicantName = this.dataset.applicantName;
                // const jobId = this.dataset.jobId; // Pass the job ID from the view

                // // Populate modal fields
                // document.getElementById('interview_applicant_id').value = applicantId;
                // document.getElementById('interview_applicant_name').value = applicantName;
                // document.getElementById('interview_job_id').value = jobId; // Set the job ID
                var applicantId = this.getAttribute('data-applicant-id');
                var applicantUserId = this.getAttribute('data-applicant-user_id');
                var applicantName = this.getAttribute('data-applicant-name');
                var jobId = this.getAttribute('data-job-id'); // Get Job ID

                document.getElementById('interview_applicant_id').value = applicantId;
                document.getElementById('interview_applicant_user_id').value = applicantUserId;
                document.getElementById('interview_applicant_name').value = applicantName;
                document.getElementById('interview_job_id').value = jobId;

                // Fetch job listings and locations
                fetch('{{ route('getFormDetails') }}')
                    .then(response => response.json())
                    .then(data => {
                        // Populate job listings dropdown
                        // const jobListings = data.jobListings;
                        const locations = data.locations;
                        // const jobDropdown = document.getElementById('interview_job_id');
                        const locationDropdown = document.getElementById(
                            'interview_location_id');

                        // jobDropdown.innerHTML =
                        //     '<option value="">Select Job Listing</option>';
                        // jobListings.forEach(job => {
                        //     jobDropdown.innerHTML +=
                        //         `<option value="${job.id}">${job.title}</option>`;
                        // });

                        locationDropdown.innerHTML =
                            '<option value="">Select Location</option>';
                        locations.forEach(location => {
                            locationDropdown.innerHTML +=
                                `<option value="${location.id}">${location.name}</option>`;
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching form details:', error);
                        alert('An error occurred while fetching form details.');
                    });

                // Show modal
                var interviewModal = new bootstrap.Modal(document.getElementById(
                    'interviewModal'));
                interviewModal.show();
            });
        });



        // Handle form submission
        document.getElementById('scheduleForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const applicantId = document.getElementById('interview_applicant_id').value;
            const applicantUserId = document.getElementById('interview_applicant_user_id').value;
            const jobId = document.getElementById('interview_job_id').value;
            const locationId = document.getElementById('interview_location_id').value;
            const interviewDate = document.getElementById('interview_date').value;
            const interviewTime = document.getElementById('interview_time').value;
            const title = document.getElementById('interview_title').value;
            const requirements = document.getElementById('interview_requirements').value;
            const url = "{{ route('scheduleInterview') }}"; // Replace with your API endpoint URL

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        user_id: applicantUserId,
                        applicant_id: applicantId,
                        job_listings_id: jobId, // Pass the job ID
                        location_id: locationId,
                        interview_date: interviewDate,
                        interview_time: interviewTime,
                        title: title,
                        requirements: requirements
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    if (data.success) {
                        // Handle successful response
                        location.reload(); // Reload the page to reflect changes
                    } else {
                        // Handle error response
                        alert('Failed to schedule interview.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while scheduling the interview.');
                });
        });
    });

    // document.addEventListener('DOMContentLoaded', function() {
    // document.addEventListener('DOMContentLoaded', function() {
    //     let isReschedule = false;

    //     // Handle interview button click
    //     document.querySelectorAll('.interview-button').forEach(button => {
    //         button.addEventListener('click', function() {
    //             var applicantId = this.getAttribute('data-applicant-id');
    //             var applicantUserId = this.getAttribute('data-applicant-user_id');
    //             var applicantName = this.getAttribute('data-applicant-name');
    //             var jobId = this.getAttribute('data-job-id');

    //             document.getElementById('interview_applicant_id').value = applicantId;
    //             document.getElementById('interview_applicant_user_id').value = applicantUserId;
    //             document.getElementById('interview_applicant_name').value = applicantName;
    //             document.getElementById('interview_job_id').value = jobId;

    //             // Check if it's a reschedule
    //             fetch(`{{ url('/AllApplicants/check-interview') }}/${jobId}/${applicantId}`)
    //                 .then(response => {
    //                     console.log('Response status:', response
    //                     .status); // Log response status
    //                     return response.json();
    //                 })
    //                 .then(data => {
    //                     console.log('Response data:', data); // Log response data
    //                     if (data.exists) {
    //                         isReschedule = true;
    //                     } else {
    //                         isReschedule = false;
    //                     }
    //                     document.getElementById('is_reschedule').value = isReschedule ?
    //                         'true' : 'false';
    //                 })
    //                 .catch(error => {
    //                     console.error('Error checking interview:', error);
    //                     alert(error);
    //                     alert('An error occurred while checking the interview status.');
    //                 });

    //             // Fetch locations
    //             fetch('{{ route('getFormDetails') }}')
    //                 .then(response => response.json())
    //                 .then(data => {
    //                     const locations = data.locations;
    //                     const locationDropdown = document.getElementById(
    //                         'interview_location_id');

    //                     locationDropdown.innerHTML =
    //                         '<option value="">Select Location</option>';
    //                     locations.forEach(location => {
    //                         locationDropdown.innerHTML +=
    //                             `<option value="${location.id}">${location.name}</option>`;
    //                     });
    //                 })
    //                 .catch(error => {
    //                     console.error('Error fetching form details:', error);
    //                     alert('An error occurred while fetching form details.');
    //                 });

    //             // Show modal
    //             var interviewModal = new bootstrap.Modal(document.getElementById(
    //                 'interviewModal'));
    //             interviewModal.show();
    //         });
    //     });

    //     // Handle form submission
    //     document.getElementById('scheduleInterviewForm').addEventListener('submit', function(event) {
    //         event.preventDefault();

    //         const applicantId = document.getElementById('interview_applicant_id').value;
    //         const applicantUserId = document.getElementById('interview_applicant_user_id').value;
    //         const jobId = document.getElementById('interview_job_id').value;
    //         const locationId = document.getElementById('interview_location_id').value;
    //         const interviewDate = document.getElementById('interview_date').value;
    //         const interviewTime = document.getElementById('interview_time').value;
    //         const title = document.getElementById('interview_title').value;
    //         const requirements = document.getElementById('interview_requirements').value;
    //         const url = "{{ route('scheduleInterview') }}";

    //         if (isReschedule) {
    //             // Show confirmation modal
    //             var confirmationModal = new bootstrap.Modal(document.getElementById(
    //                 'confirmationModal'));
    //             confirmationModal.show();

    //             document.getElementById('confirmReschedule').addEventListener('click', function() {
    //                 // Proceed with rescheduling
    //                 confirmationModal.hide();

    //                 submitForm(url, {
    //                     applicant_id: applicantId,
    //                     applicant_user_id: applicantUserId,
    //                     job_listings_id: jobId,
    //                     location_id: locationId,
    //                     interview_date: interviewDate,
    //                     interview_time: interviewTime,
    //                     title: title,
    //                     requirements: requirements
    //                 });
    //             });
    //         } else {
    //             // Directly schedule the interview
    //             submitForm(url, {
    //                 applicant_id: applicantId,
    //                 applicant_user_id: applicantUserId,
    //                 job_listings_id: jobId,
    //                 location_id: locationId,
    //                 interview_date: interviewDate,
    //                 interview_time: interviewTime,
    //                 title: title,
    //                 requirements: requirements
    //             });
    //         }
    //     });

    //     function submitForm(url, data) {
    //         fetch(url, {
    //                 method: 'POST',
    //                 headers: {
    //                     'Content-Type': 'application/json',
    //                     'X-CSRF-TOKEN': '{{ csrf_token() }}'
    //                 },
    //                 body: JSON.stringify(data)
    //             })
    //             .then(response => response.json())
    //             .then(data => {
    //                 if (data.success) {
    //                     location.reload(); // Reload the page to reflect changes
    //                 } else {
    //                     console.error('Failed to schedule interview:', data.message);
    //                     alert('Failed to schedule interview.');
    //                 }
    //             })
    //             .catch(error => {
    //                 console.error('Error:', error);
    //                 alert('An error occurred while scheduling the interview.');
    //             });
    //     }
    // });
</script>
