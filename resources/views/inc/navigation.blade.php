<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-grey navigation" id="navigation" aria-label="Main navigation">
  <div class="container">
    <a class="navbar-brand" href="/">{!! logo() !!}</a>
    <button class="navbar-toggler p-0 border-0" type="button" data-bs-toggle="offcanvas">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-collapse offcanvas-collapse" >
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link {{ request()->is('/') ? 'active':'' }}" aria-current="page" href="/">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('games') ? 'active':'' }}" aria-current="page" href="/games">Casino</a>
        </li>
      </ul>
      <div class="ms-auto mb-2 mb-lg-0">
        
        @auth
            @include('inc.navbar-top-right-widget.auth')
        @endauth
        @guest
          @include('inc.navbar-top-right-widget.guest')
        @endguest
        
      </div>
    </div>
  </div>
</nav>
@push('scripts')
<script src="{{ asset('js/login.js') }}"></script>
@endpush