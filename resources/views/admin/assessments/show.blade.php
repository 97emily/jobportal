<x-admin.app-layout>
    <x-admin.page-header />
    <div class="card p-5">
        <div class="card-body">
            <div class="row">
                <!-- begin col product-detail -->
                <div class="col-lg-12 col-md-12">
                    <!-- begin product-detail -->
                    <div class="product-detail">
                        <h1 class="product-title">{{ $assessment->title }}</h1>
                        <div class="product-price mb-2">
                            <!-- Display salary range if available -->
                            @if ($assessment->salary_min && $assessment->salary_max)
                                <span class="price text-highlight fs-lg fw-700">KES.
                                    {{ number_format($assessment->salary_min, 0) }} -
                                    KES. {{ number_format($assessment->salary_max, 0) }}</span>
                            @else
                                <span class="price text-highlight fs-lg fw-700">Salary: Not specified</span>
                            @endif
                        </div>
                        <!-- Display assessment description -->
                        <div class="product-desc mt-2">
                            <p>{!! $assessment->assessment_description !!}</p>
                        </div>
                    </div>
                    <!-- end product-detail -->
                    <hr>
                    <ul class="product-meta list-unstyled">
                        {{-- <li>Category:
                            @foreach ($assessment->categories as $category)
                                <span class="badge bg-info">{{ $category->name }}</span>
                            @endforeach
                        </li> --}}
                        <li>Tags:
                            <span class="badge bg-success">{{ $assessment->tag->name }}</span>
                        </li>
                    </ul>
                    <hr>
                    <div class="row">
                        <!-- Display additional assessment details such as available stock, number of orders, and revenue -->
                        <div class="col-md-4">
                            <h5 class="fw-700">Work Location:</h5>
                            <p class="lh-150 text-sm">{{ $assessment->location ?: 'Not specified' }}</p>
                        </div>
                        <div class="col-md-4">
                            <h5 class="fw-700">Closing Date:</h5>
                            <p class="lh-150 text-sm">
                                {{ \Carbon\Carbon::parse($assessment->closing_date)->format('d-m-Y') ?: 'Not specified' }}</p>
                        </div>
                        <!-- You can add more assessment details here as needed -->
                    </div>
                    <!-- end row -->
                    <div class="row">
                        <!-- Button to edit the assessment posting -->
                        <div class="col-12">
                            <a class="btn btn-highlight" href="{{ route('assessments.edit', $assessment->id) }}"
                                style="background-color: #00AAD0">Edit</a>
                        </div>
                    </div>
                </div>
                <!-- end col product-detail -->
            </div>
        </div>
    </div>
</x-admin.app-layout>
