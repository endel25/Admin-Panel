<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Your Secure Authentication Code</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 30px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #2c3e50;
            margin-top: 0;
        }
        p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .code {
            font-size: 24px;
            font-weight: bold;
            color: #fff;
            background-color: #3498db;
            padding: 12px 20px;
            border-radius: 6px;
            display: inline-block;
            margin-bottom: 20px;
        }
        .expiry {
            font-size: 14px;
            color: #777;
        }
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            font-size: 12px;
            color: #888;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Secure Authentication</h1>
        <p>Hello,</p>
        <p>To complete your login, please use the following authentication code:</p>
        <div class="code">{{ $code }}</div>
        <p class="expiry">This code will expire in 10 minutes.</p>
        <p>If you did not request this code, please ignore this email.</p>
        <div class="footer">
            <p>This is an automated message. Please do not reply.</p>
        </div>
    </div>
</body>
</html>
