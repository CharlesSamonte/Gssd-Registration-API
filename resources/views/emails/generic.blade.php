<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px 0;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #ddd;
            width: 100%;
        }

        .logo img {
            max-width: 150px;
        }

        .header {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #444;
        }

        .content {
            font-size: 16px;
            line-height: 1.6;
        }

        .footer {
            text-align: center;
            font-size: 14px;
            color: #777;
            margin-top: 20px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        .contact-list {
            text-align: center;
            font-size: 14px;
            color: #555;
            margin-top: 20px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        .contact-list p {
            margin: 5px 0;
        }

        .contact-list a {
            color: #007BFF;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="logo">
            <img src="https://www.gssd.ca/uploads/gssdlogo1.png" alt="GSSD Logo">
        </div>

        <div class="header">
            {{ config('app.name') }}
        </div>

        <div class="content">
            <p>{!! $body  !!}</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>

</html>