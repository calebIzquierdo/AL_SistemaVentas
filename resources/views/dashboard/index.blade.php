@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
  <h2 class="mb-4">Dashboard de Reportes</h2>

  <div class="row">
    <!-- Ventas por Semana -->
    <div class="col-md-6 mb-4">
      <div class="card shadow p-3">
        <h5>Ventas por Semana</h5>
        <canvas id="ventasSemana"></canvas>
      </div>
    </div>

    <!-- Ventas por Mes -->
    <div class="col-md-6 mb-4">
      <div class="card shadow p-3">
        <h5>Ventas por Mes</h5>
        <canvas id="ventasMes"></canvas>
      </div>
    </div>
  </div>

  <div class="row">
    <!-- Ventas por Año -->
    <div class="col-md-6 mb-4">
      <div class="card shadow p-3">
        <h5>Ventas por Año</h5>
        <canvas id="ventasAnio"></canvas>
      </div>
    </div>

    <!-- Productos más Vendidos -->
    <div class="col-md-6 mb-4">
      <div class="card shadow p-3">
        <h5>Productos más Vendidos</h5>
        <canvas id="productosVendidos"></canvas>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const tooltipFormat = value => `Total vendido: S/. ${parseFloat(value).toFixed(2)}`;

  // Ventas por Semana
  new Chart(document.getElementById('ventasSemana'), {
    type: 'bar',
    data: {
      labels: {!! json_encode($ventasSemana->pluck('dia')) !!},
      datasets: [{
        label: 'S/. Ventas',
        data: {!! json_encode($ventasSemana->pluck('total')) !!},
        backgroundColor: 'rgba(54, 162, 235, 0.5)'
      }]
    },
    options: {
      scales: { y: { beginAtZero: true } },
      plugins: {
        tooltip: {
          callbacks: {
            label: context => tooltipFormat(context.raw)
          }
        }
      }
    }
  });

  // Ventas por Mes
  new Chart(document.getElementById('ventasMes'), {
    type: 'bar',
    data: {
      labels: {!! json_encode($ventasMes->pluck('mes')) !!},
      datasets: [{
        label: 'S/. Ventas',
        data: {!! json_encode($ventasMes->pluck('total')) !!},
        backgroundColor: 'rgba(255, 159, 64, 0.6)'
      }]
    },
    options: {
      scales: { y: { beginAtZero: true } },
      plugins: {
        tooltip: {
          callbacks: {
            label: context => tooltipFormat(context.raw)
          }
        }
      }
    }
  });

  // Ventas por Año
  new Chart(document.getElementById('ventasAnio'), {
    type: 'bar',
    data: {
      labels: {!! json_encode($ventasAnio->pluck('anio')) !!},
      datasets: [{
        label: 'S/. Ventas',
        data: {!! json_encode($ventasAnio->pluck('total')) !!},
        backgroundColor: 'rgba(75, 192, 192, 0.5)'
      }]
    },
    options: {
      scales: { y: { beginAtZero: true } },
      plugins: {
        tooltip: {
          callbacks: {
            label: context => tooltipFormat(context.raw)
          }
        }
      }
    }
  });

  // Productos más Vendidos
  new Chart(document.getElementById('productosVendidos'), {
    type: 'doughnut',
    data: {
      labels: {!! json_encode($productos->pluck('producto')) !!},
      datasets: [{
        data: {!! json_encode($productos->pluck('total')) !!},
        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF']
      }]
    }
  });
</script>

 
@endsection


