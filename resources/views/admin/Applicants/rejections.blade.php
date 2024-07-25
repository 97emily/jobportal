<x-admin.app-layout>

    <x-admin.page-header />
    <x-admin.index-toolbar>
        <x-slot:mainactions>
            {{-- @can('assessment-create')
                <a class="btn btn-highlight waves-effect" href="{{ route('assessments.create') }}" style="background-color: #00AAD0">
                    <i class="fa fa-plus-circle"></i>
                    <span class="d-none d-md-inline">{{ _('Create New Assessment') }}</span>
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
                        {{-- @include('admin/assessments/table') --}}
                        <div class="container">
                            <h4 style="color:#00AAD0">Rejected Applications for {{ $job->title }}</h4>
                            <form id="rejectionForm">
                                @csrf
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="select-all"></th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Assessment Score</th>
                                            <th>Practical Score</th>
                                            <th>Interview Score</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rejectedApplicants as $applicant)
                                            <tr>
                                                <td><input type="checkbox" name="applicant_emails[]"
                                                        value="{{ $applicant['applicant']['email'] }}"></td>
                                                <td>{{ $applicant['applicant']['name'] }}</td>
                                                <td>{{ $applicant['applicant']['email'] }}</td>
                                                <td>{{ $applicant['applicant']['assessment_score'] }}</td>
                                                <td>{{ $applicant['applicant']['practical_score'] }}</td>
                                                <td>{{ $applicant['applicant']['interview_score'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-danger" id="send-rejection-emails">Send Rejection
                                    Emails</button>
                            </form>
                        </div>

                        <!-- Confirmation Modal -->
                        <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog"
                            aria-labelledby="confirmationModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmationModalLabel">Confirm Sending Emails</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to send rejection emails to the selected applicants?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Cancel</button>
                                        <button type="button" class="btn btn-danger" id="confirm-send">Send
                                            Emails</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                // Select all functionality
                                document.getElementById('select-all').addEventListener('change', function() {
                                    let checkboxes = document.querySelectorAll('input[name="applicant_emails[]"]');
                                    checkboxes.forEach(checkbox => checkbox.checked = this.checked);
                                });

                                // Show confirmation modal
                                document.getElementById('send-rejection-emails').addEventListener('click', function() {
                                    $('#confirmationModal').modal('show');
                                });

                                // Send emails on confirmation
                                document.getElementById('confirm-send').addEventListener('click', function() {
                                    let form = document.getElementById('rejectionForm');
                                    let formData = new FormData(form);
                                    let emailArray = [];
                                    for (let pair of formData.entries()) {
                                        if (pair[0] === 'applicant_emails[]') {
                                            emailArray.push(pair[1]);
                                        }
                                    }

                                    if (emailArray.length === 0) {
                                        alert('Please select at least one applicant to send rejection emails.');
                                        $('#confirmationModal').modal('hide');
                                        return;
                                    }

                                    fetch('{{ route('admin.sendRejectionEmail') }}', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                            },
                                            body: JSON.stringify({
                                                applicant_emails: emailArray
                                            })
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            $('#confirmationModal').modal('hide');
                                            if (data.success) {
                                                alert(data.message);
                                                location.reload(); // Reload page to update the list
                                            } else {
                                                alert('Failed to send emails: ' + data.message);
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Error:', error);
                                            $('#confirmationModal').modal('hide');
                                            alert('An error occurred while sending the emails. Please try again later.');
                                        });
                                });
                            });
                        </script>

                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- {!! $assessments->links('pagination::bootstrap-5') !!} --}}
</x-admin.app-layout>
