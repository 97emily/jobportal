<div class="modal fade" id="interviewModal" tabindex="-1" role="dialog" aria-labelledby="interviewModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="scheduleForm" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="interviewModalLabel">Schedule Interview</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="applicant_id" id="interview_applicant_id">
                    <input type="hidden" name="job_listings_id" id="interview_job_id"> <!-- Hidden job ID field -->
                    <div class="form-group">
                        <label for="interview_applicant_name">Name</label>
                        <input type="text" class="form-control" id="interview_applicant_name" name="applicant_name" readonly>
                    </div>
                    <div class="form-group">
                        <label for="interview_date">Date</label>
                        <input type="date" class="form-control" id="interview_date" name="interview_date" required>
                    </div>
                    <div class="form-group">
                        <label for="interview_time">Time</label>
                        <input type="time" class="form-control" id="interview_time" name="interview_time" required>
                    </div>
                    <div class="form-group">
                        <label for="interview_location_id">Location</label>
                        <select class="form-control" id="interview_location_id" name="location_id" required>
                            @foreach($locations as $location)
                                <option value="{{ $location->id }}">{{ $location->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="interview_title">Title</label>
                        <input type="text" class="form-control" id="interview_title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="interview_requirements">Requirements</label>
                        <textarea class="form-control" id="interview_requirements" name="requirements" required></textarea>
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


<script>
   document.addEventListener('DOMContentLoaded', function() {
    // Handle interview button click
    document.querySelectorAll('.interview-button').forEach(button => {
        button.addEventListener('click', function() {
            const applicantId = this.dataset.applicantId;
            const applicantName = this.dataset.applicantName;
            const jobId = {{ $job->id }}; // Pass the job ID from the view

            // Populate modal fields
            document.getElementById('interview_applicant_id').value = applicantId;
            document.getElementById('interview_applicant_name').value = applicantName;
            document.getElementById('interview_job_id').value = jobId; // Set the job ID

            // Show modal
            var interviewModal = new bootstrap.Modal(document.getElementById('interviewModal'));
            interviewModal.show();
        });
    });

    // Handle form submission
    document.getElementById('scheduleForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const applicantId = document.getElementById('interview_applicant_id').value;
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

</script>
