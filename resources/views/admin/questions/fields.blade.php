
<form method="POST" action="{{ route('assessments.questions.store', $assessment->id) }}">
    @csrf
    <div class="row">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h3>Add a Question to {{ $assessment->title }}</h3>
                                    <div class="form-group mb-3">
                                        <label for="question">Question <span class="text-danger">*</span></label>
                                        <input type="text" placeholder="Enter your question here" class="form-control" required name="question" id="question">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="answers[0]">Answer 1 <span class="text-danger">*</span></label>
                                        <input type="text" placeholder="Enter answer 1" class="form-control" required name="answers[0]" id="answers[0]">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="answers[1]">Answer 2 <span class="text-danger">*</span></label>
                                        <input type="text" placeholder="Enter answer 2" class="form-control" required name="answers[1]" id="answers[1]">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="answers[2]">Answer 3 <span class="text-danger">*</span></label>
                                        <input type="text" placeholder="Enter answer 3" class="form-control" required name="answers[2]" id="answers[2]">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="answers[3]">Answer 4 <span class="text-danger">*</span></label>
                                        <input type="text" placeholder="Enter answer 4" class="form-control" required name="answers[3]" id="answers[3]">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="correct_answer">Tick the correct answer <span class="text-danger">*</span></label>
                                        <br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="correct_answer1" name="correct_answer" value="1" required>
                                            <label class="form-check-label" for="correct_answer1">Answer 1</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="correct_answer2" name="correct_answer" value="2">
                                            <label class="form-check-label" for="correct_answer2">Answer 2</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="correct_answer3" name="correct_answer" value="3">
                                            <label class="form-check-label" for="correct_answer3">Answer 3</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="correct_answer4" name="correct_answer" value="4">
                                            <label class="form-check-label" for="correct_answer4">Answer 4</label>
                                        </div>
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
</script>

