


<x-admin.app-layout>
    <x-admin.page-header />

    <div class="card p-5">
        <div class="card-body">
            <h2 class="text-center mb-4">Application Details</h2>
            <div class="row">
                <div class="col-md-12">
                    <dl class="row">

                        <dt class="col-sm-3">Title:</dt>
                        <dd class="col-sm-9">{{ $interview->title }}</dd>

                        <dt class="col-sm-3">Interview Date:</dt>
                        <dd class="col-sm-9">{{ $interview->interview_date }}</dd>

                        <dt class="col-sm-3">Interview Time:</dt>
                        <dd class="col-sm-9">{{ $interview->interview_time }}</dd>

                        <dt class="col-sm-3">Interview Location:</dt>
                        <dd class="col-sm-9">{{ $interview->location->name}}</dd>

                        <dt class="col-sm-3">Interview Requirements:</dt>
                        <dd class="col-sm-9">{{ $interview->requirements }}</dd>
                    </dl>
                </div>
            </div>

            {{-- <h2 class="text-center mb-4">Applicant Details</h2>
            <div class="row">
                <div class="col-md-12">
                    <dl class="row">
                        <dt class="col-sm-3">Name:</dt>
                        <dd class="col-sm-9">{{ $interview->applicant_name }}</dd>

                        <dt class="col-sm-3">Status:</dt>
                        <dd class="col-sm-9">{{ $interview->status }}</dd>

                        <dt class="col-sm-3">Assessment Score:</dt>
                        <dd class="col-sm-9">{{ $interview->assessment_score }}</dd>

                        <dt class="col-sm-3">Practical Score:</dt>
                        <dd class="col-sm-9">{{ $interview->practical_score }}</dd>

                        <dt class="col-sm-3">Interview Score:</dt>
                        <dd class="col-sm-9">{{ $interview->interview_score }}</dd>
                    </dl>
                </div>
            </div> --}}

            <h4>Personal Details</h4>
            <dl class="row">
                <dt class="col-sm-3">Full Name:</dt>
                <dd class="col-sm-9">{{ $interview->personal_details['firstname'] }} {{ $interview->personal_details['lastname'] }}</dd>

                <dt class="col-sm-3">National ID:</dt>
                <dd class="col-sm-9">{{ $interview->personal_details['nationalId'] }}</dd>

                <dt class="col-sm-3">Address:</dt>
                <dd class="col-sm-9">{{ $interview->personal_details['address'] }}</dd>

                <dt class="col-sm-3">Gender:</dt>
                <dd class="col-sm-9">{{ $interview->personal_details['gender'] }}</dd>

                <dt class="col-sm-3">Contact No:</dt>
                <dd class="col-sm-9">{{ $interview->personal_details['contactNo'] }}</dd>
            </dl>

            <h4>Highest Education Level</h4>
            <dl class="row">
                <dt class="col-sm-3">Institution:</dt>
                <dd class="col-sm-9">{{ $interview->highest_education_level['institution'] }}</dd>

                <dt class="col-sm-3">Course:</dt>
                <dd class="col-sm-9">{{ $interview->highest_education_level['course'] }}</dd>

                <dt class="col-sm-3">Graduation Year:</dt>
                <dd class="col-sm-9">{{ $interview->highest_education_level['graduationYear'] }}</dd>

                <dt class="col-sm-3">Grade:</dt>
                <dd class="col-sm-9">{{ $interview->highest_education_level['grade'] }}</dd>

                <dt class="col-sm-3">Certificate:</dt>
                <dd class="col-sm-9">
                    <a href="{{ $interview->highest_education_level['certificate'] }}" target="_blank">View Certificate</a>
                </dd>
            </dl>

            <h4>Secondary Education</h4>
            <dl class="row">
                <dt class="col-sm-3">School:</dt>
                <dd class="col-sm-9">{{ $interview->secondary_education['school'] }}</dd>

                <dt class="col-sm-3">KCSE Year:</dt>
                <dd class="col-sm-9">{{ $interview->secondary_education['kcseYear'] }}</dd>

                <dt class="col-sm-3">Grade:</dt>
                <dd class="col-sm-9">{{ $interview->secondary_education['grade'] }}</dd>

                <dt class="col-sm-3">KCSE Certificate:</dt>
                <dd class="col-sm-9">
                    <a href="{{ $interview->secondary_education['kcseCertificate'] }}" target="_blank">View Certificate</a>
                </dd>
            </dl>

            <h4>Professional Qualifications</h4>
            @if(!empty($interview->professional_qualifications))
                @foreach ($interview->professional_qualifications as $qualification)
                <dl class="row">
                    <dt class="col-sm-3">Institution:</dt>
                    <dd class="col-sm-9">{{ $qualification['institution'] }}</dd>

                    <dt class="col-sm-3">Body:</dt>
                    <dd class="col-sm-9">{{ $qualification['body'] }}</dd>

                    <dt class="col-sm-3">Award:</dt>
                    <dd class="col-sm-9">{{ $qualification['award'] }}</dd>

                    <dt class="col-sm-3">Certificate:</dt>
                    <dd class="col-sm-9">
                        <a href="{{ $qualification['professionalCertificate'] }}" target="_blank">View Certificate</a>
                    </dd>
                </dl>
                <hr>
                @endforeach
            @else
                <p class="text-muted">Not specified</p>
            @endif
        </div>
    </div>
</x-admin.app-layout>

