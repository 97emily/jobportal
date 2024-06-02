<x-admin.app-layout>
    <x-admin.page-header />
    {{-- <div class="container">
        <h1>{{ $assessment->title }}</h1>
        <p>{{ $assessment->description }}</p>
        <a href="{{ route('assessments.questions.create', $assessment->id) }}" class="btn btn-primary" style="background-color: #00AAD0">Add Question</a>
        <ul>
            @foreach ($assessment->questions as $question)
                <li>
                    {{ $question->question }}
                    <a href="{{ route('assessments.show', [$assessment->id, $question->id]) }}" class="btn btn-secondary">Edit</a>
                    <form action="{{ route('assessments.destroy', [$assessment->id, $question->id]) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                    <ul>
                        @foreach ($question->answers as $answer)
                            <li>
                                {{ $answer->answer }} ({{ $answer->is_correct ? 'Correct' : 'Incorrect' }})
                                <a href="{{ route('questions.answers.edit', [$question->id, $answer->id]) }}" class="btn btn-secondary">Edit</a>
                                <form action="{{ route('questions.answers.destroy', [$question->id, $answer->id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                    <a href="{{ route('questions.answers.create', $question->id) }}" class="btn btn-primary">Add Answer</a>
                </li>
            @endforeach
        </ul>
    </div> --}}
    <div class="container">
        <h1>{{ $assessment->title }}</h1>
        <p>{{ $assessment->description }}</p>

        <h3>Questions</h3>
        @foreach($assessment->questions as $question)
            <div class="card mt-3">
                <div class="card-header">
                    {{ $question->question }}
                </div>
                <div class="card-body">
                    <ul>
                        @foreach($question->answers as $answer)
                            <li>{{ $answer->answer }} @if($answer->is_correct) <strong>(Correct)</strong> @endif</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach
    </div>
</x-admin.app-layout>
