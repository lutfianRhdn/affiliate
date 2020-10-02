<div class="wrapper ">
  @include('users.layouts.sidenav')
  <div class="main-panel">
    @include('users.layouts.navs.auth')
    @yield('content')
    @include('layouts.footers.auth')
  </div>
</div>