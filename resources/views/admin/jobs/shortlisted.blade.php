<x-admin.app-layout>
    <x-admin.page-header />
    <x-admin.index-toolbar>
        <x-slot:mainactions></x-slot>
    </x-admin.index-toolbar>

    <x-flash-message />

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="job-datatable" class="resources-datatable table-middle table-hover table-responsive table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>View</th>
                                    <th>Name</th>
                                    <th class="no-sort">Email</th>
                                    <th>Score</th>
                                    <th>Status</th>
                                    <th>Application Date</th>
                                    <th class="no-sort text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($shorListedApplicants as $key => $applicant)
                                    <tr class="item">
                                        <td>{{ ++$key }}</td>
                                        <td>
                                            <a href="{{ route('jobs.shortlisted.applicant', ['user_id' => $applicant['applicant']['user_id']]) }}">
                                                <i style="color: #00AAD0" class="fa fa-eye" data-bs-original-title="View" data-bs-toggle="tooltip"></i>
                                            </a>
                                        </td>
                                        <td>{{ $applicant['applicant']['name'] }}</td>
                                        <td>{{ $applicant['applicant']['email'] }}</td>
                                        <td>{{ $applicant['applicant']['score'] }}</td>
                                        <td>{{ $applicant['applicant']['status'] }}</td>
                                        <td>{{ $applicant['application_date'] }}</td>
                                        <td>
                                            <ul class="list-unstyled table-actions">
                                                @can('job-edit')
                                                    <li>
                                                        <a href="javascript:void(0)"
                                                           class="edit-button"
                                                           data-applicant-id="{{ $applicant['applicant']['user_id'] }}"
                                                           data-applicant-name="{{ $applicant['applicant']['name'] }}"
                                                           data-applicant-score="{{ $applicant['applicant']['score'] }}"
                                                           data-applicant-status="{{ $applicant['applicant']['status'] }}">
                                                           <i class="fa fa-edit" style="color: #00AAD0"></i>
                                                        </a>
                                                    </li>
                                                @endcan
                                            </ul>

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

    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="updateForm" method="PUT">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Update Applicant Details</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="applicant_id" id="applicant_id">
                        <div class="form-group">
                            <label for="applicant_name">Name</label>
                            <input type="text" class="form-control" id="applicant_name" name="applicant_name" readonly>
                        </div>
                        <div class="form-group">
                            <label for="score">Score</label>
                            <input type="number" class="form-control" id="score" name="score" required>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="In Review">In Review</option>
                                <option value="Approved">Approved</option>
                                <option value="Rejected">Rejected</option>
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
</x-admin.app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle edit button click
        document.querySelectorAll('.edit-button').forEach(button => {
            button.addEventListener('click', function() {
                const applicantId = this.dataset.applicantId;
                const applicantName = this.dataset.applicantName;
                const applicantScore = this.dataset.applicantScore;
                const applicantStatus = this.dataset.applicantStatus;

                // Populate modal fields
                document.getElementById('applicant_id').value = applicantId;
                document.getElementById('applicant_name').value = applicantName;
                document.getElementById('score').value = applicantScore;
                document.getElementById('status').value = applicantStatus;

                // Show modal
                var editModal = new bootstrap.Modal(document.getElementById('editModal'));
                editModal.show();
            });
        });

        // Handle form submission
        document.getElementById('updateForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const applicantId = document.getElementById('applicant_id').value;
            const score = document.getElementById('score').value;
            const status = document.getElementById('status').value;
            const url = "{{ route('updateshortlistedapplicantdetails') }}"; // Replace with your API endpoint URL

            fetch(url, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    id: applicantId,
                    score: score,
                    status: status
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
