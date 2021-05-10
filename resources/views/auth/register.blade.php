<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/signin.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <title>KH88 | Register</title>
</head>
<body class="register-page">
    <div class="register-box">
        <div class="register-logo">
          <a href="/">{!! logo() !!}</a>
        </div>
        <div class="card">
          <div class="card-body register-card-body">
            <p class="login-box-msg">Register a new membership</p>
            <form action="/register" method="post">
               @csrf
              <div class="mb-3">
                  <div class="input-group">
                    <input type="email" value="{{ old('email') }}" name="email" class="form-control" placeholder="Email">
                    <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                    </div>
                  </div>
                  @error('email')
                    <span class="text-danger small"><i class="fas fa-info-circle me-2 text-muted"></i>{{ $message }}</span>
                  @enderror
              </div>
              <div class="mb-3">
                  <div class="input-group">
                    <input type="text" value="{{ old('username') }}" name="username" class="form-control" placeholder="Username">
                    <div class="input-group-text">
                    <span class="fas fa-user"></span>
                    </div>
                  </div>
                    @error('username')
                        <span class="text-danger small"><i class="fas fa-info-circle me-2 text-muted"></i>{{ $message }}</span>
                    @enderror
              </div>
              
              <div class="mb-3">
                  <div class="input-group">
                    <input type="password" name="password" class="form-control" placeholder="Password">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                      </div>
                  </div>
                  @error('password')
                    <span class="text-danger small"><i class="fas fa-info-circle me-2 text-muted"></i>{{ $message }}</span>
                  @enderror
              </div>
              <div class="mb-3">
                  <div class="input-group">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Retype password">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                      </div>
                  </div>
              </div>
              <div class="row mb-3">
                <div class="col-8">
                  <div class="icheck-primary">
                    <input  @if (old('terms')) checked @endif type="checkbox" id="agreeTerms" name="terms" value="agree">
                    <label for="agreeTerms">
                     I agree to the <a href="#">terms</a>
                    </label>
                  </div>
                  @error('terms')
                    <span class="text-danger small"><i class="fas fa-info-circle me-2 text-muted"></i>{{ $message }}</span>
                  @enderror
                </div>
                <div class="col-4">
                  <button type="submit" class="btn btn-primary btn-block">Register</button>
                </div>
              </div>
            </form>
            <a href="/login" class="btn btn-dark btn-sm">I already have a membership</a>
          </div>
        </div>
      </div>

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/login.js') }}"></script>
</body>
</html>