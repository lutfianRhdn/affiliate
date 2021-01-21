@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Admin')])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div>

            <select name="filterByMonth" id="filterByMonth" class="select2 w-25">
                <option value="" selected>Select Month</option>
                @foreach ($months as $month)
                <option value="{{$month}}">{{$month}}</option>
                @endforeach
            </select>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-warning card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">supervisor_account</i>
                        </div>
                        <p class="card-category">Clients</p>
                        <h3 class="card-title" id="total-client">{{$totalClient}}
                        </h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <a href="{{route('reseller.client.index')}}">See All Clients</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-success card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">store</i>
                        </div>
                        <p class="card-category">Revenue</p>
                        <h3 class="card-title" id="total-revenue">Rp {{number_format($totalCommission,2)}}</h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">date_range</i> {{$lastCommission->created_at->diffforhumans()}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-danger card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">receipt_long</i>
                        </div>
                        <p class="card-category">Remaining</p>
                        <h3 class="card-title" id="total-remaining">Rp {{number_format($remainingCommission,2)}}</h3>
                    </div>
                    <div class="card-footer">
                      <div class="stats">
                          <i class="material-icons">date_range</i> {{$lastCommission->created_at->diffforhumans()}}
                      </div>
                  </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">payments</i>
                        </div>
                        <p class="card-category">Transfered</p>
                        <h3 class="card-title" id="total-transfered">Rp {{number_format($transferedCommission,2)}}</h3>
                    </div>
                    <div class="card-footer">
                      <div class="stats">
                          <i class="material-icons">date_range</i> {{$lastCommission->created_at->diffforhumans()}}
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
                            <i class="material-icons">access_time</i> {{$lastCommission->created_at->diffforhumans()}}
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
        Object.keys(dataChart).map(el => {
            let data = []
            for (var key in dataChart[el]) {
                data.push(dataChart[el][key])
            }
            result.push({
                [el]: data
            })
        })
        var data = {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                    label: "revenue",
                    data: result[0].revenue,
                    backgroundColor: '#63B967'
                },
                {
                    label: "remaining",
                    data: result[1].remaining,
                    backgroundColor: '#E63B37'

                },
                {
                    label: "transfered",
                    data: result[2].transfered,

                    backgroundColor: '#02AEC3'
                }
            ]
        };
        const options = {
            // barValueSpacing: 20,
            responsive: true,
            scaleBeginAtZero: true,
            defaultFontColor: '#fff',
            hover: {
                mode: 'index',
                intersect: false
            },
            tooltips: {
                mode: 'index',
                intersect: false,
                callbacks: {
                    title: function (el) {
                        return "";
                    },
                    label: function (item, data) {
                        var datasetLabel = data.datasets[item.datasetIndex].label || "";
                        var dataPoint = item.yLabel;
                        console.log(datasetLabel)
                        return datasetLabel + ": " + "Rp " + numeral(dataPoint).format('Oa');
                    }
                }
            },

            scales: {
                xAxes: [{
                    stacked: true
                }],
                yAxes: [{
                    display: true,
                    ticks: {
                        beginAtZero: true, 
                        callback: function (label, index, labels) {
                            return numeral(label).format('Oa')
                        }
                    },
                    stepSize: 1,
                    suggestedMin: 0.5,
                    suggestedMax: 5.5,

                }]
            }
        }
        Chart.scaleService.updateScaleDefaults('linear', {
            ticks: {
                max: 1000000
            }
        });

        var myBarChart = new Chart($('#chart'), {
            type: 'bar',
            data: data,
            options: options
        });


        $("#preloaders").fadeOut(1000);
        $('#filterByMonth').change(function () {
            // console.log($(this).val())
            $.get(`{{route('dashboard.filter.month')}}?month=${$(this).val()}`, function (res) {
                // console.log(res)
                $('#total-client').text(res.data.total_client)
                $('#total-remaining').html('Rp <br> ' + numeral(res.data.total_remaining).format(
                    '0,0.00'))
                $('#total-transfered').html('Rp <br>' + numeral(res.data.total_transfered).format(
                    '0,0.00'))
                $('#total-revenue').html('Rp <br>' + numeral(res.data.total_commission).format(
                    '0,0.00'))
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
        // if (`{{auth()->user()->profile}}` == '' && `{{auth()->user()->hasRole('reseller')}}`) {
        //   Swal.fire({
        //     type: 'info',
        //     title: 'Complate your <strong class="text-primary">Profile</strong>!',
        //     text:'Please Complate your Profile for Trander Commission',
        //     showCloseButton: true,
        //     showCancelButton: true,
        //     confirmButtonText:`Go To Profile`,
        //     confirmButtonColor: '#15BACF',
        //     cancelButtonText:`Later`
        //   }).then((res)=>{
        //     console.log(res)
        //     if (res.value ==true) {
        //     window.location.replace(`{{route('profile.edit')}}`)  
        //     }
        //   })
        // }
    });

</script>
@endpush
