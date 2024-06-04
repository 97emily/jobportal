@section('content')
<div class="container">
    <h1>Add Answer to Question</h1>
    <form action="{{ route('answers.store', $question->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="answer">Answer</label>
            <textarea name="answer" id="answer" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="is_correct">Is Correct</label>
            <select name="is_correct" id="is_correct" class="form-control" required>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
