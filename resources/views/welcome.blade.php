<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f5f5f5; text-align: center; padding: 100px;">

    <div
        style="background-color: #fff; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); max-width: 400px; margin: 0 auto; padding: 20px; border-radius: 8px;">
        <div style="margin-bottom: 20px;">
            <a href="{{ route('login') }}" style="text-decoration: none; color: #007bff; font-size: 18px;">Login</a>
        </div>
        <div style="font-size: 16px; color: #333;">atau</div>
        <div style="margin-top: 20px;">
            <a href="{{ route('register') }}"
                style="text-decoration: none; color: #007bff; font-size: 18px;">Register</a>
        </div>
    </div>

</body>

</html>