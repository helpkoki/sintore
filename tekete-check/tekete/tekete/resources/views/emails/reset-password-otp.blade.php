<!DOCTYPE html>
<html>
<head>
    <title>Reset Password OTP</title>
</head>
<body>
    <h2>Reset Your Password</h2>
    <p>You are receiving this email because we received a password reset request for your <b>{{ ucfirst($type) }}</b> account.</p>
    <p>Your OTP for password reset is: <strong>{{ $otp }}</strong></p>
    <p>This OTP will expire in 5 minutes.</p>
    <p>If you did not request a password reset, no further action is required.</p>
    <p>Thank you,<br>Tekete Management System</p>
</body>
</html>