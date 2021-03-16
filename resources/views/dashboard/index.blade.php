@extends('layouts.appUtama')

@section('tambahanCSS')

@endsection

@section('dashboard','active')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Jemaat</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$totalData[0]->total}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Rata-rata Usia</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$totalData[0]->totalUsia}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa- fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jumlah Laki-Laki</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$dataJnsKelamin[0]->totalJnsKelamin}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-male fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jumlah Perempuan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$dataJnsKelamin[1]->totalJnsKelamin}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-female fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-4 col-lg-5 mb-4">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    Data Jenis Kelamin
                </div>
                <div class="card-body">
                    <div id="jenis-kelamin"></div>
                </div>
            </div>

        </div>
        <div class="col-xl-8 col-lg-7 mb-4">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    Data Usia
                </div>
                <div class="card-body">
                    <div id="range-umur"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 mb-4">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    Data Pendidikan
                </div>
                <div class="card-body">
                    <div id="pendidikan"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



@section('tambahanJS')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
    var dataJnsKelamin = <?php echo json_encode($dataJnsKelamin) ?>;
    var jns_kelamin = [];
    for (var i = 0; i < dataJnsKelamin.length; i++) {
        jns_kelamin[i] = {
            name: dataJnsKelamin[i].name,
            y: Number(dataJnsKelamin[i].y),
        }
    }
    Highcharts.chart('jenis-kelamin', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        credits: {
            enabled: false
        },
        title: {
            text: null
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: false
                },
                showInLegend: true
            }
        },
        series: [{
            name: 'Jenis Kelamin',
            colorByPoint: true,
            data: jns_kelamin
        }]
    });

    var usia = <?php echo json_encode($usiaJemaat) ?>;
    Highcharts.chart('range-umur', {
        chart: {
            type: 'column'
        },
        title: {
            text: null
        },
        credits: {
            enabled: false
        },
        accessibility: {
            announceNewData: {
                enabled: true
            }
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Jumlah Jemaat'
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> of total<br/>'
        },

        series: [{
            name: "Browsers",
            colorByPoint: true,
            data: usia
        }],
    });


    var pendidikan = <?php echo json_encode($pendidikan) ?>;
    Highcharts.chart('pendidikan', {
        chart: {
            type: 'column'
        },
        title: {
            text: null
        },
        credits: {
            enabled: false
        },
        accessibility: {
            announceNewData: {
                enabled: true
            }
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Jumlah Jemaat'
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> of total<br/>'
        },

        series: [{
            name: "Browsers",
            colorByPoint: true,
            data: pendidikan
        }],
    });
</script>
@endsection