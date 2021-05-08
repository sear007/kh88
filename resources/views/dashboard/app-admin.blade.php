<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf_token" content="{{ csrf_token() }}">
  <title>KH88 | Admin Cpanel</title>
  <link rel="stylesheet" href="{{ asset('admin/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/plugins/sweetalert2/sweetalert2.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/css/custom.css') }}">
  @stack('css')
</head>
<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse">
<div class="wrapper">
@include('dashboard.admin.inc.navbar')
@include('dashboard.admin.inc.sidebar')
<div class="content-wrapper">
  <section class="content">
    <div class="container-fluid py-5">
        @yield('content')
    </div>
  </section>
</div>
@include('dashboard.admin.inc.footer')
<aside class="control-sidebar control-sidebar-dark"></aside>
</div>
<script src="{{ asset('/admin/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('/admin/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('/admin/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('/admin/js/adminlte.js') }}"></script>
<script src="{{ asset('js/global.js') }}"></script>
<script>
  $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>
@stack('scripts')
</body>
</html>
