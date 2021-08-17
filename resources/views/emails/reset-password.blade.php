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
<body>

    <div class="container">
        <p>こちらはPremiumSupportです。</p>
        <p>アカウントのパスワードリセットをリクエストされた場合は以下のボタンをクリックしてください。身に覚えがない場合にはこのメールは無視してください。</p>
        <a href="{{ $link }}" target="_blank">{{ $link }}</a>
        <div class="footer" style="margin-top: 30px;">
            <p>○本メールは送信専用です。本メールに返信された場合でも回答はできません。</p>
            <p>○上記URLの有効期限は24時間です。</p>
            <p>...</p>
        </div>
    </div>

</body>
</html>
