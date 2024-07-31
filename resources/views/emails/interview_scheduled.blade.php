
<!DOCTYPE html>
<html>
<head>
    <title>{{ $isReschedule ? 'Interview Rescheduled' : 'Interview Scheduled' }}</title>
</head>
<body>
    <h3>{{ $isReschedule ? 'Your interview has been rescheduled' : 'Your interview has been scheduled' }}</h3>

    <p>Dear {{ $applicant['name'] }},</p>

    <p>
        We are pleased to inform you that your interview for the position of {{ $interview->job->title }} has been
        {{ $isReschedule ? 'rescheduled' : 'scheduled' }}.
    </p>
    
    <p>Here are the Interview details:</p>
    <ul>
        <li><strong>Interview Date:</strong> {{ $interview->interview_date }}</li>
        <li><strong>Interview Time:</strong> {{ \Carbon\Carbon::parse($interview->interview_time)->format('h:i A') }}</li>
        <li><strong>Interview Title:</strong> {{ $interview->title }}</li>
        <li><strong>Interview Requirements:</strong> {{ $interview->requirements }}</li>
        <li><strong>Interview Location:</strong> {{ $interview->location->name }}</li>
    </ul>

    <p>We look forward to seeing you.</p>

    <p>Best regards,<br>{{ env('VITE_APP_NAME') }}</p>
</body>
</html>
