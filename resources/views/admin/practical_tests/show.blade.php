<x-admin.app-layout>
    <x-admin.page-header />
    <div class="card p-5">
        <div class="card-body">
            <div class="row">
                <!-- begin col product-detail -->
                <div class="col-lg-12 col-md-12">
                    <!-- begin product-detail -->
                    <div class="product-detail">
                        <h2 class="product-title" style="color: #00AAD0">{{ $practicalTest->title }}</h2>
                        <!-- Display practical test description -->
                        <div class="product-desc mt-2">
                            <p>{!! $practicalTest->description !!}</p>
                        </div>
                        <div class="product-price mb-2">
                            <!-- Display pass mark if available -->
                            @if ($practicalTest->pass_mark)
                                <span class="price text-highlight fs-lg fw-500">Pass Mark:
                                    <span>{{ number_format($practicalTest->pass_mark, 0) }}%</span>
                                <br>
                                <span class="price text-highlight fs-lg fw-500">Questions:
                                    {{ number_format(count($practicalTest->questions), 0) . ' questions' }}</span>
                                <br>
                                <span class="price text-highlight fs-lg fw-500">Total Time:
                                    {{ number_format($practicalTest->questions->sum('allocated_time'), 0) . ' minutes' }}</span>
                                <br>
                                <span class="price text-highlight fs-lg fw-500">Total Marks:
                                    {{ number_format($practicalTest->questions->sum('allocated_marks'), 0) . ' marks'}}</span>
                                <br>
                            @else
                                <span class="price text-highlight fs-lg fw-500">Pass Mark: Not specified</span>
                            @endif
                        </div>
                    </div>
                    <!-- end product-detail -->
                    <hr>
                    <ul class="product-meta list-unstyled fw-500">
                        <li> <strong> Assessment Category: </strong>
                            <span class="badge bg-success">{{ $practicalTest->category->name }}</span>
                        </li>
                    </ul>
                    <hr>
                    <!-- Display all questions under the practical test -->
                    <h3 style="color: #00AAD0;"> Assessment Questions</h3>
                    @foreach ($practicalTest->questions as $index => $question)
                        <div class="product-detail mt-4">
                            <div class="product-price mb-2">
                                <!-- Display question number and description -->
                                <div class="product-desc mt-2">
                                    <p><strong style="color: #ef4019;">Question {{ $index + 1 }}:</strong>
                                        {!! $question->question !!}</p>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Allocated Marks:</strong>
                                        {{ $question->allocated_marks . ' Marks'}}
                                    </div>
                                </div>
                                <!-- Edit Button for Each Question -->
                                <div class="col-12 mt-2">
                                    <a class="btn btn-secondary" href="{{ route('practical_questions.edit', $question->id) }}"
                                        style="background-color: #00AAD0">Edit Question</a>
                                </div>
                            </div>
                        </div>
                        <hr>
                    @endforeach
                    <!-- end questions -->
                    <div class="row">
                        <!-- Button to edit the practical test posting -->
                        <div class="col-12">
                            <a class="btn btn-highlight" href="{{ route('practical_tests.edit', $practicalTest->id) }}"
                                style="background-color: #00AAD0">Edit Practical Test</a>
                        </div>
                    </div>
                </div>
                <!-- end col product-detail -->
            </div>
        </div>
    </div>
</x-admin.app-layout>
