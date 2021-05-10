<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/offcanvas.css') }}">
    <link rel="stylesheet" href="{{ asset('css/loading.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    @stack('styles')
    <title>
      @yield('title')
    </title>
  </head>
  <body>
    <header>
      @include('inc.navigation')
      @include('inc.secondary-navigation')
    </header>
    <main id="app">
      @yield('content')
    </main>
      @include('inc.footer')
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}" ></script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('js/global.js') }}"></script>
    <script src="{{ asset('js/offcanvas.js') }}"></script>
    <script src="{{ asset('js/live-time.js') }}"></script>
    <script src="{{ asset('js/countUp.js') }}"></script>
    <script>
      var navbar_height = document.getElementById('navigation').offsetHeight;
      document.body.style.paddingTop = `${navbar_height}px`;
      var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });
    </script>
    @stack('scripts')
  </body>
</html>