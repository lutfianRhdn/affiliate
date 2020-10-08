<div class="sidebar" data-color="orange" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a href="" class="simple-text logo-normal">
      {{ __('Affiliate') }}
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('admin') }}">
          <i class="material-icons">dashboard</i>
            <p>{{ __('Dashboard') }}</p>
        </a>
      </li>
      <li class="nav-item {{ ($activePage == 'reseller' || $activePage == 'admin') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#adminService" aria-expanded="true">
          <i><span class="material-icons">perm_identity</span></i>
          <p>{{ __('User Management') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse show" id="adminService">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'admin' ? ' active' : '' }}">
              <a class="nav-link" href="{{ url('/admin/user') }}">
                <span class="sidebar-mini"> AD </span>
                <span class="sidebar-normal"> {{ __('Admin') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'reseller' ? ' active' : '' }}">
              <a class="nav-link" href="{{ url('/admin/reseller') }}">
                <span class="sidebar-mini"> RS </span>
                <span class="sidebar-normal">{{ __('Reseller') }} </span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item{{ $activePage == 'product' ? ' active' : '' }}">
        <a class="nav-link" href="{{ url('/admin/product') }}">
          <i class="material-icons">content_paste</i>
            <p>{{ __('Product') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'setting' ? ' active' : '' }}">
        <a class="nav-link" href="/admin/setting">
          <i class="material-icons">settings_applications</i>
            <p>{{ __('Settings') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'log' ? ' active' : '' }}">
        <a class="nav-link" href="/admin/log">
          <i class="material-icons">timeline</i>
            <p>{{ __('Log Activity') }}</p>
        </a>
      </li>
    </ul>
  </div>
</div>
