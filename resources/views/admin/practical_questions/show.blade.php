

<x-admin.app-layout>
    <x-admin.page-header />
    <div class="card p-5">
        <div class="card-body">
            <div class="row">
                <!-- begin col product-detail -->
                <div class="col-lg-12 col-md-12">
                    <!-- begin product-detail -->
                    <div class="product-detail">
                        <div class="product-price mb-2">

                            <!-- Display question description -->
                            <div class="product-desc mt-2">
                                <strong style="color: #00AAD0">Question:</strong>
                                <p>{!! $practicalQuestion->question !!}</p>
                            </div>


                        </div>

                    </div>
                    <!-- end product-detail -->
                    {{-- <hr>
                    <ul class="product-meta list-unstyled">
                        <li><strong>Assessment Test:</strong>
                            <span class="badge bg-success">{{ $practicalQuestion->tests->title }}</span>
                        </li>
                    </ul>
                    <hr> --}}
                    <div class="row">
                        <!-- Button to edit the question posting -->
                        <div class="col-12">
                            <a class="btn btn-highlight" href="{{ route('questions.edit', $practicalQuestion->id) }}"
                                style="background-color: #00AAD0">Edit</a>
                        </div>
                    </div>
                </div>
                <!-- end col product-detail -->
            </div>
        </div>
    </div>
</x-admin.app-layout>
