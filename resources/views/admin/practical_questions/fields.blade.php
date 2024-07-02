
<div class="row">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('practical_questions.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="practical_tests_id">Test <span class="text-danger">*</span></label>
                                        <select class="form-control select2" id="practical_tests_id" name="practical_tests_id" required>
                                            @foreach ($tests as $test)
                                                <option value="{{ $test->id }}">{{ $test->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="question">Question <span class="text-danger">*</span></label>
                                        <div class="quill-editor-wrapper">
                                            <div id="question-quill-editor" style="height: 300px;" class="ql-container ql-snow">
                                                <div class="ql-editor" data-gramm="false" contenteditable="true">
                                                </div>
                                                <div class="ql-clipboard" contenteditable="true" tabindex="-1"></div>
                                                <div class="ql-tooltip ql-hidden">
                                                    <a class="ql-preview" rel="noopener noreferrer" target="_blank" href="about:blank"></a>
                                                    <input type="text" data-formula="e=mc^2" data-link="https://quilljs.com" data-video="Embed URL">
                                                    <a class="ql-action"></a><a class="ql-remove"></a>
                                                </div>
                                            </div>
                                            <input name="question" type="hidden" id="question">
                                        </div>
                                    </div>
                                    <script>
                                        document.addEventListener("DOMContentLoaded", function() {
                                            var question_editor = new Quill('#question-quill-editor', {
                                                modules: {
                                                    toolbar: [
                                                        [{ 'header': [1, 2, false] }],
                                                        ['bold', 'italic', 'underline'],
                                                        ['link', 'blockquote', 'code-block', 'image'],
                                                        [{ 'list': 'ordered' }, { 'list': 'bullet' }]
                                                    ]
                                                },
                                                theme: 'snow'
                                            });
                                            question_editor.on('text-change', function(delta, source) {
                                                document.getElementById('question').value = question_editor.root.innerHTML;
                                            });
                                        });
                                    </script>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body d-flex justify-content-between">
                                    <button class="btn btn-highlight waves-effect" type="submit" style="background-color: #00AAD0">
                                        <i class="fa fa-save"></i>
                                        Save
                                    </button>
                                    <a href="{{ route('practical_questions.index') }}" class="btn btn-outline-highlight waves-effect">
                                        <i class="far fa-chevron-double-left"></i>
                                        Back
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

