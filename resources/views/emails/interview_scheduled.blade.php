{{-- <!DOCTYPE html>
<html>
<head>
    <title>Interview Scheduled</title>
</head>
<body>
    <h1>Interview Scheduled</h1>
    <p>Dear {{ $applicant['name'] }},</p>
    <p>You have been scheduled for an interview.</p>
    <p>Details:</p>
    <ul>
        <li>Date: {{ $interview['interview_date'] }}</li>
        <li>Time: {{ $interview['interview_time'] }}</li>
        <li>Location: {{ $interview['location_id'] }}</li>
        <li>Title: {{ $interview['title'] }}</li>
        <li>Requirements: {{ $interview['requirements'] }}</li>
    </ul>
    <p>Best regards,</p>
    <p>Your Company</p>
</body>
</html> --}}

<!DOCTYPE html>
<html>
<head>
    <title>{{ $isReschedule ? 'Interview Rescheduled' : 'Interview Scheduled' }}</title>
</head>
<body>
    <h1>{{ $isReschedule ? 'Your interview has been rescheduled' : 'Your interview has been scheduled' }}</h1>

    <p>Dear {{ $applicant['name'] }},</p>

    <p>
        We are pleased to inform you that your interview for the position of {{ $interview->job->title }} has been
        {{ $isReschedule ? 'rescheduled' : 'scheduled' }}.
    </p>

    <p>Here are the details:</p>
    <ul>
        <li><strong>Date:</strong> {{ $interview->interview_date }}</li>
        <li><strong>Time:</strong> {{ \Carbon\Carbon::parse($interview->interview_time)->format('h:i A') }}</li>
        <li><strong>Title:</strong> {{ $interview->title }}</li>
        <li><strong>Requirements:</strong> {{ $interview->requirements }}</li>
        <li><strong>Location:</strong> {{ $interview->location->name }}</li>
    </ul>

    <p>We look forward to seeing you.</p>

    <p>Best regards,<br>Your Company</p>
</body>
</html>
