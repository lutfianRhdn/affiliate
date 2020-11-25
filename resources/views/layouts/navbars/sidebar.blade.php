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
        <a class="nav-link" href="{{ route($routeDashboard) }}">
          <i class="material-icons">dashboard</i>
          <p>{{ __('Dashboard') }}</p>
        </a>
      </li>
      {{-- {{dd(auth()->user()->role())}} --}}
      
      @can('user.view')

      <li class="nav-item {{ ($activePage == 'reseller' || $activePage == 'admin') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#adminService" aria-expanded="true">
          <i><span class="material-icons">perm_identity</span></i>
          <p>{{ __('User Management') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse {{ ($activePage == 'reseller' || $activePage == 'admin' || $activePage=='company') ? ' show' : '' }}" id="adminService">
          <ul class="nav">
            @if(auth()->user()->hasRole(['super-admin']) ||auth()->user()->can('company.view'))
            <li class="nav-item{{ $activePage == 'company' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('admin.company.index') }}">
                <span class="sidebar-mini"> CP </span>
                <span class="sidebar-normal"> {{ __('Company') }} </span>
              </a>
            </li>
            @endif
            @if(auth()->user()->hasRole(['super-admin','admin-company']))
            <li class="nav-item{{ $activePage == 'admin' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('admin.user.index') }}">
                <span class="sidebar-mini"> AD </span>
                <span class="sidebar-normal"> {{ __('Admin') }} </span>
              </a>
            </li>
            @endif
            @can('user.view')
            <li class="nav-item{{ $activePage == 'reseller' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('admin.reseller.index') }}">
                <span class="sidebar-mini"> RS </span>
                <span class="sidebar-normal">{{ __('Reseller') }} </span>
              </a>
            </li>
            @endcan
          </ul>
        </div>
      </li>
      @endcan
      @can('role.view')

      <li class="nav-item{{ $activePage == 'role' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('admin.role.index') }}">
          <i class="material-icons">admin_panel_settings</i>
            <p>{{ __('Role Management') }}</p>
        </a>
      </li>
      @endcan
      @can('product.view')
      <li class="nav-item{{ $activePage == 'product' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('admin.product.index') }}">
          <i class="material-icons">content_paste</i>
            <p>{{ __('Product') }}</p>
        </a>
      </li>
      @endcan
     @if(auth()->user()->hasRole(['super-admin','admin-company']))

      <li class="nav-item{{ $activePage == 'setting' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('admin.setting.index')}}">
          <i class="material-icons">settings_applications</i>
            <p>{{ __('Settings') }}</p>
        </a>
      </li> 
      @endif
     @if(auth()->user()->hasRole(['super-admin','admin-company']))

      <li class="nav-item{{ $activePage == 'log' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('admin.log.index')}}">
          <i class="material-icons">timeline</i>
            <p>{{ __('Log Activity') }}</p>
        </a>
      </li>
      @endif
    </ul>
  </div>
</div>
