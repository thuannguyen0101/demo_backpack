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

        .form-control {
            padding-left: 10px;
            display: block;
            border: 1px solid #c9b7a2;
            background: #ffffff;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
            color: #000000;
            -webkit-box-shadow: rgba(255,255,255,0.4) 0 1px 0, inset rgba(000,000,000,0.7) 0 0px 0px;
            -moz-box-shadow: rgba(255,255,255,0.4) 0 1px 0, inset rgba(000,000,000,0.7) 0 0px 0px;
            box-shadow: rgba(255,255,255,0.4) 0 1px 0, inset rgba(000,000,000,0.7) 0 0px 0px;
            padding: 8px 0;
            margin: 16px auto;
            width: 100%;
        }

        .btn-sm {
            text-align: center;
        }
        .submit-button, .submit-button:hover {
            display: inline-block;
            width: 80%;
            background: #c29a5d;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
            color: #fff;
            font-family: "ãƒ’ãƒ©ã‚®ãƒŽè§’ã‚´ W6" helvetica, serif;
            padding: 8px 0;
            font-size: 15px;
            text-decoration: none;
            vertical-align: middle;
        }

        .invalid-feedback {
            color: red;
        }

        .is-invalid {
            border: 1px solid red;
        }
    </style>
<body>

    <div class="container">
        <h1 id="logo"><img src="{{ asset('assets/images/logo.png') }}" alt="PUREMIUM SUPPORT" width="100%"></h1>
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <div class="form-title" style="text-align: center;">
                <h2>新しいパスワードの入力</h2>
            </div>
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group row">
                <label for="password" class="col-md-12 col-form-label text-md-right">新しいパスワード</label>

                <div class="col-md-12">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label for="password-confirm" class="col-md-12 col-form-label text-md-right">新しいパスワード(確認用)</label>

                <div class="col-md-12">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-12 offset-md-4 btn-sm">
                    <button type="submit" class="btn submit-button">
                        パスワードを変更する
                    </button>
                </div>
            </div>
        </form>
    </div>

</body>
</html>
