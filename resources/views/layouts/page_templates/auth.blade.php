<div class="wrapper ">
    @include('layouts.navbars.sidebar')
    <div class="main-panel">
      @if (Cookie::get('user'))
          
      <form action="{{ route('account.switch') }}" method="post" class="position-absolute ml-4 mt-2" style="z-index: 9999999999999999999;">
        @csrf
        <input type="hidden" name="user_id" value="2">
        <button type="submit" class=" btn btn-warning">Back to Super Admin</button>
      </form>
      @endif
        @include('layouts.navbars.navs.auth')
        @yield('content')
        @include('layouts.footers.auth')
    </div>
</div>
