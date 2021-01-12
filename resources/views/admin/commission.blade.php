@extends('layouts.app', ['activePage' => 'commission', 'titlePage' => __('Commission')])

@section('content')
<style>
    h2.status {
        border-width: .4rem !important;
    }

    .rotate-status {
        -webkit-transform: rotate(-15deg);
    }

</style>
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
                        <p id="total-commission">Rp.{{$totalCommission}}</p>
                        <div>
                            <select name="filterByReseller" id="filterByReseller" class="select2 filter-data w-75">
                                <option value="" selected disabled>Select Reseller</option>
                                @foreach ($resellers as $reseller)
                                <option value="{{$reseller->name}}">{{$reseller->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <h6>Remaining</h6>
                        <p id="remaining-commission">Rp.{{$remainingCommission}}</p>
                        <div>
                            <select name="filterByMonth" id="filterByMonth" class="select2 filter-data w-75">
                                <option value="" selected disabled>Select Month</option>
                                @foreach ($months as $month)
                                <option value="{{$month}}">{{$month}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <h6>Transferred</h6>
                        <p class="transferd-commission">Rp.{{$transferedCommission}}</p>
                        <div>
                            <select name="filterByStatus" id="filterByStatus" class="select2 filter-data w-75">
                                <option value="" selected disabled>Select Status</option>
                                <option value="paid">Paid</option>
                                <option value="unpaid">Unpaid</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <div class="card-body">
                <div class="row px-2">
                    
                    <div class="col-12 ">
                        <div class="d-flex justify-content-end">
                            <a href="{{route('commission.export')}}" class="btn btn-success ">Export To Excel</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table data-table">
                        <thead>
                            <tr class="text-center text-primary text-bold">
                                <th>#</th>
                                <th>Reseller</th>
                                <th>Month</th>
                                <th>Total Client</th>
                                <th>Total Payment</th>
                                <th>Total Commision</th>
                                <th>Percentage</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($commissions as $commission)
                            <tr class="text-center">
                                <td>{{$loop->index +1}}</td>
                                <td>{{$commission->user->name}}</td>
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
                                <td>{{ $totalClient }}</td>
                                <td>{{$commission->total_payment}}</td>
                                <td>{{$commission->total_commission}}</td>
                                <td>{{$commission->percentage}}%</td>
                                <td>
                                    @if ($commission->status == true)
                                    <a rel="tooltip" class="btn btn-success btn-fab btn-fab-mini btn-round " href="">
                                        <i class="material-icons">attach_money</i>
                                        <div class="ripple-container"></div>
                                    </a>
                                    @else
                                    <a rel="tooltip" class="btn btn-danger btn-fab btn-fab-mini btn-round " href="">
                                        <i class="material-icons">money_off</i>
                                        <div class="ripple-container"></div>
                                    </a>
                                    @endif
                                </td>
                                <td class="d-flex">
                                    <p rel="tooltip" class="btn btn-info btn-fab btn-fab-mini btn-round detail"
                                        id="detail-button-{{$commission->id}}" href="" data-original-title=""
                                        data-placement="bottom" title="detail"
                                        data-month="{{$commission->created_at->format('m')}}"
                                        data-loop="{{$loop->index +1}}"
                                        data-year="{{ $commission->created_at->format('Y') }}"
                                        data-user="{{ $commission->user->id }}" data-commission-id="{{$commission->id}}"
                                       data-account-number="{{$commission->user->profile !== null ?$commission->user->profile->account_number:''}}"
                                       data-account-type="{{$commission->user->profile!== null ?$commission->user->profile->bank_type:''}}"
                                        data-total-payment="{{$commission->total_payment}}"
                                        data-total-commission="{{$commission->total_commission}}"
                                        data-percentage="{{$commission->percentage}}"
                                        data-issue-date="{{$commission->created_at->format('d-F-Y')}}"
                                        data-issue-date-id="{{$commission->created_at->format('d F')}}"
                                        data-status="{{$commission->status == true ?'paid':'unpaid'}}"
                                        data-from-company="{{$commission->company->name}}"
                                        data-from-admin="{{$commission->company->users()->whereHas('roles',function($q){$q->where('name','super-admin-company');})->get()->first()->name}}"
                                        data-for="{{$commission->user->name}}">
                                        <i class="material-icons">list</i>
                                        <div class="ripple-container"></div>
                                    </p>
                                    @if ($commission->status == false)

                                    <a rel="tooltip" class="btn btn-success btn-fab btn-fab-mini btn-round"
                                        id="upload-button-{{$loop->index+1}}" href="" data-original-title=""
                                        data-placement="bottom" title="upload transaction evidence" data-toggle="modal"
                                        data-target="#file-upload-Modal-{{$loop->index+1}}">
                                        <i class="material-icons">upload</i>
                                        <div class="ripple-container"></div>
                                    </a>
                                    @else
                                    <a rel="tooltip" class="btn btn-primary btn-fab btn-fab-mini btn-round" href=""
                                        data-original-title="" data-placement="bottom"
                                        title="show transaction evidence " data-toggle="modal"
                                        data-target="#show-image-Modal-{{$loop->index+1}}">
                                        <i class="material-icons">image</i>
                                        <div class="ripple-container"></div>
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            {{-- upload evidance modal --}}
                            <div class="modal fade" id="file-upload-Modal-{{$loop->index +1}}" tabindex="-1"
                                role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog " role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Upload Modal</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{route('admin.commissions.update',$commission->id)}}"
                                            method="post" role="form" id="myuseredit" enctype="multipart/form-data">
                                            <div class="modal-body">
                                                @method('PUT')
                                                @csrf
                                                <div class="d-flex justify-content-center">
                                                    <img id="uploadPreview-{{$loop->index+1}}"
                                                        src="https://greatdayhr.com/wp-content/uploads/sites/18/2020/06/800_N_0012_290.jpg"
                                                        class=" border border-dark p-1"
                                                        style="max-width: 500px; max-height: 300px;" />
                                                </div>
                                                <div class="form-group form-file-upload form-file-multiple">
                                                    <input type="file" name="image" id="uploadImage-{{$loop->index+1}}"
                                                        class="inputFileHidden"
                                                        onchange="PreviewImage({{$loop->index+1}});"
                                                        accept="image/x-png,image/jpeg,image/x-png,image/jjif">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control inputFileVisible"
                                                            placeholder="Single File">
                                                        <span class="input-group-btn">
                                                            <button type="button"
                                                                class="btn btn-fab btn-round btn-primary">
                                                                <i class="material-icons">attach_file</i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                                {!!$errors->first('image', '<span
                                                    class="text-danger">:message</span>')!!}

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </form>
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
                                            <div class="d-flex justify-content-center p-2 border  bg-dark   ">
                                                <img src="{{ asset('/storage/evidence/'.$commission->photo_path) }}"
                                                    style="max-width: 516px; max-height:400px" class="h-100 " alt="">
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
                            <div class="col-4 rotate-status align-content-center">
                                <h2 class=" d-inline border status px-2 ">
                                    <b class="text-uppercase">
                                        <span id="status-detail"></span>
                                    </b>
                                </h2>
                            </div>
                            <div class="col-3">
                                <div class="row">
                                    <div class="col-3 d-flex justify-content-end">From</div>
                                    <div class="col-9 border-left border-dark py-2">
                                        <p class="h6">
                                            <b>
                                                <span id="from-company-detail"></span>
                                            </b>
                                        </p>
                                        <span id="from-admin-detail"></span>
                                    </div>

                                    <div class="col-3 d-flex justify-content-end mt-2">For</div>
                                    <div class="col-9 border-left border-dark mt-2">
                                        <span id="for-detail"></span>
                                        <br>
                                        <span id="account-number-detail"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </small>

                    {{-- head --}}
                    <table class="table table-striped table-bordered mt-3">
                        <thead class="text-bold text-primary">
                            <tr>
                                <th>#</th>
                                <th class="w-100">Name</th>
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
                                <div class="col-8  ">
                                    Total Payment
                                </div>
                                <div class="col-4">
                                    Rp.<span id="total-payment-detail"></span>
                                </div>
                                <div class="col-8  ">
                                    Commission
                                </div>
                                <div class="col-4">
                                    <span id="percentage-detail"></span> %
                                </div>
                                <div class="col-8  ">
                                    Total Commission
                                </div>
                                <div class="col-4">
                                    Rp.<span id="total-commission-detail"></span>
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
    // form file upload
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

    function PreviewImage(loop) {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById(`uploadImage-${loop}`).files[0]);

        oFReader.onload = function (oFREvent) {
            document.getElementById(`uploadPreview-${loop}`).src = oFREvent.target.result;
        };
    };
    function filterData(reseller,month,status) {
        return $.get(`{{url('/admin/commission/filter')}}?reseller=${reseller}&month=${month}&status=${status}`,res=>{
            return res;
        })
    }
    $('.data-table').DataTable()
    $('.select2').select2()

    $("#preloaders").fadeOut(1000);
    md.initDashboardPageCharts();

    $('.detail').click(function () {
        const month = $(this).data('month')
        const year = $(this).data('year')
        const user_id = $(this).data('user')
        // console.log()
        $.get(`{{url('/')}}/reseller/commision-month?user_id=${user_id}&month=${month}&year=${year}`, (res) => {
            let card = $(`#show-detail`)
            card.html("");
            $('.t-column').remove()
            res.map((el, index) => {
                let show =
                    `
                    <tr>
                        <td>${index+1}</td>
                        <td>${ el.name.length > 15 ?  el.name.substring(0,15)+'...' :el.name }</td>
                        <td>${ el.company.length > 15 ?  el.company.substring(0,15)+'...' :el.company  }</td>
                        <td> <b>Rp.${el.transaction}</b></td>
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
        $('#for-detail').html($(this).data('for'))
        if ($(this).data('account-type') !=='') {
            $('#account-number-detail').html($(this).data('account-number') + ' | '+$(this).data('account-type'))
        } else {
            $('#account-number-detail').html('null')
        }
        if ($(this).data('status') == 'paid') {
            $('#status-detail').closest('h2.border').removeClass('border-danger  text-danger')
            $('#status-detail').closest('h2.border').addClass('border-success  text-success')
        } else {
            $('#status-detail').closest('h2.border').removeClass('border-success  text-success')
            $('#status-detail').closest('h2.border').addClass('border-danger  text-danger')
        }
        $('#status-detail').html($(this).data('status'))
    })
    $('.filter-data').change(function () {
        total = $('#total-commission')
        remaining = $('#remaining-commission')
        transfered = $('#transfered-commission')
        filter = filterData($('#filterByReseller').val(),$('#filterByMonth').val(),$('#filterByStatus').val()).then(res=>{
            total.text('Rp.'+res.total_commission)
            remaining.text('Rp.'+res.remaining_commission)
            transfered.text('Rp.'+res.transfered_commission)
        }
        )
    })
    $('#select-reseller').change(function () {
        
        $('#total-commission').val()
        
    })
    function complatePayment(dataLoop) {
        $(`#detailModal-${dataLoop}`).modal('hide')
        $(`#upload-button-${dataLoop}`).click()
    }

    $('.form-file-simple .inputFileVisible').click(function () {
        $(this).siblings('.inputFileHidden').trigger('click');
    });
// file input
    $('.form-file-simple .inputFileHidden').change(function () {
        var filename = $(this).val().replace(/C:\\fakepath\\/i, '');
        $(this).siblings('.inputFileVisible').val(filename);
    });

    $('.form-file-multiple .inputFileVisible, .form-file-multiple .input-group-btn').click(function () {
        $(this).parent().parent().find('.inputFileHidden').trigger('click');
        $(this).parent().parent().addClass('is-focused');
    });

    $('.form-file-multiple .inputFileHidden').change(function () {
        var names = '';
        for (var i = 0; i < $(this).get(0).files.length; ++i) {
            if (i < $(this).get(0).files.length - 1) {
                names += $(this).get(0).files.item(i).name + ',';
            } else {
                names += $(this).get(0).files.item(i).name;
            }
        }
        $(this).siblings('.input-group').find('.inputFileVisible').val(names);
    });

    $('.form-file-multiple .btn').on('focus', function () {
        $(this).parent().siblings().trigger('focus');
    });

    $('.form-file-multiple .btn').on('focusout', function () {
        $(this).parent().siblings().trigger('focusout');
    });
// file input end
    if (getUrlParameter('id')) {
        $(`#detail-button-${getUrlParameter('id')}`).click();
    }

</script>
@endpush
