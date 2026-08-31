@extends('admin.layout')
@section('titulo', 'Productos')

@push('estilos')
    <style>
        /* ===== Encabezado de la vista ===== */
        .cat-encabezado {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 22px;
            gap: 16px;
            flex-wrap: wrap;
            scroll-margin-top: 70px;
        }

        .cat-filtros {
            display: flex;
            gap: 10px;
            flex: 1;
            max-width: 540px;
            min-width: 260px;
        }

        .buscador {
            position: relative;
            max-width: 300px;
            width: 100%;
        }

        .buscador input {
            width: 100%;
            padding: 10px 14px 10px 36px;
            border: 1px solid var(--borde);
            border-radius: 6px;
            font-size: 13.5px;
            font-family: 'Inter', sans-serif;
            background: var(--superficie);
            transition: border-color .15s, box-shadow .15s;
        }

        .buscador input:focus {
            outline: none;
            border-color: var(--pino);
            box-shadow: 0 0 0 3px var(--pino-tinta);
        }

        .buscador input::placeholder {
            color: #a3a7af;
        }

        .buscador svg {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 15px;
            height: 15px;
            color: #a3a7af;
            pointer-events: none;
        }

        .filtro-subcategoria {
            max-width: 220px;
            width: 100%;
            padding: 10px 14px;
            border: 1px solid var(--borde);
            border-radius: 6px;
            font-size: 13.5px;
            font-family: 'Inter', sans-serif;
            background: var(--superficie);
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%2371757e' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 36px;
            transition: border-color .15s, box-shadow .15s;
        }

        .filtro-subcategoria:focus {
            outline: none;
            border-color: var(--pino);
            box-shadow: 0 0 0 3px var(--pino-tinta);
        }

        /* ===== Botones ===== */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 10px 18px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .01em;
            text-decoration: none;
            border: 1px solid transparent;
            cursor: pointer;
            transition: background .15s, border-color .15s, opacity .15s;
            font-family: 'Inter', sans-serif;
        }

        .btn-primario {
            background: var(--pino);
            color: #fff;
        }

        .btn-primario:hover {
            background: var(--pino-oscuro);
        }

        .btn-secundario {
            background: var(--superficie);
            color: var(--texto);
            border-color: var(--borde);
        }

        .btn-secundario:hover {
            background: var(--lienzo);
            border-color: #d3d0c8;
        }

        /* ===== Tarjeta / ledger con scroll interno ===== */
        .tarjeta {
            background: var(--superficie);
            border: 1px solid var(--borde);
            border-radius: 8px;
            overflow: hidden;
        }

        .tabla-scroll {
            max-height: 620px;
            overflow-y: auto;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead tr {
            border-bottom: 1.5px solid var(--tinta);
        }

        thead th {
            position: sticky;
            top: 0;
            background: var(--superficie);
            z-index: 1;
        }

        th,
        td {
            text-align: left;
            padding: 12px 18px;
            font-size: 13.5px;
            vertical-align: middle;
        }

        th {
            color: var(--texto-tenue);
            font-weight: 600;
            font-size: 10.5px;
            text-transform: uppercase;
            letter-spacing: .1em;
        }

        tbody tr {
            border-bottom: 1px solid var(--borde);
            transition: background .1s;
        }

        tbody tr:hover {
            background: #fbfaf8;
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        .tabla-scroll::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        .tabla-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .tabla-scroll::-webkit-scrollbar-thumb {
            background: #d8d5cd;
            border-radius: 8px;
        }

        .tabla-scroll::-webkit-scrollbar-thumb:hover {
            background: #c3c0b8;
        }

        /* ===== Miniatura ===== */
        .miniatura {
            width: 42px;
            height: 42px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid var(--borde);
            display: block;
        }

        .miniatura-vacia {
            width: 42px;
            height: 42px;
            border-radius: 6px;
            background: var(--lienzo);
            border: 1px dashed #d3d0c8;
        }

        .nombre-categoria {
            font-family: 'Fraunces', serif;
            font-weight: 500;
            font-size: 15.5px;
            letter-spacing: -.005em;
            display: block;
        }

        .etiqueta-sub {
            font-size: 12px;
            color: var(--texto-tenue);
            margin-top: 2px;
        }

        /* Destacado: diamante en vez de texto Sí/No */
        .destacado {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12.5px;
            font-weight: 500;
            color: var(--texto-tenue);
        }

        .destacado::before {
            content: '';
            width: 8px;
            height: 8px;
            border: 1.5px solid #c3c0b8;
            transform: rotate(45deg);
            flex-shrink: 0;
        }

        .destacado.si {
            color: var(--pino-oscuro);
        }

        .destacado.si::before {
            background: var(--pino);
            border-color: var(--pino);
        }

        td.acciones {
            text-align: right;
            white-space: nowrap;
        }

        .enlace-accion {
            background: none;
            border: none;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            font-weight: 600;
            padding: 4px 2px;
            text-decoration: none;
        }

        .enlace-accion.editar {
            color: var(--pino);
        }

        .enlace-accion.editar:hover {
            text-decoration: underline;
        }

        .enlace-accion.eliminar {
            color: var(--terracota);
            margin-left: 18px;
        }

        .enlace-accion.eliminar:hover {
            text-decoration: underline;
        }

        td.vacio {
            text-align: center;
            color: var(--texto-tenue);
            padding: 56px 16px;
            font-size: 13.5px;
        }

        /* ===== Badges ===== */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .02em;
        }

        .badge::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .badge-activo {
            color: var(--pino-oscuro);
        }

        .badge-activo::before {
            background: var(--pino);
        }

        .badge-inactivo {
            color: var(--texto-tenue);
        }

        .badge-inactivo::before {
            background: #c3c0b8;
        }

        /* ===== Modal ===== */
        .modal-fondo {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(21, 23, 27, 0.55);
            align-items: center;
            justify-content: center;
            z-index: 50;
            padding: 20px;
        }

        .modal-fondo.abierto {
            display: flex;
        }

        .modal-caja {
            background: var(--superficie);
            border-radius: 10px;
            width: 480px;
            max-width: 100%;
            max-height: 88vh;
            overflow-y: auto;
            box-shadow: 0 24px 48px rgba(21, 23, 27, .22);
        }

        .modal-encabezado {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 24px;
            border-bottom: 1px solid var(--borde);
        }

        .modal-encabezado h2 {
            font-family: 'Fraunces', serif;
            font-weight: 550;
            font-size: 18px;
        }

        .modal-cerrar {
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: var(--texto-tenue);
            line-height: 1;
            padding: 4px 6px;
            border-radius: 6px;
        }

        .modal-cerrar:hover {
            background: var(--lienzo);
            color: var(--texto);
        }

        .modal-cuerpo {
            padding: 24px;
        }

        .modal-pie {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 6px;
        }

        /* ===== Formulario ===== */
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
        .campo input[type="number"],
        .campo select,
        .campo textarea {
            width: 100%;
            padding: 9px 12px;
            border: 1px solid var(--borde);
            border-radius: 6px;
            font-size: 13.5px;
            font-family: 'Inter', sans-serif;
            background: var(--superficie);
            transition: border-color .15s, box-shadow .15s;
        }

        .campo textarea {
            resize: vertical;
        }

        .campo select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%2371757e' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 36px;
            cursor: pointer;
        }

        .campo input:focus,
        .campo select:focus,
        .campo textarea:focus {
            outline: none;
            border-color: var(--pino);
            box-shadow: 0 0 0 3px var(--pino-tinta);
        }

        .campo-checkbox {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13.5px;
            font-weight: 400;
            cursor: pointer;
        }

        .campo-checkbox input {
            width: auto;
        }

        .campo-error {
            color: var(--terracota);
            font-size: 12.5px;
            margin-top: 5px;
        }

        .texto-ayuda {
            font-size: 12px;
            color: var(--texto-tenue);
            margin-top: -6px;
            margin-bottom: 16px;
        }

        /* ===== Responsive ===== */
        @media (max-width: 768px) {
            .cat-encabezado {
                flex-direction: column;
                align-items: stretch;
            }

            .cat-filtros {
                max-width: 100%;
                flex-direction: column;
            }

            .buscador,
            .filtro-subcategoria {
                max-width: 100%;
            }

            .cat-encabezado>.btn-primario {
                width: 100%;
            }

            .modal-encabezado {
                padding: 16px 18px;
            }

            .modal-cuerpo {
                padding: 18px;
            }
        }

        @media (max-width: 640px) {

            /* La tabla se convierte en tarjetas apiladas */
            .tabla-scroll {
                overflow-x: visible;
                max-height: none;
            }

            .tarjeta thead {
                display: none;
            }

            /* Un solo nivel de "caja": se quita el borde exterior de .tarjeta
               para no duplicarlo con el de cada fila */
            .tarjeta {
                border: none;
                border-radius: 0;
                background: transparent;
            }

            .tarjeta table,
            .tarjeta tbody {
                display: block;
                width: 100%;
            }

            /* Cada fila es una tarjeta con grid: miniatura + nombre arriba,
               destacado/estado como filas de etiqueta+valor, acciones abajo */
            #tabla-productos tr[data-nombre] {
                display: grid;
                grid-template-columns: 42px 1fr;
                grid-template-areas:
                    "img   nombre"
                    "destacado destacado"
                    "estado    estado"
                    "acciones  acciones";
                column-gap: 12px;
                row-gap: 6px;
                border: 1px solid var(--borde);
                border-radius: 8px;
                background: var(--superficie);
                margin: 0 0 8px 0;
                padding: 10px 12px;
            }

            #tabla-productos tr[data-nombre]:last-child {
                margin-bottom: 0;
            }

            #tabla-productos td {
                padding: 0;
                border: none;
            }

            #tabla-productos td:nth-child(1) {
                grid-area: img;
                align-self: start;
            }

            #tabla-productos td:nth-child(2) {
                grid-area: nombre;
                align-self: center;
            }

            #tabla-productos td:nth-child(3) {
                grid-area: destacado;
            }

            #tabla-productos td:nth-child(4) {
                grid-area: estado;
            }

            #tabla-productos td.acciones {
                grid-area: acciones;
            }

            #tabla-productos .nombre-categoria {
                font-size: 14px;
            }

            #tabla-productos .etiqueta-sub {
                font-size: 11.5px;
            }

            #tabla-productos td[data-label] {
                display: grid;
                grid-template-columns: 76px 1fr;
                align-items: center;
                justify-items: start;
                gap: 8px;
            }

            #tabla-productos td[data-label]::before {
                content: attr(data-label);
                font-weight: 600;
                font-size: 9.5px;
                text-transform: uppercase;
                letter-spacing: .05em;
                color: var(--texto-tenue);
            }

            #tabla-productos td.acciones {
                display: flex;
                justify-content: flex-end;
                border-top: 1px solid var(--borde);
                margin-top: 2px;
                padding-top: 8px;
            }

            #tabla-productos .enlace-accion {
                font-size: 12px;
            }

            td.vacio {
                padding: 40px 16px;
            }
        }

        /* ===== Paginador (solo móvil, oculto por defecto en cualquier tamaño) ===== */
        .paginador-movil {
            display: none;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 14px 4px 4px;
        }

        .paginador-movil.visible {
            display: flex;
        }

        .paginador-info {
            font-size: 12.5px;
            color: var(--texto-tenue);
        }

        .paginador-paginas {
            display: flex;
            gap: 8px;
        }

        .paginador-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 34px;
            height: 34px;
            border-radius: 6px;
            border: 1px solid var(--borde);
            background: var(--superficie);
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            color: var(--texto);
        }

        .paginador-link:hover {
            background: var(--lienzo);
        }

        .paginador-link.deshabilitado {
            color: #c3c0b8;
            cursor: default;
            pointer-events: none;
        }

        /* ===== Combo buscable (subcategoría) ===== */
        .combo-buscable {
            position: relative;
        }

        .combo-input {
            width: 100%;
            padding: 9px 12px;
            border: 1px solid var(--borde);
            border-radius: 6px;
            font-size: 13.5px;
            font-family: 'Inter', sans-serif;
            background: var(--superficie);
            transition: border-color .15s, box-shadow .15s;
        }

        .combo-input:focus {
            outline: none;
            border-color: var(--pino);
            box-shadow: 0 0 0 3px var(--pino-tinta);
        }

        .combo-opciones {
            display: none;
            position: absolute;
            top: calc(100% + 4px);
            left: 0;
            right: 0;
            max-height: 220px;
            overflow-y: auto;
            background: var(--superficie);
            border: 1px solid var(--borde);
            border-radius: 6px;
            box-shadow: 0 10px 24px rgba(21, 23, 27, .12);
            z-index: 30;
        }

        .combo-opciones.abierto {
            display: block;
        }

        .combo-opcion {
            padding: 9px 12px;
            font-size: 13.5px;
            cursor: pointer;
        }

        .combo-opcion:hover,
        .combo-opcion.resaltada {
            background: var(--lienzo);
        }

        .combo-opcion.oculta {
            display: none;
        }

        .combo-sin-resultados {
            padding: 10px 12px;
            font-size: 12.5px;
            color: var(--texto-tenue);
            display: none;
        }

        .combo-sin-resultados.mostrar {
            display: block;
        }

        .combo-filtro {
            max-width: 240px;
            width: 100%;
        }

        .combo-filtro .combo-input {
            cursor: pointer;
        }
    </style>
@endpush

@section('contenido')


    <div class="cat-encabezado">
        <div class="cat-filtros">
            <div class="buscador">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1 0 5.4 5.4a7.5 7.5 0 0 0 11.25 11.25z" />
                </svg>
                <input type="text" id="buscador-productos" placeholder="Buscar producto...">
            </div>
            <div class="combo-buscable combo-filtro" id="combo-filtro-subcategoria">
                <input type="text" id="filtro-subcategoria-buscar" class="combo-input"
    placeholder="Todas las subcategorías" autocomplete="off">
                <input type="hidden" id="filtro-subcategoria" value="">
                <div class="combo-opciones" id="filtro-combo-opciones">
                    <div class="combo-opcion" data-id="" data-texto="todas las subcategorías todas">
                        Todas las subcategorías
                    </div>
                    @foreach ($subcategorias as $sub)
                        <div class="combo-opcion" data-id="{{ $sub->id }}"
                            data-texto="{{ Str::lower($sub->categoria->nombre . ' ' . $sub->nombre) }}">
                            {{ $sub->categoria->nombre }} · {{ $sub->nombre }}
                        </div>
                    @endforeach
                    <div class="combo-sin-resultados" id="filtro-combo-sin-resultados">Sin resultados</div>
                </div>
            </div>
        </div>
        <button class="btn btn-primario" onclick="abrirModalCrear()">+ Nuevo producto</button>
    </div>

    <div class="tarjeta">
        <div class="tabla-scroll">
            <table>
                <thead>
                    <tr>
                        <th style="width: 62px;"></th>
                        <th>Producto</th>
                        <th style="width: 100px;">Destacado</th>
                        <th style="width: 110px;">Estado</th>
                        <th style="width: 150px;"></th>
                    </tr>
                </thead>
                <tbody id="tabla-productos">
                    @forelse ($productos as $producto)
                        <tr data-nombre="{{ Str::lower($producto->nombre . ' ' . $producto->subcategoria->nombre) }}"
                            data-subcategoria-id="{{ $producto->subcategoria_id }}">
                            <td>
                                @if ($producto->imagenes->first())
                                    <img src="{{ asset('storage/' . $producto->imagenes->first()->ruta) }}" class="miniatura">
                                @else
                                    <div class="miniatura-vacia"></div>
                                @endif
                            </td>
                            <td>
                                <span class="nombre-categoria">{{ $producto->nombre }}</span>
                                <span class="etiqueta-sub">{{ $producto->subcategoria->categoria->nombre }} ·
                                    {{ $producto->subcategoria->nombre }}</span>
                            </td>
                            <td data-label="Destacado">
                                <span class="destacado {{ $producto->destacado ? 'si' : '' }}">
                                    {{ $producto->destacado ? 'Sí' : 'No' }}
                                </span>
                            </td>
                            <td data-label="Estado">
                                <span class="badge {{ $producto->activo ? 'badge-activo' : 'badge-inactivo' }}">
                                    {{ $producto->activo ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="acciones">
                                <a href="{{ route('admin.productos.show', $producto) }}"
                                    class="enlace-accion editar">Editar</a>
                                <button class="enlace-accion eliminar"
                                    onclick="confirmarEliminar({{ $producto->id }}, '{{ addslashes($producto->nombre) }}')">Eliminar</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="vacio">No hay productos todavía. Crea el primero con el botón de
                                arriba.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="paginador-movil" id="paginador-movil"></div>
    </div>

    <!-- Modal creación rápida -->
    <div class="modal-fondo" id="modal-producto">
        <div class="modal-caja">
            <div class="modal-encabezado">
                <h2>Nuevo producto</h2>
                <button class="modal-cerrar" onclick="cerrarModal()">&times;</button>
            </div>
            <div class="modal-cuerpo">
                <form id="form-producto">
                    <div class="campo">
                        <label>Subcategoría</label>
                        <div class="combo-buscable" id="combo-subcategoria">
                            <input type="text" id="input-subcategoria-buscar" class="combo-input"
                                placeholder="Buscar subcategoría..." autocomplete="off">
                            <input type="hidden" name="subcategoria_id" id="input-subcategoria-id">
                            <div class="combo-opciones" id="combo-opciones">
                                @foreach ($subcategorias as $sub)
                                    <div class="combo-opcion" data-id="{{ $sub->id }}"
                                        data-texto="{{ Str::lower($sub->categoria->nombre . ' ' . $sub->nombre) }}">
                                        {{ $sub->categoria->nombre }} · {{ $sub->nombre }}
                                    </div>
                                @endforeach
                                <div class="combo-sin-resultados" id="combo-sin-resultados">Sin resultados</div>
                            </div>
                        </div>
                        <div class="campo-error" id="error-subcategoria"></div>
                    </div>

                    <div class="campo">
                        <label>Nombre</label>
                        <input type="text" name="nombre" required>
                        <div class="campo-error" id="error-nombre"></div>
                    </div>

                    <div class="campo">
                        <label>Descripción</label>
                        <textarea name="descripcion" rows="3"></textarea>
                    </div>

                    <div class="campo">
                        <label class="campo-checkbox"><input type="checkbox" name="destacado" value="1">
                            Destacado</label>
                    </div>

                    <div class="campo">
                        <label class="campo-checkbox"><input type="checkbox" name="activo" value="1" checked>
                            Activo</label>
                    </div>

                    <p class="texto-ayuda">Después de guardar, podrás agregar imágenes y variantes (talla/color/stock).</p>

                    <div class="modal-pie">
                        <button type="button" class="btn btn-secundario" onclick="cerrarModal()">Cancelar</button>
                        <button type="submit" class="btn btn-primario">Guardar y continuar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        const modal = document.getElementById('modal-producto');
        const form = document.getElementById('form-producto');
        // ===== Combo buscable de subcategoría =====
        const inputSubcatBuscar = document.getElementById('input-subcategoria-buscar');
        const inputSubcatId = document.getElementById('input-subcategoria-id');
        const opcionesSubcat = document.getElementById('combo-opciones');
        const sinResultadosSubcat = document.getElementById('combo-sin-resultados');
        const errorSubcategoria = document.getElementById('error-subcategoria');
        const listaOpcionesSubcat = Array.from(opcionesSubcat.querySelectorAll('.combo-opcion'));

        function abrirOpcionesSubcat() {
            opcionesSubcat.classList.add('abierto');
        }

        function cerrarOpcionesSubcat() {
            opcionesSubcat.classList.remove('abierto');
        }

        function filtrarOpcionesSubcat() {
            const texto = inputSubcatBuscar.value.trim().toLowerCase();
            let visibles = 0;

            listaOpcionesSubcat.forEach(function(opcion) {
                const coincide = opcion.dataset.texto.includes(texto);
                opcion.classList.toggle('oculta', !coincide);
                if (coincide) visibles++;
            });

            sinResultadosSubcat.classList.toggle('mostrar', visibles === 0);
        }

        inputSubcatBuscar.addEventListener('focus', function() {
            filtrarOpcionesSubcat();
            abrirOpcionesSubcat();
        });

        inputSubcatBuscar.addEventListener('input', function() {
            inputSubcatId.value = ''; // si edita el texto, invalida la selección anterior
            filtrarOpcionesSubcat();
            abrirOpcionesSubcat();
        });

        opcionesSubcat.addEventListener('click', function(e) {
            const opcion = e.target.closest('.combo-opcion');
            if (!opcion) return;

            inputSubcatBuscar.value = opcion.textContent.trim();
            inputSubcatId.value = opcion.dataset.id;
            errorSubcategoria.textContent = '';
            cerrarOpcionesSubcat();
        });

        document.addEventListener('click', function (e) {
    if (!document.getElementById('combo-subcategoria').contains(e.target)) {
        cerrarOpcionesSubcat();
    }
});

        // ===== Combo buscable del filtro (encabezado) =====
        const inputFiltroBuscar = document.getElementById('filtro-subcategoria-buscar');
        const inputFiltroId = document.getElementById('filtro-subcategoria');
        const opcionesFiltro = document.getElementById('filtro-combo-opciones');
        const sinResultadosFiltro = document.getElementById('filtro-combo-sin-resultados');
        const listaOpcionesFiltro = Array.from(opcionesFiltro.querySelectorAll('.combo-opcion'));

        function abrirOpcionesFiltro() {
            opcionesFiltro.classList.add('abierto');
        }

        function cerrarOpcionesFiltro() {
            opcionesFiltro.classList.remove('abierto');
        }

        function filtrarOpcionesFiltro() {
            const texto = inputFiltroBuscar.value.trim().toLowerCase();
            let visibles = 0;

            listaOpcionesFiltro.forEach(function (opcion) {
                const coincide = opcion.dataset.texto.includes(texto);
                opcion.classList.toggle('oculta', !coincide);
                if (coincide) visibles++;
            });

            sinResultadosFiltro.classList.toggle('mostrar', visibles === 0);
        }

        inputFiltroBuscar.addEventListener('focus', function () {
            inputFiltroBuscar.select();
            filtrarOpcionesFiltro();
            abrirOpcionesFiltro();
        });

        inputFiltroBuscar.addEventListener('input', function () {
            filtrarOpcionesFiltro();
            abrirOpcionesFiltro();
        });

        opcionesFiltro.addEventListener('click', function (e) {
            const opcion = e.target.closest('.combo-opcion');
            if (!opcion) return;

            inputFiltroBuscar.value = opcion.textContent.trim();
            inputFiltroId.value = opcion.dataset.id;
            cerrarOpcionesFiltro();

            paginaActualMovil = 1;
            aplicarFiltros();
        });

        document.addEventListener('click', function (e) {
            if (!document.getElementById('combo-filtro-subcategoria').contains(e.target)) {
                cerrarOpcionesFiltro();
                // Si cierran sin elegir nada de la búsqueda escrita, vuelve a mostrar la opción ya seleccionada
                const opcionActual = listaOpcionesFiltro.find(o => o.dataset.id === inputFiltroId.value);
                inputFiltroBuscar.value = opcionActual ? opcionActual.textContent.trim() : 'Todas las subcategorías';
            }
        });

        function abrirModalCrear() {
            form.reset();
            document.getElementById('error-nombre').textContent = '';
            modal.classList.add('abierto');
        }

        function cerrarModal() {
            modal.classList.remove('abierto');
        }

        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            if (!inputSubcatId.value) {
                errorSubcategoria.textContent = 'Selecciona una subcategoría de la lista.';
                inputSubcatBuscar.focus();
                return;
            }

            const datos = new FormData(form);

            try {
                const respuesta = await fetch('{{ route('admin.productos.store') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: datos,
                });

                const resultado = await respuesta.json();

                if (respuesta.status === 422) {
                    document.getElementById('error-nombre').textContent = resultado.errors?.nombre?.[0] ?? '';
                    return;
                }

                if (!respuesta.ok) throw new Error('Error del servidor');

                await Swal.fire({
                    icon: 'success',
                    title: resultado.mensaje,
                    timer: 1800,
                    showConfirmButton: false
                });
                window.location.href = `/admin/productos/${resultado.id}`;
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Algo salió mal',
                    text: 'Intenta de nuevo.'
                });
            }
        });

        function confirmarEliminar(id, nombre) {
            Swal.fire({
                icon: 'warning',
                title: `¿Eliminar "${nombre}"?`,
                text: 'Esta acción no se puede deshacer.',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#a8402f',
            }).then(async (resultado) => {
                if (!resultado.isConfirmed) return;

                const respuesta = await fetch(`/admin/productos/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                });
                const data = await respuesta.json();

                await Swal.fire({
                    icon: 'success',
                    title: data.mensaje,
                    timer: 1600,
                    showConfirmButton: false
                });
                location.reload();
            });
        }

        // ===== Filtro + paginación (solo móvil) =====
        const FILAS_POR_PAGINA_MOVIL = 10;
        let paginaActualMovil = 1;

        function esMovil() {
            return window.matchMedia('(max-width: 640px)').matches;
        }

        function aplicarFiltros() {
            const texto = document.getElementById('buscador-productos').value.toLowerCase();
            const subcategoriaId = document.getElementById('filtro-subcategoria').value;

            const filas = Array.from(document.querySelectorAll('#tabla-productos tr[data-nombre]'));

            const filasCoinciden = filas.filter(function(fila) {
                const coincideTexto = fila.dataset.nombre.includes(texto);
                const coincideSubcategoria = !subcategoriaId || fila.dataset.subcategoriaId === subcategoriaId;
                return coincideTexto && coincideSubcategoria;
            });

            if (esMovil()) {
                const totalPaginas = Math.max(1, Math.ceil(filasCoinciden.length / FILAS_POR_PAGINA_MOVIL));
                if (paginaActualMovil > totalPaginas) paginaActualMovil = totalPaginas;

                const inicio = (paginaActualMovil - 1) * FILAS_POR_PAGINA_MOVIL;
                const fin = inicio + FILAS_POR_PAGINA_MOVIL;
                const filasVisibles = filasCoinciden.slice(inicio, fin);

                filas.forEach(fila => fila.style.display = 'none');
                filasVisibles.forEach(fila => fila.style.display = '');

                renderPaginadorMovil(totalPaginas, filasCoinciden.length);
            } else {
                filas.forEach(function(fila) {
                    fila.style.display = filasCoinciden.includes(fila) ? '' : 'none';
                });
                document.getElementById('paginador-movil').classList.remove('visible');
            }
        }

        function renderPaginadorMovil(totalPaginas, totalCoincidencias) {
            const contenedor = document.getElementById('paginador-movil');

            if (totalCoincidencias === 0) {
                contenedor.classList.remove('visible');
                contenedor.innerHTML = '';
                return;
            }

            contenedor.classList.add('visible');
            contenedor.innerHTML = `
                <span class="paginador-info">Página ${paginaActualMovil} de ${totalPaginas}</span>
                <div class="paginador-paginas">
                    <button type="button" class="paginador-link ${paginaActualMovil === 1 ? 'deshabilitado' : ''}" data-ir="anterior">&larr;</button>
                    <button type="button" class="paginador-link ${paginaActualMovil === totalPaginas ? 'deshabilitado' : ''}" data-ir="siguiente">&rarr;</button>
                </div>
            `;
        }

        function irArribaDeLaTarjeta() {
            const encabezado = document.querySelector('.cat-encabezado');

            // Doble requestAnimationFrame: espera a que el navegador
            // termine de pintar los cambios de aplicarFiltros() antes de medir/scrollear.
            requestAnimationFrame(function() {
                requestAnimationFrame(function() {
                    encabezado.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                });
            });
        }

        document.getElementById('paginador-movil').addEventListener('click', function(e) {
            const boton = e.target.closest('[data-ir]');
            if (!boton || boton.classList.contains('deshabilitado')) return;

            paginaActualMovil += boton.dataset.ir === 'siguiente' ? 1 : -1;
            aplicarFiltros();
            irArribaDeLaTarjeta();
        });

        document.getElementById('buscador-productos').addEventListener('input', function() {
            paginaActualMovil = 1;
            aplicarFiltros();
        });

       
        let temporizadorResize;
        window.addEventListener('resize', function() {
            clearTimeout(temporizadorResize);
            temporizadorResize = setTimeout(aplicarFiltros, 200);
        });

        aplicarFiltros();
    </script>

@endsection
