
<div class="container">
    <h1>Add Question to {{ $assessment->title }}</h1>
    <form action="{{ route('assessments.questions.store', $assessment->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="question">Question</label>
            <textarea name="question" id="question" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary my-3" style="background-color: #00AAD0">Save</button>
    </form>
</div>

