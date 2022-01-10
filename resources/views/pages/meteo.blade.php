<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
    integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
    crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
    integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
    crossorigin=""></script>
    <style>
        #mapEs {height: 500px}
    </style>
    
</head>
<body>
    @extends('layouts.app', ['pageSlug' => 'meteo'])

    @section('content')
        <div class="row">
            <div class="col-12">
                <div class="card card-chart">
                    <div class="card-body">
                        <div id="mapEs"></div>
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

                // Creamos el mapa usando la libreria Leaflet.js
                const mymap = L.map('mapEs').setView([43.14373, -2.194255], 10);

                // Mención al distribuidor de los mosaicos del mapa
                const attribution = '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors';
                // Formato con el que obtendremos los mosaicos
                const tileUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
                const tiles = L.tileLayer(tileUrl, {attribution});
                tiles.addTo(mymap);

                // Añadimos los popups
                cData.forEach(element => {
                    let marker = L.marker([element.lat, element.lon]).addTo(mymap);
                    marker.bindPopup(`<b>${element.name}</b><br>${element.weather}`).openPopup();
                });

                
                
            });
        </script>
    @endpush

</body>
</html>
