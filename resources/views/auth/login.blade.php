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
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <title>KH88 | Login</title>
</head>
<body class="register-page">
    <div class="register-box">
        <div class="register-logo">
          <a href="/">{!! logo() !!}</a>
        </div>
        <div class="card">
          <div class="card-body register-card-body">
            <p class="login-box-msg">Welcome back</p>
      
              <div class="mb-3">
                  <div class="input-group">
                    <input type="text" id="username" name="username" class="form-control" placeholder="Username">
                    <div class="input-group-text">
                    <span class="fas fa-user"></span>
                    </div>
                  </div>
              </div>
              
              <div class="mb-3">
                  <div class="input-group">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                      </div>
                  </div>
              </div>
              <div class="row mb-3">
                <div class="col-8">
                  <div class="icheck-primary">
                    <input  type="checkbox" id="remember" name="remember">
                    <label for="remember">
                     Remember me
                    </label>
                  </div>
                </div>
                <div class="col-4">
                  <button type="submit" id="btn-login" class="btn btn-primary btn-block">LOGIN</button>
                </div>
              </div>
            <a href="/register" class="btn btn-sm btn-dark">Signup now ?</a>
            <a href="/forgot-password" class="btn btn-sm btn-dark">Forgot password ?</a>
          </div>
        </div>
      </div>

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('js/login.js') }}"></script>
<script>
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
</script>
</body>
</html>