<!DOCTYPE html>
<html>
    <head>
        <title>Registration Confirmation</title>
    </head>
    <body>
        <h2>Welcome, {{ $userData['username'] }}!</h2>
        <p>Thank you for registering on our website. Please verify your email address by clicking the following link:</p>
        <a href="{{ $userData['verificationLink'] }}">Verify Email Address</a>
    </body>
</html>
