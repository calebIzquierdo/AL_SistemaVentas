<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Panel Administrativo')</title>
  

  <!-- Bootstrap y Bootstrap Icons -->
  <link rel="icon" href="{{ asset('logo.ico') }}" type="image/x-icon">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <!-- DataTables + Botones -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap5.min.css">

  <!-- Estilos personalizados -->
  @vite(['resources/css/plantilla.css', 'resources/css/styles.css'])

</head>
<body class="bg-body-secondary">
  @php use Illuminate\Support\Facades\Auth; @endphp

<div class="wrapper d-flex">
  <!-- Sidebar -->
  <div id="sidebar" class="sidebar d-flex flex-column px-3">
    <h4><i class="bi bi-shop"></i> <span>Confecciones</span></h4>
    <ul class="nav nav-pills flex-column">
  <li>
    <a href="" class="nav-link">
      <i class="bi bi-speedometer2 me-2"></i>
      <span class="link-text">Dashboard</span>
    </a>
  </li>
  <li>
    <a href="{{ route('categorias.index') }}" class="nav-link">
      <i class="bi bi-tags me-2"></i>
      <span class="link-text">Categorías</span>
    </a>
  </li>
  <li>
    <a href="{{ route('usuarios.index') }}" class="nav-link">
      <i class="bi bi-people me-2"></i>
      <span class="link-text">Usuarios</span>
    </a>
  </li>
  <li>
    <a href="{{ route('productos.index') }}" class="nav-link">
      <i class="bi bi-box-seam me-2"></i>
      <span class="link-text">Productos</span>
    </a>
  </li>
  <li>
    <a href="" class="nav-link">
      <i class="bi bi-cart4 me-2"></i>
      <span class="link-text">Ventas</span>
    </a>
  </li>
  <li>
    <a href="" class="nav-link">
      <i class="bi bi-graph-up me-2"></i>
      <span class="link-text">Reportes</span>
    </a>
  </li>

  <li class="slide has-sub">
    <a href="#" class="nav-link toggle-submenu d-flex align-items-center justify-content-between">
      <span>
        <i class="bi bi-gear me-2"></i>
        <span class="link-text">Configuración</span>
      </span>
      <i class="bi bi-chevron-down"></i>
    </a>
    <ul class="slide-menu child1 submenu">
      <li><a href="#" class="nav-link"><span class="link-text">General</span></a></li>
      <li><a href="#" class="nav-link"><span class="link-text">Permisos</span></a></li>
      <li><a href="#" class="nav-link"><span class="link-text">Aplicación</span></a></li>
      <li><a href="#" class="nav-link"><span class="link-text">Apariencia</span></a></li>
    </ul>
  </li>

  <li>
    <a href="{{ route('login') }}" class="nav-link">
      <i class="bi bi-question-circle me-2"></i>
      <span class="link-text">Login</span>
    </a>
  </li>
  <li>
    <a href="{{ route('logout') }}" class="nav-link">
      <i class="bi bi-box-arrow-right me-2"></i>
      <span class="link-text">Salir</span>
    </a>
  </li>
</ul>

  </div>

  <!-- Main Content -->
  <div class="main flex-grow-1">
    <!-- Navbar -->
    <nav id="navbar" class="navbar px-3 py-2 d-flex justify-content-between align-items-center">
      <div>
        <button id="toggleSidebar" class="btn btn-outline-secondary btn-sm">
          <i id="toggleIcon" class="bi bi-list"></i>
        </button>
      </div>
      <div class="d-flex align-items-center gap-3">
        <i class="bi bi-search"></i>
        <i class="bi bi-bell"></i>
        <i id="darkModeToggle" class="bi bi-moon" style="cursor:pointer;"></i>
        <i id="fullscreenToggle" class="bi bi-arrows-fullscreen" style="cursor:pointer;"></i>
        @if(auth()->check())
          <div class="dropdown">
            <a class="d-flex flex-column align-items-start text-end text-decoration-none dropdown-toggle" href="#" role="button" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
              <strong>{{ auth()->user()->nombre }}</strong>
              <small class="text-muted">{{ auth()->user()->tipo->nombre ?? 'Usuario' }}</small>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownUser">
              <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalPerfil"><i class="bi bi-person-circle"></i>
                Ver perfil</a>

              <li>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                  @csrf
                  <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right"></i>
                    Cerrar sesión</button>
                </form>
              </li>
            </ul>
          </div>
        @else
          <span>Invitado</span>
        @endif



        <i class="bi bi-gear" id="gearIcon" style="cursor:pointer;"></i>
      </div>
    </nav>

    <!-- Contenido -->
    <main class="content p-4">
      @yield('content')
    </main>
  </div>
</div>

<!-- Panel de Colores -->
<div id="colorSettings">
  <h6>Sidebar - Degradados</h6>
  <div class="color-palette">
    @foreach ([['#f093fb','#f5576c'], ['#43e97b','#38f9d7'], ['#a8edea','#fed6e3'], ['#667eea','#764ba2'], ['#89f7fe','#66a6ff'], ['#f6d365','#fda085']] as $colors)
      <button onclick="setGradient('sidebar','{{ $colors[0] }}','{{ $colors[1] }}')" style="background: linear-gradient(to bottom, {{ $colors[0] }}, {{ $colors[1] }});"></button>
    @endforeach
  </div>
  <button onclick="restoreDefault('sidebar')" class="btn btn-outline-danger btn-sm mb-3">Restaurar Sidebar</button>

  <h6>Navbar - Degradados</h6>
  <div class="color-palette">
    @foreach ([['#f093fb','#f5576c'], ['#43e97b','#38f9d7'], ['#a8edea','#fed6e3'], ['#667eea','#764ba2'], ['#89f7fe','#66a6ff'], ['#f6d365','#fda085']] as $colors)
      <button onclick="setGradient('navbar','{{ $colors[0] }}','{{ $colors[1] }}')" style="background: linear-gradient(to right, {{ $colors[0] }}, {{ $colors[1] }});"></button>
    @endforeach
  </div>
  <button onclick="restoreDefault('navbar')" class="btn btn-outline-danger btn-sm">Restaurar Navbar</button>
</div>

<!-- Modal Perfil Usuario -->
<div class="modal fade" id="modalPerfil" tabindex="-1" aria-labelledby="modalPerfilLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalPerfilLabel">Perfil de Usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
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

<!-- DataTables + Botones JS -->
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

<!-- Scripts adicionales -->
@yield('scripts')

</body>
</html>
