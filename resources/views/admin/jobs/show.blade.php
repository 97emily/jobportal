<x-admin.app-layout>
    <x-admin.page-header />
    <div class="card p-5">
        <div class="card-body">
            <div class="row">
                <!-- begin col product-detail -->
                <div class="col-lg-12 col-md-12">
                    <!-- begin product-detail -->
                    <div class="product-detail">
                        <h3 class="product-title">{{ $job->title }}</h3>
                        <div class="product-price mb-2">
                            <!-- Display salary range if available -->
                            @if ($job->salary_min && $job->salary_max)
                                <span class="price text-highlight fs-lg fw-700">KES.
                                    {{ number_format($job->salary_min, 0) }} -
                                    KES. {{ number_format($job->salary_max, 0) }}</span>
                            @else
                                <span class="price text-highlight fs-lg fw-700">Salary: Not specified</span>
                            @endif
                        </div>
                        <!-- Display job description -->
                        <div class="product-desc mt-2">
                            <p>{!! $job->job_description !!}</p>
                        </div>
                    </div>
                    <!-- end product-detail -->
                    <hr>
                    <ul class="product-meta list-unstyled">
                        {{-- <li>Category:
                            @foreach ($job->categories as $category)
                                <span class="badge bg-info">{{ $category->name }}</span>
                            @endforeach
                        </li> --}}
                        <li>Tags:
                            <span class="badge bg-success">{{ $job->tag->name }}</span>
                        </li>
                    </ul>
                    <hr>
                    <div class="row">
                        <!-- Display additional job details such as available stock, number of orders, and revenue -->
                        <div class="col-md-4">
                            <h5 class="fw-700">Location:</h5>
                            <p class="lh-150 text-sm">{{ $job->location ?: 'Not specified' }}</p>
                        </div>
                        <div class="col-md-4">
                            <h5 class="fw-700">Closing Date:</h5>
                            <p class="lh-150 text-sm">
                                {{ \Carbon\Carbon::parse($job->closing_date)->format('d-m-Y') ?: 'Not specified' }}</p>
                        </div>
                        <!-- You can add more job details here as needed -->
                    </div>
                    <!-- end row -->
                    <div class="row">
                        <!-- Button to edit the job posting -->
                        <div class="col-12">
                            <a class="btn btn-highlight" href="{{ route('jobs.edit', $job->id) }}"
                                style="background-color: #00AAD0">Edit</a>
                        </div>
                    </div>
                </div>
                <!-- end col product-detail -->
            </div>
        </div>
    </div>
</x-admin.app-layout>
