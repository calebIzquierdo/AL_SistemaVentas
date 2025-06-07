<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Panel Administrativo')</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap5.min.css">

  <link rel="icon" href="{{ asset('logo.ico') }}" type="image/x-icon">

  <!-- Vite CSS personalizados -->
  @vite(['resources/css/plantilla.css', 'resources/css/styles.css'])
 
  
</head>


<body class="bg-body-secondary">

@php use Illuminate\Support\Facades\Auth; @endphp

<div class="wrapper d-flex">
  <!-- Sidebar -->
  <div id="sidebar" class="sidebar d-flex flex-column px-3">
    <h4><i class="bi bi-shop"></i> <span>Confecciones</span></h4>
    <ul class="nav nav-pills flex-column">
      <!-- Enlaces de navegación -->
      <li><a href="{{ route('categorias.index') }}" class="nav-link"><i class="bi bi-tags me-2"></i>Categorías</a></li>
      <li><a href="{{ route('usuarios.index') }}" class="nav-link"><i class="bi bi-people me-2"></i>Usuarios</a></li>
      <li><a href="{{ route('productos.index') }}" class="nav-link"><i class="bi bi-box-seam me-2"></i>Productos</a></li>
      <li><a href="{{ route('login') }}" class="nav-link"><i class="bi bi-question-circle me-2"></i>Login</a></li>
      <li><a href="{{ route('logout') }}" class="nav-link"><i class="bi bi-box-arrow-right me-2"></i>Salir</a></li>
    </ul>
  </div>

  <!-- Main Content -->
  <div class="main flex-grow-1">
    <!-- Navbar -->
    <nav id="navbar" class="navbar px-3 py-2 d-flex justify-content-between align-items-center">
      <button id="toggleSidebar" class="btn btn-outline-secondary btn-sm"><i class="bi bi-list"></i></button>

      <div class="d-flex align-items-center gap-3">
        <i class="bi bi-search"></i>
        <i class="bi bi-bell"></i>
        <i id="darkModeToggle" class="bi bi-moon" style="cursor:pointer;"></i>
        <i id="fullscreenToggle" class="bi bi-arrows-fullscreen" style="cursor:pointer;"></i>

        @if(auth()->check())
        <div class="dropdown">
          <a class="dropdown-toggle text-decoration-none" href="#" role="button" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
            <strong>{{ auth()->user()->nombre }}</strong>
            <small class="text-muted">{{ auth()->user()->tipo->nombre ?? 'Usuario' }}</small>
          </a>
          <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownUser">
            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalPerfil"><i class="bi bi-person-circle me-2"></i>Ver perfil</a></li>
            <li><form action="{{ route('logout') }}" method="POST">@csrf<button class="dropdown-item"><i class="bi bi-box-arrow-right me-2"></i>Cerrar sesión</button></form></li>
          </ul>
        </div>
        @else
        <span>Invitado</span>
        @endif

        <i class="bi bi-gear" id="gearIcon" style="cursor:pointer;"></i>
      </div>
    </nav>

    <!-- Contenido de las vistas -->
    <main class="content p-4">
      @yield('content')
    </main>
  </div>
</div>

<!-- Modal Perfil Usuario -->
<div class="modal fade" id="modalPerfil" tabindex="-1" aria-labelledby="modalPerfilLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Perfil de Usuario</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        @if(auth()->check())
        <ul class="list-group">
          <li class="list-group-item"><strong>Nombre:</strong> {{ auth()->user()->nombre }}</li>
          <li class="list-group-item"><strong>Correo:</strong> {{ auth()->user()->correo }}</li>
          <li class="list-group-item"><strong>Celular:</strong> {{ auth()->user()->celular ?? 'No registrado' }}</li>
          <li class="list-group-item"><strong>Dirección:</strong> {{ auth()->user()->direccion ?? 'No registrada' }}</li>
          <li class="list-group-item"><strong>Tipo de Usuario:</strong> {{ auth()->user()->tipo->nombre ?? 'Usuario' }}</li>
        </ul>
        @else
        <p class="text-muted">No hay sesión activa.</p>
        @endif
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Scripts requeridos -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- DataTables y botones -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>

<!-- Vite -->
@vite(['resources/js/plantilla.js'])

<!-- Scripts específicos de cada vista -->
@yield('scripts')

@yield('modals')

</body>
</html>
