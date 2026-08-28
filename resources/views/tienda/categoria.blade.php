@extends('tienda')
@section('titulo', $categoria->nombre . ' — ' . config('app.name', 'Catálogo'))

@section('contenido')

    @php
        $modo = $modo ?? 'normal';
        $prefijo = $modo === 'mayorista' ? 'mayorista' : 'tienda';
    @endphp

    <style>
        [data-revelar] {
            opacity: 0;
            transform: translateY(22px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        [data-revelar].visible {
            opacity: 1;
            transform: none;
        }

        /* ============ Cabecera de categoría ============ */
        .cabecera-categoria {
            max-width: 1240px;
            margin: 0 auto;
            padding: 40px 24px 0;
        }
/* ============ Buscador de categoría ============ */
.buscador-categoria {
    margin-top: 20px;
    max-width: 340px;
    position: relative;
}

.buscador-categoria input {
    width: 100%;
    padding: 11px 40px 11px 16px;
    font-size: 13.5px;
    letter-spacing: 0.01em;
    background: var(--crudo, #faf8f3);
    border: 1px solid rgba(26, 26, 24, 0.18);
    border-radius: 999px;
    color: var(--tinta);
    transition: border-color 0.2s ease;
}

.buscador-categoria input::placeholder {
    color: var(--arena);
}

.buscador-categoria input:focus {
    outline: none;
    border-color: var(--tinta);
}

.buscador-categoria svg {
    position: absolute;
    right: 14px;
    top: 50%;
    transform: translateY(-50%);
    width: 15px;
    height: 15px;
    color: var(--arena);
    pointer-events: none;
}

@media (max-width: 480px) {
    .buscador-categoria {
        max-width: 100%;
    }
}
        .migas {
            font-size: 12px;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: var(--arena);
            margin-bottom: 16px;
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

        .cabecera-categoria h1 {
            font-size: clamp(32px, 5.5vw, 48px);
            font-weight: 500;
        }

        .cabecera-categoria .conteo {
            margin-top: 8px;
            font-size: 13px;
            color: var(--arena);
            letter-spacing: 0.03em;
            text-transform: uppercase;
        }

        /* ============ Filtros de subcategoría ============ */
        .filtros {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            padding: 28px 0 4px;
            -webkit-overflow-scrolling: touch;
        }

        .filtros::-webkit-scrollbar {
            display: none;
        }

        .chip-filtro {
            flex: 0 0 auto;
            padding: 9px 18px;
            font-size: 12.5px;
            letter-spacing: 0.03em;
            text-transform: uppercase;
            border: 1px solid rgba(26, 26, 24, 0.18);
            border-radius: 999px;
            color: var(--tinta);
            opacity: 0.75;
            white-space: nowrap;
            transition: background 0.25s ease, color 0.25s ease, opacity 0.25s ease, border-color 0.25s ease;
        }

        .chip-filtro:hover {
            opacity: 1;
            border-color: var(--tinta);
        }

        .chip-filtro.activo {
            background: var(--tinta);
            color: var(--crudo);
            border-color: var(--tinta);
            opacity: 1;
        }

        /* ============ Grid de productos ============ */
        .seccion-productos {
            max-width: 1240px;
            margin: 0 auto;
            padding: 24px 24px 80px;
        }

        .grid-productos {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 22px 16px;
        }

        @media (min-width: 640px) {
            .grid-productos {
                grid-template-columns: repeat(3, 1fr);
                gap: 30px 22px;
            }
        }

        @media (min-width: 1000px) {
            .grid-productos {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        .tarjeta-producto {
            display: block;
        }

        .tarjeta-producto .foto {
            position: relative;
            aspect-ratio: 1 / 1;
            background: radial-gradient(120% 130% at 50% 20%, #f8f5ee 0%, #efece3 55%, #e2ddce 100%);
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 22px;
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

        .tarjeta-producto:hover img {
            transform: scale(1.045);
        }

        .tarjeta-producto .sin-foto {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Fraunces', serif;
            font-style: italic;
            color: var(--arena);
            font-size: 13px;
            text-align: center;
            padding: 10px;
        }

        .tarjeta-producto .etiqueta-destacado {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 2;
            background: var(--musgo);
            color: var(--crudo);
            font-size: 10px;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            padding: 4px 9px;
            border-radius: 2px;
        }

        .tarjeta-producto .sin-stock {
            position: absolute;
            inset: 0;
            z-index: 2;
            background: rgba(250, 248, 243, 0.72);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: var(--tinta);
        }

        .tarjeta-producto h3 {
            margin-top: 12px;
            font-family: 'Fraunces', serif;
            font-size: 16px;
            font-weight: 500;
            line-height: 1.3;
        }

        .tarjeta-producto p {
            font-size: 11.5px;
            color: var(--arena);
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-top: 3px;
        }

        /* ============ Swatches de color ============ */
        .swatches-color {
            display: flex;
            gap: 6px;
            margin-top: 8px;
        }

        .swatch-color {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-size: cover;
            background-position: center;
            border: 2px solid transparent;
            cursor: pointer;
            padding: 0;
        }

        .swatch-color:hover {
            border-color: rgba(26, 26, 24, 0.3);
        }

        .swatch-color.activo {
            border-color: var(--tinta);
        }

        /* ============ Estado vacío ============ */
        .estado-vacio {
            text-align: center;
            padding: 90px 24px;
        }

        .estado-vacio h3 {
            font-family: 'Fraunces', serif;
            font-style: italic;
            font-size: 22px;
            color: var(--tinta);
            opacity: 0.75;
        }

        .estado-vacio p {
            margin-top: 8px;
            font-size: 13.5px;
            color: var(--arena);
        }

        /* ============ Paginación ============ */
        /* ============ Paginación ============ */
        .paginacion-wrap {
            margin-top: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .pag-flecha {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            border: 1px solid rgba(26, 26, 24, 0.18);
            color: var(--tinta);
            font-size: 15px;
            line-height: 1;
            transition: background 0.2s ease, color 0.2s ease, border-color 0.2s ease, opacity 0.2s ease;
        }

        .pag-flecha:hover {
            background: var(--tinta);
            color: var(--crudo);
            border-color: var(--tinta);
        }

        .pag-flecha.deshabilitada {
            opacity: 0.25;
            pointer-events: none;
        }

        .pag-numeros {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .pag-numero {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 38px;
            height: 38px;
            padding: 0 4px;
            border-radius: 50%;
            font-size: 13px;
            color: var(--tinta);
            opacity: 0.6;
            transition: background 0.2s ease, color 0.2s ease, opacity 0.2s ease;
        }

        .pag-numero:hover {
            opacity: 1;
            background: rgba(26, 26, 24, 0.06);
        }

        .pag-numero.activo {
            opacity: 1;
            background: var(--tinta);
            color: var(--crudo);
            font-weight: 500;
        }

        @media (max-width: 480px) {
            .paginacion-wrap {
                gap: 8px;
            }

            .pag-numeros {
                gap: 4px;
            }

            .pag-flecha,
            .pag-numero {
                width: 34px;
                height: 34px;
                min-width: 34px;
            }
        }
    </style>

       <div class="cabecera-categoria" data-revelar>
        <div class="migas">
            <a href="{{ route($prefijo . '.home') }}">Inicio</a>
            <span>/</span>
            {{ $categoria->nombre }}
        </div>
        <h1 class="serif">{{ $categoria->nombre }}</h1>
        <div class="conteo">{{ $productos->total() }} {{ Str::plural('producto', $productos->total()) }}</div>

        <form class="buscador-categoria" method="GET" action="{{ route($prefijo . '.categoria', $categoria->slug) }}" id="form-buscador-categoria">
            @if ($subSlug)
                <input type="hidden" name="sub" value="{{ $subSlug }}">
            @endif
           <input type="text" name="buscar" id="input-buscador-categoria" value="{{ $buscar }}" placeholder="Buscar en {{ $categoria->nombre }}..." autocomplete="off">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1 0 5.4 5.4a7.5 7.5 0 0 0 11.25 11.25z" />
            </svg>
        </form>
    </div>

    @if ($categoria->subcategorias->count())
        <div class="cabecera-categoria" style="padding-top:0;">
            <div class="filtros" data-revelar>
                <a href="{{ route($prefijo . '.categoria', $categoria->slug) }}"
                    class="chip-filtro {{ !$subSlug ? 'activo' : '' }}">Todas</a>
                @foreach ($categoria->subcategorias as $sub)
                    <a href="{{ route($prefijo . '.categoria', $categoria->slug) }}?sub={{ $sub->slug }}"
                        class="chip-filtro {{ $subSlug === $sub->slug ? 'activo' : '' }}">
                        {{ $sub->nombre }}
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    <section class="seccion-productos">
        @if ($productos->count())
            <div class="grid-productos">
                @foreach ($productos as $producto)
                    <a href="{{ route($prefijo . '.producto', $producto->slug) }}" class="tarjeta-producto" data-revelar
                        style="transition-delay: {{ ($loop->index % 4) * 60 }}ms">
                        <div class="foto">
                            @if ($producto->destacado)
                                <span class="etiqueta-destacado">Destacado</span>
                            @endif

                            @if ($producto->imagenes->first())
                                <img src="{{ asset('storage/' . $producto->imagenes->first()->ruta) }}"
                                    alt="{{ $producto->nombre }}" loading="lazy"
                                    onerror="this.replaceWith(Object.assign(document.createElement('div'), {className:'sin-foto', textContent:'{{ $producto->nombre }}'}))">
                            @else
                                <div class="sin-foto">{{ $producto->nombre }}</div>
                            @endif

                            @if (!$producto->tieneVariantes() && !$producto->activo)
                                <div class="sin-stock">No disponible</div>
                            @endif
                        </div>

                        @php $coloresImg = collect($producto->coloresConImagen())->filter(fn($ci) => !empty($ci['imagen']))->values(); @endphp
                        @if ($coloresImg->count() > 1)
                            <div class="swatches-color">
                                @foreach ($coloresImg as $ci)
                                    <button type="button" class="swatch-color" title="{{ $ci['color'] }}"
                                        data-img="{{ asset('storage/' . $ci['imagen']) }}"
                                        style="background-image:url('{{ asset('storage/' . $ci['imagen']) }}')"></button>
                                @endforeach
                            </div>
                        @endif

                        <h3 class="serif">{{ $producto->nombre }}</h3>
                        <p>{{ $producto->subcategoria->nombre }}</p>
                    </a>
                @endforeach
            </div>

            @if ($productos->hasPages())
                <nav class="paginacion-wrap" role="navigation" aria-label="Paginación" data-revelar>
                    @if ($productos->onFirstPage())
                        <span class="pag-flecha deshabilitada">&larr;</span>
                    @else
                        <a href="{{ $productos->previousPageUrl() }}" class="pag-flecha">&larr;</a>
                    @endif

                    <div class="pag-numeros">
                        @foreach (range(1, $productos->lastPage()) as $pagina)
                            @if ($pagina == $productos->currentPage())
                                <span class="pag-numero activo">{{ $pagina }}</span>
                            @else
                                <a href="{{ $productos->url($pagina) }}" class="pag-numero">{{ $pagina }}</a>
                            @endif
                        @endforeach
                    </div>

                    @if ($productos->hasMorePages())
                        <a href="{{ $productos->nextPageUrl() }}" class="pag-flecha">&rarr;</a>
                    @else
                        <span class="pag-flecha deshabilitada">&rarr;</span>
                    @endif
                </nav>
            @endif
        @else
            <div class="estado-vacio" data-revelar>
                <h3>Todavía no hay productos aquí</h3>
                <p>Pronto agregaremos piezas a esta colección.</p>
            </div>
        @endif
    </section>

   <script>
    document.addEventListener('DOMContentLoaded', function () {
        var prefiereMenosMovimiento = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        function inicializarRevelado(lista) {
            if (prefiereMenosMovimiento || !('IntersectionObserver' in window)) {
                lista.forEach(function (el) { el.classList.add('visible'); });
                return;
            }
            var observador = new IntersectionObserver(function (entradas) {
                entradas.forEach(function (entrada) {
                    entrada.target.classList.toggle('visible', entrada.isIntersecting);
                });
            }, { threshold: 0.15 });
            lista.forEach(function (el) { observador.observe(el); });
        }

        function inicializarSwatches(contenedor) {
            contenedor.querySelectorAll('.swatch-color').forEach(function (btn) {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    var tarjeta = this.closest('.tarjeta-producto');
                    var img = tarjeta.querySelector('.foto img');
                    if (img) img.src = this.dataset.img;
                    tarjeta.querySelectorAll('.swatch-color').forEach(function (s) {
                        s.classList.remove('activo');
                    });
                    this.classList.add('activo');
                });
            });
        }

        // Inicialización normal de la carga de página
        inicializarRevelado(document.querySelectorAll('[data-revelar]'));
        inicializarSwatches(document);

        // ===== Búsqueda en vivo =====
        var input = document.getElementById('input-buscador-categoria');
        var form = document.getElementById('form-buscador-categoria');
        var seccionProductos = document.querySelector('.seccion-productos');
        var conteo = document.querySelector('.cabecera-categoria .conteo');

        if (input && form && seccionProductos) {
            var timeoutId = null;

            form.addEventListener('submit', function (e) {
                e.preventDefault(); // ya no hace falta Enter
            });

            input.addEventListener('input', function () {
                clearTimeout(timeoutId);
                var valor = input.value;

                timeoutId = setTimeout(function () {
                    var url = new URL(form.action, window.location.origin);
                    var params = new URLSearchParams();
                    var subInput = form.querySelector('input[name="sub"]');
                    if (subInput) params.set('sub', subInput.value);
                    if (valor) params.set('buscar', valor);
                    url.search = params.toString();

                    fetch(url.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                        .then(function (resp) { return resp.text(); })
                        .then(function (html) {
                            var doc = new DOMParser().parseFromString(html, 'text/html');
                            var nuevaSeccion = doc.querySelector('.seccion-productos');
                            var nuevoConteo = doc.querySelector('.cabecera-categoria .conteo');

                            if (nuevaSeccion) {
                                seccionProductos.innerHTML = nuevaSeccion.innerHTML;
                                inicializarRevelado(seccionProductos.querySelectorAll('[data-revelar]'));
                                inicializarSwatches(seccionProductos);
                            }
                            if (nuevoConteo && conteo) {
                                conteo.textContent = nuevoConteo.textContent;
                            }

                            history.replaceState(null, '', url.toString());
                        })
                        .catch(function (err) {
                            console.error('Error al buscar:', err);
                        });
                }, 350); // espera 350ms de silencio antes de buscar
            });
        }
    });
</script>

@endsection
