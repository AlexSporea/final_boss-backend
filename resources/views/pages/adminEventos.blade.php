@extends('layouts.app', ['pageSlug' => 'adminEventos'])

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-chart">
                <div class="card-body">
                    <div>
                        <canvas id="chart-adminEventos" style="display:block; width:100%; height:600px"></canvas>
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
            let cData = JSON.parse(`<?php echo $data;?>`);

            
            console.log(cData);
            

            const ctx = document.getElementById('chart-adminEventos').getContext('2d');
            // Creamos el gráfico

            const myChart = new Chart(ctx, {
                type:'pie',
                data:{
                    labels:cData[0],
                    datasets:[{
                        label:'Eventos por adjucidador',
                        data:cData[1],
                        backgroundColor:[
                            'rgb(255, 173, 173)',
                            'rgb(255, 214, 165)',
                            'rgb(253, 255, 182)',
                            'rgb(202, 255, 191)',
                            'rgb(155, 246, 255)',
                            'rgb(160, 196, 255)',
                            'rgb(189, 178, 255)',
                            'rgb(255, 198, 255)',
                            'rgb(255, 255, 252)',
                            'rgb(212, 163, 115)'
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
                        text:'Logística - Eventos Administrativos',
                        fontSize:25
                    },
                    legend:{
                        position:'left'
                    }
                }
            });
        });
    </script>
@endpush
