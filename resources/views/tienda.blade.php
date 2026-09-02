<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'AZUR')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,500;0,9..144,600;1,9..144,400;1,9..144,500&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --crudo: #FAF8F3;
            --tinta: #1A1A18;
            --musgo: #4B5D3F;
            --arena: #B8AF9E;
            --blanco: #FFFFFF;
            --whatsapp: #25D366;
            --whatsapp-oscuro: #128C7E;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--crudo);
            color: var(--tinta);
            -webkit-font-smoothing: antialiased;
        }

        h1,
        h2,
        h3,
        .serif {
            font-family: 'Fraunces', serif;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        img {
            display: block;
            max-width: 100%;
        }

        button {
            font-family: inherit;
            cursor: pointer;
        }

        :focus-visible {
            outline: 2px solid var(--musgo);
            outline-offset: 3px;
        }

        @media (prefers-reduced-motion: reduce) {
            * {
                animation: none !important;
                transition: none !important;
            }
        }

        /* ============ Header ============ */
        .cabecera {
            position: sticky;
            top: 0;
            z-index: 50;
            background: rgba(26, 26, 24, 0.96);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid rgba(250, 248, 243, 0.08);
        }

        .cabecera-interior {
            max-width: 1240px;
            margin: 0 auto;
            padding: 14px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .marca {
            display: flex;
            align-items: center;
            flex-shrink: 1;
            min-width: 0;
        }

        .marca img {
            height: 76px;
            width: auto;
            flex-shrink: 0;
        }

        .marca .marca-texto {
            display: flex;
            flex-direction: column;
            line-height: 1;
            margin-left: 14px;
            padding-left: 14px;
            border-left: 1px solid rgba(250, 248, 243, 0.2);
            min-width: 0;
            overflow: hidden;
        }

        .marca .marca-texto .marca-nombre {
            font-family: 'Fraunces', serif;
            font-size: 21px;
            font-weight: 600;
            letter-spacing: 0.01em;
            white-space: nowrap;
            color: var(--crudo);
        }

        .marca .marca-texto .marca-lema {
            font-family: 'Inter', sans-serif;
            font-size: 10.5px;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--crudo);
            opacity: 0.75;
            margin-top: 4px;
            white-space: nowrap;
        }

        @media (max-width: 480px) {
            .marca img {
                height: 100px;
            }

            .marca .marca-texto {
                margin-left: 10px;
                padding-left: 10px;
            }

            .marca .marca-texto .marca-nombre {
                font-size: 16px;
            }

            .marca .marca-texto .marca-lema {
                font-size: 8.5px;
            }
        }

        .nav-principal {
            display: flex;
            align-items: center;
            gap: 30px;
            flex-wrap: nowrap;
            min-width: 0;
        }

        .nav-enlaces {
            display: flex;
            align-items: center;
            gap: 26px;
            overflow-x: auto;
            scrollbar-width: none;
            -ms-overflow-style: none;
            -webkit-overflow-scrolling: touch;
        }

        .nav-enlaces::-webkit-scrollbar {
            display: none;
        }

        .nav-enlaces a {
            font-size: 13px;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: var(--crudo);
            opacity: 0.75;
            padding: 4px 0;
            border-bottom: 1px solid transparent;
            white-space: nowrap;
        }

        .nav-enlaces a:hover,
        .nav-enlaces a.activo {
            opacity: 1;
            border-bottom-color: var(--musgo);
        }

        .btn-whatsapp-nav {
            position: relative;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(135deg, #2CD46A, #22B85A);
            color: #FFFFFF;
            padding: 8px 20px 8px 8px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            border-radius: 999px;
            flex-shrink: 0;
            box-shadow: 0 4px 14px -4px rgba(37, 211, 102, 0.55);
            transition: box-shadow 0.25s ease, transform 0.25s ease, background 0.25s ease;
        }

        .btn-whatsapp-nav:hover {
            background: linear-gradient(135deg, #25D366, #1EA952);
            box-shadow: 0 6px 18px -4px rgba(37, 211, 102, 0.7);
            transform: translateY(-1px);
        }

        .btn-whatsapp-nav:active {
            transform: translateY(0);
        }

        .btn-whatsapp-nav .icono-wsp {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            background: #FFFFFF;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .btn-whatsapp-nav svg {
            width: 17px;
            height: 17px;
            display: block;
            color: #22B85A;
        }

        /* Botón hamburguesa (solo mobile) */
        .btn-hamburguesa {
            display: none;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 5px;
            width: 44px;
            height: 44px;
            background: none;
            border: none;
            flex-shrink: 0;
        }

        .btn-hamburguesa span {
            display: block;
            width: 22px;
            height: 1.5px;
            background: var(--crudo);
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        .btn-hamburguesa[aria-expanded="true"] span:nth-child(1) {
            transform: translateY(6.5px) rotate(45deg);
        }

        .btn-hamburguesa[aria-expanded="true"] span:nth-child(2) {
            opacity: 0;
        }

        .btn-hamburguesa[aria-expanded="true"] span:nth-child(3) {
            transform: translateY(-6.5px) rotate(-45deg);
        }

        /* Menú off-canvas mobile */
        .menu-movil {
            position: fixed;
            inset: 0;
            z-index: 60;
            visibility: hidden;
        }

        .menu-movil-fondo {
            position: absolute;
            inset: 0;
            background: rgba(26, 26, 24, 0.45);
            opacity: 0;
            transition: opacity 0.35s ease;
        }

        .menu-movil-panel {
            position: absolute;
            top: 0;
            right: 0;
            height: 100%;
            width: min(320px, 84vw);
            background: var(--crudo);
            padding: 20px 26px 32px;
            display: flex;
            flex-direction: column;
            transform: translateX(100%);
            transition: transform 0.4s cubic-bezier(0.2, 0.8, 0.2, 1);
            box-shadow: -18px 0 40px -20px rgba(26, 26, 24, 0.35);
        }

        .menu-movil.abierto {
            visibility: visible;
        }

        .menu-movil.abierto .menu-movil-fondo {
            opacity: 1;
        }

        .menu-movil.abierto .menu-movil-panel {
            transform: translateX(0);
        }

        .menu-movil-cerrar {
            align-self: flex-end;
            width: 44px;
            height: 44px;
            background: none;
            border: none;
            font-size: 26px;
            line-height: 1;
            color: var(--tinta);
        }

        .menu-movil-enlaces {
            display: flex;
            flex-direction: column;
            margin-top: 12px;
        }

        .menu-movil-enlaces a {
            padding: 15px 4px;
            font-family: 'Fraunces', serif;
            font-size: 19px;
            border-bottom: 1px solid rgba(26, 26, 24, 0.08);
        }

        .menu-movil .btn-whatsapp-nav {
            margin-top: 24px;
            justify-content: center;
            padding: 14px 18px;
        }

        @media (max-width: 880px) {
            .nav-principal {
                display: none;
            }

            .btn-hamburguesa {
                display: flex;
            }
        }

        @media (min-width: 881px) {
            .menu-movil {
                display: none;
            }
        }

        /* ============ Botón flotante de ayuda ("¿Cómo funciona?") ============ */
        .btn-ayuda-flotante {
            position: fixed;
            left: 20px;
            bottom: 20px;
            z-index: 55;
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: var(--tinta);
            color: var(--crudo);
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Fraunces', serif;
            font-style: italic;
            font-size: 22px;
            box-shadow: 0 10px 26px -8px rgba(26, 26, 24, 0.5);
            transition: transform 0.25s ease, background 0.25s ease, box-shadow 0.25s ease;
        }

        .btn-ayuda-flotante:hover {
            background: var(--musgo);
            transform: translateY(-2px);
            box-shadow: 0 14px 30px -8px rgba(26, 26, 24, 0.55);
        }

        .btn-ayuda-flotante:active {
            transform: translateY(0);
        }

        @media (max-width: 480px) {
            .btn-ayuda-flotante {
                width: 46px;
                height: 46px;
                font-size: 19px;
                left: 16px;
                bottom: 16px;
            }
        }

        /* ============ Modal "Cómo funciona" ============ */
        .modal-ayuda {
            position: fixed;
            inset: 0;
            z-index: 70;
            visibility: hidden;
        }

        .modal-ayuda-fondo {
            position: absolute;
            inset: 0;
            background: rgba(26, 26, 24, 0.5);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .modal-ayuda-caja {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -46%);
            background: var(--crudo);
            width: min(440px, 90vw);
            max-height: 86vh;
            overflow-y: auto;
            padding: 34px 30px 30px;
            border-radius: 4px;
            opacity: 0;
            transition: opacity 0.3s ease, transform 0.3s ease;
            box-shadow: 0 30px 60px -20px rgba(26, 26, 24, 0.4);
        }

        .modal-ayuda.abierto {
            visibility: visible;
        }

        .modal-ayuda.abierto .modal-ayuda-fondo {
            opacity: 1;
        }

        .modal-ayuda.abierto .modal-ayuda-caja {
            opacity: 1;
            transform: translate(-50%, -50%);
        }

        .modal-ayuda-cerrar {
            position: absolute;
            top: 12px;
            right: 12px;
            width: 38px;
            height: 38px;
            background: none;
            border: none;
            font-size: 24px;
            line-height: 1;
            color: var(--tinta);
            opacity: 0.6;
        }

        .modal-ayuda-cerrar:hover {
            opacity: 1;
        }

        .modal-ayuda-encabezado {
            margin-bottom: 6px;
        }

        .modal-ayuda-encabezado .ojo-eyebrow {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 11px;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--musgo);
            font-weight: 600;
            margin-bottom: 8px;
        }

        .modal-ayuda-encabezado .ojo-eyebrow::before {
            content: '';
            width: 20px;
            height: 1px;
            background: var(--musgo);
        }

        .modal-ayuda-encabezado h3 {
            font-size: 22px;
            font-weight: 500;
        }

        .modal-ayuda-pasos {
            margin-top: 26px;
            display: flex;
            flex-direction: column;
            gap: 22px;
        }

        .modal-ayuda-paso {
            display: flex;
            gap: 16px;
            align-items: flex-start;
        }

        .modal-ayuda-paso .numero-paso {
            flex-shrink: 0;
            font-family: 'Fraunces', serif;
            font-style: italic;
            font-size: 22px;
            color: var(--musgo);
            line-height: 1.3;
        }

        .modal-ayuda-paso h4 {
            font-size: 14.5px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .modal-ayuda-paso p {
            font-size: 13px;
            color: var(--tinta);
            opacity: 0.68;
            line-height: 1.55;
        }

        .modal-ayuda-cta {
            margin-top: 28px;
            padding-top: 22px;
            border-top: 1px solid rgba(26, 26, 24, 0.08);
        }

        .modal-ayuda-cta a {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 12.5px;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: var(--musgo);
            font-weight: 600;
        }

        .modal-ayuda-cta a:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .modal-ayuda-caja {
                padding: 28px 22px 24px;
            }
        }

        /* ============ Modal selector de WhatsApp ============ */
        .modal-selector-wsp .modal-ayuda-caja {
            padding: 30px 26px 26px;
        }

        .modal-selector-wsp .modal-ayuda-encabezado p {
            margin-top: 6px;
            font-size: 13px;
            color: var(--tinta);
            opacity: 0.62;
            line-height: 1.5;
        }

        .selector-wsp-lista {
            margin-top: 24px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .selector-wsp-item {
            display: flex;
            align-items: center;
            gap: 14px;
            width: 100%;
            padding: 13px 14px;
            background: var(--blanco);
            border: 1px solid rgba(26, 26, 24, 0.08);
            border-radius: 8px;
            text-align: left;
            cursor: pointer;
            transition: border-color 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
        }

        .selector-wsp-item:hover {
            border-color: rgba(37, 211, 102, 0.4);
            transform: translateY(-1px);
            box-shadow: 0 8px 18px -10px rgba(26, 26, 24, 0.25);
        }

        .selector-wsp-item:active {
            transform: translateY(0);
        }

        .selector-wsp-avatar {
            flex-shrink: 0;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, #2CD46A, #22B85A);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .selector-wsp-avatar svg {
            width: 20px;
            height: 20px;
            color: #FFFFFF;
        }

        .selector-wsp-info {
            flex: 1;
            min-width: 0;
        }

        .selector-wsp-nombre {
            font-family: 'Fraunces', serif;
            font-size: 15px;
            color: var(--tinta);
        }

        .selector-wsp-sub {
            font-size: 11.5px;
            color: var(--tinta);
            opacity: 0.5;
            margin-top: 1px;
        }

        .selector-wsp-flecha {
            flex-shrink: 0;
            width: 16px;
            height: 16px;
            color: var(--arena);
            transition: transform 0.2s ease;
        }

        .selector-wsp-item:hover .selector-wsp-flecha {
            transform: translateX(3px);
            color: var(--musgo);
        }

        @media (max-width: 480px) {
            .modal-selector-wsp .modal-ayuda-caja {
                padding: 26px 20px 22px;
            }
        }

        /* ============ Footer ============ */
        .pie {
            background: var(--tinta);
            color: var(--crudo);
            margin-top: 80px;
            padding: 40px 24px 28px;
        }

        .pie-interior {
            max-width: 1200px;
            margin: 0 auto;
        }

        .pie-columnas {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            align-items: start;
            padding-bottom: 24px;
        }

        /* Columna izquierda: horario */
        .pie-horario .ojo-eyebrow {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 10.5px;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--arena);
            font-weight: 600;
            margin-bottom: 10px;
        }

        .pie-horario .ojo-eyebrow::before {
            content: '';
            width: 18px;
            height: 1px;
            background: var(--arena);
        }

        .pie-horario-dias {
            font-family: 'Fraunces', serif;
            font-size: 16px;
            color: var(--crudo);
        }

        .pie-horario-horas {
            font-size: 12.5px;
            color: var(--arena);
            margin-top: 3px;
        }

        /* Columna derecha: redes sociales */
        .pie-redes {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .pie-redes .ojo-eyebrow {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 10.5px;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--arena);
            font-weight: 600;
            margin-bottom: 12px;
        }

        .pie-redes .ojo-eyebrow::after {
            content: '';
            width: 18px;
            height: 1px;
            background: var(--arena);
        }

        .pie-redes-iconos {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .pie-redes-iconos a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            flex-shrink: 0;
            transition: transform 0.25s ease;
        }

        .pie-redes-iconos a:hover {
            transform: translateY(-2px);
        }

        .pie-redes-iconos a.icono-facebook {
            background: #1877F2;
            color: #FFFFFF;
            width: 32px;
            height: 32px;
        }

        .pie-redes-iconos a.icono-facebook svg {
            width: 11px;
            height: 17px;
        }

        .pie-redes-iconos a.icono-instagram svg {
            fill: url(#gradienteInstagram);
            width: 26px;
            height: 26px;
        }

        .pie-redes-iconos .icono-whatsapp {
            color: #25D366;
            background: none;
            border: none;
            cursor: pointer;
        }

        .pie-redes-iconos .icono-whatsapp svg {
            width: 26px;
            height: 26px;
        }

        .pie-redes-iconos svg {
            width: 17px;
            height: 17px;
        }

        /* Fila inferior: marca + nota legal */
        .pie-base {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            padding-top: 20px;
            border-top: 1px solid rgba(250, 248, 243, 0.12);
        }

        .pie-marca {
            font-family: 'Fraunces', serif;
            font-size: 15px;
            color: var(--crudo);
        }

        .pie-nota {
            font-size: 11.5px;
            color: var(--arena);
            letter-spacing: 0.02em;
        }

        @media (max-width: 400px) {
            .pie-redes-iconos {
                gap: 8px;
            }

            .pie-redes-iconos a {
                width: 34px;
                height: 34px;
            }

            .pie-redes-iconos svg {
                width: 15px;
                height: 15px;
            }
        }

        /* ============ Botón flotante del carrito ============ */
        .btn-carrito-flotante {
            position: fixed;
            right: 20px;
            bottom: 20px;
            z-index: 55;
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: var(--tinta);
            color: var(--crudo);
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 26px -8px rgba(26, 26, 24, 0.5);
            transition: transform 0.25s ease, background 0.25s ease, box-shadow 0.25s ease;
        }

        .btn-carrito-flotante svg {
            width: 22px;
            height: 22px;
        }

        .btn-carrito-flotante:hover {
            background: var(--musgo);
            transform: translateY(-2px);
            box-shadow: 0 14px 30px -8px rgba(26, 26, 24, 0.55);
        }

        .btn-carrito-flotante:active {
            transform: translateY(0);
        }

        .badge-carrito {
            position: absolute;
            top: -4px;
            right: -4px;
            min-width: 20px;
            height: 20px;
            padding: 0 5px;
            border-radius: 999px;
            background: var(--musgo);
            color: var(--crudo);
            font-size: 11px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 0 2px var(--crudo);
        }

        .badge-carrito.oculto {
            display: none;
        }

        @media (max-width: 480px) {
            .btn-carrito-flotante {
                width: 46px;
                height: 46px;
                right: 16px;
                bottom: 16px;
            }

            .btn-carrito-flotante svg {
                width: 19px;
                height: 19px;
            }
        }

        /* ============ Modal del carrito ============ */
        .modal-carrito {
            position: fixed;
            inset: 0;
            z-index: 70;
            visibility: hidden;
        }

        .modal-carrito-fondo {
            position: absolute;
            inset: 0;
            background: rgba(26, 26, 24, 0.5);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .modal-carrito-caja {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -46%);
            background: var(--crudo);
            width: min(480px, 92vw);
            max-height: 86vh;
            overflow-y: auto;
            padding: 30px 26px 26px;
            border-radius: 4px;
            opacity: 0;
            transition: opacity 0.3s ease, transform 0.3s ease;
            box-shadow: 0 30px 60px -20px rgba(26, 26, 24, 0.4);
        }

        .modal-carrito.abierto {
            visibility: visible;
        }

        .modal-carrito.abierto .modal-carrito-fondo {
            opacity: 1;
        }

        .modal-carrito.abierto .modal-carrito-caja {
            opacity: 1;
            transform: translate(-50%, -50%);
        }

        .modal-carrito-cerrar {
            position: absolute;
            top: 12px;
            right: 12px;
            width: 38px;
            height: 38px;
            background: none;
            border: none;
            font-size: 24px;
            line-height: 1;
            color: var(--tinta);
            opacity: 0.6;
        }

        .modal-carrito-cerrar:hover {
            opacity: 1;
        }

        .modal-carrito-encabezado h3 {
            font-size: 20px;
            font-weight: 500;
        }

        .carrito-lista {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            gap: 14px;
            max-height: 46vh;
            overflow-y: auto;
        }

        .carrito-item {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            justify-content: space-between;
            padding-bottom: 14px;
            border-bottom: 1px solid rgba(26, 26, 24, 0.08);
        }

        .carrito-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .carrito-item-info {
            flex: 1;
            min-width: 0;
        }

        .carrito-item-nombre {
            font-family: 'Fraunces', serif;
            font-size: 14.5px;
        }

        .carrito-item-detalle {
            font-size: 12px;
            color: var(--tinta);
            opacity: 0.6;
            margin-top: 2px;
        }

        .carrito-item-acciones {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 8px;
            flex-shrink: 0;
        }

        .carrito-cantidad-control {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .carrito-cantidad-control button {
            width: 24px;
            height: 24px;
            border: 1px solid rgba(26, 26, 24, 0.2);
            background: none;
            border-radius: 2px;
            font-size: 13px;
            line-height: 1;
            color: var(--tinta);
        }

        .carrito-cantidad-control span {
            font-size: 13px;
            min-width: 16px;
            text-align: center;
        }

        .carrito-item-quitar {
            font-size: 11px;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: #a4423a;
            opacity: 0.75;
            background: none;
            border: none;
        }

        .carrito-item-quitar:hover {
            opacity: 1;
            text-decoration: underline;
        }

        .carrito-vacio {
            margin-top: 24px;
            text-align: center;
            font-size: 13px;
            color: var(--arena);
            padding: 20px 0;
        }

        .carrito-pie {
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid rgba(26, 26, 24, 0.08);
        }

        .btn-enviar-carrito {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            width: 100%;
            padding: 14px 20px;
            background: var(--tinta);
            color: var(--crudo);
            font-size: 12.5px;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            border-radius: 2px;
            border: none;
        }

        .btn-enviar-carrito:hover {
            background: var(--musgo);
        }

        .btn-enviar-carrito svg {
            width: 16px;
            height: 16px;
        }

        .btn-enviar-carrito:disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        @media (max-width: 480px) {
            .modal-carrito-caja {
                padding: 26px 20px 22px;
            }
        }

        /* ============ Toast de confirmación ============ */
        .toast-carrito {
            position: fixed;
            bottom: 84px;
            right: 20px;
            z-index: 65;
            background: var(--tinta);
            color: var(--crudo);
            padding: 12px 18px;
            border-radius: 4px;
            font-size: 13px;
            box-shadow: 0 12px 26px -10px rgba(26, 26, 24, 0.5);
            opacity: 0;
            transform: translateY(8px);
            transition: opacity 0.3s ease, transform 0.3s ease;
            pointer-events: none;
        }

        .toast-carrito.visible {
            opacity: 1;
            transform: translateY(0);
        }

        @media (max-width: 480px) {
            .toast-carrito {
                right: 16px;
                bottom: 76px;
            }
        }

        .carrito-cantidad-fija {
            font-size: 13px;
            font-weight: 600;
            color: var(--tinta);
        }
    </style>

    @stack('estilos')
</head>

<body>

    @php
        $modo = $modo ?? 'normal';
        $prefijo = $modo === 'mayorista' ? 'mayorista' : 'tienda';
        $esMayorista = $modo === 'mayorista';

        $facebookUrl = $esMayorista ? config('app.facebook_url_mayorista') : config('app.facebook_url');
        $instagramUrl = $esMayorista ? config('app.instagram_url_mayorista') : config('app.instagram_url');
        $whatsappMayorista = config('app.whatsapp_mayorista');
    @endphp

    <header class="cabecera">
        <div class="cabecera-interior">
            <a href="{{ route($prefijo . '.home') }}" class="marca">
                <img src="{{ asset($modo === 'mayorista' ? 'images/logo-mayorista.png' : 'images/logo.png') }}"
                    alt="AZUR" onerror="this.style.display='none';">
                <span class="marca-texto">
                    <span class="marca-nombre">{{ $modo === 'mayorista' ? 'GUANA' : 'AZUR' }}</span>
                    <span
                        class="marca-lema">{{ $modo === 'mayorista' ? 'Pedidos al por mayor' : 'Hasta tu casa' }}</span>
                </span>
            </a>

            <nav class="nav-principal" aria-label="Navegación principal">
                <div class="nav-enlaces">
                    <a href="{{ route($prefijo . '.home') }}"
                        class="{{ request()->routeIs($prefijo . '.home') ? 'activo' : '' }}">Inicio</a>
                    @foreach ($categoriasNav ?? [] as $cat)
                        <a href="{{ route($prefijo . '.categoria', $cat->slug) }}"
                            class="{{ request()->routeIs($prefijo . '.categoria') && request()->route('slug') === $cat->slug ? 'activo' : '' }}">
                            {{ $cat->nombre }}
                        </a>
                    @endforeach
                </div>

                @if ($esMayorista)
                    <button type="button" class="btn-whatsapp-nav" data-abrir-selector-wsp>
                        <span class="icono-wsp">
                            <svg viewBox="0 0 32 32" fill="currentColor">
                                <path
                                    d="M16.001 3C9.096 3 3.5 8.596 3.5 15.5c0 2.2.57 4.35 1.66 6.24L3 29l7.42-2.11a12.44 12.44 0 0 0 5.58 1.33h.01c6.9 0 12.5-5.6 12.5-12.5S22.9 3 16.001 3zm0 22.55h-.01a10.4 10.4 0 0 1-5.3-1.45l-.38-.22-3.94 1.12 1.15-3.83-.25-.4a10.36 10.36 0 0 1-1.6-5.53c0-5.74 4.67-10.4 10.42-10.4 2.78 0 5.4 1.08 7.36 3.05a10.32 10.32 0 0 1 3.05 7.36c0 5.74-4.67 10.4-10.5 10.4zm5.72-7.75c-.31-.16-1.86-.92-2.15-1.02-.29-.1-.5-.16-.71.16-.21.31-.81 1.02-.99 1.23-.18.21-.37.24-.68.08-.31-.16-1.31-.48-2.5-1.55-.92-.82-1.55-1.83-1.73-2.14-.18-.31-.02-.48.14-.63.14-.14.31-.37.47-.55.16-.18.21-.31.31-.52.1-.21.05-.39-.02-.55-.08-.16-.71-1.71-.97-2.34-.26-.61-.52-.53-.71-.54-.18-.01-.39-.01-.6-.01s-.55.08-.84.39c-.29.31-1.1 1.08-1.1 2.63s1.13 3.05 1.29 3.26c.16.21 2.22 3.39 5.38 4.75.75.32 1.34.51 1.8.66.76.24 1.44.21 1.99.13.61-.09 1.86-.76 2.12-1.5.26-.73.26-1.35.18-1.48-.07-.13-.28-.21-.59-.37z" />
                            </svg>
                        </span>
                        Escríbenos
                    </button>
                @else
                    <a href="{{ config('app.whatsapp_url', '#') }}" class="btn-whatsapp-nav" target="_blank"
                        rel="noopener">
                        <span class="icono-wsp">
                            <svg viewBox="0 0 32 32" fill="currentColor">
                                <path
                                    d="M16.001 3C9.096 3 3.5 8.596 3.5 15.5c0 2.2.57 4.35 1.66 6.24L3 29l7.42-2.11a12.44 12.44 0 0 0 5.58 1.33h.01c6.9 0 12.5-5.6 12.5-12.5S22.9 3 16.001 3zm0 22.55h-.01a10.4 10.4 0 0 1-5.3-1.45l-.38-.22-3.94 1.12 1.15-3.83-.25-.4a10.36 10.36 0 0 1-1.6-5.53c0-5.74 4.67-10.4 10.42-10.4 2.78 0 5.4 1.08 7.36 3.05a10.32 10.32 0 0 1 3.05 7.36c0 5.74-4.67 10.4-10.5 10.4zm5.72-7.75c-.31-.16-1.86-.92-2.15-1.02-.29-.1-.5-.16-.71.16-.21.31-.81 1.02-.99 1.23-.18.21-.37.24-.68.08-.31-.16-1.31-.48-2.5-1.55-.92-.82-1.55-1.83-1.73-2.14-.18-.31-.02-.48.14-.63.14-.14.31-.37.47-.55.16-.18.21-.31.31-.52.1-.21.05-.39-.02-.55-.08-.16-.71-1.71-.97-2.34-.26-.61-.52-.53-.71-.54-.18-.01-.39-.01-.6-.01s-.55.08-.84.39c-.29.31-1.1 1.08-1.1 2.63s1.13 3.05 1.29 3.26c.16.21 2.22 3.39 5.38 4.75.75.32 1.34.51 1.8.66.76.24 1.44.21 1.99.13.61-.09 1.86-.76 2.12-1.5.26-.73.26-1.35.18-1.48-.07-.13-.28-.21-.59-.37z" />
                            </svg>
                        </span>
                        Escríbenos
                    </a>
                @endif
            </nav>

            <button type="button" class="btn-hamburguesa" id="boton-menu-movil" aria-expanded="false"
                aria-controls="menu-movil" aria-label="Abrir menú">
                <span></span><span></span><span></span>
            </button>
        </div>
    </header>

    <div class="menu-movil" id="menu-movil">
        <div class="menu-movil-fondo" data-cerrar-menu></div>
        <div class="menu-movil-panel" role="dialog" aria-modal="true" aria-label="Menú de navegación">
            <button type="button" class="menu-movil-cerrar" data-cerrar-menu aria-label="Cerrar menú">&times;</button>
            <nav class="menu-movil-enlaces" aria-label="Navegación mobile">
                <a href="{{ route($prefijo . '.home') }}">Inicio</a>
                @foreach ($categoriasNav ?? [] as $cat)
                    <a href="{{ route($prefijo . '.categoria', $cat->slug) }}">{{ $cat->nombre }}</a>
                @endforeach
            </nav>
            @if ($esMayorista)
                <button type="button" class="btn-whatsapp-nav" data-abrir-selector-wsp>
                    <span class="icono-wsp">
                        <svg viewBox="0 0 32 32" fill="currentColor">
                            <path
                                d="M16.001 3C9.096 3 3.5 8.596 3.5 15.5c0 2.2.57 4.35 1.66 6.24L3 29l7.42-2.11a12.44 12.44 0 0 0 5.58 1.33h.01c6.9 0 12.5-5.6 12.5-12.5S22.9 3 16.001 3zm0 22.55h-.01a10.4 10.4 0 0 1-5.3-1.45l-.38-.22-3.94 1.12 1.15-3.83-.25-.4a10.36 10.36 0 0 1-1.6-5.53c0-5.74 4.67-10.4 10.42-10.4 2.78 0 5.4 1.08 7.36 3.05a10.32 10.32 0 0 1 3.05 7.36c0 5.74-4.67 10.4-10.5 10.4zm5.72-7.75c-.31-.16-1.86-.92-2.15-1.02-.29-.1-.5-.16-.71.16-.21.31-.81 1.02-.99 1.23-.18.21-.37.24-.68.08-.31-.16-1.31-.48-2.5-1.55-.92-.82-1.55-1.83-1.73-2.14-.18-.31-.02-.48.14-.63.14-.14.31-.37.47-.55.16-.18.21-.31.31-.52.1-.21.05-.39-.02-.55-.08-.16-.71-1.71-.97-2.34-.26-.61-.52-.53-.71-.54-.18-.01-.39-.01-.6-.01s-.55.08-.84.39c-.29.31-1.1 1.08-1.1 2.63s1.13 3.05 1.29 3.26c.16.21 2.22 3.39 5.38 4.75.75.32 1.34.51 1.8.66.76.24 1.44.21 1.99.13.61-.09 1.86-.76 2.12-1.5.26-.73.26-1.35.18-1.48-.07-.13-.28-.21-.59-.37z" />
                        </svg>
                    </span>
                    Escríbenos
                </button>
            @else
                <a href="{{ config('app.whatsapp_url', '#') }}" class="btn-whatsapp-nav" target="_blank"
                    rel="noopener">
                    <span class="icono-wsp">
                        <svg viewBox="0 0 32 32" fill="currentColor">
                            <path
                                d="M16.001 3C9.096 3 3.5 8.596 3.5 15.5c0 2.2.57 4.35 1.66 6.24L3 29l7.42-2.11a12.44 12.44 0 0 0 5.58 1.33h.01c6.9 0 12.5-5.6 12.5-12.5S22.9 3 16.001 3zm0 22.55h-.01a10.4 10.4 0 0 1-5.3-1.45l-.38-.22-3.94 1.12 1.15-3.83-.25-.4a10.36 10.36 0 0 1-1.6-5.53c0-5.74 4.67-10.4 10.42-10.4 2.78 0 5.4 1.08 7.36 3.05a10.32 10.32 0 0 1 3.05 7.36c0 5.74-4.67 10.4-10.5 10.4zm5.72-7.75c-.31-.16-1.86-.92-2.15-1.02-.29-.1-.5-.16-.71.16-.21.31-.81 1.02-.99 1.23-.18.21-.37.24-.68.08-.31-.16-1.31-.48-2.5-1.55-.92-.82-1.55-1.83-1.73-2.14-.18-.31-.02-.48.14-.63.14-.14.31-.37.47-.55.16-.18.21-.31.31-.52.1-.21.05-.39-.02-.55-.08-.16-.71-1.71-.97-2.34-.26-.61-.52-.53-.71-.54-.18-.01-.39-.01-.6-.01s-.55.08-.84.39c-.29.31-1.1 1.08-1.1 2.63s1.13 3.05 1.29 3.26c.16.21 2.22 3.39 5.38 4.75.75.32 1.34.51 1.8.66.76.24 1.44.21 1.99.13.61-.09 1.86-.76 2.12-1.5.26-.73.26-1.35.18-1.48-.07-.13-.28-.21-.59-.37z" />
                        </svg>
                    </span>
                    Escríbenos
                </a>
            @endif
        </div>
    </div>

    <main>
        @yield('contenido')
    </main>
    <svg width="0" height="0" style="position:absolute">
        <defs>
            <linearGradient id="gradienteInstagram" x1="0%" y1="100%" x2="100%" y2="0%">
                <stop offset="0%" stop-color="#FFDC80" />
                <stop offset="25%" stop-color="#FCAF45" />
                <stop offset="50%" stop-color="#E1306C" />
                <stop offset="75%" stop-color="#C13584" />
                <stop offset="100%" stop-color="#5851DB" />
            </linearGradient>
        </defs>
    </svg>
    <footer class="pie">
        <div class="pie-interior">
            <div class="pie-columnas">
                <div class="pie-horario">
                    <span class="ojo-eyebrow">Horario de atención</span>
                    <div class="pie-horario-dias">Lunes a sábado</div>
                    <div class="pie-horario-horas">8:00 a.m. &mdash; 6:00 p.m.</div>
                </div>

                <div class="pie-redes">
                    <span class="ojo-eyebrow">Síguenos</span>
                    <div class="pie-redes-iconos">
                        {{-- TODO: reemplazar "#" por el link real de Facebook --}}
                        <a href="{{ $facebookUrl }}" target="_blank" rel="noopener" aria-label="Facebook"
                            class="icono-facebook">
                            <svg viewBox="0 0 320 512" fill="currentColor">
                                <path
                                    d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z" />
                            </svg>
                        </a>
                        <a href="{{ $instagramUrl }}" target="_blank" rel="noopener" aria-label="Instagram"
                            class="icono-instagram">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M12 2.2c3.2 0 3.58.01 4.85.07 1.17.05 1.97.24 2.43.4.61.24 1.05.52 1.51.98.46.46.74.9.98 1.51.16.46.35 1.26.4 2.43.06 1.27.07 1.65.07 4.85s-.01 3.58-.07 4.85c-.05 1.17-.24 1.97-.4 2.43-.24.61-.52 1.05-.98 1.51-.46.46-.9.74-1.51.98-.46.16-1.26.35-2.43.4-1.27.06-1.65.07-4.85.07s-3.58-.01-4.85-.07c-1.17-.05-1.97-.24-2.43-.4a4.1 4.1 0 0 1-1.51-.98 4.1 4.1 0 0 1-.98-1.51c-.16-.46-.35-1.26-.4-2.43-.06-1.27-.07-1.65-.07-4.85s.01-3.58.07-4.85c.05-1.17.24-1.97.4-2.43.24-.61.52-1.05.98-1.51.46-.46.9-.74 1.51-.98.46-.16 1.26-.35 2.43-.4C8.42 2.21 8.8 2.2 12 2.2zm0 3.05a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5zm0 11.13a4.38 4.38 0 1 1 0-8.76 4.38 4.38 0 0 1 0 8.76zm7.02-11.4a1.58 1.58 0 1 1-3.15 0 1.58 1.58 0 0 1 3.15 0z" />
                            </svg>
                        </a>
                        @if ($esMayorista)
                            <button type="button" data-abrir-selector-wsp aria-label="WhatsApp"
                                class="icono-whatsapp">
                                <svg viewBox="0 0 32 32" fill="currentColor">
                                    <path
                                        d="M16.001 3C9.096 3 3.5 8.596 3.5 15.5c0 2.2.57 4.35 1.66 6.24L3 29l7.42-2.11a12.44 12.44 0 0 0 5.58 1.33h.01c6.9 0 12.5-5.6 12.5-12.5S22.9 3 16.001 3zm0 22.55h-.01a10.4 10.4 0 0 1-5.3-1.45l-.38-.22-3.94 1.12 1.15-3.83-.25-.4a10.36 10.36 0 0 1-1.6-5.53c0-5.74 4.67-10.4 10.42-10.4 2.78 0 5.4 1.08 7.36 3.05a10.32 10.32 0 0 1 3.05 7.36c0 5.74-4.67 10.4-10.5 10.4zm5.72-7.75c-.31-.16-1.86-.92-2.15-1.02-.29-.1-.5-.16-.71.16-.21.31-.81 1.02-.99 1.23-.18.21-.37.24-.68.08-.31-.16-1.31-.48-2.5-1.55-.92-.82-1.55-1.83-1.73-2.14-.18-.31-.02-.48.14-.63.14-.14.31-.37.47-.55.16-.18.21-.31.31-.52.1-.21.05-.39-.02-.55-.08-.16-.71-1.71-.97-2.34-.26-.61-.52-.53-.71-.54-.18-.01-.39-.01-.6-.01s-.55.08-.84.39c-.29.31-1.1 1.08-1.1 2.63s1.13 3.05 1.29 3.26c.16.21 2.22 3.39 5.38 4.75.75.32 1.34.51 1.8.66.76.24 1.44.21 1.99.13.61-.09 1.86-.76 2.12-1.5.26-.73.26-1.35.18-1.48-.07-.13-.28-.21-.59-.37z" />
                                </svg>
                            </button>
                        @else
                            <a href="{{ config('app.whatsapp_url', '#') }}" target="_blank" rel="noopener"
                                aria-label="WhatsApp" class="icono-whatsapp">
                                <svg viewBox="0 0 32 32" fill="currentColor">
                                    <path
                                        d="M16.001 3C9.096 3 3.5 8.596 3.5 15.5c0 2.2.57 4.35 1.66 6.24L3 29l7.42-2.11a12.44 12.44 0 0 0 5.58 1.33h.01c6.9 0 12.5-5.6 12.5-12.5S22.9 3 16.001 3zm0 22.55h-.01a10.4 10.4 0 0 1-5.3-1.45l-.38-.22-3.94 1.12 1.15-3.83-.25-.4a10.36 10.36 0 0 1-1.6-5.53c0-5.74 4.67-10.4 10.42-10.4 2.78 0 5.4 1.08 7.36 3.05a10.32 10.32 0 0 1 3.05 7.36c0 5.74-4.67 10.4-10.5 10.4zm5.72-7.75c-.31-.16-1.86-.92-2.15-1.02-.29-.1-.5-.16-.71.16-.21.31-.81 1.02-.99 1.23-.18.21-.37.24-.68.08-.31-.16-1.31-.48-2.5-1.55-.92-.82-1.55-1.83-1.73-2.14-.18-.31-.02-.48.14-.63.14-.14.31-.37.47-.55.16-.18.21-.31.31-.52.1-.21.05-.39-.02-.55-.08-.16-.71-1.71-.97-2.34-.26-.61-.52-.53-.71-.54-.18-.01-.39-.01-.6-.01s-.55.08-.84.39c-.29.31-1.1 1.08-1.1 2.63s1.13 3.05 1.29 3.26c.16.21 2.22 3.39 5.38 4.75.75.32 1.34.51 1.8.66.76.24 1.44.21 1.99.13.61-.09 1.86-.76 2.12-1.5.26-.73.26-1.35.18-1.48-.07-.13-.28-.21-.59-.37z" />
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="pie-base">
                <div class="pie-marca">{{ $modo === 'mayorista' ? 'GUANA' : 'AZUR' }}</div>
                <div class="pie-nota">Catálogo digital &mdash; consultas y pedidos por WhatsApp</div>
            </div>
        </div>
    </footer>

    <!-- Botón flotante: ¿Cómo funciona? -->
    <button type="button" class="btn-ayuda-flotante" id="boton-ayuda" aria-haspopup="dialog"
        aria-controls="modal-ayuda" aria-label="¿Cómo funciona este catálogo?">
        ?
    </button>

    <!-- Modal: Cómo funciona -->
    <div class="modal-ayuda" id="modal-ayuda">
        <div class="modal-ayuda-fondo" data-cerrar-ayuda></div>
        <div class="modal-ayuda-caja" role="dialog" aria-modal="true" aria-labelledby="modal-ayuda-titulo">
            <button type="button" class="modal-ayuda-cerrar" data-cerrar-ayuda aria-label="Cerrar">&times;</button>

            <div class="modal-ayuda-encabezado">
                <span class="ojo-eyebrow">Guía rápida</span>
                <h3 class="serif" id="modal-ayuda-titulo">¿Cómo funciona?</h3>
            </div>

            @if ($modo === 'mayorista')
                <div class="modal-ayuda-pasos">
                    <div class="modal-ayuda-paso">
                        <span class="numero-paso">01</span>
                        <div>
                            <h4>Explora el catálogo mayorista</h4>
                            <p>Navega por categorías y encuentra los productos disponibles para pedidos al por mayor.
                            </p>
                        </div>
                    </div>
                    <div class="modal-ayuda-paso">
                        <span class="numero-paso">02</span>
                        <div>
                            <h4>Elige cantidad</h4>
                            <p>Usa los botones de media docena o docena para acumular la cantidad que necesitas, y
                                escribe los colores si el producto lo permite.</p>
                        </div>
                    </div>
                    <div class="modal-ayuda-paso">
                        <span class="numero-paso">03</span>
                        <div>
                            <h4>Coordinamos por WhatsApp</h4>
                            <p>Con un clic enviamos tu pedido completo y te respondemos con disponibilidad y precio al
                                instante.</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="modal-ayuda-pasos">
                    <div class="modal-ayuda-paso">
                        <span class="numero-paso">01</span>
                        <div>
                            <h4>Explora el catálogo</h4>
                            <p>Navega por categorías y encuentra las piezas que te interesan, con fotos grandes y todos
                                los detalles.</p>
                        </div>
                    </div>
                    <div class="modal-ayuda-paso">
                        <span class="numero-paso">02</span>
                        <div>
                            <h4>Arma tu consulta</h4>
                            <p>Selecciona los productos que te gustaron &mdash; talla, color y cantidad, si aplican.</p>
                        </div>
                    </div>
                    <div class="modal-ayuda-paso">
                        <span class="numero-paso">03</span>
                        <div>
                            <h4>Coordinamos por WhatsApp</h4>
                            <p>Con un clic enviamos tu selección completa y te respondemos con disponibilidad y precio
                                al instante.</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="modal-ayuda-cta">
                @if ($esMayorista)
                    <a href="#" data-abrir-selector-wsp>
                        ¿Tienes dudas? Escríbenos directamente →
                    </a>
                @else
                    <a href="{{ config('app.whatsapp_url', '#') }}" target="_blank" rel="noopener">
                        ¿Tienes dudas? Escríbenos directamente →
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Botón flotante: Carrito de consulta -->
    <button type="button" class="btn-carrito-flotante" id="boton-carrito" aria-haspopup="dialog"
        aria-controls="modal-carrito" aria-label="Ver carrito de consulta">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
            stroke-linejoin="round">
            <circle cx="9" cy="21" r="1"></circle>
            <circle cx="20" cy="21" r="1"></circle>
            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
        </svg>
        <span class="badge-carrito oculto" id="badge-carrito">0</span>
    </button>

    <!-- Modal: Carrito de consulta -->
    <div class="modal-carrito" id="modal-carrito">
        <div class="modal-carrito-fondo" data-cerrar-carrito></div>
        <div class="modal-carrito-caja" role="dialog" aria-modal="true" aria-labelledby="modal-carrito-titulo">
            <button type="button" class="modal-carrito-cerrar" data-cerrar-carrito
                aria-label="Cerrar">&times;</button>

            <div class="modal-carrito-encabezado">
                <span class="ojo-eyebrow">Tu selección</span>
                <h3 class="serif" id="modal-carrito-titulo">Carrito de consulta</h3>
            </div>

            <div class="carrito-lista" id="carrito-lista"></div>
            <div class="carrito-vacio" id="carrito-vacio" style="display:none;">Todavía no has agregado productos.
            </div>

            <div class="carrito-pie">
                <button type="button" class="btn-enviar-carrito" id="btn-enviar-carrito" disabled>
                    <svg viewBox="0 0 32 32" fill="currentColor">
                        <path
                            d="M16.001 3C9.096 3 3.5 8.596 3.5 15.5c0 2.2.57 4.35 1.66 6.24L3 29l7.42-2.11a12.44 12.44 0 0 0 5.58 1.33h.01c6.9 0 12.5-5.6 12.5-12.5S22.9 3 16.001 3zm0 22.55h-.01a10.4 10.4 0 0 1-5.3-1.45l-.38-.22-3.94 1.12 1.15-3.83-.25-.4a10.36 10.36 0 0 1-1.6-5.53c0-5.74 4.67-10.4 10.42-10.4 2.78 0 5.4 1.08 7.36 3.05a10.32 10.32 0 0 1 3.05 7.36c0 5.74-4.67 10.4-10.5 10.4zm5.72-7.75c-.31-.16-1.86-.92-2.15-1.02-.29-.1-.5-.16-.71.16-.21.31-.81 1.02-.99 1.23-.18.21-.37.24-.68.08-.31-.16-1.31-.48-2.5-1.55-.92-.82-1.55-1.83-1.73-2.14-.18-.31-.02-.48.14-.63.14-.14.31-.37.47-.55.16-.18.21-.31.31-.52.1-.21.05-.39-.02-.55-.08-.16-.71-1.71-.97-2.34-.26-.61-.52-.53-.71-.54-.18-.01-.39-.01-.6-.01s-.55.08-.84.39c-.29.31-1.1 1.08-1.1 2.63s1.13 3.05 1.29 3.26c.16.21 2.22 3.39 5.38 4.75.75.32 1.34.51 1.8.66.76.24 1.44.21 1.99.13.61-.09 1.86-.76 2.12-1.5.26-.73.26-1.35.18-1.48-.07-.13-.28-.21-.59-.37z" />
                    </svg>
                    Enviar consulta por WhatsApp
                </button>
            </div>
        </div>
    </div>

    <!-- Modal: selector de WhatsApp (solo mayorista) -->
    <!-- Modal: selector de WhatsApp (solo mayorista) -->
    <div class="modal-ayuda modal-selector-wsp" id="modal-selector-wsp" style="max-width:none;">
        <div class="modal-ayuda-fondo" data-cerrar-selector-wsp></div>
        <div class="modal-ayuda-caja" role="dialog" aria-modal="true" aria-labelledby="selector-wsp-titulo"
            style="max-width:360px;">
            <button type="button" class="modal-ayuda-cerrar" data-cerrar-selector-wsp
                aria-label="Cerrar">&times;</button>
            <div class="modal-ayuda-encabezado">
                <span class="ojo-eyebrow">WhatsApp</span>
                <h3 class="serif" id="selector-wsp-titulo">¿Con quién deseas hablar?</h3>
                <p>Elige un contacto para continuar tu consulta.</p>
            </div>
            <div class="selector-wsp-lista">
                @foreach ($whatsappMayorista as $contacto)
                    <button type="button" class="selector-wsp-item" data-wsp-base="{{ $contacto['url'] }}">
                        <span class="selector-wsp-avatar">
                            <svg viewBox="0 0 32 32" fill="currentColor">
                                <path
                                    d="M16.001 3C9.096 3 3.5 8.596 3.5 15.5c0 2.2.57 4.35 1.66 6.24L3 29l7.42-2.11a12.44 12.44 0 0 0 5.58 1.33h.01c6.9 0 12.5-5.6 12.5-12.5S22.9 3 16.001 3zm0 22.55h-.01a10.4 10.4 0 0 1-5.3-1.45l-.38-.22-3.94 1.12 1.15-3.83-.25-.4a10.36 10.36 0 0 1-1.6-5.53c0-5.74 4.67-10.4 10.42-10.4 2.78 0 5.4 1.08 7.36 3.05a10.32 10.32 0 0 1 3.05 7.36c0 5.74-4.67 10.4-10.5 10.4zm5.72-7.75c-.31-.16-1.86-.92-2.15-1.02-.29-.1-.5-.16-.71.16-.21.31-.81 1.02-.99 1.23-.18.21-.37.24-.68.08-.31-.16-1.31-.48-2.5-1.55-.92-.82-1.55-1.83-1.73-2.14-.18-.31-.02-.48.14-.63.14-.14.31-.37.47-.55.16-.18.21-.31.31-.52.1-.21.05-.39-.02-.55-.08-.16-.71-1.71-.97-2.34-.26-.61-.52-.53-.71-.54-.18-.01-.39-.01-.6-.01s-.55.08-.84.39c-.29.31-1.1 1.08-1.1 2.63s1.13 3.05 1.29 3.26c.16.21 2.22 3.39 5.38 4.75.75.32 1.34.51 1.8.66.76.24 1.44.21 1.99.13.61-.09 1.86-.76 2.12-1.5.26-.73.26-1.35.18-1.48-.07-.13-.28-.21-.59-.37z" />
                            </svg>
                        </span>
                        <span class="selector-wsp-info">
                            <span class="selector-wsp-nombre">{{ $contacto['nombre'] }}</span>
                            <span class="selector-wsp-sub">Abrir chat de WhatsApp</span>
                        </span>
                        <svg class="selector-wsp-flecha" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 18l6-6-6-6" />
                        </svg>
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    <div class="toast-carrito" id="toast-carrito"></div>

    <script>
        (function() {
            var boton = document.getElementById('boton-menu-movil');
            var menu = document.getElementById('menu-movil');
            var cerradores = menu.querySelectorAll('[data-cerrar-menu]');

            function abrirMenu() {
                menu.classList.add('abierto');
                boton.setAttribute('aria-expanded', 'true');
                document.body.style.overflow = 'hidden';
                var primerEnlace = menu.querySelector('a');
                if (primerEnlace) primerEnlace.focus();
            }

            function cerrarMenu() {
                menu.classList.remove('abierto');
                boton.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
                boton.focus();
            }

            boton.addEventListener('click', function() {
                var abierto = boton.getAttribute('aria-expanded') === 'true';
                abierto ? cerrarMenu() : abrirMenu();
            });

            cerradores.forEach(function(el) {
                el.addEventListener('click', cerrarMenu);
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && menu.classList.contains('abierto')) {
                    cerrarMenu();
                }
            });
        })();

        // ---- Modal "Cómo funciona" ----
        (function() {
            var botonAyuda = document.getElementById('boton-ayuda');
            var modal = document.getElementById('modal-ayuda');
            var cerradores = modal.querySelectorAll('[data-cerrar-ayuda]');

            function abrirModal() {
                modal.classList.add('abierto');
                document.body.style.overflow = 'hidden';
            }

            function cerrarModal() {
                modal.classList.remove('abierto');
                document.body.style.overflow = '';
                botonAyuda.focus();
            }

            botonAyuda.addEventListener('click', abrirModal);

            cerradores.forEach(function(el) {
                el.addEventListener('click', cerrarModal);
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && modal.classList.contains('abierto')) {
                    cerrarModal();
                }
            });
        })();
        // ---- Carrito de consulta (sessionStorage: persiste al navegar/refrescar, se borra al cerrar la pestaña) ----
        window.CarritoAzur = (function() {
            var CLAVE = 'azur_carrito';

            function leer() {
                try {
                    var datos = sessionStorage.getItem(CLAVE);
                    return datos ? JSON.parse(datos) : [];
                } catch (e) {
                    return [];
                }
            }

            function guardar(items) {
                try {
                    sessionStorage.setItem(CLAVE, JSON.stringify(items));
                } catch (e) {}
                actualizarBadge();
                if (typeof window.renderizarModalCarrito === 'function') {
                    window.renderizarModalCarrito();
                }
            }

            function generarId() {
                return 'c' + Date.now() + Math.random().toString(36).slice(2, 8);
            }

            function agregar(item) {
                var items = leer();
                var existente = items.find(function(i) {
                    return i.producto_id === item.producto_id && i.talla === item.talla && i.color === item
                        .color;
                });
                if (existente) {
                    existente.cantidad += item.cantidad;
                } else {
                    item.id = generarId();
                    items.push(item);
                }
                guardar(items);
            }

            function quitar(id) {
                var items = leer().filter(function(i) {
                    return i.id !== id;
                });
                guardar(items);
            }

            function cambiarCantidad(id, delta) {
                var items = leer();
                var item = items.find(function(i) {
                    return i.id === id;
                });
                if (!item) return;
                item.cantidad = Math.max(1, item.cantidad + delta);
                guardar(items);
            }

            function total() {
                return leer().reduce(function(acc, i) {
                    return acc + i.cantidad;
                }, 0);
            }

            function actualizarBadge() {
                var badge = document.getElementById('badge-carrito');
                if (!badge) return;
                var t = total();
                badge.textContent = t;
                badge.classList.toggle('oculto', t === 0);
            }

            return {
                leer: leer,
                agregar: agregar,
                quitar: quitar,
                cambiarCantidad: cambiarCantidad,
                total: total,
                actualizarBadge: actualizarBadge
            };
        })();

        document.addEventListener('DOMContentLoaded', function() {
            window.CarritoAzur.actualizarBadge();
        });

        // ---- Toast de confirmación ----
        window.mostrarToastCarrito = function(texto) {
            var toast = document.getElementById('toast-carrito');
            if (!toast) return;
            toast.textContent = texto;
            toast.classList.add('visible');
            clearTimeout(toast._timeout);
            toast._timeout = setTimeout(function() {
                toast.classList.remove('visible');
            }, 2200);
        };

        // ---- Modal del carrito ----
        (function() {
            var boton = document.getElementById('boton-carrito');
            var modal = document.getElementById('modal-carrito');
            if (!boton || !modal) return;

            var cerradores = modal.querySelectorAll('[data-cerrar-carrito]');
            var lista = document.getElementById('carrito-lista');
            var vacio = document.getElementById('carrito-vacio');
            var btnEnviar = document.getElementById('btn-enviar-carrito');
            var esMayorista = '{{ $modo }}' === 'mayorista';

            function renderizar() {
                var items = window.CarritoAzur.leer();
                lista.innerHTML = '';

                if (!items.length) {
                    vacio.style.display = 'block';
                    btnEnviar.disabled = true;
                    return;
                }
                vacio.style.display = 'none';
                btnEnviar.disabled = false;

                items.forEach(function(item) {
                    var detalle = [item.categoria, item.subcategoria].filter(Boolean).join(' / ');
                    var variante = [
                        item.talla ? 'Talla: ' + item.talla : null,
                        item.color ? 'Color: ' + item.color : null
                    ].filter(Boolean).join(' · ');

                    var controlCantidad = esMayorista ?
                        '<span class="carrito-cantidad-fija"></span>' :
                        '<div class="carrito-cantidad-control">' +
                        '<button type="button" data-menos aria-label="Restar">&minus;</button>' +
                        '<span></span>' +
                        '<button type="button" data-mas aria-label="Sumar">+</button>' +
                        '</div>';

                    var fila = document.createElement('div');
                    fila.className = 'carrito-item';
                    fila.innerHTML =
                        '<div class="carrito-item-info">' +
                        '<div class="carrito-item-nombre"></div>' +
                        '<div class="carrito-item-detalle"></div>' +
                        '</div>' +
                        '<div class="carrito-item-acciones">' +
                        controlCantidad +
                        '<button type="button" class="carrito-item-quitar" data-quitar>Quitar</button>' +
                        '</div>';

                    fila.querySelector('.carrito-item-nombre').textContent = item.nombre;
                    fila.querySelector('.carrito-item-detalle').textContent = detalle + (variante ? ' — ' +
                        variante : '');
                    fila.querySelector('.carrito-cantidad-control span, .carrito-cantidad-fija').textContent =
                        item.cantidad;

                    if (!esMayorista) {
                        fila.querySelector('[data-menos]').addEventListener('click', function() {
                            window.CarritoAzur.cambiarCantidad(item.id, -1);
                        });
                        fila.querySelector('[data-mas]').addEventListener('click', function() {
                            window.CarritoAzur.cambiarCantidad(item.id, 1);
                        });
                    }
                    fila.querySelector('[data-quitar]').addEventListener('click', function() {
                        window.CarritoAzur.quitar(item.id);
                    });

                    lista.appendChild(fila);
                });
            }

            window.renderizarModalCarrito = renderizar;

            function abrir() {
                renderizar();
                modal.classList.add('abierto');
                document.body.style.overflow = 'hidden';
            }

            function cerrar() {
                modal.classList.remove('abierto');
                document.body.style.overflow = '';
                boton.focus();
            }

            boton.addEventListener('click', abrir);
            cerradores.forEach(function(el) {
                el.addEventListener('click', cerrar);
            });
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && modal.classList.contains('abierto')) cerrar();
            });

            btnEnviar.addEventListener('click', function() {
                var items = window.CarritoAzur.leer();
                if (!items.length) return;

                var partes = ['Hola, quisiera consultar por estos productos:', ''];
                items.forEach(function(item, idx) {
                    var detalle = [item.categoria, item.subcategoria].filter(Boolean).join(' / ');
                    var linea = (idx + 1) + '. *' + item.nombre + '*';
                    if (detalle) linea += '\n' + detalle;
                    if (item.talla) linea += '\n' + 'Talla: ' + item.talla;
                    if (item.color) linea += '\n' + 'Color: ' + item.color;
                    linea += '\n' + 'Cantidad: ' + item.cantidad;
                    if (item.url) linea += '\n' + item.url;
                    partes.push(linea);
                    partes.push(''); // línea en blanco entre productos
                });

                var textoMensaje = partes.join('\n');

                if (esMayorista) {
                    window.abrirSelectorWhatsapp(textoMensaje);
                } else {
                    var mensaje = encodeURIComponent(textoMensaje);
                    var base = "{{ config('app.whatsapp_url', '#') }}";
                    var separador = base.includes('?') ? '&' : '?';
                    window.open(base + separador + 'text=' + mensaje, '_blank');
                }
            });
        })();
    </script>

    <script>
        // ---- Selector de WhatsApp (mayorista) ----
        (function() {
            var modal = document.getElementById('modal-selector-wsp');
            if (!modal) return;
            var cerradores = modal.querySelectorAll('[data-cerrar-selector-wsp]');
            var mensajePendiente = '';

            window.abrirSelectorWhatsapp = function(mensaje) {
                mensajePendiente = mensaje || '';
                modal.classList.add('abierto');
                document.body.style.overflow = 'hidden';
            };

            function cerrar() {
                modal.classList.remove('abierto');
                document.body.style.overflow = '';
            }

            cerradores.forEach(function(el) {
                el.addEventListener('click', cerrar);
            });
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && modal.classList.contains('abierto')) cerrar();
            });

            modal.querySelectorAll('[data-wsp-base]').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var base = btn.getAttribute('data-wsp-base');
                    var separador = base.includes('?') ? '&' : '?';
                    var url = base + (mensajePendiente ? separador + 'text=' + encodeURIComponent(
                        mensajePendiente) : '');
                    window.open(url, '_blank');
                    cerrar();
                });
            });

            document.querySelectorAll('[data-abrir-selector-wsp]').forEach(function(el) {
                el.addEventListener('click', function(e) {
                    e.preventDefault();
                    window.abrirSelectorWhatsapp('');
                });
            });
        })();
    </script>

    @stack('scripts')
</body>

</html>
