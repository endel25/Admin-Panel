<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Password Reset OTP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #0056b3;
            border-bottom: 2px solid #0056b3;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        p {
            margin-bottom: 15px;
        }
        .otp {
            font-size: 24px;
            font-weight: bold;
            color: #0056b3;
            background-color: #e6f7ff;
            padding: 5px 10px;
            border-radius: 5px;
            display: inline-block;
        }
        .expiration {
            font-size: 12px;
            color: #888;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            color: #777;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Password Reset OTP</h1>
        <p>Dear User,</p>
        <p>You have requested to reset your password. Please use the following One-Time Password (OTP) to complete the process:</p>
        <p class="otp">{{ $otp }}</p>
        <p class="expiration">This OTP is valid for the next 10 minutes. After this time, you will need to request a new OTP.</p>
        <p>If you did not request this password reset, please ignore this email or contact our support team immediately.</p>
        <p>Thank you,</p>
        <p>The {{ config('app.name') }} Team</p>

        <div class="footer">
            <p>This is an automated email, please do not reply.</p>
        </div>
    </div>
</body>
</html>
