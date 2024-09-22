<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #c1baf7; 
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }

        .content {
            padding: 20px;
        }

        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #888;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>@yield('title')</h1>
        </div>
        <div class="content">
            @yield('content')
        </div>
        <div class="footer">
            You're receiving this email because you have a Phplanner account.
        </div>
    </div>
</body>
</html>
