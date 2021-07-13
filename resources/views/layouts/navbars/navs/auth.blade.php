<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
  <div class="container-fluid">
    <div class="navbar-wrapper">
      <a class="navbar-brand" href="#">{{ $titlePage ?? '' }}</a>
    </div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
    <span class="sr-only">Toggle navigation</span>
    <span class="navbar-toggler-icon icon-bar"></span>
    <span class="navbar-toggler-icon icon-bar"></span>
    <span class="navbar-toggler-icon icon-bar"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end">
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="material-icons">notifications</i>
            @if (auth()->user()->unreadNotifications->count() >0)
            <span class="notification" id="countNotification">{{auth()->user()->unreadNotifications->count()}}</span>
            @endif
            <p class="d-lg-none d-md-block">
              {{ __('Some Actions') }}
            </p>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
            @forelse  (auth()->user()->unreadNotifications as $notification)
            @if ($loop->count >1)
              <div class="dropdown-divider"></div>
            @endif
            @if (auth()->user()->hasRole('reseller'))
              @if (array_key_exists('transfered_by',$notification->data))
              <a href="#" class="dropdown-item d-flex justify-content-arround mark-as-read "  data-id="{{$notification->id}}"  data-commission="{{$notification->data['commission_id']}}">
                Your Commission in {{ $notification->data['month'] }} has been transfered by &nbsp; <b> {{ $notification->data['transfered_by'] }}  </b>
              </a>
              @else
              <a href="#" class="dropdown-item d-flex justify-content-arround mark-as-read "  data-id="{{$notification->id}}"  data-commission="{{$notification->data['commission_id']}}">
                You have received a &nbsp; <b>Commission </b>&nbsp; in {{ $notification->data['month'] }} for &nbsp; <b> Rp {{ number_format($notification->data['commission'],2) }} </b>
              </a>

              @endif
            @else
            <a href="#" class="dropdown-item d-flex justify-content-arround mark-as-read "  data-id="{{$notification->id}}"  data-commission="{{$notification->data['commission_id']}}">
              You have a commission that&nbsp; <b> must be paid </b>&nbsp; to <b>&nbsp; {{$notification->data['reseller_name']}} </b>&nbsp; for Rp {{ number_format($notification->data['commission'],2)}}
            </a>
            @endif
         
             
              @empty
              <p class="dropdown-item">you dont have any notifications</p>
            @endforelse 
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link" href="#pablo" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="material-icons">person</i>
            <p class="d-lg-none d-md-block">
              {{ __('Account') }}
            </p>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
            <a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('Profile') }}</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ url('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('Log out') }}</a>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>
@push('js')
    <script>
      const markRead =(id =null)=>{
        return $.ajax(`{{ route('notification.read') }}`,{
          method:'post',
          data  :{
            _method:'post',
            id
          }
        })
      }
      $(function () {
        $('.mark-as-read').click(function () {
          let request = markRead($(this).data('id'))
          request.done(()=>{
            $(this).parents('p.dropdown-item').remove()
            let count = $('#countNotification').val()
            // $('#countNotification').text(count - 1)
            if (`{{auth()->user()->hasRole('reseller')}}`) {
            window.location.replace(`{{route('reseller.commission.index')}}?id=${$(this).data('commission')}`)
              
            }else{
            window.location.replace(`{{route('admin.commissions.index')}}?id=${$(this).data('commission')}`)
            }
          })
        })
      })
    </script>
@endpush