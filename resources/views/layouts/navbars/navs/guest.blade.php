<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top text-white">
  <div class="container">
    <div class="navbar-wrapper">
      <a class="navbar-brand" href="{{ url('/') }}">{{ $title ?? '' }}</a>
    </div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
      <span class="sr-only">Toggle navigation</span>
      <span class="navbar-toggler-icon icon-bar"></span>
      <span class="navbar-toggler-icon icon-bar"></span>
      <span class="navbar-toggler-icon icon-bar"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end">
      <ul class="navbar-nav">
    @auth
        <li class="nav-item{{ $activePage == 'logout' ? ' active' : '' }}">
          <a class="nav-link" href="{{ url('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
            <i class="material-icons">fingerprint</i> {{ __('Logout') }}
          </a>
        </li>
        <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
          <a class="nav-link" href="{{ auth()->user()->role == 1 ? route('admin') : route('reseller')}}">
            <i class="material-icons">book</i> {{ __('Dashboard') }}
          </a>
        </li>
    @endauth
    @guest
    <li class="nav-item{{ $activePage == 'login' ? ' active' : '' }}">
      <a href="{{ route('login') }}" class="nav-link">
        <i class="material-icons">fingerprint</i> {{ __('Login') }}
      </a>
    </li>
    <li class="nav-item{{ $activePage == 'register' ? ' active' : '' }}">
      <a href="{{ route('register') }}" class="nav-link">
        <i class="material-icons">person_add</i> {{ __('register') }}
      </a>
    </li>
    @endguest
      </ul>
    </div>
  </div>
</nav>
<!-- End Navbar -->