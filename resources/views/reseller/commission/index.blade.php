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
                            <tr class="text-center text-primary text-bold">
                                <th>#</th>
                                <th>Month</th>
                                <th>Total Client</th>
                                <th>Total Payment</th>
                                <th>Total Commision</th>
                                <th>Percentage</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($commissions as $commission)
                            <tr class="text-center">
                                {{-- {{dd($commission->user)}} --}}
                                <td>{{$loop->index +1}}</td>
                                <td>{{$commission->created_at->format('M-Y')}}</td>
                                @php
                                $clients = $commission->user->clients;
                                $totalClient=[];
                                foreach ($clients as $client) {
                                foreach ($client->transactions as $transaction ) {
                                if (Carbon\Carbon::parse($transaction->payment_date)->format('m-Y') ==
                                $commission->created_at->format('m-Y')) {
                                array_push($totalClient,$transaction);
                                }
                                }
                                }
                                $totalClient = count($totalClient);
                                @endphp
                                <td>{{$totalClient}}</td>
                                <td>{{$commission->total_payment}}</td>
                                <td>{{$commission->total_commission}}</td>
                                <td>{{$commission->percentage}}%</td>
                               
                                <td>
                                    <a rel="tooltip" id="detail-button-{{$commission->id}}" class="btn btn-info btn-fab btn-fab-mini btn-round detail" href=""
                                        data-original-title="" data-placement="bottom" title="detail"
                                        data-month="{{$commission->created_at->format('m')}}"
                                        data-loop="{{$loop->index +1}}"
                                        data-year="{{ $commission->created_at->format('Y') }}" data-toggle="modal"
                                        data-target="#detailModal-{{$commission->id}}">
                                        <i class="material-icons">list</i>
                                        <div class="ripple-container"></div>
                                    </a>
                                    <a rel="tooltip" class="btn btn-primary btn-fab btn-fab-mini btn-round detail"
                                        href="" data-original-title="" data-placement="bottom"
                                        title="show transaction evidence " data-toggle="modal"
                                        data-target="#show-image-Modal-{{$loop->index+1}}">
                                        <i class="material-icons">image</i>
                                        <div class="ripple-container"></div>
                                    </a>
                                </td>
                            </tr>
                            {{-- detail modal --}}
                            <div class="modal fade" id="detailModal-{{$commission->id}}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Detail Modal</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class=" mx-3">

                                            <div class="row ">
                                                <div class="col-6">
                                                    <p>Commission Id : {{$commission->id}}</p>
                                                    <p>Issue date : {{$commission->created_at}}</p>
                                                    <p>Summary </p>
                                                </div>
                                                <div class="col-6">
                                                    <p>From : {{$commission->company->name}}</p>
                                                    <p>Status : {{$commission->status ?'paid':"waiting"}}</p>
                                                </div>
                                            </div>
                                            {{-- head --}}
                                            <div class="mx-auto">

                                                <div class="row text-center align-items-center">
                                                    <div class=" col-1 border py-2 border-dark text-primary ">
                                                        <b>
                                                            <h5 class="my-auto">#</h5>
                                                        </b>
                                                    </div>
                                                    <div class=" col-3 border py-2 border-dark text-primary ">
                                                        <b>
                                                            <h5 class="my-auto">Name</h5>
                                                        </b>
                                                    </div>
                                                    <div class=" col-4 border py-2 border-dark text-primary ">
                                                        <b>
                                                            <h5 class="my-auto">Company</h5>
                                                        </b>
                                                    </div>
                                                    <div class=" col-4 border py-2 border-dark text-primary ">
                                                        <b>
                                                            <h5 class="my-auto">Payment</h5>
                                                        </b>
                                                    </div>

                                                    {{-- content --}}
                                                    <div id="show-detail-{{$loop->index+1}}"></div>

                                                    {{-- end content --}}
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-end flex-column  my-3">
                                                <p>
                                                    Total Payment : {{$commission->total_payment}}
                                                </p>
                                                <p>
                                                    Commission : {{$commission->percentage}}%
                                                </p>
                                                <p>
                                                    Total Commission : {{$commission->total_commission}}
                                                </p>
                                            </div>
                                        </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- upload evidance modal --}}
                            <div class="modal fade" id="show-image-Modal-{{$loop->index +1}}" tabindex="-1"
                                role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog " role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Detail Modal</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body ">
                                            <div class="d-flex justify-content-center p-2 border  bg-light flex-column  text-center ">
                                                @if ($commission->status == true)
                                                <img src="{{ asset('/storage/evidence/'.$commission->photo_path) }}"
                                                    style="max-width: 516px; max-height:400px" class="h-100 " alt="">

                                                @else
                                                    <h3 class="text-primary">Hasn't Been <b> Transferred </b>Yet</h3>
                                                    <p>please, contact admin for transfer your commission</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                        </form>
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
    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = window.location.search.substring(1),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
            }
        }
    }   
   
    $('.table').DataTable()
    $("#preloaders").fadeOut(1000);
 
 md.initDashboardPageCharts();    
    
   
    
    $('.detail').click(function () {
        const month = $(this).data('month')
        const year = $(this).data('year')
        const user_id = '{{auth()->user()->id}}'
        // console.log()
        $.get(`{{url('/')}}/reseller/commision-month?user_id=${user_id}&month=${month}&year=${year}`, (res) => {
            let card = $(`#show-detail-${$(this).data('loop')}`)
            // card.html("");
            console.log('res', res)
            $('.t-column').remove()
            res.map((el, index) => {
                console.log(el.name, el.data)
                let show =
                    `
                    <div class="col-1 py-1  border border-dark t-column border-top-0  ${index+1 !==res.length ?'border-bottom-0':''}" ${index%2 ==0?'style="background:#e9ecef"':''}>
                        <p class="my-auto h-100">${index+1}</p>
                    </div>
                    <div class="col-3 py-1  border border-dark t-column border-top-0  ${index+1 !==res.length ?'border-bottom-0':''}" ${index%2 ==0?'style="background:#e9ecef"':''}>
                        <p class="my-auto h-100">${ el.name.length > 15 ?  el.name.substring(0,15)+'...' :el.name }</p>
                    </div>
                    <div class="col-4 py-1  border border-dark t-column border-top-0  ${index+1 !==res.length ?'border-bottom-0':''}" ${index%2 ==0?'style="background:#e9ecef"':''}>
                        <p class="my-auto h-100">${ el.company.length > 15 ?  el.company.substring(0,15)+'...' :el.company  }</p>
                    </div>
                    <div class="col-4 py-1  border border-dark t-column border-top-0  ${index+1 !==res.length ?'border-bottom-0':''}" ${index%2 ==0?'style="background:#e9ecef"':''}>
                        <p class="my-auto h-100">Rp.${el.transaction}</p>
                    </div>
                `
                card.before(show)
            })
        })
    })
    if (getUrlParameter('id')) {
        $(`#detail-button-${getUrlParameter('id')}`).click(); 
    } 
</script>
@endpush
