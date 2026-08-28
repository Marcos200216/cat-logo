<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'Panel de administración')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,450;9..144,550;9..144,650&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@500&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --tinta: #15171b;
            --tinta-suave: #1d2025;
            --lienzo: #f7f6f2;
            --superficie: #ffffff;
            --borde: #e6e3dc;
            --texto: #1c1e22;
            --texto-tenue: #71757e;
            --pino: #2f5d50;
            --pino-oscuro: #234a40;
            --pino-tinta: #e4eee9;
            --terracota: #a8402f;
            --terracota-tinta: #fbece9;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--lienzo);
            color: var(--texto);
            display: flex;
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        :focus-visible {
            outline: 2px solid var(--pino);
            outline-offset: 2px;
        }

        /* ============ Barra superior (solo mobile) ============ */
        .barra-superior-movil {
            display: none;
            align-items: center;
            gap: 14px;
            padding: 14px 18px;
            background: var(--tinta);
            color: #fff;
            position: sticky;
            top: 0;
            z-index: 30;
        }

        .btn-hamburguesa {
            background: none;
            border: none;
            color: #fff;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            flex-shrink: 0;
        }

        .btn-hamburguesa svg {
            width: 22px;
            height: 22px;
        }

        .barra-superior-movil .marca {
            font-family: 'Fraunces', serif;
            font-weight: 550;
            font-size: 17px;
            letter-spacing: -.01em;
        }

        /* ============ Overlay ============ */
        .overlay-sidebar {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .45);
            z-index: 40;
        }

        .overlay-sidebar.visible {
            display: block;
        }

        /* Sidebar */
        .sidebar {
            width: 246px;
            background: var(--tinta);
            color: #a9adb6;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;

            /* --- Fijar el sidebar al hacer scroll --- */
            position: sticky;
            top: 0;
            height: 100vh;
            align-self: flex-start;
            overflow-y: auto;
            /* por si el nav crece más que la pantalla */
        }

        .sidebar .logo {
            padding: 26px 24px 22px;
            border-bottom: 1px solid rgba(255, 255, 255, .07);
        }

        .sidebar .logo .marca {
            font-family: 'Fraunces', serif;
            font-weight: 550;
            font-size: 19px;
            color: #fff;
            letter-spacing: -.01em;
        }

        .sidebar .logo .sub {
            display: block;
            margin-top: 3px;
            font-size: 10.5px;
            font-weight: 500;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: #6b6f78;
        }

        /* ============ Selector de canal ============ */
        .selector-canal {
            display: flex;
            gap: 4px;
            padding: 14px 24px 4px;
            border-bottom: 1px solid rgba(255, 255, 255, .07);
        }

        .selector-canal form {
            flex: 1;
        }

        .selector-canal button {
            width: 100%;
            background: rgba(255, 255, 255, .04);
            border: 1px solid rgba(255, 255, 255, .08);
            color: #9195a0;
            font-family: 'Inter', sans-serif;
            font-size: 11.5px;
            font-weight: 600;
            letter-spacing: .03em;
            text-transform: uppercase;
            padding: 8px 6px;
            border-radius: 6px;
            cursor: pointer;
            transition: background .15s, color .15s, border-color .15s;
        }

        .selector-canal button:hover {
            color: #fff;
            background: rgba(255, 255, 255, .07);
        }

        .selector-canal button.activo {
            background: var(--pino);
            border-color: var(--pino);
            color: #fff;
        }

        .sidebar nav {
            padding: 18px 0;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            padding: 10px 24px;
            margin: 1px 0;
            color: #9195a0;
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            border-left: 2px solid transparent;
            transition: color .15s, border-color .15s, background .15s;
        }

        .sidebar a:hover {
            color: #fff;
            background: rgba(255, 255, 255, .03);
        }

        .sidebar a.activo {
            color: #fff;
            border-left-color: var(--pino);
            background: rgba(255, 255, 255, .04);
        }

        .sidebar .cerrar-sesion {
            padding: 18px 24px;
            border-top: 1px solid rgba(255, 255, 255, .07);
        }

        .sidebar .cerrar-sesion button {
            background: none;
            border: none;
            color: #71757e;
            font-size: 12.5px;
            font-weight: 500;
            cursor: pointer;
            padding: 0;
            letter-spacing: .01em;
        }

        .sidebar .cerrar-sesion button:hover {
            color: #fff;
        }

        /* Contenido */
        .contenido {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .main {
            padding: 32px;
            flex: 1;
            min-width: 0;
        }

        .alerta-exito {
            background: var(--pino-tinta);
            color: var(--pino-oscuro);
            padding: 11px 16px;
            border-radius: 6px;
            margin-bottom: 18px;
            font-size: 13.5px;
            font-weight: 500;
            border: 1px solid #cfe3d8;
        }

        /* ============ Responsive: sidebar en off-canvas ============ */
        @media (max-width: 900px) {
            body {
                flex-direction: column;
            }

            .barra-superior-movil {
                display: flex;
            }

            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                height: 100vh;
                z-index: 50;
                transform: translateX(-100%);
                transition: transform .25s ease;
                box-shadow: 8px 0 24px rgba(0, 0, 0, .25);
            }

            .sidebar.abierto {
                transform: translateX(0);
            }

            .main {
                padding: 20px 16px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            * {
                transition: none !important;
                animation: none !important;
            }
        }
    </style>

    @stack('estilos')
</head>

<body>

    <div class="barra-superior-movil">
        <button type="button" class="btn-hamburguesa" id="btn-abrir-sidebar" aria-label="Abrir menú"
            aria-expanded="false" aria-controls="sidebar-admin">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
        </button>
        <span class="marca">Catálogo</span>
    </div>

    <div class="overlay-sidebar" id="overlay-sidebar"></div>

    <aside class="sidebar" id="sidebar-admin">
        <div class="logo">
            <span class="marca">Catálogo</span>
            <span class="sub">Panel admin</span>
        </div>

        @php $canalActivo = session('admin_canal', 'normal'); @endphp
        @php
            $redirigirAlCambiarCanal = request()->routeIs('admin.productos.show')
                ? route('admin.productos.index')
                : null;
        @endphp
        <div class="selector-canal">
            <form method="POST" action="{{ route('admin.canal.set') }}">
                @csrf
                <input type="hidden" name="canal" value="normal">
                @if ($redirigirAlCambiarCanal)
                    <input type="hidden" name="redirigir_a" value="{{ $redirigirAlCambiarCanal }}">
                @endif
                <button type="submit" class="{{ $canalActivo === 'normal' ? 'activo' : '' }}">AZUR</button>
            </form>
            <form method="POST" action="{{ route('admin.canal.set') }}">
                @csrf
                <input type="hidden" name="canal" value="mayorista">
                @if ($redirigirAlCambiarCanal)
                    <input type="hidden" name="redirigir_a" value="{{ $redirigirAlCambiarCanal }}">
                @endif
                <button type="submit" class="{{ $canalActivo === 'mayorista' ? 'activo' : '' }}">GUANA</button>
            </form>
        </div>

        <nav>
            <a href="{{ route('admin.dashboard') }}"
                class="{{ request()->routeIs('admin.dashboard') ? 'activo' : '' }}">Inicio</a>
            <a href="{{ route('admin.categorias.index') }}"
                class="{{ request()->routeIs('admin.categorias.*') ? 'activo' : '' }}">Categorías</a>
            <a href="{{ route('admin.subcategorias.index') }}"
                class="{{ request()->routeIs('admin.subcategorias.*') ? 'activo' : '' }}">Subcategorías</a>
            <a href="{{ route('admin.productos.index') }}"
                class="{{ request()->routeIs('admin.productos.*') ? 'activo' : '' }}">Productos</a>
        </nav>
        <div class="cerrar-sesion">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit">Cerrar sesión</button>
            </form>
        </div>
    </aside>

    <div class="contenido">
        <div class="main">
            @if (session('exito'))
                <div class="alerta-exito">{{ session('exito') }}</div>
            @endif
            @yield('contenido')
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var sidebar = document.getElementById('sidebar-admin');
            var overlay = document.getElementById('overlay-sidebar');
            var btnAbrir = document.getElementById('btn-abrir-sidebar');

            function abrirSidebar() {
                sidebar.classList.add('abierto');
                overlay.classList.add('visible');
                btnAbrir.setAttribute('aria-expanded', 'true');
                document.body.style.overflow = 'hidden';
            }

            function cerrarSidebar() {
                sidebar.classList.remove('abierto');
                overlay.classList.remove('visible');
                btnAbrir.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
            }

            btnAbrir.addEventListener('click', abrirSidebar);
            overlay.addEventListener('click', cerrarSidebar);

            // Cierra el sidebar si cambian a un ancho de desktop mientras está abierto
            window.addEventListener('resize', function() {
                if (window.innerWidth > 900) cerrarSidebar();
            });

            // Cierra al hacer click en un link del menú (útil en mobile, una sola vista a la vez)
            sidebar.querySelectorAll('nav a').forEach(function(a) {
                a.addEventListener('click', cerrarSidebar);
            });
        });
    </script>

</body>

</html>
