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
                            @if ($assessment->pass_mark)
                                <span
                                    class="price text-highlight fs-lg fw-700">{{ number_format($assessment->pass_mark, 0) }}</span>
                            @else
                                <span class="price text-highlight fs-lg fw-700">Passmark: Not specified</span>
                            @endif
                        </div>
                        <!-- Display assessment description -->
                        <div class="product-desc mt-2">
                            <p>{!! $assessment->description !!}</p>
                        </div>
                    </div>
                    <!-- end product-detail -->
                    <hr>
                    <ul class="product-meta list-unstyled">
                        <li>Category:
                            <span class="badge bg-success">{{ $assessment->category->name }}</span>
                        </li>
                    </ul>
                    <hr>
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
