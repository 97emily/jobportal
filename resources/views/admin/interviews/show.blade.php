<x-admin.app-layout>
    <x-admin.page-header />
    <div class="card p-5">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h3>Interview Details</h3>
                            <hr>
                            <ul class="list-unstyled">
                                <li><strong>Interview Date:</strong> {{ \Carbon\Carbon::parse($interview->interview_date)->format('d-m-Y') }}</li>
                                <li><strong>Interview Time:</strong> {{ \Carbon\Carbon::parse($interview->interview_time)->format('H:i') }}</li>
                                <li><strong>Title:</strong> {{ $interview->title }}</li>
                                <li><strong>Location:</strong> {{ $interview->location ? $interview->location->name : 'Not specified' }}</li>
                            </ul>
                            <hr>
                            <h3>Applicant Details</h3>
                            <hr>
                            <ul class="list-unstyled">
                                <li><strong>Name:</strong> {{ $interview->applicant_name }}</li>
                                <li><strong>Status:</strong> {{ $interview->status }}</li>
                                <li><strong>Assessment Score:</strong> {{ $interview->assessment_score }}</li>
                                <li><strong>Practical Score:</strong> {{ $interview->practical_score }}</li>
                                <li><strong>Interview Score:</strong> {{ $interview->interview_score }}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12">
                            {{-- <a class="btn btn-highlight" href="{{ route('jobs.edit', $job->id) }}"
                                style="background-color: #00AAD0">Edit Job</a> --}}
                            {{-- <a class="btn btn-info" href="{{ route('interviews.edit', $interview->id) }}"
                                style="background-color: #00AAD0">Edit Interview</a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin.app-layout>
