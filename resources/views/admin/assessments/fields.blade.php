<div class="row">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label for="title">Title <span class="text-danger">*</span></label>
                                    <input placeholder="Title" class="form-control" required name="title"
                                        type="text" id="title" value="{{ $assessment->title ?? '' }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="description">Assessment Description <span
                                            class="text-danger">*</span></label>
                                    <div class="quill-editor-wrapper">
                                        <div id="description-quill-editor" style="height: 300px;"
                                            class="ql-container ql-snow">
                                            <div class="ql-editor" data-gramm="false" contenteditable="true">
                                                {!! $assessment->description ?? '' !!}
                                            </div>
                                            <div class="ql-clipboard" contenteditable="true" tabindex="-1"></div>
                                            <div class="ql-tooltip ql-hidden"><a class="ql-preview"
                                                    rel="noopener noreferrer" target="_blank"
                                                    href="about:blank"></a><input type="text" data-formula="e=mc^2"
                                                    data-link="https://quilljs.com" data-video="Embed URL"><a
                                                    class="ql-action"></a><a class="ql-remove"></a></div>
                                        </div>
                                        <input name="description" type="hidden" id="description">
                                    </div>

                                    <script>
                                        document.addEventListener("DOMContentLoaded", function() {
                                            var description_editor = new Quill('#description-quill-editor', {
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
                                            description_editor.on('text-change', function(delta, source) {
                                                document.getElementById('description').value = description_editor.root.innerHTML;
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
                        <h4>Passmark</h4>
                        <div class="row border-bottom mb-3">
                            <div class="col-lg-6">
                                <div class="form-group mb-3">
                                    <label for="pass_mark">Assessment Minimum Threshold Score</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa fa-pen"></i></span>
                                        <input placeholder="Assessment Minimum Threshold Score" class="form-control"
                                            name="pass_mark" type="number" step="0.01" id="pass_mark"
                                            value="{{ $assessment->pass_mark ?? '' }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="category_id">Category</label>
                            <select class="form-control select2" id="category_id" name="category_id">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $assessment->category_id ?? '' == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- end card-body -->
                </div>

                <div class="card">
                    <div class="card-body d-flex justify-content-between">
                        <button class="btn btn-highlight waves-effect" type="submit" style="background-color: #00AAD0">
                            <i class="fa fa-save"></i>
                            Save
                        </button>
                        <a href="{{ route('assessments.index') }}" class="btn btn-outline-highlight waves-effect">
                            <i class="far fa-chevron-double-left"></i>
                            Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
