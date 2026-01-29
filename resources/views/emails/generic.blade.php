<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .email-wrapper {
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background-color: #007bff;
            color: #ffffff;
            padding: 30px 20px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .email-body {
            padding: 30px 20px;
        }
        .email-content {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 4px;
            padding: 20px;
            margin: 20px 0;
        }
        .email-content p {
            margin: 0;
            white-space: pre-wrap;
        }
        .email-footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #6c757d;
        }
        .button {
            display: inline-block;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 4px;
            margin: 20px 0;
        }
        .button:hover {
            background-color: #0056b3;
        }
        @media only screen and (max-width: 600px) {
            .container {
                padding: 10px;
            }
            .email-header, .email-body, .email-footer {
                padding: 20px 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="email-wrapper">
            <div class="email-header">
                <h1>{{ config('app.name', 'Transport Management System') }}</h1>
            </div>
            <div class="email-body">
                <p>Dear Recipient,</p>
                
                <div class="email-content">
                    {!! $body !!}
                </div>
                
                <p>If you have any questions, please don't hesitate to contact us.</p>
                
                <center>
                    <a href="{{ route('home') }}" class="button">Visit Dashboard</a>
                </center>
            </div>
            <div class="email-footer">
                <p>This is an automated message from {{ config('app.name', 'Transport Management System') }}.</p>
                <p>&copy; {{ date('Y') }} {{ config('app.name', 'Transport Management System') }}. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>
