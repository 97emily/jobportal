<!DOCTYPE html>
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
</html>
