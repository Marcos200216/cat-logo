@extends('admin.layout')
@section('titulo', 'Inicio')

@push('estilos')
    <style>
        /* ===== Encabezado ===== */
        .saludo {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 28px;
            gap: 16px;
            flex-wrap: wrap;
        }

        .saludo h2 {
            font-family: 'Fraunces', serif;
            font-weight: 550;
            font-size: 24px;
            letter-spacing: -.01em;
            margin-bottom: 4px;
        }

        .saludo p {
            font-size: 13.5px;
            color: var(--texto-tenue);
        }

        .saludo .fecha {
            font-size: 12.5px;
            color: var(--texto-tenue);
            font-family: 'JetBrains Mono', monospace;
            text-transform: capitalize;
        }

        /* ===== Métricas ===== */
        .grid-metricas {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 22px;
        }

        .grid-metricas.tres-columnas {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        @media (max-width: 900px) {

            .grid-metricas,
            .grid-metricas.tres-columnas {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        .metrica {
            background: var(--superficie);
            border: 1px solid var(--borde);
            border-radius: 8px;
            padding: 18px 20px;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 10px;
        }

        .metrica .texto {
            min-width: 0;
        }

        .metrica .etiqueta {
            font-size: 10.5px;
            font-weight: 600;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--texto-tenue);
            margin-bottom: 8px;
        }

        .metrica .valor {
            font-family: 'JetBrains Mono', monospace;
            font-size: 26px;
            font-weight: 500;
            color: var(--texto);
            line-height: 1;
        }

        .metrica .valor .divisor {
            color: var(--texto-tenue);
            font-size: 16px;
            margin: 0 2px;
        }

        .metrica .icono {
            width: 34px;
            height: 34px;
            border-radius: 7px;
            background: var(--pino-tinta);
            color: var(--pino);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .metrica .icono svg {
            width: 17px;
            height: 17px;
        }

        .metrica.alerta .icono {
            background: var(--terracota-tinta);
            color: var(--terracota);
        }

        .metrica.alerta .valor {
            color: var(--terracota);
        }

        /* ===== Layout principal ===== */
        .grid-inicio {
            display: grid;
            grid-template-columns: minmax(0, 1.5fr) minmax(0, 1fr);
            gap: 18px;
            align-items: start;
            margin-bottom: 18px;
        }

        @media (max-width: 900px) {
            .grid-inicio {
                grid-template-columns: minmax(0, 1fr);
            }
        }

        .tarjeta {
            background: var(--superficie);
            border: 1px solid var(--borde);
            border-radius: 8px;
            padding: 22px;
            min-width: 0;
        }

        .tarjeta-encabezado {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
        }

        .tarjeta-titulo {
            font-family: 'Fraunces', serif;
            font-weight: 550;
            font-size: 16px;
            letter-spacing: -.005em;
        }

        .tarjeta-enlace {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--pino);
            text-decoration: none;
        }

        .tarjeta-enlace:hover {
            text-decoration: underline;
        }

        /* ===== Gráfico de barras (productos por categoría) ===== */
        .barra-fila {
            display: grid;
            grid-template-columns: 100px 1fr 34px;
            align-items: center;
            gap: 12px;
            padding: 9px 0;
        }

        .barra-fila .nombre-cat {
            font-size: 13px;
            font-weight: 500;
            color: var(--texto);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .barra-pista {
            background: var(--lienzo);
            border-radius: 4px;
            height: 8px;
            overflow: hidden;
        }

        .barra-relleno {
            height: 100%;
            background: var(--pino);
            border-radius: 4px;
            transition: width .4s ease;
        }

        .barra-fila .num {
            font-family: 'JetBrains Mono', monospace;
            font-size: 12.5px;
            color: var(--texto-tenue);
            text-align: right;
        }

        /* ===== Lista de últimos productos ===== */
        .fila-producto {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 0;
            border-bottom: 1px solid var(--borde);
        }

        .fila-producto:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .fila-producto:first-child {
            padding-top: 0;
        }

        .fila-producto .miniatura {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid var(--borde);
            flex-shrink: 0;
        }

        .fila-producto .miniatura-vacia {
            width: 40px;
            height: 40px;
            border-radius: 6px;
            background: var(--lienzo);
            border: 1px dashed #d3d0c8;
            flex-shrink: 0;
        }

        .fila-producto .info {
            min-width: 0;
            flex: 1;
        }

        .fila-producto .nombre {
            font-family: 'Fraunces', serif;
            font-weight: 500;
            font-size: 14px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .fila-producto .sub {
            font-size: 12px;
            color: var(--texto-tenue);
            margin-top: 1px;
        }

        .vacio-lista {
            text-align: center;
            padding: 34px 10px;
            color: var(--texto-tenue);
            font-size: 13px;
        }

        /* ===== Accesos directos ===== */
        .accesos {
            display: flex;
            flex-direction: column;
            gap: 9px;
        }

        .acceso-directo {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border: 1px solid var(--borde);
            border-radius: 6px;
            text-decoration: none;
            color: var(--texto);
            font-size: 13.5px;
            font-weight: 500;
            transition: background .15s, border-color .15s;
        }

        .acceso-directo:hover {
            background: var(--lienzo);
            border-color: #d3d0c8;
        }

        .acceso-directo .icono-acceso {
            width: 30px;
            height: 30px;
            border-radius: 6px;
            background: var(--lienzo);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--texto-tenue);
            flex-shrink: 0;
        }

        .acceso-directo .icono-acceso svg {
            width: 15px;
            height: 15px;
        }

        .acceso-directo span.arrow {
            margin-left: auto;
            color: var(--texto-tenue);
        }

        /* ===== Tabla de bajo stock ===== */
        .tabla-scroll {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin: 0 -22px;
            padding: 0 22px;
        }

        .tabla-stock {
            width: 100%;
            border-collapse: collapse;
        }

        .tabla-stock th,
        .tabla-stock td {
            white-space: nowrap;
        }

        .tabla-stock th {
            text-align: left;
            font-size: 10.5px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: var(--texto-tenue);
            padding: 0 20px 10px 0;
        }

        .tabla-stock td {
            padding: 10px 20px 10px 0;
            font-size: 13.5px;
            border-top: 1px solid var(--borde);
        }

        .tabla-stock td.stock-bajo {
            font-family: 'JetBrains Mono', monospace;
            color: var(--terracota);
            font-weight: 600;
            text-align: right;
        }

        .tabla-stock td.enlace-ver {
            text-align: right;
        }

        .tabla-stock td.enlace-ver a {
            color: var(--pino);
            font-size: 12.5px;
            font-weight: 600;
            text-decoration: none;
        }

        .tabla-stock td.enlace-ver a:hover {
            text-decoration: underline;
        }

        .grid-inicio.una-columna {
            grid-template-columns: minmax(0, 1fr);
        }
    </style>
@endpush

@section('contenido')

    <div class="saludo">
        <div>
            <h2>Bienvenido al panel</h2>
            <p>Un vistazo rápido al estado de tu catálogo.</p>
        </div>

    </div>

    <div class="grid-metricas {{ $canal === 'mayorista' ? 'tres-columnas' : '' }}">
        <div class="metrica">
            <div class="texto">
                <div class="etiqueta">Categorías</div>
                <div class="valor">{{ $totalCategorias }}</div>
            </div>
            <div class="icono">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="7" rx="1" />
                    <rect x="14" y="3" width="7" height="7" rx="1" />
                    <rect x="3" y="14" width="7" height="7" rx="1" />
                    <rect x="14" y="14" width="7" height="7" rx="1" />
                </svg>
            </div>
        </div>

        <div class="metrica">
            <div class="texto">
                <div class="etiqueta">Subcategorías</div>
                <div class="valor">{{ $totalSubcategorias }}</div>
            </div>
            <div class="icono">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M4 6h16M4 12h10M4 18h6" />
                </svg>
            </div>
        </div>

        <div class="metrica">
            <div class="texto">
                <div class="etiqueta">Productos activos</div>
                <div class="valor">{{ $productosActivos }}<span class="divisor">/</span>{{ $totalProductos }}</div>
            </div>
            <div class="icono">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M20 6L9 17l-5-5" />
                </svg>
            </div>
        </div>

        @if ($canal !== 'mayorista')
            <div class="metrica {{ $productosSinStock > 0 ? 'alerta' : '' }}">
                <div class="texto">
                    <div class="etiqueta">Sin stock</div>
                    <div class="valor">{{ $productosSinStock }}</div>
                </div>
                <div class="icono">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path
                            d="M12 9v4M12 17h.01M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                    </svg>
                </div>
            </div>
        @endif
    </div>

    <div class="grid-inicio">
        <div class="tarjeta">
            <div class="tarjeta-encabezado">
                <h3 class="tarjeta-titulo">Productos por categoría</h3>
            </div>

            @php $maxCount = $productosPorCategoria->max('productos_count') ?: 1; @endphp

            @forelse ($productosPorCategoria as $cat)
                <div class="barra-fila">
                    <div class="nombre-cat">{{ $cat->nombre }}</div>
                    <div class="barra-pista">
                        <div class="barra-relleno"
                            style="width: {{ $cat->productos_count > 0 ? ($cat->productos_count / $maxCount) * 100 : 0 }}%">
                        </div>
                    </div>
                    <div class="num">{{ $cat->productos_count }}</div>
                </div>
            @empty
                <div class="vacio-lista">Todavía no hay datos suficientes.</div>
            @endforelse
        </div>

        <div class="tarjeta">
            <div class="tarjeta-encabezado">
                <h3 class="tarjeta-titulo">Accesos rápidos</h3>
            </div>
            <div class="accesos">
                <a href="{{ route('admin.categorias.index') }}" class="acceso-directo">
                    <div class="icono-acceso">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="7" height="7" rx="1" />
                            <rect x="14" y="3" width="7" height="7" rx="1" />
                            <rect x="3" y="14" width="7" height="7" rx="1" />
                            <rect x="14" y="14" width="7" height="7" rx="1" />
                        </svg>
                    </div>
                    Categorías <span class="arrow">&rarr;</span>
                </a>
                <a href="{{ route('admin.subcategorias.index') }}" class="acceso-directo">
                    <div class="icono-acceso">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 6h16M4 12h10M4 18h6" />
                        </svg>
                    </div>
                    Subcategorías <span class="arrow">&rarr;</span>
                </a>
                <a href="{{ route('admin.productos.index') }}" class="acceso-directo">
                    <div class="icono-acceso">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    Productos <span class="arrow">&rarr;</span>
                </a>
            </div>
        </div>
    </div>

    <div class="grid-inicio {{ $canal === 'mayorista' ? 'una-columna' : '' }}">
        @if ($canal !== 'mayorista')
            <div class="tarjeta">
                <div class="tarjeta-encabezado">
                    <h3 class="tarjeta-titulo">Alerta de bajo stock</h3>
                    <a href="{{ route('admin.productos.index') }}" class="tarjeta-enlace">Ver productos &rarr;</a>
                </div>

                @if ($productosBajoStock->count() > 0)
                    <div class="tabla-scroll">
                        <table class="tabla-stock">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Categoría</th>
                                    <th style="text-align: right;">Stock mínimo</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productosBajoStock as $producto)
                                    <tr>
                                        <td>{{ $producto->nombre }}</td>
                                        <td>{{ $producto->subcategoria->categoria->nombre }} ·
                                            {{ $producto->subcategoria->nombre }}</td>
                                        <td class="stock-bajo">{{ $producto->stock_minimo }}</td>
                                        <td class="enlace-ver">
                                            href="{{ route('admin.productos.show', $producto) }}">Ver</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="vacio-lista">Todo el inventario está en buen nivel.</div>
                @endif
            </div>
        @endif

        <div class="tarjeta">
            <div class="tarjeta-encabezado">
                <h3 class="tarjeta-titulo">Últimos agregados</h3>
                <a href="{{ route('admin.productos.index') }}" class="tarjeta-enlace">Ver todos &rarr;</a>
            </div>

            @forelse ($ultimosProductos as $producto)
                <div class="fila-producto">
                    @if ($producto->imagenes->first())
                        <img src="{{ asset('storage/' . $producto->imagenes->first()->ruta) }}" class="miniatura"
                            alt=""
                            onerror="this.replaceWith(Object.assign(document.createElement('div'), {className:'miniatura-vacia'}))">
                    @else
                        <div class="miniatura-vacia"></div>
                    @endif
                    <div class="info">
                        <div class="nombre">{{ $producto->nombre }}</div>
                        <div class="sub">{{ $producto->subcategoria->categoria->nombre }} ·
                            {{ $producto->subcategoria->nombre }}</div>
                    </div>
                </div>
            @empty
                <div class="vacio-lista">Todavía no hay productos registrados.</div>
            @endforelse
        </div>
    </div>

@endsection
