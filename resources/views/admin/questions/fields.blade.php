<div class="row">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label for="question">Question <span class="text-danger">*</span></label>
                                    <div class="quill-editor-wrapper">
                                        <div id="question-quill-editor" style="height: 300px;"
                                            class="ql-container ql-snow">
                                            <div class="ql-editor" data-gramm="false" contenteditable="true">
                                                {!! $question->question ?? '' !!}
                                            </div>
                                            <div class="ql-clipboard" contenteditable="true" tabindex="-1"></div>
                                            <div class="ql-tooltip ql-hidden"><a class="ql-preview"
                                                    rel="noopener noreferrer" target="_blank"
                                                    href="about:blank"></a><input type="text" data-formula="e=mc^2"
                                                    data-link="https://quilljs.com" data-video="Embed URL"><a
                                                    class="ql-action"></a><a class="ql-remove"></a></div>
                                        </div>
                                        <input name="question" type="hidden" id="question">
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
                                                document.getElementById('question').value = question_editor.root
                                                    .innerHTML;
                                            });
                                        });
                                    </script>
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
                        <h4>Marks and Time Allocations</h4>
                        <div class="row border-bottom mb-3">
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="allocated_marks">Allocated Marks</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa fa-pen"></i> </span>
                                        <input placeholder="Allocated Marks" class="form-control" type="number"
                                            name="allocated_marks" step="1" id="allocated_marks"
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
                                        <input placeholder="Allocated Time" class="form-control" name="allocated_time"
                                            type="number" step="1" id="allocated_time"
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
                    </div>

                    <div class="card-body d-flex justify-content-between">
                        <button class="btn btn-highlight waves-effect" type="submit" style="background-color: #00AAD0">
                            <i class="fa fa-save"></i>
                            Save
                        </button>
                        <a href="{{ route('questions.index') }}" class="btn btn-outline-highlight waves-effect">
                            <i class="far fa-chevron-double-left"></i>
                            Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
