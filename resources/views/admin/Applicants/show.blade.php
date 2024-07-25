<x-admin.app-layout>
    <x-admin.page-header />
    <div class="card p-5">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="product-detail">
                        <h2 class="product-title" style="color:#00AAD0">{{ $job->title }}</h2>
                        <div class="product-price mb-2">
                    @if ( $job->salaryRange->minimum . '-'. $job->salaryRange->maximum )
                                <span class="price text-highlight fs-lg fw-700">KES.
                                    {{ number_format($job->salaryRange->minimum, 0) }} -
                                    KES. {{ number_format($job->salaryRange->maximum, 0) }}</span>
                            @else
                                <span class="price text-highlight fs-lg fw-700">Salary: Not specified</span>
                            @endif
                        </div>
                        <div class="product-desc mt-2">
                            <p>{!! $job->job_description !!}</p>
                        </div>
                    </div>
                    <hr>
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
                    <div class="row">
                        <div class="col-12">
                            <a class="btn btn-highlight" href="{{ route('jobs.edit', $job->id) }}"
                                style="background-color: #00AAD0">Edit</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin.app-layout>
