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
                                <p>{!! $question->question !!}</p>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong style="color: #00AAD0">Multiple Choices:</strong>
                                    <!-- Output the choices -->
                                    <p><strong> The multiple options are: </strong> </p>
                                    <ul>
                                        @foreach (assessments_choices($question->id) as $choice)
                                            <li>{{ $choice }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong style="color: #00AAD0">Marking Scheme:</strong>
                                    <!-- Output the correct multiple choice answers -->
                                    <p><strong> The Correct Answers are: </strong></p>
                                    <ul>
                                        @foreach (assessments_answers($question->id) as $answer)
                                            <li>{{ $answer }}</li>
                                        @endforeach
                                    </ul>
                                </div>
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

                        </div>

                    </div>
                    <!-- end product-detail -->
                    <hr>
                    <ul class="product-meta list-unstyled">
                        <li><strong>Assessment:</strong>
                            <span class="badge bg-success">{{ $question->assessment->title }}</span>
                        </li>
                    </ul>
                    <hr>
                    <div class="row">
                        <!-- Button to edit the question posting -->
                        <div class="col-12">
                            <a class="btn btn-highlight" href="{{ route('questions.edit', $question->id) }}"
                                style="background-color: #00AAD0">Edit</a>
                        </div>
                    </div>
                </div>
                <!-- end col product-detail -->
            </div>
        </div>
    </div>
</x-admin.app-layout>
