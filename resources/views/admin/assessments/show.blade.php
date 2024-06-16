<x-admin.app-layout>
    <x-admin.page-header />
    <div class="card p-5">
        <div class="card-body">
            <div class="row">
                <!-- begin col product-detail -->
                <div class="col-lg-12 col-md-12">
                    <!-- begin product-detail -->
                    <div class="product-detail">
                        <h2 class="product-title">{{ $assessment->title }}</h2>
                        <div class="product-price mb-2">
                            <!-- Display pass mark if available -->
                            @if ($assessment->pass_mark)
                                <span class="price text-highlight fs-lg fw-700">Pass Mark:
                                    {{ number_format($assessment->pass_mark, 0) }}</span>
                                <br>
                                <span class="price text-highlight fs-lg fw-700">Questions:
                                    {{ number_format(count($questions->where('assessment_id', $assessment->id)), 0) }}</span>
                                <br>
                                <span class="price text-highlight fs-lg fw-700">Total Time:
                                    {{ number_format($questions->where('assessment_id', $assessment->id)->sum('allocated_time'), 0) }}</span>
                                <br>
                                <span class="price text-highlight fs-lg fw-700">Total Marks:
                                    {{ number_format($questions->where('assessment_id', $assessment->id)->sum('allocated_marks'), 0) }}</span>
                                <br>
                            @else
                                <span class="price text-highlight fs-lg fw-700">Pass Mark: Not specified</span>
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
                    <!-- Display all questions under the assessment -->
                    <h3 style="color: #00AAD0;">Questions</h3>
                    @foreach ($assessment->questions as $index => $question)
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
                                        {{ $question->allocated_marks }}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Allocated Time:</strong>
                                        {{ $question->allocated_time }}
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Multiple Choices:</strong>
                                        <!-- Output the choices -->
                                        <p>The choices options are:</p>
                                        <ul>
                                            @foreach (assessments_choices($question->id) as $choice)
                                                <li>{{ $choice }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Marking Scheme:</strong>
                                        <!-- Output the correct multiple choice answers -->
                                        <p>The correct answers are:</p>
                                        <ul>
                                            @foreach (assessments_answers($question->id) as $answer)
                                                <li>{{ $answer }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>


                                <!-- Edit Button for Each Question -->
                                <div class="col-12 mt-2">
                                    <a class="btn btn-secondary" href="{{ route('questions.edit', $question->id) }}"
                                        style="background-color: #00AAD0">Edit Question</a>
                                </div>
                            </div>
                        </div>
                        <hr>
                    @endforeach
                    <!-- end questions -->
                    <div class="row">
                        <!-- Button to edit the assessment posting -->
                        <div class="col-12">
                            <a class="btn btn-highlight" href="{{ route('assessments.edit', $assessment->id) }}"
                                style="background-color: #00AAD0">Edit Assessment</a>
                        </div>
                    </div>
                </div>
                <!-- end col product-detail -->
            </div>
        </div>
    </div>
</x-admin.app-layout>
