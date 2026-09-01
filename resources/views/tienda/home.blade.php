@extends('tienda')
@section('titulo', ($modo === 'mayorista' ? 'GUANA' : 'AZUR') . ' — Catálogo')

@section('contenido')

        @php
        $modo = $modo ?? 'normal';
        $prefijo = $modo === 'mayorista' ? 'mayorista' : 'tienda';
        $esMayorista = $modo === 'mayorista';
    @endphp
    <style>
        /* ============ Utilidad: revelar al hacer scroll ============ */
        [data-revelar] {
            opacity: 0;
            transform: translateY(26px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }

        [data-revelar].visible {
            opacity: 1;
            transform: none;
        }

        /* ============ Hero ============ */
        .hero {
            max-width: 1240px;
            margin: 0 auto;
            padding: 48px 24px 0;
            display: grid;
            grid-template-columns: 1fr;
            gap: 40px;
            align-items: center;
        }

        .hero-texto .ojo-eyebrow {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 12px;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: var(--musgo);
            font-weight: 600;
            margin-bottom: 18px;
        }

        .hero-texto .ojo-eyebrow::before {
            content: '';
            width: 26px;
            height: 1px;
            background: var(--musgo);
        }

        .hero-texto h1 {
            font-size: clamp(38px, 7vw, 64px);
            font-weight: 500;
            line-height: 1.05;
            letter-spacing: -0.015em;
        }

        .hero-texto h1 em {
            font-style: italic;
            font-weight: 400;
            color: var(--musgo);
        }

        .hero-texto p {
            margin-top: 20px;
            max-width: 44ch;
            font-size: 15.5px;
            line-height: 1.65;
            color: var(--tinta);
            opacity: 0.72;
        }

        .hero-acciones {
            margin-top: 30px;
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
        }

        .btn-hero {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 13px 24px;
            font-size: 13px;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            border-radius: 2px;
        }

        .btn-hero-primario {
            background: var(--tinta);
            color: var(--crudo);
        }

        .btn-hero-primario:hover {
            background: var(--musgo);
        }

        .btn-hero-secundario {
            border: 1px solid rgba(26, 26, 24, 0.25);
            color: var(--tinta);
        }

        .btn-hero-secundario:hover {
            border-color: var(--tinta);
        }

        /* Collage editorial */
        .hero-collage {
            position: relative;
            height: 380px;
        }

        .hero-collage .marco {
            position: absolute;
            border-radius: 2px;
            overflow: hidden;
            box-shadow: 0 22px 40px -18px rgba(26, 26, 24, 0.35);
            background: #e7e2d6;
        }

        .hero-collage img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .hero-collage .marco-a {
            width: 62%;
            height: 82%;
            top: 0;
            left: 0;
            z-index: 2;
        }

        .hero-collage .marco-b {
            width: 46%;
            height: 56%;
            bottom: 0;
            right: 0;
            z-index: 3;
            border: 6px solid var(--crudo);
        }

        .hero-collage .marco-c {
            width: 34%;
            height: 40%;
            top: 6%;
            right: 4%;
            z-index: 1;
            opacity: 0.9;
        }

        .hero-collage .plato {
            position: absolute;
            left: -6px;
            bottom: 14%;
            z-index: 4;
            background: var(--crudo);
            border: 1px solid rgba(26, 26, 24, 0.12);
            padding: 10px 16px;
            font-family: 'Fraunces', serif;
            font-style: italic;
            font-size: 13px;
            box-shadow: 0 10px 24px -12px rgba(26, 26, 24, 0.3);
        }

        /* Fallback sin fotos: capas de muestra tipo "swatches" de tela */
        .hero-collage.sin-fotos .swatch {
            position: absolute;
            border-radius: 2px;
            box-shadow: 0 20px 36px -18px rgba(26, 26, 24, 0.3);
        }

        .hero-collage.sin-fotos .swatch-1 {
            width: 58%;
            height: 78%;
            top: 0;
            left: 2%;
            background: linear-gradient(155deg, #5c6f4c, #33402a);
            z-index: 2;
            transform: rotate(-2deg);
        }

        .hero-collage.sin-fotos .swatch-2 {
            width: 42%;
            height: 50%;
            bottom: 0;
            right: 0;
            background: #e7e2d6;
            border: 6px solid var(--crudo);
            z-index: 3;
            transform: rotate(3deg);
        }

        .hero-collage.sin-fotos .swatch-3 {
            width: 30%;
            height: 34%;
            top: 8%;
            right: 6%;
            background: #c9c2b1;
            z-index: 1;
            transform: rotate(-4deg);
        }

        @media (min-width: 920px) {
            .hero {
                grid-template-columns: 1.05fr 0.95fr;
                padding-top: 64px;
            }

            .hero-collage {
                height: 460px;
            }
        }

        /* ============ Ticker de marca ============ */
        .ticker {
            margin-top: 56px;
            background: var(--tinta);
            color: var(--crudo);
            overflow: hidden;
            padding: 15px 0;
        }

        .ticker-riel {
            display: flex;
            width: max-content;
            animation: mover-ticker 32s linear infinite;
        }

        .ticker-riel span {
            white-space: nowrap;
            font-family: 'Fraunces', serif;
            font-style: italic;
            font-size: 15px;
            padding: 0 26px;
            opacity: 0.85;
        }

        .ticker-riel span::after {
            content: '✦';
            font-style: normal;
            font-size: 10px;
            margin-left: 26px;
            opacity: 0.6;
        }

        @keyframes mover-ticker {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-50%);
            }
        }

        /* ============ Sección genérica ============ */
        .seccion {
            max-width: 1240px;
            margin: 0 auto;
            padding: 72px 24px 0;
        }

        .titulo-seccion {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            margin-bottom: 28px;
            border-bottom: 1px solid rgba(26, 26, 24, 0.1);
            padding-bottom: 14px;
        }

        .titulo-seccion h2 {
            font-size: 23px;
            font-weight: 500;
        }

        .titulo-seccion span {
            font-size: 12px;
            color: var(--arena);
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        /* ============ Grid de categorías ============ */
        .grid-categorias {
            display: grid;
            grid-template-columns: 1fr;
            gap: 4px;
        }

        .tarjeta-categoria {
            position: relative;
            display: block;
            overflow: hidden;
            background: #e7e2d6;
            aspect-ratio: 3 / 4;
        }

        .tarjeta-categoria img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.7s cubic-bezier(0.2, 0.7, 0.2, 1);
        }

        .tarjeta-categoria:hover img {
            transform: scale(1.05);
        }

        .tarjeta-categoria .sin-imagen {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Fraunces', serif;
            font-style: italic;
            color: var(--arena);
            font-size: 15px;
        }

        .tarjeta-categoria::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(26, 26, 24, 0.68) 0%, rgba(26, 26, 24, 0) 48%);
            pointer-events: none;
        }

        .numero-plato {
            position: absolute;
            top: 18px;
            left: 18px;
            font-family: 'Fraunces', serif;
            font-style: italic;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.85);
            letter-spacing: 0.04em;
        }

        .info-categoria {
            position: absolute;
            left: 20px;
            bottom: 20px;
            right: 20px;
            color: #fff;
        }

        .info-categoria h3 {
            font-size: 25px;
            font-weight: 500;
        }

        .info-categoria .ver-mas {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 8px;
            font-size: 12px;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            border-bottom: 1px solid transparent;
            transition: border-color 0.3s ease, gap 0.3s ease;
        }

        .tarjeta-categoria:hover .ver-mas {
            border-bottom-color: rgba(255, 255, 255, 0.8);
            gap: 10px;
        }

        @media (min-width: 640px) {
            .grid-categorias {
                grid-template-columns: repeat(3, 1fr);
            }

            .tarjeta-categoria:nth-child(3n+1) {
                grid-column: span 2;
                aspect-ratio: 16 / 10;
            }
        }

        @media (min-width: 640px) and (max-width: 899px) {
            .tarjeta-categoria:nth-child(3n+1) {
                grid-column: span 3;
            }
        }

        /* ============ Destacados ============ */
        .fila-destacados {
            display: flex;
            gap: 18px;
            overflow-x: auto;
            padding-bottom: 8px;
            scroll-snap-type: x mandatory;
            -webkit-overflow-scrolling: touch;
        }

        .fila-destacados::-webkit-scrollbar {
            height: 5px;
        }

        .fila-destacados::-webkit-scrollbar-thumb {
            background: var(--arena);
            border-radius: 4px;
        }

        .tarjeta-producto {
            flex: 0 0 240px;
            scroll-snap-align: start;
        }

        .tarjeta-producto .foto {
            aspect-ratio: 1 / 1;
            background: radial-gradient(120% 130% at 50% 20%, #f8f5ee 0%, #efece3 55%, #e2ddce 100%);
            overflow: hidden;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 18px;
        }

        .tarjeta-producto .foto::after {
            content: '';
            position: absolute;
            left: 50%;
            bottom: 10%;
            width: 55%;
            height: 12%;
            transform: translateX(-50%);
            background: radial-gradient(closest-side, rgba(26, 26, 24, 0.15), rgba(26, 26, 24, 0) 75%);
            z-index: 0;
            pointer-events: none;
        }

        .tarjeta-producto img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            transition: transform 0.5s ease;
            position: relative;
            z-index: 1;
        }

        .tarjeta-producto a:hover img {
            transform: scale(1.04);
        }

        .tarjeta-producto .etiqueta-cat {
    position: absolute;
    top: 12px;
    left: 12px;
    background: var(--crudo);
    font-size: 10px;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    padding: 4px 9px;
    color: var(--tinta);
    z-index: 2;
}

        .tarjeta-producto h4 {
            margin-top: 12px;
            font-family: 'Fraunces', serif;
            font-size: 17px;
            font-weight: 500;
        }

        .tarjeta-producto p {
            font-size: 12px;
            color: var(--arena);
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-top: 3px;
        }

        /* ============ Valores ============ */
        .fila-valores {
            display: grid;
            grid-template-columns: 1fr;
            gap: 28px;
            padding: 64px 0 8px;
            border-top: 1px solid rgba(26, 26, 24, 0.1);
        }

        .valor {
            display: flex;
            gap: 16px;
            align-items: flex-start;
        }

        .valor svg {
            flex-shrink: 0;
            width: 26px;
            height: 26px;
            color: var(--musgo);
        }

        .valor h4 {
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .valor p {
            font-size: 13.5px;
            color: var(--tinta);
            opacity: 0.68;
            line-height: 1.55;
        }

        @media (min-width: 780px) {
            .fila-valores {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        /* ============ CTA final ============ */
        .cta-final {
            margin: 80px 0 0;
            background: var(--tinta);
            color: var(--crudo);
            padding: 64px 24px;
            text-align: center;
        }

        .cta-final-interior {
            max-width: 620px;
            margin: 0 auto;
        }

        .cta-final h2 {
            font-size: clamp(26px, 4vw, 36px);
            font-weight: 500;
            margin-bottom: 14px;
        }

        .cta-final h2 em {
            font-style: italic;
            color: #a7b89a;
        }

        .cta-final p {
            font-size: 14.5px;
            opacity: 0.72;
            margin-bottom: 26px;
        }

        .btn-cta {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 28px;
            background: var(--crudo);
            color: var(--tinta);
            font-size: 13px;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            border-radius: 2px;
        }

        .btn-cta:hover {
            background: #fff;
        }
    </style>

    <!-- Hero -->
    <section class="hero">
                <div class="hero-texto" data-revelar>
            @if ($modo === 'mayorista')
                <span class="ojo-eyebrow">Catálogo mayorista</span>
                <h1>Pedidos al <em>por mayor</em></h1>
                <p>
                    Explora nuestras colecciones mayoristas y arma tu pedido por docenas o medias docenas. Sin compras en línea, sin complicaciones.
                    Solo selecciona lo que necesitas y coordinamos el envío o la entrega por WhatsApp.
                </p>
            @else
                <span class="ojo-eyebrow">Catálogo digital</span>
                <h1>Encuentra lo que <em>buscas</em></h1>
                <p>
                    Explora nuestras colecciones y arma tu consulta. Sin compras en línea,
                    sin complicaciones &mdash; solo selecciona lo que te gusta y coordinamos
                    el resto por WhatsApp.
                </p>
            @endif
            <div class="hero-acciones">
                <a href="#colecciones" class="btn-hero btn-hero-primario">Ver colecciones</a>
                @if ($esMayorista)
                    <button type="button" class="btn-hero btn-hero-secundario" data-abrir-selector-wsp>Escríbenos</button>
                @else
                    <a href="{{ config('app.whatsapp_url', '#') }}" class="btn-hero btn-hero-secundario"
                        target="_blank" rel="noopener">Escríbenos</a>
                @endif
            </div>
        </div>

        @php
            $fotosHero = $categorias->pluck('imagen')->filter()->values();
        @endphp

        @if ($fotosHero->count() >= 2)
            <div class="hero-collage" data-revelar>
                <div class="marco marco-a">
                    <img src="{{ asset('storage/' . $fotosHero[0]) }}" alt=""
                        onerror="this.closest('.marco').style.display='none'">
                </div>
                <div class="marco marco-b">
                    <img src="{{ asset('storage/' . $fotosHero[1]) }}" alt=""
                        onerror="this.closest('.marco').style.display='none'">
                </div>
                @if ($fotosHero->count() >= 3)
                    <div class="marco marco-c">
                        <img src="{{ asset('storage/' . $fotosHero[2]) }}" alt=""
                            onerror="this.closest('.marco').style.display='none'">
                    </div>
                @endif
                <div class="plato">{{ $modo === 'mayorista' ? 'GUANA' : 'AZUR' }}</div>
            </div>
        @else
            <div class="hero-collage sin-fotos" data-revelar>
                <div class="swatch swatch-1"></div>
                <div class="swatch swatch-2"></div>
                <div class="swatch swatch-3"></div>
                <div class="plato">{{ $modo === 'mayorista' ? 'GUANA' : 'AZUR' }}</div>
            </div>
        @endif
    </section>

    <!-- Ticker -->
    <div class="ticker">
        <div class="ticker-riel">
            @for ($i = 0; $i < 2; $i++)
                @foreach ($categorias as $categoria)
                    <span>{{ $categoria->nombre }}</span>
                @endforeach
                <span>Consulta por WhatsApp</span>
            @endfor
        </div>
    </div>

    <!-- Categorías -->
    <section class="seccion" id="colecciones">
        <div class="titulo-seccion" data-revelar>
            <h2>Colecciones</h2>
            <span>{{ $categorias->count() }} categorías</span>
        </div>

        <div class="grid-categorias">
            @foreach ($categorias as $categoria)
                <a href="{{ route($prefijo . '.categoria', $categoria->slug) }}" class="tarjeta-categoria" data-revelar
                    style="transition-delay: {{ $loop->index * 70 }}ms">
                    @if ($categoria->imagen)
                        <img src="{{ asset('storage/' . $categoria->imagen) }}" alt="{{ $categoria->nombre }}"
                            loading="lazy"
                            onerror="this.replaceWith(Object.assign(document.createElement('div'), {className:'sin-imagen', textContent:'{{ $categoria->nombre }}'}))">
                    @else
                        <div class="sin-imagen">{{ $categoria->nombre }}</div>
                    @endif

                    <span class="numero-plato">N&deg;{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>

                    <div class="info-categoria">
                        <h3 class="serif">{{ $categoria->nombre }}</h3>
                        <span class="ver-mas">Ver colección →</span>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    <!-- Destacados -->
    @if ($productosDestacados->count())
        <section class="seccion">
            <div class="titulo-seccion" data-revelar>
                <h2>Destacados</h2>
                <span>Selección de la casa</span>
            </div>

            <div class="fila-destacados" data-revelar>
                @foreach ($productosDestacados as $producto)
                    <div class="tarjeta-producto">
                        <a href="{{ route($prefijo . '.producto', $producto->slug) }}">
                            <div class="foto">
                                @if ($producto->imagenes->first())
                                    <img src="{{ asset('storage/' . $producto->imagenes->first()->ruta) }}"
                                        alt="{{ $producto->nombre }}" loading="lazy" onerror="this.style.display='none'">
                                @endif
                                <span class="etiqueta-cat">{{ $producto->subcategoria->categoria->nombre }}</span>
                            </div>
                            <h4 class="serif">{{ $producto->nombre }}</h4>
                        </a>
                        <p>{{ $producto->subcategoria->nombre }}</p>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    <!-- Valores -->
    <section class="seccion">
        <div class="fila-valores">
            <div class="valor" data-revelar>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z" />
                </svg>
                <div>
                    <h4>Consulta sin compromiso</h4>
                    <p>Selecciona lo que te interesa y te respondemos por WhatsApp, sin registros ni pasos de más.</p>
                </div>
            </div>
            <div class="valor" data-revelar>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 0 0 4.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 0 1-15.357-2m15.357 2H15" />
                </svg>
                <div>
                    <h4>Catálogo siempre actualizado</h4>
                    <p>Las colecciones se renuevan según disponibilidad real, para que nunca preguntes por algo agotado.</p>
                </div>
            </div>
            <div class="valor" data-revelar>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                <div>
                    <h4>Trato directo, sin intermediarios</h4>
                    <p>Coordinamos tu pedido directamente contigo &mdash; tallas, colores y entrega, todo en la misma
                        conversación.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA final -->
    <section class="cta-final" data-revelar>
        <div class="cta-final-interior">
            <h2>¿Ya viste algo que <em>te gustó</em>?</h2>
            <p>Escríbenos por WhatsApp y con gusto te ayudamos a encontrarlo.</p>
                        @if ($esMayorista)
                <button type="button" class="btn-cta" data-abrir-selector-wsp>Iniciar conversación</button>
            @else
                <a href="{{ config('app.whatsapp_url', '#') }}" class="btn-cta" target="_blank" rel="noopener">Iniciar conversación</a>
            @endif
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var prefiereMenosMovimiento = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            var elementos = document.querySelectorAll('[data-revelar]');

            if (prefiereMenosMovimiento || !('IntersectionObserver' in window)) {
                elementos.forEach(function(el) {
                    el.classList.add('visible');
                });
                return;
            }

            var observador = new IntersectionObserver(function(entradas) {
                entradas.forEach(function(entrada) {
                    entrada.target.classList.toggle('visible', entrada.isIntersecting);
                });
            }, {
                threshold: 0.15
            }); // mantené el threshold que ya tenía cada vista

            elementos.forEach(function(el) {
                observador.observe(el);
            });
        });
    </script>

@endsection
