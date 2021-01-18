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
            <div class="mx-3">

            <div class="card-header card-header-primary border border-light">
                <h4>Summary</h4>
                <div class="row text-center">
                    <div class="col-4">
                        <h6>Life Time Commission</h6>
                        <p>Rp.{{number_format($totalCommission,2)}}</p>
                    </div>
                    <div class="col-4">
                        <h6>Remaining</h6>
                        <p>Rp.{{number_format($remainingCommission,2)}}</p>
                    </div>
                    <div class="col-4">
                        <h6>Transferred</h6>
                        <p>Rp.{{number_format($transferedCommission,2)}}</p>
                    </div>
                </div>
            </div>
        </div>

            <div class="card-body">
                
                <div class="table-responsive">

                    <table class="table data-table">
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
                                <td>{{$commission->created_at->format('F Y')}}</td>
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
                                <td>Rp {{number_format($commission->total_payment,2)}}</td>
                                <td>Rp {{number_format($commission->total_commission,2)}}</td>
                                <td>{{$commission->percentage}}%</td>

                                <td class="d-flex">
                                    <p rel="tooltip" id="detail-button-{{$commission->id}}"
                                        class="btn btn-info btn-fab btn-fab-mini btn-round detail" href=""
                                        data-original-title="" data-placement="bottom" title="detail"
                                        data-month="{{$commission->created_at->format('m')}}"
                                        data-loop="{{$loop->index +1}}"
                                        data-year="{{ $commission->created_at->format('Y') }}"

                                        data-commission-id="{{$commission->id}}"
                                        data-total-payment="{{number_format($commission->total_payment,2)}}"
                                        data-total-commission="{{number_format($commission->total_commission,2)}}"
                                        data-percentage="{{$commission->percentage}}"
                                        data-issue-date="{{$commission->created_at->format('d-F-Y')}}"
                                        data-issue-date-id="{{$commission->created_at->format('d F')}}"
                                        data-status="{{$commission->status == true ?'paid':'waiting'}}"
                                        data-from-company="{{$commission->company->name}}"
                                        data-from-admin="{{$commission->company->users()->whereHas('roles',function($q){$q->where('name','super-admin-company');})->get()->first()->name}}"
                                        data-for="{{$commission->user->name}}">
                                        <i class="material-icons">list</i>
                                        <div class="ripple-container"></div>
                                    </p>
                                    <a rel="tooltip" class="btn btn-primary btn-fab btn-fab-mini btn-round" href=""
                                        data-original-title="" data-placement="bottom"
                                        title="show transaction evidence " data-toggle="modal"
                                        data-target="#show-image-Modal-{{$loop->index+1}}">
                                        <i class="material-icons">image</i>
                                        <div class="ripple-container"></div>
                                    </a>
                                </td>
                            </tr>

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
                                            <div
                                                class="d-flex justify-content-center p-2 border  bg-light flex-column  text-center ">
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
{{-- detail modal --}}
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class=" mx-3">
                    <small>
                        <div class="row justify-content-between">
                            <div class="col-5 row">
                                <div class="col-12">
                                    <h2> <b> INVOICE </b></h2>

                                </div>
                                <div class="col-6 d-flex">
                                    Commission Id
                                </div>
                                <div class="col-6 d-flex border-left border-dark">
                                    <span id="commission-id-detail"></span>
                                </div>
                                <div class="col-6 d-flex">
                                    Issue date
                                </div>
                                <div class="col-6 d-flex border-left border-dark">
                                    <span id="issue-date-detail"></span>
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="row">
                                    <div class="col-6 d-flex justify-content-end">From</div>
                                    <div class="col-6 border-left border-dark py-2">
                                        <p class="h6">
                                            <b>
                                                <span id="from-company-detail"></span>
                                            </b>
                                        </p>
                                        <span id="from-admin-detail"></span>
                                    </div>

                                    <div class="col-6 d-flex justify-content-end mt-2">For</div>
                                    <div class="col-6 border-left border-dark mt-2"><span id="for-detail"></span></div>
                                </div>
                            </div>
                        </div>
                    </small>

                    {{-- head --}}
                    <table class="table table-striped table-bordered mt-3">
                        <thead class="text-bold text-primary">
                            <tr>
                                <th>#</th>
                                <th class="w-50">Name</th>
                                <th>Company</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody id="show-detail">

                        </tbody>
                    </table>
                    <div class="col-4 d-flex ml-auto flex-column  my-3 ">
                        <small>

                            <div class="row justify-content-end text-right">
                                <div class="col-7  ">
                                    Total Payment
                                </div>
                                <div class="col-5">
                                    Rp <span id="total-payment-detail"></span>
                                </div>
                                <div class="col-7  ">
                                    Commission
                                </div>
                                <div class="col-5">
                                    <span id="percentage-detail"></span> %
                                </div>
                                <div class="col-7  ">
                                    Total Commission
                                </div>
                                <div class="col-5">
                                    Rp <span id="total-commission-detail"></span>
                                </div>
                            </div>
                        </small>
                    </div>
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

    $('.data-table').DataTable()
    $("#preloaders").fadeOut(1000);

    md.initDashboardPageCharts();



    $('.detail').click(function () {
        const month = $(this).data('month')
        const year = $(this).data('year')
        const user_id = '{{auth()->user()->id}}'
        $.get(`{{url('/')}}/reseller/commision-month?user_id=${user_id}&month=${month}&year=${year}`, (res) => {
            let card = $(`#show-detail`)
            card.html("");
            $('.t-column').remove()
            res.map((el, index) => {
                let show =
                    `
                    <tr>
                        <td>${index+1}</td>
                        <td>${el.name }</td>
                        <td class="w-100"> ${ el.company.length > 15 ?  el.company.substring(0,15)+'...' :el.company  }</td>
                        <td> <b>Rp.${parseInt(el.transaction).toFixed(3)}</b></td>
                    </tr>
                `
                card.append(show)
            })
        })
        $('#detailModal').modal('show')
        $('#commission-id-detail').html($(this).data('issue-date-id') +' - '+$(this).data('commission-id'))
        $('#issue-date-detail').html($(this).data('issue-date'))
        $('#from-company-detail').html($(this).data('from-company'))
        $('#from-admin-detail').html($(this).data('from-admin'))
        $('#total-commission-detail').html($(this).data('total-commission'))
        $('#total-payment-detail').html($(this).data('total-payment'))
        $('#percentage-detail').html($(this).data('percentage'))
        $('#status-detail').html($(this).data('status'))
        $('#for-detail').html($(this).data('for'))
    })
    if (getUrlParameter('id')) {
        $(`#detail-button-${getUrlParameter('id')}`).click();
    }

</script>
@endpush
