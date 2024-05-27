@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Panel de Estadísticas</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Usuarios Registrados</h5>
                <p class="card-text">{{ $totalUsers }}</p>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Coches Anunciados</h5>
                <p class="card-text">{{ $totalCars }}</p>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Usuarios Registrados</h5>
                
        <div class="container">

        <div id="users_chart" style="width: 100%; height: 400px;"></div>
        <div id="cars_chart" style="width: 100%; height: 400px;"></div>
    </div>

    <script type="text/javascript">
        
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawUsersChart);

        function drawUsersChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Día');
            data.addColumn('number', 'Usuarios');

            var usersData = {!! $usersByDay !!};

            usersData.forEach(function(row) {
                data.addRow([row.date, row.count]);
            });

            var options = {
                title: 'Usuarios Creados por Día',
                curveType: 'function',
                legend: { position: 'bottom' }
            };

            var chart = new google.visualization.LineChart(document.getElementById('users_chart'));
            chart.draw(data, options);
        }

        // Dibujar gráfico de coches
        google.charts.setOnLoadCallback(drawCarsChart);

        function drawCarsChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Día');
            data.addColumn('number', 'Coches');

            var carsData = {!! $carsByDay !!}; 

            carsData.forEach(function(row) {
                data.addRow([row.date, row.count]);
            });

            var options = {
                title: 'Coches Creados por Día',
                curveType: 'function',
                legend: { position: 'bottom' }
            };

            var chart = new google.visualization.LineChart(document.getElementById('cars_chart'));
            chart.draw(data, options);
        }
    </script>
            
        </div>
@endsection