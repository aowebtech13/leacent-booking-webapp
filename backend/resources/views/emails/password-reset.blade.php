<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password</title>
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            background-color: #f6f7fb;
            margin: 0;pa.
            padding: 20px;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }
        .header {
            background-color: #7366ff;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #7366ff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 4px;
            margin: 10px 0;
        }
        .otp-code {
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 8px;
            color: #7366ff;
            text-align: center;
            padding: 20px;
            margin: 20px 0;
            background-color: #f6f7fb;
            border-radius: 8px;
        }
        p {
            line-height: 1.6;
            margin: 0 0 15px;
        }
        .footer {
            padding: 20px 30px;
            text-align: center;
            color: #999;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Reset Your Password</h1>
        </div>
        <div class="content">
            <p>Hi {{ $user->name ?? 'there' }},</p>
            <p>You are receiving this email because we received a password reset request for your account.</p>
            <div class="otp-code">{{ $otpCode }}</div>
            <p>Use this verification code to reset your password. This code will expire in 10 minutes. If you did not request a password reset, no further action is required.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
