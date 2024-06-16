
<div class="row">
    <div class="container">
        <form action="{{ route('questions.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group mb-3">
                                                <label for="question">Question <span
                                                        class="text-danger">*</span></label>
                                                <div class="quill-editor-wrapper">
                                                    <div id="question-quill-editor" style="height: 300px;"
                                                        class="ql-container ql-snow">
                                                        <div class="ql-editor" data-gramm="false"
                                                            contenteditable="true">
                                                            {!! $question->question ?? '' !!}
                                                        </div>
                                                        <div class="ql-clipboard" contenteditable="true" tabindex="-1">
                                                        </div>
                                                        <div class="ql-tooltip ql-hidden"><a class="ql-preview"
                                                                rel="noopener noreferrer" target="_blank"
                                                                href="about:blank"></a><input type="text"
                                                                data-formula="e=mc^2" data-link="https://quilljs.com"
                                                                data-video="Embed URL"><a class="ql-action"></a><a
                                                                class="ql-remove"></a></div>
                                                    </div>
                                                    <input name="question" type="hidden" id="question">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end col -->
                                    </div>
                                    <!-- end row -->
                                </div>
                                <!-- end card-body -->
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group mb-3">
                                        <label for="number_of_choices">Number of Multiple Choices</label>
                                        <div class="input-group">
                                            <input placeholder="Number of Choices" class="form-control" type="number"
                                                name="number_of_choices" step="1" id="number_of_choices">
                                            <button type="button" id="generate-choices"
                                                class="btn btn-primary">Generate Choices</button>
                                        </div>
                                    </div>

                                    <div id="choices-container" class="form-group mb-3"></div>

                                    <h4>Marks and Time Allocations</h4>
                                    <div class="row border-bottom mb-3">
                                        <div class="col-lg-6">
                                            <div class="form-group mb-3">
                                                <label for="allocated_marks">Allocated Marks</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fa fa-pen"></i> </span>
                                                    <input placeholder="Allocated Marks" class="form-control"
                                                        type="number" name="allocated_marks" step="1"
                                                        id="allocated_marks"
                                                        value="{{ $question->allocated_marks ?? '' }}">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end col -->
                                        <div class="col-lg-6">
                                            <div class="form-group mb-3">
                                                <label for="allocated_time">Allocated Time</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fa fa-clock-o"></i> </span>
                                                    <input placeholder="Allocated Time" class="form-control"
                                                        name="allocated_time" type="number" step="1"
                                                        id="allocated_time"
                                                        value="{{ $question->allocated_time ?? '' }}">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- end col -->
                                    </div>
                                    <!-- end row -->
                                </div>
                                <!-- end card-body -->
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="assessment_id">Assessment</label>
                                        <select class="form-control select2" id="assessment_id" name="assessment_id">
                                            @foreach ($assessments as $assessment)
                                                <option value="{{ $assessment->id }}"
                                                    {{ $question->assessment_id ?? '' == $assessment->id ? 'selected' : '' }}>
                                                    {{ $assessment->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- end card-body -->
                                @if ($question ?? null)
                                    <div class="card-body">
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
                                    </div>
                                    <!-- end card-body -->
                                @endif

                                <div class="card-body d-flex justify-content-between">
                                    <button class="btn btn-highlight waves-effect" type="submit"
                                        style="background-color: #00AAD0">
                                        <i class="fa fa-save"></i>
                                        Save
                                    </button>
                                    <a href="{{ route('questions.index') }}"
                                        class="btn btn-outline-highlight waves-effect">
                                        <i class="far fa-chevron-double-left"></i>
                                        Back
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var question_editor = new Quill('#question-quill-editor', {
            modules: {
                toolbar: [
                    [{
                        'header': [1, 2, false]
                    }],
                    ['bold', 'italic', 'underline'],
                    ['link', 'blockquote', 'code-block', 'image'],
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }]
                ]
            },
            theme: 'snow'
        });
        question_editor.on('text-change', function(delta, source) {
            document.getElementById('question').value = question_editor.root.innerHTML;
        });

        document.getElementById('generate-choices').addEventListener('click', function() {
            var numberOfChoices = document.getElementById('number_of_choices').value;
            var choicesContainer = document.getElementById('choices-container');
            choicesContainer.innerHTML = ''; // Clear existing choices
            for (var i = 0; i < numberOfChoices; i++) {
                var choiceGroup = document.createElement('div');
                choiceGroup.className = 'form-group';

                var choiceLabel = document.createElement('label');
                choiceLabel.textContent = 'Choice ' + (i + 1);
                choiceGroup.appendChild(choiceLabel);

                var choiceInput = document.createElement('input');
                choiceInput.type = 'text';
                choiceInput.name = 'multiple_choices[' + i + ']';
                choiceInput.className = 'form-control mb-2';
                choiceGroup.appendChild(choiceInput);

                var correctAnswerCheckbox = document.createElement('input');
                correctAnswerCheckbox.type = 'checkbox';
                correctAnswerCheckbox.name = 'correct_answers[]';
                correctAnswerCheckbox.value = i;
                correctAnswerCheckbox.className = 'form-check-input';
                choiceGroup.appendChild(correctAnswerCheckbox);

                var correctAnswerLabel = document.createElement('label');
                correctAnswerLabel.textContent = ' Correct Answer';
                correctAnswerLabel.className = 'form-check-label';
                choiceGroup.appendChild(correctAnswerLabel);

                choicesContainer.appendChild(choiceGroup);
            }
        });
    });
</script>
