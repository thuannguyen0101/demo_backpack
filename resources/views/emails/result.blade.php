<!DOCTYPE html>
<html lang="en">
    <head>
        <title>PremiumSupport</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    </head>
    <style>
        .form-title {
            margin-top: 50px;
            margin-bottom: 50px;
            text-align: center;
            font-size: 18px;
            color: #000000;
            text-shadow: #f7f7f7 0 1px 0;
        }

        .form-title h2 {
            text-shadow: #f7f7f7 0 1px 0;
            font-size: 18px;
            margin: 0 0 20px 0;
            font-weight: bold;
            text-align: center;
        }
    </style>
<body>

    <div class="container">
        <h1 id="logo"><img src="{{ asset('assets/images/logo.png') }}" alt="PUREMIUM SUPPORT" width="100%"></h1>
        <div class="form-title" style="text-align: center;">
            <h2>{{$message}}</h2>
        </div>
    </div>

</body>
</html>
