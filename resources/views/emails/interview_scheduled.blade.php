<!DOCTYPE html>
<html>
<head>
    <title>Interview Scheduled</title>
</head>
<body>
    <h1>Interview Scheduled</h1>
    <p>Dear {{ $interview->applicant->name }},</p>
    <p>We are pleased to inform you that an interview has been scheduled for you.</p>
    <p><strong>Date:</strong> {{ $interview->interview_date }}</p>
    <p><strong>Time:</strong> {{ $interview->interview_time }}</p>
    <p><strong>Title:</strong> {{ $interview->title }}</p>
    <p><strong>Requirements:</strong> {{ $interview->requirements }}</p>
    <p>Location: {{ $interview->location->name }}</p>
    <p>Job Listing: {{ $interview->jobListing->title }}</p>
    <p>We look forward to meeting you.</p>
</body>
</html>
