@php
    use Illuminate\Support\Facades\Auth;

    $user = Auth::user();
    $dashboardRoute = route('login'); // Por defecto a login

    if ($user) {
        $rolClave = $user->rol->clave ?? null;

        switch ($rolClave) {
            case 'admin':
                $dashboardRoute = route('dashboard.administrador');
                break;
            case 'estudiante':
                $dashboardRoute = route('dashboard.estudiante');
                break;
            case 'profesortutor':
            case 'profesorsustituto':
                $dashboardRoute = route('dashboard.profesor'); // Si tienes esta ruta
                break;
            default:
                $dashboardRoute = route('dashboard'); // Ruta genérica
                break;
        }
    }
@endphp

    <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>403 - Acceso no autorizado</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
<div class="bg-white p-8 rounded shadow-md text-center max-w-md">
    <h1 class="text-6xl font-bold text-red-600 mb-4">403</h1>
    <h2 class="text-2xl font-semibold mb-6">Acceso no autorizado</h2>
    <p class="mb-6">No tienes permiso para acceder a esta página.</p>
    <a href="{{ $dashboardRoute }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded transition">
        Ir a mi dashboard
    </a>
</div>
</body>
</html>
