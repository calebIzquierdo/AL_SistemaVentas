
# 🛍️ Sistema Web de Ventas de Ropa Deportiva

Proyecto desarrollado en Laravel 12 que permite gestionar la venta de productos deportivos mediante un sistema web moderno, modular y escalable.

## 📦 Requisitos del Sistema

- PHP 
- Composer  
- Laravel 12  
- MySQL 
- Node.js 
- Git  
- Xampp
- Visual Studio Code 

## ⚙️ Instalación del Proyecto

```bash
# Clona el repositorio
git clone https://github.com/calebIzquierdo/AL_SistemaVentas.git
cd tienda-deportiva

# Instala dependencias PHP
composer install


# Genera la clave de la aplicación
php artisan key:generate

# Configura tus credenciales en el archivo .env (base de datos, etc.)

# Ejecuta migraciones
php artisan migrate

# Opcional: ejecuta seeders si los hay
php artisan db:seed

# Instala dependencias frontend
npm install && npm run dev

# Inicia el servidor de desarrollo
php artisan serve
```

## 🧪 Pruebas

Para ejecutar las pruebas unitarias:

```bash
php artisan test
```

> Se utiliza PHPUnit para las pruebas automatizadas. Los archivos se encuentran en `/tests/`.


```

## 👥 Convenciones del Proyecto

- MVC estricto: separación clara entre lógica, datos y vistas.
- Estilo de código: PSR-12, con validaciones estáticas (`phpstan`, `phpcs`).
- Vistas: Blade templates en español, nombres en `snake_case`.
- Control de versiones: Git con ramas por desarrollador.
  - main: versión estable y productiva.
  - develop: integración de funcionalidades antes del pase a producción.
  - juan-registro, laura-carrito, etc.: ramas individuales por funcionalidad.



## 📌 Autoridad del Proyecto

- Lider Tecnico técnico: Caleb Izquierdo
- Fecha de inicio: 07/05/2025
