@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Admin')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div>
            <select name="filterByMonth" id="filterByMonth" class="select2 w-25 filter-dashboard">
                <option value="" selected>Select Month</option>
                @foreach ($months as $month)
                <option value="{{$month}}">{{$month}}</option>
                @endforeach
            </select>
            <select name="filterByMonth" id="filterByYear" class="select2 w-25 filter-dashboard">
                <option value="" selected>Select Year</option>
                @foreach ($years as $year)
                <option value="{{$year}}">{{$year}}</option>
                @endforeach
            </select>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats w-100 ">
                    <div class="card-header card-header-warning card-header-icon h-100">
                        <div class="card-icon">
                            <i class="material-icons">supervisor_account</i>
                        </div>
                        <p class="card-category">Clients</p>
                        <h5 class="card-title" id="total-client">{{$totalClient}}
                        </h5>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <a href="{{route('reseller.client.index')}}">See All Clients</a>
                        </div>
                    </div>
                </div>
            </div>
            @if (!auth()->user()->hasRole('reseller'))
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-stats w-100">
                        <div class="card-header card-header-primary card-header-icon">
                            <div class="card-icon">
                                <i class="material-icons">store</i>
                            </div>
                            <p class="card-category">Revenue</p>
                            <h4 class="card-title" id="total-revenue">{{$totalRevenue}}</h4>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">date_range</i> {{$lastCommission !==null ?$lastCommission->created_at->diffforhumans():"your revenue hasn't generated"}}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats w-100">
                    <div class="card-header card-header-success card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">payments</i>
                        </div>
                        <p class="card-category">Commissions</p>
                        <h4 class="card-title" id="total-commission">{{$totalCommission}}</h4>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">date_range</i> {{$lastCommission !==null ?$lastCommission->created_at->diffforhumans():"your revenue hasn't generated"}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats w-100">
                    <div class="card-header card-header-danger card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">receipt_long</i>
                        </div>
                        <p class="card-category">Remaining</p>
                        <h4 class="card-title" id="total-remaining">{{$remainingCommission}}</h4>
                    </div>
                    <div class="card-footer">
                      <div class="stats">
                          <i class="material-icons">date_range</i> {{$lastCommission !==null ?$lastCommission->created_at->diffforhumans():"your revenue   hasn't generated"}}
                      </div>
                  </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats w-100">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">payments</i>
                        </div>
                        <p class="card-category">Transfered</p>
                        <h4 class="card-title" id="total-transfered">{{$transferedCommission}}</h4>
                    </div>
                    <div class="card-footer">
                      <div class="stats">
                          <i class="material-icons">date_range</i> {{$lastCommission !==null ?$lastCommission->created_at->diffforhumans():"your revenue   hasn't generated"}}
                      </div>
                  </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 my-sm-2">
                <div class="card card-chart">
                    <div class="card-header card-header-warning">
                        <canvas class="ct-chart " id="chart"></canvas>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">Commission Statistics</h4>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">access_time</i> {{$lastCommission !==null ?$lastCommission->created_at->diffforhumans():"your revenue    hasn't generated"}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header card-header-warning">
                        <h4 class="card-title">Clients Stats</h4>
                        <p class="card-category">New Clients on {{Carbon\Carbon::now()->format('F, Y')}}</p>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-hover">
                            <thead class="text-warning">
                                <th>ID</th>
                                <th>Name</th>
                                <th>Company</th>
                            </thead>
                            <tbody id="table-clients">
                                @foreach ($clients as $client)
                                <tr>
                                    <td>{{$loop->index +1}}</td>
                                    <td>{{$client->name}}</td>
                                    <td>{{$client->company}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function () {
        $('.select2').select2()
        let dataChart = JSON.parse('{!! $data !!}')
        let result = []
        $('#total-revenue').text('Rp '+ numeral($('#total-revenue').text()).format('O.ooa'))
        $('#total-commission').text('Rp '+ numeral($('#total-commission').text()).format('O.ooa'))
        $('#total-remaining').text('Rp '+ numeral($('#total-remaining').text()).format('O.ooa'))
        $('#total-transfered').text('Rp '+ numeral($('#total-transfered').text()).format('O.ooa'))
        Object.keys(dataChart).map(el => {
            let data = []
            for (var key in dataChart[el]) {
                data.push(dataChart[el][key])
            }
            result.push({
                [el]: data
            })
        })
        let revenue =[]
        const Maxres = Math.max.apply(Math,result[0].revenue).toString()
        let heightChart= 
        Maxres.split('')
        .filter(e=> e !== '0')
        .map((el,i)=> i ==0 ? `${el}.`:el)
        .join('')
        let zero = 
            Maxres.split('')
            // .filter(e=> e == '0')
            .map((el,i)=> i !==0 ? '0' :'' )
            .join('')
        const nominal = '1' + zero.toString()
        heightChart = Math.ceil(parseFloat(heightChart))*nominal
        var data = {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                    label: "Revenue",
                    data:result[0].revenue,
                    stack:'client',
                    backgroundColor: '#45aaf2'
                },
 
            ]
        };
        if (result[3] !== undefined) {
                data.datasets.push(
                {
                    label: "Transfered",
                    data: result[2].transfered,
                    stack:'reseller',
                    backgroundColor: '#26de81'
                },
                {
                    label: "Remaining",
                    data: result[1].remaining,
                    stack:'reseller',
                    backgroundColor: '#fc5c65'
                },
               
                )

                }
        const options = {
            // barValueSpacing: 20,
            responsive: true,
            scaleBeginAtZero: true,
            defaultFontColor: '#fff',
            hover: {
                mode: 'x',
                intersect: true
            },
            tooltips: {
                mode: 'x',
                intersect: true,
                callbacks: {
                    title: function (el) {
                        return "";
                    },
                    label: function (item, data) {
                        var datasetLabel = data.datasets[item.datasetIndex].label || "";
                        var dataPoint = item.yLabel;
                        // if (datasetLabel == 'Revenue') {
                        //      dataPoint += result[1].remaining[item.index] + result[2].transfered[item.index] 
                        // }
                        return datasetLabel + ": " + "Rp " + numeral(dataPoint).format('O.ooa');
                    }
                }
            },

            scales: {
                xAxes: [{
                    stacked: true,
                }],
                yAxes: [{
                    stacked: true,
                    ticks: {
                        beginAtZero: true, 
                        callback: function (label, index, labels) {
                            return numeral(label).format('O.oa')
                        }
                    },
                    stepSize: 1,
                    suggestedMin: 0.5,
                    suggestedMax: 5.5,

                }]
            }
        }
        Chart.defaults.global.defaultFontColor = "#fff";
        Chart.scaleService.updateScaleDefaults('linear', {
            ticks: {
                max: (heightChart ) 
            }
        });
        // new Chart(ctx));
        var myBarChart = new Chart($('#chart'), {
            type: 'bar',
            data: data,
            options: options
        })

        $("#preloaders").fadeOut(1000);
        $('.filter-dashboard').change(function () {
            // console.log($(this).val())
            $.get(`{{route('dashboard.filter.month')}}?month=${$('#filterByMonth').val()}&year=${$('#filterByYear').val()}`, function (res) {
                console.log(res)
                $('#total-client').text(res.data.total_client)
                $('#total-commission').html('Rp ' + numeral(res.data.total_commission).format(
                    'O.ooa'))
                $('#total-remaining').html('Rp ' + numeral(res.data.total_remaining).format(
                    'O.ooa'))
                $('#total-transfered').html('Rp ' + numeral(res.data.total_transfered).format(
                    'O.ooa'))
                $('#total-revenue').html('Rp ' + numeral(res.data.total_revenue).format(
                    'O.ooa'))
                let tbody = $('#table-clients')
                tbody.html("")
                res.data.clients.map(function (el, index) {
                    let tr = `  <tr>
                    <td>${index+1}</td>
                    <td>${el.name}</td>
                    <td>${el.company}</td>
                  </tr>`
                    tbody.append(tr)
                })

            })
        })
        if (`{{auth()->user()->profile}}` == '' && `{{auth()->user()->hasRole('reseller')}}`) {
          Swal.fire({
            type: 'info',
            title: 'Complate your <strong class="text-primary">Profile</strong>!',
            text:'Please Complate your Profile for Trander Commission',
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText:`Go To Profile`,
            confirmButtonColor: '#15BACF',
            cancelButtonText:`Later`
          }).then((res)=>{
            console.log(res)
            if (res.value ==true) {
            window.location.replace(`{{route('profile.edit')}}`)  
            }
          })
        }
    });

</script>
@endpush
