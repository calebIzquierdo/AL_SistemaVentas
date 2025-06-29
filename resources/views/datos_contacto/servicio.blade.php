@extends('layouts.vista')

@section('content')
<!-- Sección Hero -->
<section class="hero-section py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="display-4 fw-bold mb-4">Confección de Ropa Deportiva</h1>
                <p class="lead mb-4">Diseño, calidad y confort en cada prenda deportiva. Tu equipo merece lo mejor.</p>
                <a href="#contacto" class="btn btn-primary btn-lg">Solicitar Servicio</a>
            </div>
            <div class="col-md-6">
                <img src="https://www.asioka.com/blog/wp-content/uploads/2020/06/Help-520x245.jpg" alt="Ropa deportiva" class="img-fluid rounded shadow-lg">
            </div>
        </div>
    </div>
</section>

<!-- Sección Características -->
<section class="features-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="feature-icon mb-3">
                            <i class="bi bi-check-circle-fill text-success fs-1"></i>
                        </div>
                        <h3 class="h5 mb-3">Calidad Superior</h3>
                        <p>Materiales de primera calidad y acabados profesionales.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="feature-icon mb-3">
                            <i class="bi bi-palette-fill text-info fs-1"></i>
                        </div>
                        <h3 class="h5 mb-3">Diseño Personalizado</h3>
                        <p>Logos y colores a tu medida.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="feature-icon mb-3">
                            <i class="bi bi-clock-fill text-warning fs-1"></i>
                        </div>
                        <h3 class="h5 mb-3">Entrega Rápida</h3>
                        <p>Producción eficiente y entrega puntual.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Sección de Formulario -->
<section id="contacto" class="contact-section py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-4">
                <img src="https://bfbordados.com/wp-content/uploads/2017/12/F%C3%A1brica-de-ropa-deportiva.jpg" alt="Proceso de confección" class="img-fluid rounded shadow-lg">
            </div>
            <div class="col-lg-6">
                <div class="card border-0 shadow-lg">
                    <div class="card-body p-5">
                        <h2 class="card-title mb-4">Solicita tu Servicio</h2>
                        <form id="form-crear" class="needs-validation" action="{{ route('datos-contacto.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="fecha_inicio" class="form-label">Fecha Inicio</label>
                                    <input type="date" class="form-control form-control-lg" id="fecha_inicio" name="fecha_inicio" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="fecha_fin" class="form-label">Fecha Fin</label>
                                    <input type="date" class="form-control form-control-lg" id="fecha_fin" name="fecha_fin" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="cantidad" class="form-label">Cantidad de prendas</label>
                                <div class="input-group">
                                    <span class="input-group-text">Unidades</span>
                                    <input type="number" class="form-control form-control-lg" id="cantidad" name="cantidad" min="1" required>
                                </div>
                            </div>
                            <input type="hidden" name="id_usuario" value="{{ Auth::id() }}">
                            <button type="submit" class="btn btn-primary btn-lg w-100">Solicitar Servicio</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal de éxito -->
<div class="modal fade" id="modalExito">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">¡Éxito!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p id="mensajeExito" class="text-center"></p>
            </div>
        </div>
    </div>
</div>

<!-- Modal de error -->
<div class="modal fade" id="modalError">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Error</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p id="mensajeError" class="text-center"></p>
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
    .hero-section {
        background: linear-gradient(rgba(0, 0, 0, 0.05), rgba(0, 0, 0, 0.05)), url('{{ asset('images/fondo-heroe.jpg') }}');
        background-size: cover;
        background-position: center;
    }

    .feature-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto;
        background: white;
        border-radius: 50%;
        padding: 1rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .contact-section .card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
    }

    .form-control-lg {
        padding: 1rem;
    }

    .input-group-text {
        background-color: #f8f9fa;
        border: 1px solid #ced4da;
    }
</style>
@endsection

@section('scripts')
@vite(['resources/js/datos_contacto.js'])
@endsection