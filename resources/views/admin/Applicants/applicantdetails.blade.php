<x-admin.app-layout>
    <x-admin.page-header />

    <div class="card p-5">
        <div class="card-body">
            <h2 class="text-center mb-4">Applicant Details</h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-4">
                        <h4>Personal Details</h4>
                        <dl class="row">
                            <dt class="col-sm-4">Full Name:</dt>
                            <dd class="col-sm-8">{{ $shortListedApplicantDetails['personal_details']['firstname'] ?? 'Not specified' }} {{ $shortListedApplicantDetails['personal_details']['lastname'] ?? 'Not specified' }}</dd>

                            <dt class="col-sm-4">National ID:</dt>
                            <dd class="col-sm-8">{{ $shortListedApplicantDetails['personal_details']['nationalId'] ?? 'Not specified' }}</dd>

                            <dt class="col-sm-4">Address:</dt>
                            <dd class="col-sm-8">{{ $shortListedApplicantDetails['personal_details']['address'] ?? 'Not specified' }}</dd>

                            <dt class="col-sm-4">Gender:</dt>
                            <dd class="col-sm-8">{{ $shortListedApplicantDetails['personal_details']['gender'] ?? 'Not specified' }}</dd>

                            <dt class="col-sm-4">Contact No:</dt>
                            <dd class="col-sm-8">{{ $shortListedApplicantDetails['personal_details']['contactNo'] ?? 'Not specified' }}</dd>
                        </dl>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-4">
                        <h4>Highest Education Level</h4>
                        <dl class="row">
                            <dt class="col-sm-4">Institution:</dt>
                            <dd class="col-sm-8">{{ $shortListedApplicantDetails['highest_education_level']['institution'] ?? 'Not specified' }}</dd>

                            <dt class="col-sm-4">Course:</dt>
                            <dd class="col-sm-8">{{ $shortListedApplicantDetails['highest_education_level']['course'] ?? 'Not specified' }}</dd>

                            <dt class="col-sm-4">Graduation Year:</dt>
                            <dd class="col-sm-8">{{ $shortListedApplicantDetails['highest_education_level']['graduationYear'] ?? 'Not specified' }}</dd>

                            <dt class="col-sm-4">Grade:</dt>
                            <dd class="col-sm-8">{{ $shortListedApplicantDetails['highest_education_level']['grade'] ?? 'Not specified' }}</dd>

                            <dt class="col-sm-4">Certificate:</dt>
                            <dd class="col-sm-8">
                                @if(!empty($shortListedApplicantDetails['highest_education_level']['certificate']))
                                    <a href="{{ $shortListedApplicantDetails['highest_education_level']['certificate'] }}" target="_blank">View Certificate</a>
                                @else
                                    Not specified
                                @endif
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-4">
                        <h4>Secondary Education</h4>
                        <dl class="row">
                            <dt class="col-sm-4">School:</dt>
                            <dd class="col-sm-8">{{ $shortListedApplicantDetails['secondary_education']['school'] ?? 'Not specified' }}</dd>

                            <dt class="col-sm-4">KCSE Year:</dt>
                            <dd class="col-sm-8">{{ $shortListedApplicantDetails['secondary_education']['kcseYear'] ?? 'Not specified' }}</dd>

                            <dt class="col-sm-4">Grade:</dt>
                            <dd class="col-sm-8">{{ $shortListedApplicantDetails['secondary_education']['grade'] ?? 'Not specified' }}</dd>

                            <dt class="col-sm-4">KCSE Certificate:</dt>
                            <dd class="col-sm-8">
                                @if(!empty($shortListedApplicantDetails['secondary_education']['kcseCertificate']))
                                    <a href="{{ $shortListedApplicantDetails['secondary_education']['kcseCertificate'] }}" target="_blank">View Certificate</a>
                                @else
                                    Not specified
                                @endif
                            </dd>
                        </dl>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-4">
                        <h4>Professional Qualifications</h4>
                        @if(!empty($shortListedApplicantDetails['professional_qualifications']))
                            @foreach ($shortListedApplicantDetails['professional_qualifications'] as $qualification)
                            <dl class="row">
                                <dt class="col-sm-4">Institution:</dt>
                                <dd class="col-sm-8">{{ $qualification['institution'] ?? 'Not specified' }}</dd>

                                <dt class="col-sm-4">Body:</dt>
                                <dd class="col-sm-8">{{ $qualification['body'] ?? 'Not specified' }}</dd>

                                <dt class="col-sm-4">Award:</dt>
                                <dd class="col-sm-8">{{ $qualification['award'] ?? 'Not specified' }}</dd>

                                <dt class="col-sm-4">Certificate:</dt>
                                <dd class="col-sm-8">
                                    @if(!empty($qualification['professionalCertificate']))
                                        <a href="{{ $qualification['professionalCertificate'] }}" target="_blank">View Certificate</a>
                                    @else
                                        Not specified
                                    @endif
                                </dd>
                            </dl>
                            <hr>
                            @endforeach
                        @else
                            <p class="text-muted">Not specified</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin.app-layout>
