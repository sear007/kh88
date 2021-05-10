<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/signin.css') }}">
    <title>KH88 | Login</title>
</head>
<body class="register-page">
    <div class="register-box">
        <div class="register-logo">
          <a href="/">{!! logo() !!}</a>
        </div>
        <div class="card">
          <div class="card-body register-card-body">
            <p class="login-box-msg">Change New Password  </p>
      
            <form action="" method="POST">
                @csrf
                <div class="mb-3">
                    <div class="input-group">
                      <input type="password" name="password" class="form-control" placeholder="Your New Password">
                      <div class="input-group-text">
                      <span class="fas fa-lock"></span>
                      </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="input-group">
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Password Confirmation">
                        <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                        </div>
                      </div>
                </div>
                @error('password')
                    <div class="mb-3">
                        <span class="text-danger">{{ $message }}</span>
                    </div>
                @enderror
                <div class="row">
                  <div class="col-4">
                    <button type="submit" id="btn-login" class="btn btn-primary btn-block">Submit</button>
                  </div>
                </div>
            </form>
          </div>
        </div>
      </div>
</body>
</html>