@extends('tienda')
@section('titulo', $producto->nombre . ' — ' . config('app.name', 'Catálogo'))

@section('contenido')

    @php
        $modo = $modo ?? 'normal';
        $prefijo = $modo === 'mayorista' ? 'mayorista' : 'tienda';
    @endphp

    <style>
        [data-revelar] {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        [data-revelar].visible {
            opacity: 1;
            transform: none;
        }

        .ficha-wrap {
            max-width: 1120px;
            margin: 0 auto;
            padding: 32px 24px 0;
        }

        .migas {
            font-size: 12px;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: var(--arena);
            margin-bottom: 28px;
        }

        .migas a {
            color: var(--tinta);
            opacity: 0.6;
        }

        .migas a:hover {
            opacity: 1;
        }

        .migas span {
            margin: 0 6px;
        }

        .ficha-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 36px;
        }

        @media (min-width: 900px) {
            .ficha-grid {
                grid-template-columns: 1fr 1fr;
                gap: 56px;
                align-items: start;
            }
        }

        /* ============ Galería ============ */
        .galeria {
            display: flex;
            flex-direction: column-reverse;
            gap: 12px;
            max-width: 420px;
            margin: 0 auto;
        }

        @media (min-width: 900px) {
            .galeria {
                margin: 0;
            }
        }

        .galeria-principal {
            aspect-ratio: 1 / 1;
            max-height: 480px;
            background: radial-gradient(120% 130% at 50% 20%, #f8f5ee 0%, #efece3 55%, #e2ddce 100%);
            overflow: hidden;
            position: relative;
            border-radius: 3px;
            box-shadow: 0 18px 34px -22px rgba(26, 26, 24, 0.28);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 28px;
        }

        .galeria-principal::after {
            content: '';
            position: absolute;
            left: 50%;
            bottom: 9%;
            width: 55%;
            height: 12%;
            transform: translateX(-50%);
            background: radial-gradient(closest-side, rgba(26, 26, 24, 0.15), rgba(26, 26, 24, 0) 75%);
            z-index: 0;
            pointer-events: none;
        }

        .galeria-principal img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            position: relative;
            z-index: 1;
        }

        .galeria-principal .sin-foto {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Fraunces', serif;
            font-style: italic;
            color: var(--arena);
            font-size: 16px;
        }

        .galeria-miniaturas {
            display: flex;
            gap: 9px;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .galeria-miniaturas::-webkit-scrollbar {
            display: none;
        }

        .miniatura {
            flex: 0 0 58px;
            width: 58px;
            height: 76px;
            overflow: hidden;
            background: radial-gradient(120% 130% at 50% 20%, #f8f5ee 0%, #efece3 55%, #e2ddce 100%);
            border: 1.5px solid transparent;
            border-radius: 2px;
            opacity: 0.55;
            transition: opacity 0.25s ease, border-color 0.25s ease;
        }

        .miniatura {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 4px;
        }

        .miniatura img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .miniatura:hover {
            opacity: 0.85;
        }

        .miniatura.activa {
            opacity: 1;
            border-color: var(--tinta);
        }

        /* ============ Info del producto ============ */
        .info-producto {
            max-width: 460px;
        }

        .info-producto .etiqueta-cat {
            font-size: 12px;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--musgo);
            font-weight: 600;
        }

        .info-producto h1 {
            margin-top: 10px;
            font-size: clamp(25px, 3.4vw, 33px);
            font-weight: 500;
            line-height: 1.15;
        }

        .info-producto .descripcion {
            margin-top: 16px;
            font-size: 14px;
            line-height: 1.7;
            color: var(--tinta);
            opacity: 0.7;
        }

        /* ============ Selectores de variante ============ */
        .selector-bloque {
            margin-top: 26px;
            padding-top: 22px;
            border-top: 1px solid rgba(26, 26, 24, 0.08);
        }

        .selector-bloque:first-of-type {
            border-top: none;
            margin-top: 28px;
            padding-top: 0;
        }

        .selector-bloque .etiqueta-fila {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            margin-bottom: 11px;
        }

        .selector-bloque .etiqueta {
            font-size: 12px;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--tinta);
            font-weight: 600;
        }

        .selector-bloque .etiqueta-hint {
            font-size: 11.5px;
            color: var(--arena);
            font-style: italic;
        }

        .opciones-chip {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .chip-opcion {
            padding: 9px 16px;
            font-size: 13px;
            border: 1px solid rgba(26, 26, 24, 0.2);
            border-radius: 2px;
            background: transparent;
            color: var(--tinta);
            transition: all 0.2s ease;
        }

        .chip-opcion:hover:not(:disabled) {
            border-color: var(--tinta);
        }

        .chip-opcion.seleccionada {
            background: var(--tinta);
            color: var(--crudo);
            border-color: var(--tinta);
        }

        .chip-opcion:disabled {
            opacity: 0.3;
            text-decoration: line-through;
            cursor: not-allowed;
        }

        .bloque-color {
            transition: opacity 0.2s ease;
        }

        .bloque-color.deshabilitado {
            opacity: 0.45;
            pointer-events: none;
        }

        .aviso-disponibilidad {
            margin-top: 16px;
            font-size: 12.5px;
            letter-spacing: 0.02em;
            font-weight: 600;
        }

        .aviso-disponibilidad.ok {
            color: var(--musgo);
        }

        .aviso-disponibilidad.agotado {
            color: #a4423a;
        }

        /* ============ Selector de cantidad ============ */
        .selector-cantidad {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .selector-cantidad button {
            width: 32px;
            height: 32px;
            border: 1px solid rgba(26, 26, 24, 0.2);
            background: transparent;
            border-radius: 2px;
            font-size: 16px;
            line-height: 1;
            color: var(--tinta);
            transition: border-color 0.2s ease;
        }

        .selector-cantidad button:hover {
            border-color: var(--tinta);
        }

        .selector-cantidad span {
            font-size: 15px;
            min-width: 22px;
            text-align: center;
        }

        /* ============ Cantidad y color (mayorista) ============ */
        .cantidad-total-mayorista {
            margin-top: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
        }

        .cantidad-total-mayorista span#cantidad-valor-mayorista {
            font-family: 'Fraunces', serif;
            font-size: 19px;
        }

        .btn-reiniciar {
            margin-left: auto;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: none;
            border: 1px solid rgba(26, 26, 24, 0.2);
            border-radius: 999px;
            padding: 6px 12px;
            font-size: 11.5px;
            letter-spacing: 0.03em;
            text-transform: uppercase;
            color: var(--tinta);
            opacity: 0.7;
            cursor: pointer;
            transition: opacity 0.2s ease, border-color 0.2s ease, background 0.2s ease;
        }

        .btn-reiniciar svg {
            width: 13px;
            height: 13px;
            transition: transform 0.4s ease;
        }

        .btn-reiniciar:hover {
            opacity: 1;
            border-color: var(--tinta);
        }

        .btn-reiniciar:active svg {
            transform: rotate(-360deg);
        }

        .tooltip-ayuda {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            border: 1px solid rgba(26, 26, 24, 0.3);
            font-size: 11px;
            color: var(--tinta);
            cursor: pointer;
        }

        .tooltip-ayuda .tooltip-texto {
            display: none;
            position: absolute;
            bottom: 26px;
            right: 0;
            width: 220px;
            background: var(--tinta);
            color: var(--crudo);
            font-size: 11.5px;
            line-height: 1.5;
            padding: 10px 12px;
            border-radius: 3px;
            box-shadow: 0 10px 24px -10px rgba(26, 26, 24, 0.4);
            z-index: 5;
        }

        .tooltip-ayuda.abierto .tooltip-texto,
        .tooltip-ayuda:hover .tooltip-texto,
        .tooltip-ayuda:focus .tooltip-texto {
            display: block;
        }

        .input-color-mayorista {
            width: 100%;
            padding: 11px 14px;
            font-size: 13.5px;
            border: 1px solid rgba(26, 26, 24, 0.2);
            border-radius: 2px;
            font-family: 'Inter', sans-serif;
            background: transparent;
            color: var(--tinta);
        }

        .input-color-mayorista:focus {
            outline: none;
            border-color: var(--tinta);
        }

        /* ============ Acciones ============ */
        .acciones-producto {
            margin-top: 30px;
            padding-top: 26px;
            border-top: 1px solid rgba(26, 26, 24, 0.08);
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .btn-consultar {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 15px 24px;
            background: var(--tinta);
            color: var(--crudo);
            font-size: 13px;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            border-radius: 2px;
            border: none;
            width: 100%;
            transition: background 0.2s ease;
        }

        .btn-consultar:hover {
            background: var(--musgo);
        }

        .btn-consultar:disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        .btn-consultar svg {
            width: 19px;
            height: 19px;
        }

        .nota-consulta {
            font-size: 12px;
            color: var(--arena);
            text-align: center;
        }

        /* ============ Relacionados ============ */
        .seccion-relacionados {
            max-width: 1120px;
            margin: 88px auto 0;
            padding: 0 24px 80px;
            border-top: 1px solid rgba(26, 26, 24, 0.1);
        }

        .seccion-relacionados h2 {
            margin: 40px 0 24px;
            font-size: 21px;
            font-weight: 500;
        }

        .grid-relacionados {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        @media (min-width: 700px) {
            .grid-relacionados {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        .tarjeta-relacionado .foto {
            aspect-ratio: 1 / 1;
            background: radial-gradient(120% 130% at 50% 20%, #f8f5ee 0%, #efece3 55%, #e2ddce 100%);
            overflow: hidden;
            border-radius: 2px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 14px;
        }

        .tarjeta-relacionado .foto::after {
            content: '';
            position: absolute;
            left: 50%;
            bottom: 8%;
            width: 55%;
            height: 12%;
            transform: translateX(-50%);
            background: radial-gradient(closest-side, rgba(26, 26, 24, 0.15), rgba(26, 26, 24, 0) 75%);
            z-index: 0;
            pointer-events: none;
        }

        .tarjeta-relacionado img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            transition: transform 0.5s ease;
            position: relative;
            z-index: 1;
        }

        .tarjeta-relacionado:hover img {
            transform: scale(1.045);
        }

        .tarjeta-relacionado h4 {
            margin-top: 10px;
            font-family: 'Fraunces', serif;
            font-size: 14.5px;
        }
    </style>

    <div class="ficha-wrap">
        <div class="migas" data-revelar>
            <a href="{{ route($prefijo . '.home') }}">Inicio</a>
            <span>/</span>
            <a
                href="{{ route($prefijo . '.categoria', $producto->subcategoria->categoria->slug) }}">{{ $producto->subcategoria->categoria->nombre }}</a>
            <span>/</span>
            {{ $producto->nombre }}
        </div>

        <div class="ficha-grid">
            {{-- Galería --}}
            <div data-revelar>
                <div class="galeria">
                    <div class="galeria-miniaturas" id="miniaturas">
                        @forelse ($producto->imagenes as $imagen)
                            <button type="button" class="miniatura {{ $loop->first ? 'activa' : '' }}"
                                data-src="{{ asset('storage/' . $imagen->ruta) }}">
                                <img src="{{ asset('storage/' . $imagen->ruta) }}" alt=""
                                    onerror="this.closest('.miniatura').style.display='none'">
                            </button>
                        @empty
                        @endforelse
                    </div>
                    <div class="galeria-principal">
                        @if ($producto->imagenes->first())
                            <img id="imagen-principal" src="{{ asset('storage/' . $producto->imagenes->first()->ruta) }}"
                                alt="{{ $producto->nombre }}"
                                onerror="this.style.display='none'; this.insertAdjacentHTML('afterend', '<div class=\'sin-foto\'>{{ $producto->nombre }}</div>')">
                        @else
                            <div class="sin-foto">{{ $producto->nombre }}</div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Info --}}
            <div class="info-producto" data-revelar>
                <span class="etiqueta-cat">{{ $producto->subcategoria->nombre }}</span>
                <h1 class="serif">{{ $producto->nombre }}</h1>

                @if ($producto->descripcion)
                    <p class="descripcion">{{ $producto->descripcion }}</p>
                @endif

                @if ($modo === 'mayorista')
                    <div class="selector-bloque" style="border-top: none; margin-top: 28px; padding-top: 0;">
                        <div class="etiqueta-fila">
                            <span class="etiqueta">Cantidad</span>
                        </div>
                        <div class="opciones-chip">
                            <button type="button" class="chip-opcion" id="btn-media-docena">+ Media docena</button>
                            <button type="button" class="chip-opcion" id="btn-docena">+ Docena</button>
                        </div>
                        <div class="cantidad-total-mayorista">
                            <span class="etiqueta">Total:</span>
                            <span id="cantidad-valor-mayorista">0</span>
                            <button type="button" id="btn-reiniciar-cantidad" class="btn-reiniciar"
                                aria-label="Borrar cantidad seleccionada">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="1 4 1 10 7 10"></polyline>
                                    <path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path>
                                </svg>
                                Borrar todo
                            </button>
                        </div>
                    </div>

                    @if ($producto->tiene_color)
                        <div class="selector-bloque" id="bloque-color-mayorista" style="display:none;">
                            <div class="etiqueta-fila">
                                <span class="etiqueta">Color</span>
                                <span class="tooltip-ayuda" tabindex="0">
                                    ?
                                    <span class="tooltip-texto">Escribe cuántas unidades quieres de cada color. Por ejemplo:
                                        "6 rojo, 6 azul o surtido de colores".</span>
                                </span>
                            </div>
                            <input type="text" id="input-color-mayorista" class="input-color-mayorista"
                                placeholder='Ej: 6 rojo, 6 azul o surtido'>
                        </div>
                    @endif
                @else
                    @php
                        $tallas = $producto->variantes->pluck('talla')->filter()->unique()->values();
                        $colores = $producto->variantes->pluck('color')->filter()->unique()->values();
                    @endphp

                    @if ($producto->tieneVariantes())
                        <div id="datos-variantes" data-variantes='@json($producto->variantes->map(fn($v) => ['talla' => $v->talla, 'color' => $v->color, 'stock' => $v->stock]))'></div>

                        {{-- Imagen asociada a cada color (para cambiar la galería al seleccionar) --}}
                        <div id="datos-colores-imagen" data-colores='@json(collect($producto->coloresConImagen())->filter(fn($ci) => !empty($ci['imagen']))->map(fn($ci) => ['color' => $ci['color'], 'imagen' => asset('storage/' . $ci['imagen'])])->values())'></div>

                        @if ($tallas->count())
                            <div class="selector-bloque">
                                <div class="etiqueta-fila">
                                    <span class="etiqueta">Talla</span>
                                </div>
                                <div class="opciones-chip" id="opciones-talla">
                                    @foreach ($tallas as $talla)
                                        <button type="button" class="chip-opcion"
                                            data-talla="{{ $talla }}">{{ $talla }}</button>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if ($colores->count())
                            <div class="selector-bloque bloque-color {{ $tallas->count() ? 'deshabilitado' : '' }}"
                                id="bloque-color">
                                <div class="etiqueta-fila">
                                    <span class="etiqueta">Color</span>
                                    @if ($tallas->count())
                                        <span class="etiqueta-hint" id="hint-color">Elige una talla primero</span>
                                    @endif
                                </div>
                                <div class="opciones-chip" id="opciones-color">
                                    @foreach ($colores as $color)
                                        <button type="button" class="chip-opcion"
                                            data-color="{{ $color }}">{{ $color }}</button>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="aviso-disponibilidad" id="aviso-disponibilidad"></div>
                    @endif

                    <div class="selector-bloque" style="border-top: none; margin-top: 28px; padding-top: 0;">
                        <div class="etiqueta-fila">
                            <span class="etiqueta">Cantidad</span>
                        </div>
                        <div class="selector-cantidad">
                            <button type="button" id="cantidad-menos" aria-label="Restar cantidad">&minus;</button>
                            <span id="cantidad-valor">1</span>
                            <button type="button" id="cantidad-mas" aria-label="Sumar cantidad">+</button>
                        </div>
                    </div>
                @endif

                <div class="acciones-producto">
                    <button type="button" class="btn-consultar" id="btn-agregar-carrito"
                        data-producto-id="{{ $producto->id }}" data-nombre="{{ $producto->nombre }}"
                        data-categoria="{{ $producto->subcategoria->categoria->nombre }}"
                        data-subcategoria="{{ $producto->subcategoria->nombre }}" data-url="{{ url()->current() }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                            stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                        Agregar al carrito
                    </button>
                    <span class="nota-consulta">Podrás revisar tu selección y enviarla por WhatsApp cuando quieras</span>
                </div>
            </div>
        </div>
    </div>

    @if ($relacionados->count())
        <div class="seccion-relacionados">
            <h2 class="serif" data-revelar>También te puede interesar</h2>
            <div class="grid-relacionados">
                @foreach ($relacionados as $rel)
                    <a href="{{ route($prefijo . '.producto', $rel->slug) }}" class="tarjeta-relacionado" data-revelar
    style="transition-delay: {{ $loop->index * 60 }}ms">
    <div class="foto">
                            @if ($rel->imagenes->first())
                                <img src="{{ asset('storage/' . $rel->imagenes->first()->ruta) }}"
                                    alt="{{ $rel->nombre }}" loading="lazy" onerror="this.style.display='none'">
                            @endif
                        </div>
                        <h4>{{ $rel->nombre }}</h4>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ---- Revelar al hacer scroll ----
            var prefiereMenosMovimiento = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            var elementos = document.querySelectorAll('[data-revelar]');
            if (prefiereMenosMovimiento || !('IntersectionObserver' in window)) {
                elementos.forEach(function(el) {
                    el.classList.add('visible');
                });
            } else {
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
            }

            // ---- Galería: click en miniatura cambia imagen principal ----
            var miniaturas = document.querySelectorAll('.miniatura');
            var imagenPrincipal = document.getElementById('imagen-principal');
            miniaturas.forEach(function(min) {
                min.addEventListener('click', function() {
                    miniaturas.forEach(function(m) {
                        m.classList.remove('activa');
                    });
                    min.classList.add('activa');
                    if (imagenPrincipal) imagenPrincipal.src = min.dataset.src;
                });
            });

            // ---- Colores con imagen asociada (para cambiar la galería al elegir color) ----
            var contenedorColoresImg = document.getElementById('datos-colores-imagen');
            var coloresImg = contenedorColoresImg ? JSON.parse(contenedorColoresImg.dataset.colores) : [];

            function cambiarImagenPorColor(color) {
                if (!imagenPrincipal || !coloresImg.length) return;
                var match = coloresImg.find(function(ci) {
                    return ci.color === color;
                });
                if (!match) return;

                imagenPrincipal.src = match.imagen;

                miniaturas.forEach(function(m) {
                    m.classList.toggle('activa', m.dataset.src === match.imagen);
                });
            }

            // ---- Selector de variantes (talla/color) ----
            var contenedorDatos = document.getElementById('datos-variantes');
            var btnAgregar = document.getElementById('btn-agregar-carrito');

            if (contenedorDatos) {
                var variantes = JSON.parse(contenedorDatos.dataset.variantes);
                var chipsTalla = document.querySelectorAll('#opciones-talla .chip-opcion');
                var chipsColor = document.querySelectorAll('#opciones-color .chip-opcion');
                var bloqueColor = document.getElementById('bloque-color');
                var hintColor = document.getElementById('hint-color');
                var avisoEl = document.getElementById('aviso-disponibilidad');

                var estado = {
                    talla: null,
                    color: null
                };

                function variantesQueCoinciden(filtro) {
                    return variantes.filter(function(v) {
                        var okTalla = !filtro.talla || v.talla === filtro.talla;
                        var okColor = !filtro.color || v.color === filtro.color;
                        return okTalla && okColor;
                    });
                }

                // Muestra solo los colores que existen para la talla elegida; oculta el resto
                function actualizarColoresVisibles() {
                    if (!chipsColor.length || !bloqueColor) return;

                    // Si el producto no maneja talla, el color siempre está disponible
                    if (!chipsTalla.length) {
                        bloqueColor.classList.remove('deshabilitado');
                        chipsColor.forEach(function(chip) {
                            chip.style.display = '';
                        });
                        return;
                    }

                    if (!estado.talla) {
                        bloqueColor.classList.add('deshabilitado');
                        if (hintColor) hintColor.textContent = 'Elige una talla primero';
                        chipsColor.forEach(function(chip) {
                            chip.style.display = 'none';
                            chip.classList.remove('seleccionada');
                        });
                        estado.color = null;
                        return;
                    }

                    bloqueColor.classList.remove('deshabilitado');
                    var algunColorVisible = false;

                    chipsColor.forEach(function(chip) {
                        var color = chip.dataset.color;
                        var existeParaEstaTalla = variantes.some(function(v) {
                            return v.talla === estado.talla && v.color === color;
                        });
                        chip.style.display = existeParaEstaTalla ? '' : 'none';
                        if (existeParaEstaTalla) algunColorVisible = true;

                        if (!existeParaEstaTalla && chip.classList.contains('seleccionada')) {
                            chip.classList.remove('seleccionada');
                            estado.color = null;
                        }
                    });

                    if (hintColor) {
                        hintColor.textContent = algunColorVisible ? '' : 'Sin colores para esta talla';
                    }
                }

                function actualizarDisponibilidadChips(chips, campo, filtroBase) {
                    chips.forEach(function(chip) {
                        var valor = chip.dataset[campo];
                        var filtro = Object.assign({}, filtroBase);
                        filtro[campo] = valor;
                        var coincidencias = variantesQueCoinciden(filtro);
                        var hayStock = coincidencias.some(function(v) {
                            return v.stock > 0;
                        });
                        chip.disabled = coincidencias.length > 0 && !hayStock;
                    });
                }

                function refrescar() {
                    if (chipsColor.length) actualizarDisponibilidadChips(chipsTalla, 'talla', {
                        color: estado.color
                    });
                    if (chipsTalla.length) actualizarDisponibilidadChips(chipsColor, 'color', {
                        talla: estado.talla
                    });

                    var necesitaTalla = chipsTalla.length > 0;
                    var necesitaColor = chipsColor.length > 0;
                    var completo = (!necesitaTalla || estado.talla) && (!necesitaColor || estado.color);

                    if (!completo) {
                        avisoEl.textContent = '';
                        btnAgregar.disabled = false; // sigue pudiendo agregar sin elegir variante
                        return;
                    }

                    var coincidencias = variantesQueCoinciden(estado);
                    var stockTotal = coincidencias.reduce(function(acc, v) {
                        return acc + (v.stock || 0);
                    }, 0);

                    if (stockTotal > 0) {
                        avisoEl.textContent = 'Disponible';
                        avisoEl.className = 'aviso-disponibilidad ok';
                    } else {
                        avisoEl.textContent = 'Agotado en esta combinación';
                        avisoEl.className = 'aviso-disponibilidad agotado';
                    }
                }

                chipsTalla.forEach(function(chip) {
                    chip.addEventListener('click', function() {
                        if (chip.disabled) return;
                        var yaSeleccionada = chip.classList.contains('seleccionada');
                        chipsTalla.forEach(function(c) {
                            c.classList.remove('seleccionada');
                        });
                        estado.talla = yaSeleccionada ? null : chip.dataset.talla;
                        if (!yaSeleccionada) chip.classList.add('seleccionada');

                        actualizarColoresVisibles();
                        refrescar();
                    });
                });

                chipsColor.forEach(function(chip) {
                    chip.addEventListener('click', function() {
                        if (chip.disabled || chip.style.display === 'none') return;
                        var yaSeleccionada = chip.classList.contains('seleccionada');
                        chipsColor.forEach(function(c) {
                            c.classList.remove('seleccionada');
                        });
                        estado.color = yaSeleccionada ? null : chip.dataset.color;
                        if (!yaSeleccionada) chip.classList.add('seleccionada');

                        if (estado.color) cambiarImagenPorColor(estado.color);

                        refrescar();
                    });
                });

                actualizarColoresVisibles();
                refrescar();
            }

            var modoTienda = '{{ $modo }}';
            var cantidadActual = 1;

            if (modoTienda === 'mayorista') {
                // ---- Cantidad mayorista: botones + media docena / + docena, acumulativos ----
                var cantidadValorMay = document.getElementById('cantidad-valor-mayorista');
                var btnMediaDocena = document.getElementById('btn-media-docena');
                var btnDocena = document.getElementById('btn-docena');
                var btnReiniciarCantidad = document.getElementById('btn-reiniciar-cantidad');
                var bloqueColorMay = document.getElementById('bloque-color-mayorista');
                var inputColorMay = document.getElementById('input-color-mayorista');

                cantidadActual = 0;

                function actualizarCantidadMayorista() {
                    if (cantidadValorMay) cantidadValorMay.textContent = cantidadActual;
                    if (bloqueColorMay) bloqueColorMay.style.display = cantidadActual > 0 ? 'block' : 'none';
                }

                if (btnMediaDocena) {
                    btnMediaDocena.addEventListener('click', function() {
                        cantidadActual += 6;
                        actualizarCantidadMayorista();
                    });
                }
                if (btnDocena) {
                    btnDocena.addEventListener('click', function() {
                        cantidadActual += 12;
                        actualizarCantidadMayorista();
                    });
                }

                if (btnReiniciarCantidad) {
                    btnReiniciarCantidad.addEventListener('click', function() {
                        cantidadActual = 0;
                        actualizarCantidadMayorista();
                        if (inputColorMay) inputColorMay.value = '';
                    });
                }

                // ---- Tooltip de ayuda del campo color ----
                var tooltipAyuda = document.querySelector('.tooltip-ayuda');
                if (tooltipAyuda) {
                    tooltipAyuda.addEventListener('click', function(e) {
                        e.stopPropagation();
                        tooltipAyuda.classList.toggle('abierto');
                    });
                    document.addEventListener('click', function(e) {
                        if (!tooltipAyuda.contains(e.target)) tooltipAyuda.classList.remove('abierto');
                    });
                }

                // ---- Botón "Agregar al carrito" (mayorista) ----
                btnAgregar.addEventListener('click', function() {
                    if (cantidadActual <= 0) {
                        if (window.mostrarToastCarrito) {
                            window.mostrarToastCarrito('Elige al menos media docena');
                        }
                        return;
                    }

                    window.CarritoAzur.agregar({
                        producto_id: btnAgregar.dataset.productoId,
                        nombre: btnAgregar.dataset.nombre,
                        categoria: btnAgregar.dataset.categoria,
                        subcategoria: btnAgregar.dataset.subcategoria,
                        talla: null,
                        color: inputColorMay ? (inputColorMay.value.trim() || null) : null,
                        cantidad: cantidadActual,
                        url: btnAgregar.dataset.url
                    });

                    if (window.mostrarToastCarrito) {
                        window.mostrarToastCarrito('Agregado al carrito ✓');
                    }

                    cantidadActual = 0;
                    actualizarCantidadMayorista();
                    if (inputColorMay) inputColorMay.value = '';
                });

            } else {
                // ---- Selector de cantidad (catálogo normal) ----
                var cantidadValor = document.getElementById('cantidad-valor');
                var btnCantidadMenos = document.getElementById('cantidad-menos');
                var btnCantidadMas = document.getElementById('cantidad-mas');

                if (btnCantidadMenos && btnCantidadMas && cantidadValor) {
                    btnCantidadMenos.addEventListener('click', function() {
                        cantidadActual = Math.max(1, cantidadActual - 1);
                        cantidadValor.textContent = cantidadActual;
                    });
                    btnCantidadMas.addEventListener('click', function() {
                        cantidadActual += 1;
                        cantidadValor.textContent = cantidadActual;
                    });
                }

                // ---- Botón "Agregar al carrito" (catálogo normal) ----
                btnAgregar.addEventListener('click', function() {
                    var tallaSel = document.querySelector('#opciones-talla .chip-opcion.seleccionada');
                    var colorSel = document.querySelector('#opciones-color .chip-opcion.seleccionada');

                    window.CarritoAzur.agregar({
                        producto_id: btnAgregar.dataset.productoId,
                        nombre: btnAgregar.dataset.nombre,
                        categoria: btnAgregar.dataset.categoria,
                        subcategoria: btnAgregar.dataset.subcategoria,
                        talla: tallaSel ? tallaSel.dataset.talla : null,
                        color: colorSel ? colorSel.dataset.color : null,
                        cantidad: cantidadActual,
                        url: btnAgregar.dataset.url
                    });

                    if (window.mostrarToastCarrito) {
                        window.mostrarToastCarrito('Agregado al carrito ✓');
                    }

                    // Reinicia el selector de cantidad para la próxima adición
                    cantidadActual = 1;
                    if (cantidadValor) cantidadValor.textContent = '1';
                });
            }
        });
    </script>

@endsection
