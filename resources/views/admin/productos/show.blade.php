@extends('admin.layout')
@section('titulo', $producto->nombre)

@push('estilos')
    <style>
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
        .volver {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 600;
            color: var(--texto-tenue);
            text-decoration: none;
            margin-bottom: 18px;
        }

        .volver:hover {
            color: var(--pino);
        }

        .ficha-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 22px;
            align-items: start;
        }

        @media (max-width: 920px) {
            .ficha-grid {
                grid-template-columns: 1fr;
            }
        }

        .tarjeta {
            background: var(--superficie);
            border: 1px solid var(--borde);
            border-radius: 8px;
            padding: 22px;
        }

        .tarjeta+.tarjeta {
            margin-top: 20px;
        }

        .tarjeta-titulo {
            font-family: 'Fraunces', serif;
            font-weight: 550;
            font-size: 16px;
            margin-bottom: 18px;
            letter-spacing: -.005em;
        }

        /* ===== Botones ===== */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 16px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .01em;
            text-decoration: none;
            border: 1px solid transparent;
            cursor: pointer;
            transition: background .15s, border-color .15s;
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
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 12.5px;
        }

        /* ===== Formulario ===== */
        .campo {
            margin-bottom: 18px;
        }

        .campo:last-of-type {
            margin-bottom: 22px;
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
            gap: 10px;
            font-size: 13.5px;
            font-weight: 500;
            color: var(--texto);
            cursor: pointer;
            margin-bottom: 14px;
            user-select: none;
        }

        .campo-checkbox input {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .campo-checkbox .caja {
            position: relative;
            width: 18px;
            height: 18px;
            flex-shrink: 0;
            border: 1.5px solid var(--borde);
            border-radius: 5px;
            background: var(--superficie);
            transition: background .15s, border-color .15s, box-shadow .15s;
        }

        .campo-checkbox .caja::after {
            content: '';
            position: absolute;
            left: 5px;
            top: 1px;
            width: 5px;
            height: 9px;
            border: solid #fff;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg) scale(0);
            transition: transform .15s ease;
        }

        .campo-checkbox input:checked+.caja {
            background: var(--pino);
            border-color: var(--pino);
        }

        .campo-checkbox input:checked+.caja::after {
            transform: rotate(45deg) scale(1);
        }

        .campo-checkbox input:focus-visible+.caja {
            box-shadow: 0 0 0 3px var(--pino-tinta);
        }

        .campo-checkbox:hover .caja {
            border-color: var(--pino);
        }

        /* ===== Galería de imágenes ===== */
        .galeria {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 18px;
        }

        .imagen-tarjeta {
            width: 88px;
        }

        .imagen-marco {
            position: relative;
        }

        .imagen-marco img {
            width: 88px;
            height: 88px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid var(--borde);
            display: block;
        }

        .imagen-eliminar {
            position: absolute;
            top: -7px;
            right: -7px;
            background: var(--superficie);
            border: 1px solid var(--borde);
            border-radius: 50%;
            width: 20px;
            height: 20px;
            cursor: pointer;
            font-size: 12px;
            line-height: 1;
            color: var(--texto-tenue);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .imagen-eliminar:hover {
            background: var(--terracota-tinta);
            color: var(--terracota);
            border-color: #e8b8b0;
        }

        .imagen-color {
            width: 100%;
            margin-top: 6px;
            font-size: 11px;
            padding: 4px 6px;
            border: 1px solid var(--borde);
            border-radius: 4px;
            background: var(--superficie);
            font-family: 'Inter', sans-serif;
        }

        .zona-subida {
            border: 1.5px dashed #d3d0c8;
            border-radius: 8px;
            padding: 18px;
            text-align: center;
        }

        .zona-subida label {
            font-size: 12.5px;
            color: var(--texto-tenue);
            cursor: pointer;
            font-weight: 500;
        }

        .zona-subida label span {
            color: var(--pino);
            font-weight: 600;
        }

        .zona-subida input[type="file"] {
            display: none;
        }

        /* ===== Tabla de variantes (ledger compacto) ===== */
        .tabla-variantes {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }

        .tabla-variantes thead tr {
            border-bottom: 1.5px solid var(--tinta);
        }

        .tabla-variantes th {
            text-align: left;
            padding: 8px 10px;
            color: var(--texto-tenue);
            font-weight: 600;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: .09em;
        }

        .tabla-variantes td {
            padding: 6px 10px;
            font-size: 13.5px;
            border-bottom: 1px solid var(--borde);
        }

        .tabla-variantes tr:last-child td {
            border-bottom: none;
        }

        /* ===== Modal de colores por talla ===== */
        .btn-editar-colores {
            background: none;
            border: 1px solid var(--borde);
            border-radius: 6px;
            padding: 6px 12px;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--pino);
            cursor: pointer;
        }

        .btn-editar-colores:hover {
            background: var(--lienzo);
        }

        .fila-color-modal {
            display: flex;
            gap: 8px;
            align-items: center;
            margin-bottom: 8px;
        }

        .fila-color-modal input[type="text"],
        .fila-color-modal input[type="number"] {
            padding: 8px 10px;
            border: 1px solid var(--borde);
            border-radius: 6px;
            font-size: 13.5px;
            font-family: 'Inter', sans-serif;
        }

        .fila-color-modal input[type="text"] {
            flex: 1;
        }

        .fila-color-modal input[type="number"] {
            width: 70px;
        }

        .fila-color-modal button {
            background: none;
            border: none;
            color: var(--terracota);
            font-size: 18px;
            line-height: 1;
            cursor: pointer;
            padding: 4px 6px;
        }

        .num-stock {
            font-family: 'JetBrains Mono', monospace;
            font-size: 12.5px;
            color: var(--texto);
        }

        .celda-vacia {
            color: #c3c0b8;
        }

        .fila-agregar-variante {
            display: flex;
            gap: 10px;
            align-items: flex-end;
            flex-wrap: wrap;
            padding-top: 4px;
            border-top: 1px solid var(--borde);
            margin-top: 4px;
        }

        .fila-agregar-variante .campo {
            margin: 0;
        }

        .fila-agregar-variante input {
            width: 88px !important;
        }

        /* ===== Inputs editables inline (variantes) ===== */
        .input-variante {
            width: 100%;
            border: 1px solid transparent;
            background: transparent;
            padding: 6px 7px;
            border-radius: 4px;
            font-size: 13.5px;
            font-family: 'Inter', sans-serif;
            color: var(--texto);
            transition: border-color .15s, background .15s;
        }

        .input-variante:hover {
            background: var(--lienzo);
        }

        .input-variante:focus {
            outline: none;
            border-color: var(--pino);
            background: var(--superficie);
            box-shadow: 0 0 0 3px var(--pino-tinta);
        }

        .input-variante.input-stock {
            font-family: 'JetBrains Mono', monospace;
            max-width: 80px;
        }

        .input-variante.guardado {
            border-color: var(--pino);
        }

        /* ===== Responsive ===== */
        @media (max-width: 640px) {
            .tarjeta {
                padding: 16px;
            }

            .ficha-grid {
                gap: 16px;
            }

            .tarjeta-titulo {
                font-size: 15px;
                margin-bottom: 14px;
            }

            #form-datos .btn-primario {
                width: 100%;
                justify-content: center;
            }

            /* Galería más compacta */
            .imagen-tarjeta {
                width: 74px;
            }

            .imagen-marco img {
                width: 74px;
                height: 74px;
            }

            .zona-subida {
                padding: 14px;
            }

            /* Fila para agregar variante: en columna y a ancho completo */
            .fila-agregar-variante {
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
            }

            .fila-agregar-variante .campo {
                width: 100%;
            }

            .fila-agregar-variante input {
                width: 100% !important;
            }

            .fila-agregar-variante .btn {
                width: 100%;
                justify-content: center;
            }

            /* Tabla de variantes -> tarjetas apiladas */
            .tabla-variantes thead {
                display: none;
            }

            .tabla-variantes,
            .tabla-variantes tbody,
            .tabla-variantes tr,
            .tabla-variantes td {
                display: block;
                width: 100%;
            }

            .tabla-variantes tr {
                border: 1px solid var(--borde);
                border-radius: 8px;
                margin-bottom: 8px;
                padding: 8px 10px;
            }

            .tabla-variantes tr:last-child {
                margin-bottom: 0;
            }

            .tabla-variantes td {
                border: none;
                padding: 5px 0;
            }

            .tabla-variantes td[data-label] {
                display: grid;
                grid-template-columns: 60px 1fr;
                align-items: center;
                gap: 8px;
            }

            .tabla-variantes td[data-label]::before {
                content: attr(data-label);
                font-weight: 600;
                font-size: 9.5px;
                text-transform: uppercase;
                letter-spacing: .05em;
                color: var(--texto-tenue);
            }

            .tabla-variantes td:last-child:not(.celda-vacia) {
                text-align: right;
                border-top: 1px solid var(--borde);
                margin-top: 4px;
                padding-top: 8px;
            }


            /* Modal de colores por talla en mobile: todo en una sola fila, más compacto */
            .fila-color-modal {
                gap: 6px;
            }

            .fila-color-modal input[type="text"] {
                min-width: 0;
            }

            .fila-color-modal input[type="number"] {
                width: 52px;
                padding: 8px 6px;
            }

            .fila-color-modal button {
                flex-shrink: 0;
                padding: 4px 2px;
            }
        }
    </style>
@endpush

@section('contenido')

    <a href="{{ route('admin.productos.index') }}" class="volver">&larr; Volver a productos</a>

    <div class="ficha-grid">

        <!-- Datos básicos -->
        <div class="tarjeta">
            <h3 class="tarjeta-titulo">Datos del producto</h3>
            <form id="form-datos">
                                <div class="campo">
                    <label>Subcategoría</label>
                    <div class="combo-buscable" id="combo-subcategoria">
                        <input
                            type="text"
                            id="input-subcategoria-buscar"
                            class="combo-input"
                            placeholder="Buscar subcategoría..."
                            autocomplete="off"
                            value="{{ $producto->subcategoria->categoria->nombre }} · {{ $producto->subcategoria->nombre }}"
                        >
                        <input type="hidden" name="subcategoria_id" id="input-subcategoria-id" value="{{ $producto->subcategoria_id }}">
                        <div class="combo-opciones" id="combo-opciones">
                            @foreach ($subcategorias as $sub)
                                <div
                                    class="combo-opcion"
                                    data-id="{{ $sub->id }}"
                                    data-texto="{{ Str::lower($sub->categoria->nombre.' '.$sub->nombre) }}"
                                >
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
                    <input type="text" name="nombre" value="{{ $producto->nombre }}" required>
                </div>
                <div class="campo">
                    <label>Descripción</label>
                    <textarea name="descripcion" rows="4">{{ $producto->descripcion }}</textarea>
                </div>
                <label class="campo-checkbox">
                    <input type="checkbox" name="destacado" value="1" {{ $producto->destacado ? 'checked' : '' }}>
                    <span class="caja"></span>
                    Destacado
                </label>
                <label class="campo-checkbox">
                    <input type="checkbox" name="activo" value="1" {{ $producto->activo ? 'checked' : '' }}>
                    <span class="caja"></span>
                    Activo
                </label>
                <label class="campo-checkbox">
                    <input type="checkbox" name="tiene_color" value="1" {{ $producto->tiene_color ? 'checked' : '' }}>
                    <span class="caja"></span>
                    Tiene color (mayorista)
                </label>
                <button type="submit" class="btn btn-primario">Guardar cambios</button>
            </form>
        </div>

        <div>
            <!-- Imágenes -->
            <div class="tarjeta">
                <h3 class="tarjeta-titulo">Imágenes</h3>
                <div id="galeria" class="galeria">
                    @php $coloresVariantes = $producto->variantes->pluck('color')->filter()->unique(); @endphp
                    @foreach ($producto->imagenes as $img)
                        <div class="imagen-tarjeta" data-imagen-id="{{ $img->id }}">
                            <div class="imagen-marco">
                                <img src="{{ asset('storage/' . $img->ruta) }}">
                                <button class="imagen-eliminar"
                                    onclick="eliminarImagen({{ $img->id }})">&times;</button>
                            </div>
                            <select class="imagen-color" onchange="actualizarColorImagen({{ $img->id }}, this.value)">
                                <option value="">General</option>
                                @foreach ($coloresVariantes as $color)
                                    <option value="{{ $color }}" {{ $img->color === $color ? 'selected' : '' }}>
                                        {{ $color }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach
                </div>
                <div class="zona-subida">
                    <label for="input-imagenes"><span>Elegir archivos</span> o arrastra aquí las imágenes</label>
                    <input type="file" id="input-imagenes" accept="image/*" multiple>
                </div>
            </div>

            @if ($canal !== 'mayorista')
                <!-- Variantes -->
                <!-- Variantes -->
                <div class="tarjeta">
                    <h3 class="tarjeta-titulo">Variantes (talla - medida / colores / stock)</h3>
                    <table class="tabla-variantes">
                        <thead>
                            <tr>
                                <th>Talla</th>
                                <th>Colores</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="tabla-variantes">
                            @forelse ($variantesPorTalla as $talla => $variantesGrupo)
                                <tr>
                                    <td data-label="Talla">{{ $talla !== '' ? $talla : '—' }}</td>
                                    <td data-label="Colores">
                                        <button type="button" class="btn-editar-colores" data-talla="{{ $talla }}"
                                            data-variantes='@json($variantesGrupo->map(fn($v) => ['id' => $v->id, 'color' => $v->color, 'stock' => $v->stock])->values())'>
                                            {{ $variantesGrupo->count() }}
                                            color{{ $variantesGrupo->count() === 1 ? '' : 'es' }} — editar
                                        </button>
                                    </td>
                                    <td style="text-align:right;">
                                        <button type="button" class="enlace-accion eliminar"
                                            style="background:none;border:none;color:var(--terracota);font-weight:600;font-size:12.5px;cursor:pointer;"
                                            data-eliminar-talla data-talla="{{ $talla }}"
                                            data-ids="{{ $variantesGrupo->pluck('id')->implode(',') }}">
                                            Eliminar 
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="celda-vacia">Sin variantes todavía.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <button type="button" class="btn btn-secundario btn-sm" id="btn-agregar-talla">+ Agregar</button>
                </div>
            @endif
        </div>
    </div>

        <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        const productoId = {{ $producto->id }};
        const coloresDisponibles = @json($coloresVariantes->values());

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

            listaOpcionesSubcat.forEach(function (opcion) {
                const coincide = opcion.dataset.texto.includes(texto);
                opcion.classList.toggle('oculta', !coincide);
                if (coincide) visibles++;
            });

            sinResultadosSubcat.classList.toggle('mostrar', visibles === 0);
        }

        inputSubcatBuscar.addEventListener('focus', function () {
            inputSubcatBuscar.select();
            filtrarOpcionesSubcat();
            abrirOpcionesSubcat();
        });

        inputSubcatBuscar.addEventListener('input', function () {
            inputSubcatId.value = ''; // si edita el texto, invalida la selección anterior
            filtrarOpcionesSubcat();
            abrirOpcionesSubcat();
        });

        opcionesSubcat.addEventListener('click', function (e) {
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

               document.getElementById('form-datos').addEventListener('submit', async function(e) {
    e.preventDefault();

    if (!inputSubcatId.value) {
        errorSubcategoria.textContent = 'Selecciona una subcategoría de la lista.';
        inputSubcatBuscar.focus();
        return;
    }

    const datos = new FormData(e.target);
    datos.append('_method', 'PUT');

    const respuesta = await fetch(`/admin/productos/${productoId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: datos,
    });
    const resultado = await respuesta.json();

    await Swal.fire({
        icon: 'success',
        title: resultado.mensaje,
        timer: 1600,
        showConfirmButton: false
    });

    window.location.href = "{{ route('admin.productos.index') }}";
});

                document.getElementById('input-imagenes').addEventListener('change', async function(e) {
            const datos = new FormData();
            for (const archivo of e.target.files) {
                datos.append('imagenes[]', archivo);
            }

            const respuesta = await fetch(`/admin/productos/${productoId}/imagenes`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: datos,
            });
            const resultado = await respuesta.json();

            resultado.imagenes.forEach(function (img) {
                const opcionesColor = coloresDisponibles.map(function (color) {
                    return `<option value="${color}">${color}</option>`;
                }).join('');

                const html = `
                    <div class="imagen-tarjeta" data-imagen-id="${img.id}">
                        <div class="imagen-marco">
                            <img src="${img.url}">
                            <button class="imagen-eliminar" onclick="eliminarImagen(${img.id})">&times;</button>
                        </div>
                        <select class="imagen-color" onchange="actualizarColorImagen(${img.id}, this.value)">
                            <option value="">General</option>
                            ${opcionesColor}
                        </select>
                    </div>
                `;
                document.getElementById('galeria').insertAdjacentHTML('beforeend', html);
            });

            e.target.value = '';

            await Swal.fire({
                icon: 'success',
                title: resultado.mensaje,
                timer: 1500,
                showConfirmButton: false
            });
        });

        
                function eliminarImagen(id) {
            Swal.fire({
                icon: 'warning',
                title: '¿Eliminar esta imagen?',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#a8402f',
            }).then(async (resultado) => {
                if (!resultado.isConfirmed) return;
                await fetch(`/admin/productos/${productoId}/imagenes/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                });
                document.querySelector(`.imagen-tarjeta[data-imagen-id="${id}"]`).remove();
            });
        }



        function eliminarVariante(id) {
            Swal.fire({
                icon: 'warning',
                title: '¿Eliminar esta variante?',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#a8402f',
            }).then(async (resultado) => {
                if (!resultado.isConfirmed) return;
                await fetch(`/admin/productos/${productoId}/variantes/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                });
                location.reload();
            });
        }

        async function actualizarColorImagen(imagenId, color) {
            await fetch(`/admin/productos/${productoId}/imagenes/${imagenId}`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    color
                }),
            });
        }

        document.getElementById('tabla-variantes').addEventListener('click', function(e) {
            const btnColores = e.target.closest('.btn-editar-colores');
            if (btnColores) {
                abrirModalColores(btnColores.dataset.talla, JSON.parse(btnColores.dataset.variantes));
                return;
            }
            const btnEliminarTalla = e.target.closest('[data-eliminar-talla]');
            if (btnEliminarTalla) {
                const ids = btnEliminarTalla.dataset.ids.split(',').filter(Boolean);
                eliminarTalla(btnEliminarTalla.dataset.talla, ids);
            }
        });

        document.getElementById('btn-agregar-talla').addEventListener('click', function() {
            abrirModalColores(null, []);
        });

        function filaColorHtml(id, color, stock) {
            return `
        <div class="fila-color-modal" ${id ? `data-id="${id}"` : ''}>
            <input type="text" data-campo-color placeholder="Color" value="${color ?? ''}">
            <input type="number" data-campo-stock placeholder="Stock" min="0" value="${stock ?? 0}">
            <button type="button" data-quitar-fila>&times;</button>
        </div>
    `;
        }

        function abrirModalColores(talla, variantesExistentes) {
            const idsAEliminar = [];
            const filasHtml = variantesExistentes.map(v => filaColorHtml(v.id, v.color, v.stock)).join('');

            Swal.fire({
                title: talla === null ? 'Agregar nueva talla o medida' : `Colores — Talla ${talla || '—'}`,
                html: `
            <div style="text-align:left;">
                <label style="display:block;font-size:12.5px;font-weight:600;margin-bottom:6px;">Talla/Medida</label>
                <input type="text" id="modal-talla" value="${talla ?? ''}" placeholder="Ej: M, 38, Único"
                    style="width:100%;padding:8px 10px;border:1px solid #d3d0c8;border-radius:6px;font-size:13.5px;margin-bottom:16px;">

                <label style="display:block;font-size:12.5px;font-weight:600;margin-bottom:6px;">Colores y stock</label>
                <div id="filas-colores">${filasHtml}</div>
                <button type="button" id="btn-agregar-fila-color"
                    style="margin-top:6px;background:none;border:1px dashed #d3d0c8;border-radius:6px;padding:8px 12px;font-size:12.5px;font-weight:600;color:var(--pino);cursor:pointer;width:100%;">
                    + Agregar color
                </button>
            </div>
        `,
                showCancelButton: true,
                confirmButtonText: 'Guardar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#4B5D3F',
                width: window.innerWidth < 640 ? '92%' : 480,
                didOpen: () => {
                    document.getElementById('btn-agregar-fila-color').addEventListener('click', () => {
                        document.getElementById('filas-colores')
                            .insertAdjacentHTML('beforeend', filaColorHtml(null, '', 0));
                    });

                    document.getElementById('filas-colores').addEventListener('click', (e) => {
                        if (e.target.dataset.quitarFila === undefined) return;
                        const fila = e.target.closest('.fila-color-modal');
                        if (fila.dataset.id) idsAEliminar.push(fila.dataset.id);
                        fila.remove();
                    });
                },
                preConfirm: () => {
                    const tallaValor = document.getElementById('modal-talla').value.trim();
                    const filas = document.querySelectorAll('#filas-colores .fila-color-modal');
                    const items = [];

                    filas.forEach(fila => {
                        const color = fila.querySelector('[data-campo-color]').value.trim();
                        const stock = parseInt(fila.querySelector('[data-campo-stock]').value, 10);
                        if (color === '') return;
                        items.push({
                            id: fila.dataset.id || null,
                            color,
                            stock: isNaN(stock) ? 0 : stock
                        });
                    });

                    if (!tallaValor) {
                        Swal.showValidationMessage('Escribe la talla');
                        return false;
                    }
                    if (items.length === 0) {
                        Swal.showValidationMessage('Agrega al menos un color');
                        return false;
                    }
                    return {
                        talla: tallaValor,
                        items
                    };
                }
            }).then(async (resultado) => {
                if (!resultado.isConfirmed) return;
                const {
                    talla: nuevaTalla,
                    items
                } = resultado.value;

                const peticionesEliminar = idsAEliminar.map(id =>
                    fetch(`/admin/productos/${productoId}/variantes/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                    })
                );

                const peticiones = items.map(item => {
                    const cuerpo = JSON.stringify({
                        talla: nuevaTalla,
                        color: item.color,
                        stock: item.stock
                    });
                    if (item.id) {
                        return fetch(`/admin/productos/${productoId}/variantes/${item.id}`, {
                            method: 'PUT',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: cuerpo,
                        });
                    }
                    return fetch(`/admin/productos/${productoId}/variantes`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: cuerpo,
                    });
                });

                await Promise.all([...peticionesEliminar, ...peticiones]);
                location.reload();
            });
        }

        function eliminarTalla(talla, ids) {
            Swal.fire({
                icon: 'warning',
                title: `¿Eliminar la talla ${talla || '—'} y todos sus colores?`,
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#a8402f',
            }).then(async (resultado) => {
                if (!resultado.isConfirmed) return;
                await Promise.all(ids.map(id =>
                    fetch(`/admin/productos/${productoId}/variantes/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                    })
                ));
                location.reload();
            });
        }
    </script>

@endsection
