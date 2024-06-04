{{-- <form method="POST" action="{{ route('assessments.store') }}">
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
                                    <label for="title">Title <span class="text-danger">*</span></label>
                                    <input placeholder="Title" class="form-control" required name="title" type="text" id="title">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="description">Description</label>
                                    <textarea placeholder="Description" class="form-control" name="description" id="description"></textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="job_listings_id">Job Listing<span class="text-danger">*</span></label>
                                    <select name="job_listings_id" id="job_listings_id" class="form-control select2" required>
                                        @foreach ($jobs as $job)
                                            <option value="{{ $job->id }}"
                                                {{ $assessments->job_listings_id ?? '' == $job->id ? 'selected' : '' }}>
                                                {{ $job->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body d-flex justify-content-between">
                        <button class="btn btn-highlight waves-effect" type="submit" style="background-color: #00AAD0">
                            <i class="fa fa-save"></i> Save
                        </button>
                        <a href="{{ route('assessments.index') }}" class="btn btn-outline-highlight waves-effect">
                            <i class="far fa-chevron-double-left"></i> Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        $('.select2').select2();
    });
</script> --}}

<div class="container">
    <form action="{{ route('assessments.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="job_listing_id">Job Listing ID</label>
            <input type="text" name="job_listing_id" class="form-control" required>
        </div>
        <div id="questions">
            <h3>Questions</h3>
            <div class="form-group">
                <label for="question">Question</label>
                <input type="text" name="questions[0][question]" class="form-control" required>
                <h3>Answers</h3>
                <div class="form-group">
                    <label for="answer">Answer</label>
                    <input type="text" name="questions[0][answers][0][answer]" class="form-control" required>
                    <label for="is_correct">Is Correct?</label>
                    <input type="checkbox" name="questions[0][answers][0][is_correct]">
                </div>
                <div class="form-group">
                    <label for="answer">Answer</label>
                    <input type="text" name="questions[0][answers][1][answer]" class="form-control" required>
                    <label for="is_correct">Is Correct?</label>
                    <input type="checkbox" name="questions[0][answers][1][is_correct]">
                </div>
                <div class="form-group">
                    <label for="answer">Answer</label>
                    <input type="text" name="questions[0][answers][1][answer]" class="form-control" required>
                    <label for="is_correct">Is Correct?</label>
                    <input type="checkbox" name="questions[0][answers][1][is_correct]">
                </div>
                <div class="form-group">
                    <label for="answer">Answer</label>
                    <input type="text" name="questions[0][answers][1][answer]" class="form-control" required>
                    <label for="is_correct">Is Correct?</label>
                    <input type="checkbox" name="questions[0][answers][1][is_correct]">
                </div>
            </div>

        </div>
        <button type="button" class="btn btn-secondary" style="background-color: #00AAD0" id="addQuestion">>Add Question</button>
        <button type="submit" class="btn btn-primary">Create Assessment</button>
    </form>
</div>

<script>
    document.getElementById('addQuestion').addEventListener('click', function() {
        let questionCount = document.querySelectorAll('#questions .form-group').length / 2;
        let questionTemplate = `
            <div class="form-group">
                <label for="question">Question</label>
                <input type="text" name="questions[${questionCount}][question]" class="form-control" required>
                <h4>Answers</h4>
                <div class="form-group">
                    <label for="answer">Answer</label>
                    <input type="text" name="questions[${questionCount}][answers][0][answer]" class="form-control" required>
                    <label for="is_correct">Is Correct?</label>
                    <input type="checkbox" name="questions[${questionCount}][answers][0][is_correct]">
                </div>
                <div class="form-group">
                    <label for="answer">Answer</label>
                    <input type="text" name="questions[${questionCount}][answers][1][answer]" class="form-control" required>
                    <label for="is_correct">Is Correct?</label>
                    <input type="checkbox" name="questions[${questionCount}][answers][1][is_correct]">
                </div>
            </div>`;
        document.getElementById('questions').insertAdjacentHTML('beforeend', questionTemplate);
    });
</script>

