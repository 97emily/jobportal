
<div class="row">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('practical_tests.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="title">Title <span class="text-danger">*</span></label>
                                        <input placeholder="Title" class="form-control" required name="title" type="text" id="title" value="{{ $practicalTest->title ?? '' }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="description">Test Description <span class="text-danger">*</span></label>
                                        <div class="quill-editor-wrapper">
                                            <div id="description-quill-editor" style="height: 300px;" class="ql-container ql-snow">
                                                <div class="ql-editor" data-gramm="false" contenteditable="true">
                                                    {!! $practicalTest->description ?? '' !!}
                                                </div>
                                                <div class="ql-clipboard" contenteditable="true" tabindex="-1"></div>
                                                <div class="ql-tooltip ql-hidden">
                                                    <a class="ql-preview" rel="noopener noreferrer" target="_blank" href="about:blank"></a>
                                                    <input type="text" data-formula="e=mc^2" data-link="https://quilljs.com" data-video="Embed URL">
                                                    <a class="ql-action"></a><a class="ql-remove"></a>
                                                </div>
                                            </div>
                                            <input name="description" type="hidden" id="description">
                                        </div>
                                    </div>
                                    <script>
                                        document.addEventListener("DOMContentLoaded", function() {
                                            var description_editor = new Quill('#description-quill-editor', {
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
                                            description_editor.on('text-change', function(delta, source) {
                                                document.getElementById('description').value = description_editor.root.innerHTML;
                                            });
                                        });
                                    </script>
                                    <div class="form-group mb-3">
                                        <label for="instructions">Instructions <span class="text-danger">*</span></label>
                                        <div class="quill-editor-wrapper">
                                            <div id="instructions-quill-editor" style="height: 300px;" class="ql-container ql-snow">
                                                <div class="ql-editor" data-gramm="false" contenteditable="true">
                                                    {!! $practicalTest->instructions ?? '' !!}
                                                </div>
                                                <div class="ql-clipboard" contenteditable="true" tabindex="-1"></div>
                                                <div class="ql-tooltip ql-hidden">
                                                    <a class="ql-preview" rel="noopener noreferrer" target="_blank" href="about:blank"></a>
                                                    <input type="text" data-formula="e=mc^2" data-link="https://quilljs.com" data-video="Embed URL">
                                                    <a class="ql-action"></a><a class="ql-remove"></a>
                                                </div>
                                            </div>
                                            <input name="instructions" type="hidden" id="instructions">
                                        </div>
                                    </div>
                                    <script>
                                        document.addEventListener("DOMContentLoaded", function() {
                                            var instructions_editor = new Quill('#instructions-quill-editor', {
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
                                            document.getElementById('instructions').value = instructions_editor.root.innerHTML;
                                            instructions_editor.on('text-change', function(delta, source) {
                                                document.getElementById('instructions').value = instructions_editor.root.innerHTML;
                                            });
                                        });
                                    </script>
                                    <div class="form-group mb-3">
                                        <label for="deadline"> Deadline <span class="text-danger">*</span></label>
                                        <input type="datetime-local" class="form-control" id="deadline" name="deadline" value="{!! $practicalTest->deadline ?? '' !!}"required>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="card">
                                <div class="card-body">
                                    <h4>Passmark</h4>
                                    <div class="row border-bottom mb-3">
                                        <div class="col-lg-6">
                                            <div class="form-group mb-3">
                                                <label for="pass_mark">Assessment Minimum Threshold Score</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fa fa-pen"></i></span>
                                                    <input placeholder="Assessment Minimum Threshold Score" class="form-control" name="pass_mark" type="number" step="0.01" id="pass_mark">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="category_id">Category</label>
                                            <select class="form-control select2" id="category_id" name="category_id">
                                                <option value="Select">Select Test Category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}" {{ (isset($practicalTest->category_id) && $practicalTest->category_id == $category->id) ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-body d-flex justify-content-between">
                                        <button class="btn btn-highlight waves-effect" type="submit" style="background-color: #00AAD0">
                                            <i class="fa fa-save"></i>
                                            Save
                                        </button>
                                        <a href="{{ route('practical_tests.index') }}" class="btn btn-outline-highlight waves-effect">
                                            <i class="far fa-chevron-double-left"></i>
                                            Back
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

