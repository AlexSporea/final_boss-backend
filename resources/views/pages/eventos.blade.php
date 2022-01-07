@extends('layouts.app', ['pageSlug' => 'eventos'])

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-chart">  
                <div class="card-body">
                    <div>
                        <canvas id="chart-eventos" style="display:block; width:100%; height:600px"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('white') }}/js/plugins/chartjs.min.js"></script>
    <script>
        $(document).ready(function() {
            // Obtenemos el array enviado y lo convertimos a json
            let cData = JSON.parse(`<?php echo $data; ?>`);
            console.log(cData);
            
            const ctx = document.getElementById('chart-eventos').getContext('2d');
            
            // Opciones globales de los gráficos
            Chart.defaults.global.defaultFontColor= '#000';
            Chart.defaults.global.defaultFontFamily= 'Lato';
            
            // Creamos el gráfico
            const myChart = new Chart(ctx, {
                type:'bar',
                data:{
                    labels:cData[0],
                    datasets:[{
                        label:'Tipo de evento',
                        data:cData[1],
                        backgroundColor:[
                            'rgb(217, 237, 146)',
                            'rgb(181, 228, 140)',
                            'rgb(153, 217, 140)',
                            'rgb(118, 200, 147)',
                            'rgb(82, 182, 154)',
                            'rgb(52, 160, 164)',
                            'rgb(22, 138, 173)',
                            'rgb(26, 117, 159)',
                            'rbg(30, 96, 145)'
                        ],
                        borderWidth:1,
                        borderColor:'#777',
                        hoverBorderWidth:3,
                        hoverBorderColor:'#000'
                    }]
                },
                options:{
                    title:{
                        display:true,
                        text:'Logística - Eventos',
                        fontSize:25
                    },
                    legend:{
                        position:'left',
                        fontColor: '#777'
                    },
                    scales:{
                    yAxes:[{
                        ticks:{
                            beginAtZero:true,
                            max:8
                        }
                    }]
                }
                }
            });
        });
    </script>
@endpush
