@extends('layouts.master')

@section('title')
    Peramalan
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Peramalan</li>
@endsection

@section('content')
<style>
    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }
    
    .overlay i {
        color: #000000;
        /* color: #fff; */
    }

    .d-none {
        display: none;
    }

    .d-block {
        display: block;
    }
</style>

<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-body px-5">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="bulan_awal">Bulan Awal</label>
                            <input type="month" class="form-control" id="bulan_awal" placeholder="name@example.com">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="bulan_akhir">Bulan Akhir</label>
                            <input type="month" class="form-control" id="bulan_akhir" placeholder="name@example.com">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="periode">Periode</label>
                            <select class="form-control" id="periode">
                                <option>3</option>
                                <option>5</option>
                                <!-- <option>7</option> -->
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="produk">Nama Barang</label>
                            <select class="form-control" id="produk">
                                @foreach ($productLists as $item)
                                <option value="{{ $item->id_produk }}">{{ $item->nama_produk }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 pb-3">
                        <div class="form-group">
                            <button type="button" id="btn-hitung-forecast" class="btn btn-success btn-block mt-4 mb-4">Hitung</button>
                        </div>
                    </div>
                </div>
                <div id="loading-spinner" class="row px-4 d-none">
                    <div class="overlay">
                        <i class="fas fa-sync-alt fa-spin fa-2x"></i>
                    </div>
                </div>
                <div id="forecast-result" class="row px-4 d-none">
                    <table class="table table-bordered" id="forecast-actual">
                        <thead>
                            <tr>
                                <th scope="col" colspan="4" class="bg-primary" id="fx_nama_barang">Nama Barang</th>
                            </tr>
                            <tr>
                                <th>Bulan (n)</th>
                                <th>Data Aktual (T)</th>
                                <th>Forecast (Fx)</th>
                                <th>Error%</th>
                            </tr>
                        </thead>
                        <tbody id="fx_body_actual"></tbody>
                    </table>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col" colspan="2">Hasil Prediksi</th>
                            </tr>
                            <tr>
                                <th>Bulan (n)</th>
                                <th>Fx</th>
                            </tr>
                        </thead>
                        <tbody id="fx_body_prediction"></tbody>
                    </table>
                </div>
                <div id="chart-container" class="row px-4">
                    <canvas id="forecastChart" style="height: 180px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@includeIf('peramalan.detail')
@endsection

@push('scripts')
<script src="{{ asset('AdminLTE-2/bower_components/chart.js/Chart.js') }}"></script>
<script>
    function renderTable(data) {
        $("#fx_nama_barang").text(data.produk.nama_produk);

        $("#fx_body_actual").empty();
        data.forecast.forEach(e => {
            let actual = `
                <tr>
                    <td scope="row">`+ e.month +`</td>
                    <td>`+ e.actual_sales +`</td>
                    <td>`+ e.forecast_sales +`</td>
                    <td>`+ (e.mape).toFixed(2) +`</td>
                </tr>
            `;
            $("#fx_body_actual").append(actual);
        });

        let mape = `
            <tr>
                <th colspan="3" class="text-right">MAPE (Mean Absolute Percentage Error)</th>
                <th>`+ data.mape +`%</th>
            </tr>
            <tr>
                <th colspan="3" class="text-right">Akurasi</th>
                <th>`+ data.accuracy +`%</th>
            </tr>
        `;
        
        $("#fx_body_actual").append(mape);

        $("#fx_body_prediction").empty();
        data.prediction.forEach(e => {
            let fx = `
                <tr>
                    <td scope="row">`+ e.month +`</td>
                    <td>`+ e.forecast_sales +`</td>
                </tr>
            `;
            $("#fx_body_prediction").append(fx);
        });
    }

    function drawChart(data) {
        try {
            $("#forecastChart").remove();
            $("#chart-container").append(`<canvas id="forecastChart" style="height: 180px;"></canvas>`);
        } finally {
            console.log(data);
    
            var forecastChartCanvas = $('#forecastChart').get(0).getContext('2d')
            var forecastChart = new Chart(forecastChartCanvas)
    
            var forecastChartData = {
                labels: data.labels,
                datasets: data.datasets
            };
    
            var forecastChartOptions = {
                showScale               : true,
                scaleShowGridLines      : false,
                scaleGridLineColor      : 'rgba(0,0,0,.05)',
                scaleGridLineWidth      : 1,
                scaleShowHorizontalLines: true,
                scaleShowVerticalLines  : true,
                scaleBeginAtZero        : true,
                bezierCurve             : true,
                bezierCurveTension      : 0.3,
                pointDot                : true,
                pointDotRadius          : 4,
                pointDotStrokeWidth     : 1,
                pointHitDetectionRadius : 20,
                datasetStroke           : true,
                datasetStrokeWidth      : 2,
                datasetFill             : true,
                legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].lineColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
                maintainAspectRatio     : true,
                responsive              : true,
            }
            // forecastChartOptions.scales = {
            //     yAxes:[{
            //         ticks:{
            //             callback: function (value) {
            //                 if (value % 10 === 0 ){
            //                     return value;
            //                 }
            //             }
            //         }
            //     }]
            // }
            forecastChartOptions.datasetFill = false;
            forecastChart.Line(forecastChartData, forecastChartOptions);
        }
    }

    $("#btn-hitung-forecast").on('click', () => {
        $('#loading-spinner').show();

        let url = "{{ route('peramalan.hitung') }}";
        let data = {
            'id_produk': $("#produk").val(),
            'periode': $("#periode").val(),
            'bulan_awal': $("#bulan_awal").val(),
            'bulan_akhir': $("#bulan_akhir").val(),
        };

        $.post(url, {
            '_token': $('[name=csrf-token]').attr('content'),
            '_method': 'post',
            '_data': data
        })
        .done((response) => {
            renderTable(response);
            drawChart(response.chart_data);

            setTimeout(() => {
                $('#forecast-result').show();
                $('#loading-spinner').hide();
            }, 1500);
        })
        .fail((errors) => {
            alert('Gagal menghitung data!');
            $('#loading-spinner').hide();
            return;
        });
    });
</script>
@endpush