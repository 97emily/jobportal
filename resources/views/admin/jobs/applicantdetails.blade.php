<x-admin.app-layout>
    <x-admin.page-header />

    <div class="card p-5">
        <div class="card-body">
            <h2 class="text-center mb-4">Applicant Details</h2>

            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="section mb-4">
                        <h4>Personal Details</h4>
                        <p><strong>Full Name:</strong>
                            {{ $shortListedApplicantDetails['personal_details']['firstname'] }}
                            {{ $shortListedApplicantDetails['personal_details']['lastname'] }}</p>
                        <p><strong>National ID:</strong>
                            {{ $shortListedApplicantDetails['personal_details']['nationalId'] }}</p>
                        <p><strong>Address:</strong> {{ $shortListedApplicantDetails['personal_details']['address'] }}
                        </p>
                        <p><strong>Gender:</strong> {{ $shortListedApplicantDetails['personal_details']['gender'] }}</p>
                        <p><strong>Contact No:</strong>
                            {{ $shortListedApplicantDetails['personal_details']['contactNo'] }}</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="section mb-4">
                        <h4>Highest Education Level</h4>
                        <p><strong>Institution:</strong>
                            {{ $shortListedApplicantDetails['highest_education_level']['institution'] }}</p>
                        <p><strong>Course:</strong>
                            {{ $shortListedApplicantDetails['highest_education_level']['course'] }}</p>
                        <p><strong>Graduation Year:</strong>
                            {{ $shortListedApplicantDetails['highest_education_level']['graduationYear'] }}</p>
                        <p><strong>Grade:</strong>
                            {{ $shortListedApplicantDetails['highest_education_level']['grade'] }}</p>
                        <p><strong>Certificate:</strong> <a
                                href="{{ $shortListedApplicantDetails['highest_education_level']['certificate'] }}"
                                target="_blank">View Certificate</a></p>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="section mb-4">
                        <h4>Secondary Education</h4>
                        <p><strong>School:</strong> {{ $shortListedApplicantDetails['secondary_education']['school'] }}
                        </p>
                        <p><strong>KCSE Year:</strong>
                            {{ $shortListedApplicantDetails['secondary_education']['kcseYear'] }}</p>
                        <p><strong>Grade:</strong> {{ $shortListedApplicantDetails['secondary_education']['grade'] }}
                        </p>
                        <p><strong>KCSE Certificate:</strong> <a
                                href="{{ $shortListedApplicantDetails['secondary_education']['kcseCertificate'] }}"
                                target="_blank">View Certificate</a></p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="section mb-4">
                        <h4>Professional Qualifications</h4>
                        @foreach ($shortListedApplicantDetails['professional_qualifications'] as $qualification)
                            <p><strong>Institution:</strong> {{ $qualification['institution'] }}</p>
                            <p><strong>Body:</strong> {{ $qualification['body'] }}</p>
                            <p><strong>Award:</strong> {{ $qualification['award'] }}</p>
                            <p><strong>Certificate:</strong> <a href="{{ $qualification['professionalCertificate'] }}"
                                    target="_blank">View Certificate</a></p>
                            <hr>
                        @endforeach
                    </div>
                </div>
            </div>


        </div>
    </div>
</x-admin.app-layout>
