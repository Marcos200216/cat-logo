<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Iniciar sesión</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,450;9..144,550;9..144,650&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --tinta: #15171b;
            --lienzo: #f7f6f2;
            --superficie: #ffffff;
            --borde: #e6e3dc;
            --texto: #1c1e22;
            --texto-tenue: #71757e;
            --pino: #2f5d50;
            --pino-oscuro: #234a40;
            --pino-tinta: #e4eee9;
            --terracota: #a8402f;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--lienzo);
            color: var(--texto);
            min-height: 100vh;
            display: flex;
            -webkit-font-smoothing: antialiased;
        }

        :focus-visible {
            outline: 2px solid var(--pino);
            outline-offset: 2px;
        }

        /* ===== Panel izquierdo (marca) ===== */
        .panel-marca {
            flex: 1;
            background: var(--tinta);
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px;
            position: relative;
            overflow: hidden;
        }

        .panel-marca::before {
            content: '';
            position: absolute;
            top: -120px;
            right: -120px;
            width: 340px;
            height: 340px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(47, 93, 80, .35), transparent 70%);
        }

        .panel-marca::after {
            content: '';
            position: absolute;
            bottom: -160px;
            left: -100px;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(168, 64, 47, .18), transparent 70%);
        }

        .panel-marca .marca {
            font-family: 'Fraunces', serif;
            font-weight: 550;
            font-size: 21px;
            letter-spacing: -.01em;
            position: relative;
            z-index: 1;
        }

        .panel-marca .marca .sub {
            display: block;
            margin-top: 4px;
            font-size: 10.5px;
            font-weight: 500;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: #6b6f78;
            font-family: 'Inter', sans-serif;
        }

        .panel-marca .frase {
            position: relative;
            z-index: 1;
            max-width: 380px;
        }

        .panel-marca .frase h2 {
            font-family: 'Fraunces', serif;
            font-weight: 550;
            font-size: 30px;
            line-height: 1.25;
            letter-spacing: -.01em;
        }

        .panel-marca .frase p {
            margin-top: 12px;
            font-size: 14px;
            color: #9195a0;
            line-height: 1.6;
        }

        .panel-marca .pie {
            position: relative;
            z-index: 1;
            font-size: 12px;
            color: #6b6f78;
        }

        /* ===== Panel derecho (formulario) ===== */
        .panel-formulario {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px;
            min-width: 0;
        }

        .caja-login {
            width: 380px;
            max-width: 100%;
        }

        .caja-login .encabezado {
            margin-bottom: 30px;
        }

        .caja-login .encabezado span.etiqueta {
            display: inline-block;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--pino);
            margin-bottom: 10px;
        }

        .caja-login h1 {
            font-family: 'Fraunces', serif;
            font-weight: 550;
            font-size: 25px;
            letter-spacing: -.01em;
            margin-bottom: 6px;
        }

        .caja-login .encabezado p {
            font-size: 13.5px;
            color: var(--texto-tenue);
        }

        .campo {
            margin-bottom: 18px;
        }

        .campo label {
            display: block;
            font-size: 12.5px;
            font-weight: 600;
            margin-bottom: 7px;
            color: var(--texto);
            letter-spacing: .01em;
        }

        .campo input[type="text"],
        .campo input[type="email"],
        .campo input[type="password"] {
            width: 100%;
            padding: 10px 13px;
            border: 1px solid var(--borde);
            border-radius: 6px;
            font-size: 13.5px;
            font-family: 'Inter', sans-serif;
            background: var(--superficie);
            transition: border-color .15s, box-shadow .15s;
            /* evita zoom automático en iOS al enfocar el input */
            font-size: max(13.5px, 16px);
        }

        .campo input:focus {
            outline: none;
            border-color: var(--pino);
            box-shadow: 0 0 0 3px var(--pino-tinta);
        }

        .fila-opciones {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .campo-checkbox {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--texto-tenue);
            cursor: pointer;
        }

        .campo-checkbox input {
            width: auto;
            accent-color: var(--pino);
            cursor: pointer;
        }

        .btn-entrar {
            width: 100%;
            padding: 11px;
            background: var(--pino);
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 13.5px;
            font-weight: 600;
            letter-spacing: .01em;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: background .15s;
        }

        .btn-entrar:hover {
            background: var(--pino-oscuro);
        }

        .btn-entrar:active {
            background: var(--pino-oscuro);
        }

        /* ===== Responsive ===== */

        /* Tablet: se reduce el panel de marca en vez de ocultarlo de golpe */
        @media (max-width: 980px) {
            .panel-marca {
                padding: 36px;
            }

            .panel-marca .frase h2 {
                font-size: 25px;
            }
        }

        /* Mobile grande / tablet vertical: ocultamos el panel de marca */
        @media (max-width: 760px) {
            .panel-marca {
                display: none;
            }

            .panel-formulario {
                padding: 24px;
                align-items: flex-start;
                padding-top: 64px;
            }

            .caja-login {
                width: 100%;
                max-width: 420px;
            }
        }

        /* Mobile pequeño */
        @media (max-width: 420px) {
            .panel-formulario {
                padding: 20px;
                padding-top: 48px;
            }

            .caja-login h1 {
                font-size: 21px;
            }

            .caja-login .encabezado {
                margin-bottom: 24px;
            }

            .campo {
                margin-bottom: 15px;
            }
        }

        /* Pantallas muy bajas en horizontal (móvil acostado) */
        @media (max-height: 480px) and (orientation: landscape) {
            .panel-marca {
                display: none;
            }

            .panel-formulario {
                align-items: center;
                padding-top: 24px;
                padding-bottom: 24px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            * {
                transition: none !important;
            }
        }
    </style>
</head>

<body>

    <div class="panel-marca">
        <div class="marca">
            Catálogo
            <span class="sub">Panel admin</span>
        </div>
        <div class="frase">
            <h2>Gestiona tu catálogo con orden y claridad.</h2>
            <p>Categorías, subcategorías, productos e inventario, todo desde un mismo lugar.</p>
        </div>
        <div class="pie">&copy; {{ date('Y') }} By M&M TECH</div>
    </div>

    <div class="panel-formulario">
        <div class="caja-login">
            <div class="encabezado">
                <span class="etiqueta">Acceso restringido</span>
                <h1>Iniciar sesión</h1>
                <p>Ingresa tus credenciales para continuar.</p>
            </div>

            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf

                <div class="campo">
                    <label>Usuario</label>
                    <input type="text" name="email" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="campo">
                    <label>Contraseña</label>
                    <input type="password" name="password" required>
                </div>

                <div class="fila-opciones">
                    <label class="campo-checkbox">
                        <input type="checkbox" name="recordarme" id="recordarme">
                        Recordarme
                    </label>
                </div>

                <button type="submit" class="btn-entrar">Entrar</button>
            </form>
        </div>
    </div>

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'No se pudo iniciar sesión',
                text: '{{ $errors->first() }}',
                confirmButtonColor: '#2f5d50',
            });
        </script>
    @endif

</body>

</html>
