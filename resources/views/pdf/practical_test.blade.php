
<!DOCTYPE html>
<html>
<head>
    <title>{{ $practicalTest->title }}</title>
    <style>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .header {

            text-align: left;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            color: rgb(0, 162, 255);
            padding: 0;
            font-size: 20px;
        }
        .header p {
            margin: 5px 0;
            font-size: 16px;
        }
        .instructions {
            margin-bottom: 20px;
        }
        .deadline p {
         color:red !important;
        }
        .question {
            margin-bottom: 15px;
        }
        .question-number {
            font-weight: bold;
            display: inline;
        }
        .question p {
            display: inline;
            margin-left: 5px; /* Adjust the margin to reduce space */
        }
    </style>
    </style>
</head>
<body>
    <div class="header">
        <h2>{{ $practicalTest->title }}</h2>
        <p><strong>Description:</strong> {!! $practicalTest->description !!}</p>
        <p><strong>Deadline:</strong> {!! \Carbon\Carbon::parse($practicalTest->deadline)->format('d-m-Y H:i:s') !!}</p>
        <p><strong>Instructions:</strong> {!! $practicalTest->instructions !!}</p>

    </div>

    @if($practicalQuestions->isNotEmpty())
        <ul>
            @foreach($practicalQuestions as $index => $question)
                <div class="question">
                    <span class="question-number">Question {{ $index + 1 }}:</span>
                    <p>{!! $question->question !!}</p> <!-- Ensure 'question' is the correct attribute name -->
                </div>
            @endforeach
            </ul>
    @else
        <p> No questions available for this practical test. </p>
    @endif
</body>
</html>

