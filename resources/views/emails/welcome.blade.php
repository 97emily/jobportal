
<!DOCTYPE html>
<html>
<head>
    <title>WE'VE CREATED AN ACCOUNT FOR YOU!</title>
</head>

<body>
    <h4>Welcome, {{ $details['name'] }}!</h4>
    <p>You have been registered to our admin portal. We're excited to have you on board.</p>
    <p> Please click on the 'Get Started' button and use the following credentials to login to your account. Thereafter visit your profile and
        update your password.</p>
    <p>
     <br>
    <strong>Username:</strong> {{ $details['email'] }}
        <br>
        <strong>password:</strong> {{ $details['password'] }}
    </p>

    <a href="{{ $details['login_url'] }}"
        style="
display: inline-block;
padding: 10px 20px;
font-size: 16px;
color: #fff;
background-color: #00AAD0;
text-decoration: none;
border-radius: 20px;
">
        Get Started
    </a>

    <p style="margin-top: 2rem; color: #4b5563; ">
        Thank you, <br />
        {{ env('MAIL_FROM_ADDRESS') }}
    </p>
    {{-- <p>Best regards,<br>Company Name</p> --}}
</body>
</html>
