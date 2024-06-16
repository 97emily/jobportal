
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
                                    <input placeholder="Title" class="form-control" required name="title" type="text" id="title" value="{{ $job->title ?? '' }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="job_description">Job Description <span
                                            class="text-danger">*</span></label>
                                    <div class="quill-editor-wrapper">
                                        <div id="job_description-quill-editor" style="height: 300px;"
                                            class="ql-container ql-snow">
                                            <div class="ql-editor" data-gramm="false" contenteditable="true">
                                                {!! $job->job_description ?? '' !!}
                                            </div>
                                            <div class="ql-clipboard" contenteditable="true" tabindex="-1"></div>
                                            <div class="ql-tooltip ql-hidden"><a class="ql-preview"
                                                    rel="noopener noreferrer" target="_blank"
                                                    href="about:blank"></a><input type="text" data-formula="e=mc^2"
                                                    data-link="https://quilljs.com" data-video="Embed URL"><a
                                                    class="ql-action"></a><a class="ql-remove"></a></div>
                                        </div>
                                        <input name="job_description" type="hidden" id="job_description">
                                    </div>

                                    <script>
                                        document.addEventListener("DOMContentLoaded", function() {
                                            var job_description_editor = new Quill('#job_description-quill-editor', {
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
                                            job_description_editor.on('text-change', function(delta, source) {
                                                document.getElementById('job_description').value = job_description_editor.root.innerHTML;
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
                        <h4>Salary and Location</h4>
                        <div class="row border-bottom mb-3">
                            <div class="form-group mb-3">
                                <label for="location_id">Location</label>
                                <select class="form-control" id="location_id" name="location_id">
                                    <option value="">Select Location</option>
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label for="salary_range_id">Salary Range</label>
                                <select class="form-control" id="salary_range_id" name="salary_range_id">
                                    <option value="">Select Salary Range</option>
                                    @foreach ($salaryRanges as $salaryRange)
                                        <option value="{{ $salaryRange->id }}">{{ $salaryRange->minimum }} - {{ $salaryRange->maximum }} </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label for="assessment_id">Assessment</label>
                                <select class="form-control" id="assessment_id" name="assessment_id">
                                    <option value="">Select Assessment</option>
                                    @foreach ($assessments as $assessment)
                                        <option value="{{ $assessment->id }}">{{ $assessment->title }}</option>
                                    @endforeach
                                </select>
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
                            <label for="status">Status</label>
                            <select class="form-control select2" id="status" name="status">
                                <option value="open" {{ $job->status ?? '' == 'open' ? 'selected' : '' }}>Open</option>
                                <option value="preview" {{ $job->status ?? '' == 'preview' ? 'selected' : '' }}>Preview</option>
                                <option value="closed" {{ $job->status ?? '' == 'closed' ? 'selected' : '' }}>Closed</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="category_id">Category</label>
                            <select class="form-control select2" id="category_id" name="category_id">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ $job->category_id ?? '' == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tag_id">Tag</label>
                            <select class="form-control select2" id="tag_id" name="tag_id">
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag->id }}" {{ $job->tag_id ?? '' == $tag->id ? 'selected' : '' }}>
                                        {{ $tag->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- end card-body -->
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="closing_date">Closing Date</label>
                            <input type="date" class="form-control" name="closing_date" id="closing_date" value="{{ $job->closing_date ?? '' }}">
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
                        <a href="{{ route('jobs.index') }}" class="btn btn-outline-highlight waves-effect">
                            <i class="far fa-chevron-double-left"></i>
                            Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

