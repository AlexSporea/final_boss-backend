@extends('layouts.app', ['pageSlug' => 'incidencias'])

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-chart">
                <div class="card-body">
                    <div>
                        <canvas id="chart-incidencias" style="display:block; width:100%; height:600px"></canvas>
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
            
        });
    </script>
@endpush
