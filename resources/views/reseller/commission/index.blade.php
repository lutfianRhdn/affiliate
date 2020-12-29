@extends('layouts.app', ['activePage' => 'commission', 'titlePage' => __('Commission')])

@section('content')
<div id="preloaders" class="preloader"></div>
<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title">Commision</h4>
                <p class="category">Commision</p>
            </div>
            <div class="card-body">
                <div class="table-responsive">

                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>month</th>
                            <th>total Client</th>
                            <th>total Commision</th>
                            <th>action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($commissions as $commission)
                        <tr>
                                
                            <td>{{$loop->index +1}}</td>
                            <td>{{$commission->created_at->format('M-Y')}}</td>
                            <td>10</td>
                            <td>{{$commission->payment}}</td>
                            <td> 
                                <a rel="tooltip" class="btn btn-primary btn-fab btn-fab-mini btn-round detail" href=""
                                data-original-title="" data-placement="bottom" title="detail" 
                                data-month="{{$commission->created_at->format('m')}}" data-loop="{{$loop->index +1}}"
                                data-year="{{ $commission->created_at->format('Y') }}"
                                data-toggle="modal"  data-target="#detailModal-{{$loop->index+1}}">
                                <i class="material-icons">list</i>
                                <div class="ripple-container"></div>
                            </a>
                              
                           
                            
                        </td>
                        </tr>

                        <div class="modal fade" id="detailModal-{{$loop->index +1}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Detail Modal</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-4">
                                        <h5>Transfer Evidence </h5>
                                       
                                        <div class="d-flex justify-content-center border border-dark">
                                          @if ($commission->status == true)
                                          <img src="{{asset('storage/evidence/'.$commission->photo_path)}}" style="max-height: 300px;max-width:400px" alt="">
                                              
                                          @else
                                          <div class="text-center">

                                            <h3 class="text-primary text-capitalize"> hasn't been transferred yet</h3>
                                            <p>please, contact admin for transfer your commission</p>
                                          </div>
                                          @endif
                                        </div>
                                      </div>
                                      <h5>Client Payed</h5>
                                    <div id="show-detail-{{$loop->index+1}}">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                  <button type="button" class="btn btn-primary">Save changes</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        @endforeach

                    </tbody>
                </table>
            </div>

            </div>
        </div>
    </div>
</div>

@endsection
@push('js')
<script>
          $('table').DataTable()
          $("#preloaders").fadeOut(1000);
        md.initDashboardPageCharts();
        $('.detail').click(function(){
            const month = $(this).data('month')
            const year = $(this).data('year')
            const user_id = '{{auth()->user()->id}}'
            // console.log()
            $.get(`{{url('/')}}/reseller/commision-month?user_id=${user_id}&month=${month}&year=${year}`, (res)=> {
                let card = $(`#show-detail-${$(this).data('loop')}`)
                card.html("");

                res.map((el)=>{
                    console.log(el.name,el.data)
                let show =
                `
                <div class="row text-center">
                    <div class="col-6">
                        <p>${el.name}</p>
                    </div>
                    <div class="col-6">                    
                        ${el.data.map(e=>{
                            return e.total_payment
                        })}
                    </div>
                </div>
                `
                card.append(show)
                })
            })
        })
</script>
@endpush