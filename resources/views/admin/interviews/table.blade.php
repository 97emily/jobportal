<div>
    <table id="interview-datatable" class="resources-datatable table-middle table-hover table-responsive table">
        <thead>
            <tr>
                <th>No</th>
                <th>View</th>
                <th>Applicant</th>
                <th>Date</th>
                <th>Job Title</th>
                <th>Assessment Score</th>
                <th>Interview Score</th>
                <th>Practical Score</th>
                <th>Interview Status</th>
                <th>Status</th>
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
                    <td>{{ $interview->applicant_name }}</td>
                    <td>{{ \Carbon\Carbon::parse($interview->interview_date)->format('d-m-Y') }}</td>
                    <td>{{ $interview->job->title }}</td>
                    <td>{{ $interview->assessment_score }}</td>
                    <td>{{ $interview->interview_score }}</td>

                    <td>{{ $interview->practical_score }}</td>
                    <td>
                        <span class="badge {{ empty($interview->interview_score) ? 'bg-warning' : 'bg-info' }}">
                            {{ empty($interview->interview_score) ? 'Pending' : 'Done' }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-info">{{ $interview->status }}</span>
                    </td>
                    <td>
                        <ul class="list-unstyled table-actions">
                            <li>
                                <a href="javascript:void(0)" class="edit-button" data-applicant-id="{{ $interview->applicant_id }}" data-applicant-name="{{ $interview->applicant_name }}" data-applicant-assessment-score="{{ $interview->assessment_score }}" data-applicant-practical-score="{{ $interview->practical_score }}" data-applicant-interview-score="{{ $interview->interview_score }}" data-applicant-status="{{ $interview->status }}">
                                    <i class="fa fa-edit" style="color: #000000" data-bs-toggle="tooltip" title="Update Interview Score"></i>
                                </a>
                            </li>
                            <li>
                                <button type="button" class="shortlist-button" data-id="{{ $interview->id }}" style="border: none; background: none;">
                                    <i class="fa {{ $interview->shortlisted == 'shortlisted' ? 'fa-check-circle' : 'fa-plus-circle' }}" style="color: {{ $interview->shortlisted == 'shortlisted' ? '#17a2b8' : '#28a745' }}" data-bs-toggle="tooltip" title="{{ $interview->shortlisted == 'shortlisted' ? 'Shortlisted' : 'Shortlist?' }}"></i>
                                </button>
                            </li>
                            <li>
                                <form action="{{ route('interviews.destroy', $interview->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="border: none; background: none;" data-bs-toggle="tooltip" title="Delete">
                                        <i class="fa fa-trash" style="color: #dc3545"></i>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div>
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
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
                            <input type="text" class="form-control" id="applicant_name" name="applicant_name" readonly>
                        </div>
                        <div class="form-group">
                            <label for="assessment_score">Assessment Score</label>
                            <input type="number" class="form-control" id="assessment_score" name="assessment_score" readonly>
                        </div>
                        <div class="form-group">
                            <label for="practical_score">Practical Score</label>
                            <input type="number" class="form-control" id="practical_score" name="practical_score" required>
                        </div>
                        <div class="form-group">
                            <label for="interview_score">Interview Score</label>
                            <input type="number" class="form-control" id="interview_score" name="interview_score" required>
                        </div>
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Handle edit button click
    document.querySelectorAll('.edit-button').forEach(button => {
        button.addEventListener('click', function () {
            const applicantId = this.getAttribute('data-applicant-id');
            const applicantName = this.getAttribute('data-applicant-name');
            const assessmentScore = this.getAttribute('data-applicant-assessment-score');
            const practicalScore = this.getAttribute('data-applicant-practical-score');
            const interviewScore = this.getAttribute('data-applicant-interview-score');
            const status = this.getAttribute('data-applicant-status');

            document.getElementById('applicant_id').value = applicantId;
            document.getElementById('applicant_name').value = applicantName;
            document.getElementById('assessment_score').value = assessmentScore;
            document.getElementById('practical_score').value = practicalScore;
            document.getElementById('interview_score').value = interviewScore;
            document.getElementById('status').value = status;

            // Show modal
            var editModal = new bootstrap.Modal(document.getElementById('editModal'));
            editModal.show();
        });
    });

    // Handle form submission
    document.getElementById('updateForm').addEventListener('submit', function (event) {
        event.preventDefault();

        const applicantId = document.getElementById('applicant_id').value;
        const assessmentScore = document.getElementById('assessment_score').value;
        const practicalScore = document.getElementById('practical_score').value;
        const interviewScore = document.getElementById('interview_score').value;
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
                    interview_score: interviewScore,
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.shortlist-button').forEach(button => {
        button.addEventListener('click', function() {
            const interviewId = this.getAttribute('data-id');

            fetch('{{ route('interviews.shortlist') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ interview_id: interviewId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload(); // Reload the page to reflect changes
                } else {
                    alert('Failed to update shortlisting status.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating shortlisting status.');
            });
        });
    });
});
</script>
