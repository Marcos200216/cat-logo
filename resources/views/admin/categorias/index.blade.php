@extends('admin.layout')
@section('titulo', 'Categorías')

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
    }

    .buscador { position: relative; max-width: 300px; width: 100%; }
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
    .buscador input::placeholder { color: #a3a7af; }
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
    .btn-primario { background: var(--pino); color: #fff; }
    .btn-primario:hover { background: var(--pino-oscuro); }
    .btn-secundario { background: var(--superficie); color: var(--texto); border-color: var(--borde); }
    .btn-secundario:hover { background: var(--lienzo); border-color: #d3d0c8; }

    /* ===== Tarjeta / ledger con scroll interno ===== */
    .tarjeta {
        background: var(--superficie);
        border: 1px solid var(--borde);
        border-radius: 8px;
        overflow: hidden;
    }

    .tabla-scroll {
        max-height: 320px;
        overflow-y: auto;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    table { width: 100%; min-width: 560px; border-collapse: collapse; }

    thead tr { border-bottom: 1.5px solid var(--tinta); }
    thead th {
        position: sticky;
        top: 0;
        background: var(--superficie);
        z-index: 1;
    }

    th, td {
        text-align: left;
        padding: 14px 18px;
        font-size: 13.5px;
    }
    th {
        color: var(--texto-tenue);
        font-weight: 600;
        font-size: 10.5px;
        text-transform: uppercase;
        letter-spacing: .1em;
    }
    tbody tr { border-bottom: 1px solid var(--borde); transition: background .1s; }
    tbody tr:hover { background: #fbfaf8; }
    tbody tr:last-child { border-bottom: none; }

    /* Scrollbar discreta, a tono con la paleta */
    .tabla-scroll::-webkit-scrollbar { width: 8px; height: 8px; }
    .tabla-scroll::-webkit-scrollbar-track { background: transparent; }
    .tabla-scroll::-webkit-scrollbar-thumb {
        background: #d8d5cd;
        border-radius: 8px;
    }
    .tabla-scroll::-webkit-scrollbar-thumb:hover { background: #c3c0b8; }

    .num-orden {
        font-family: 'JetBrains Mono', monospace;
        font-size: 12.5px;
        color: var(--texto-tenue);
    }
    .nombre-categoria {
        font-family: 'Fraunces', serif;
        font-weight: 500;
        font-size: 16px;
        letter-spacing: -.005em;
    }

    td.acciones { text-align: right; white-space: nowrap; }
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
    .enlace-accion.editar { color: var(--pino); }
    .enlace-accion.editar:hover { text-decoration: underline; }
    .enlace-accion.eliminar { color: var(--terracota); margin-left: 18px; }
    .enlace-accion.eliminar:hover { text-decoration: underline; }

    td.vacio {
        text-align: center;
        color: var(--texto-tenue);
        padding: 56px 16px;
        font-size: 13.5px;
    }

    /* ===== Drag and drop ===== */
    .asa-arrastre {
        width: 32px;
        text-align: center;
        cursor: grab;
        color: var(--texto-tenue);
        font-size: 16px;
        letter-spacing: -1px;
    }
    .asa-arrastre:hover { color: var(--pino); }
    tr.fila-arrastrando { opacity: .4; background: var(--lienzo); }
    tr.fila-fantasma { background: var(--pino-tinta) !important; }

    /* ===== Badges ===== */
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: .02em;
    }
    .badge::before { content: ''; width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
    .badge-activo { color: var(--pino-oscuro); }
    .badge-activo::before { background: var(--pino); }
    .badge-inactivo { color: var(--texto-tenue); }
    .badge-inactivo::before { background: #c3c0b8; }

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
    .modal-fondo.abierto { display: flex; }
    .modal-caja {
        background: var(--superficie);
        border-radius: 10px;
        width: 460px;
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
    .modal-cerrar:hover { background: var(--lienzo); color: var(--texto); }
    .modal-cuerpo { padding: 24px; }
    .modal-pie {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 6px;
    }

    /* ===== Formulario ===== */
    .campo { margin-bottom: 18px; }
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
    .campo input[type="file"] {
        width: 100%;
        padding: 9px 12px;
        border: 1px solid var(--borde);
        border-radius: 6px;
        font-size: 13.5px;
        font-family: 'Inter', sans-serif;
        transition: border-color .15s, box-shadow .15s;
    }
    .campo input[type="text"]:focus,
    .campo input[type="number"]:focus {
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
    .campo-checkbox input { width: auto; }
    .campo-error { color: var(--terracota); font-size: 12.5px; margin-top: 5px; }
    .texto-ayuda { font-size: 12px; color: var(--texto-tenue); margin-top: 6px; }

    /* ===== Recortador de imagen ===== */
    .contenedor-recorte {
        display: none;
        margin-top: 10px;
        max-height: 300px;
        overflow: hidden;
        border-radius: 6px;
        border: 1px solid var(--borde);
        background: #000;
    }
    .contenedor-recorte img {
        display: block;
        max-width: 100%;
    }
    .texto-recorte {
        display: none;
        font-size: 11.5px;
        color: var(--texto-tenue);
        margin-top: 7px;
        line-height: 1.4;
    }

    /* ===== Responsive ===== */
    @media (max-width: 640px) {
        .cat-encabezado {
            flex-direction: column;
            align-items: stretch;
            gap: 10px;
        }
        .buscador { max-width: 100%; }
        .cat-encabezado .btn-primario { width: 100%; }

        .modal-encabezado { padding: 16px 18px; }
        .modal-cuerpo { padding: 18px; }

        /* La tabla se convierte en tarjetas apiladas */
        .tabla-scroll { overflow-x: visible; max-height: none; }

        .tarjeta thead { display: none; }

        /* Se quita el borde exterior de la tarjeta contenedora para no duplicar
           el recuadro con el de cada fila; ahora solo hay un nivel de "caja" */
        .tarjeta {
            border: none;
            border-radius: 0;
            background: transparent;
        }

        .tarjeta table,
        .tarjeta tbody,
        #tabla-categorias tr,
        #tabla-categorias td {
            display: block;
            width: 100%;
            min-width: 0;
        }

        #tabla-categorias tr[data-id] {
            border: 1px solid var(--borde);
            border-radius: 8px;
            background: var(--superficie);
            margin: 0 0 8px 0;
            padding: 8px 12px;
            position: relative;
        }
        #tabla-categorias tr[data-id]:last-child { margin-bottom: 0; }

        #tabla-categorias .nombre-categoria { font-size: 13.5px; }
        #tabla-categorias .num-orden { font-size: 11.5px; }
        #tabla-categorias .badge { font-size: 11px; }

        #tabla-categorias td {
            border: none;
            padding: 5px 0;
        }

        #tabla-categorias td[data-label] {
            display: grid;
            grid-template-columns: 76px 1fr;
            align-items: center;
            justify-items: start;
            gap: 8px;
        }

        #tabla-categorias td[data-label]::before {
            content: attr(data-label);
            font-weight: 600;
            font-size: 9.5px;
            text-transform: uppercase;
            letter-spacing: .05em;
            color: var(--texto-tenue);
        }

        #tabla-categorias td.acciones {
            display: flex;
            justify-content: flex-end;
            border-top: 1px solid var(--borde);
            margin-top: 4px;
            padding-top: 8px;
        }

        #tabla-categorias .enlace-accion { font-size: 12px; }

        /* El arrastre manual no es práctico en táctil; se posiciona como acento sutil */
        #tabla-categorias .asa-arrastre {
            position: absolute;
            top: 8px;
            right: 12px;
            width: auto;
            padding: 0;
            font-size: 13px;
        }
        #tabla-categorias tr[data-id] { padding-right: 30px; }

        td.vacio { padding: 40px 16px; }
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
@endpush

@section('contenido')

    <div class="cat-encabezado">
        <div class="buscador">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1 0 5.4 5.4a7.5 7.5 0 0 0 11.25 11.25z"/></svg>
            <input type="text" id="buscador-categorias" placeholder="Buscar categoría...">
        </div>
        <button class="btn btn-primario" onclick="abrirModalCrear()">+ Nueva categoría</button>
    </div>

    <div class="tarjeta">
        <div class="tabla-scroll">
            <table>
                <thead>
                    <tr>
                        <th style="width: 32px;"></th>
                        <th style="width: 70px;">Orden</th>
                        <th>Nombre</th>
                        <th style="width: 120px;">Estado</th>
                        <th style="width: 150px;"></th>
                    </tr>
                </thead>
                <tbody id="tabla-categorias">
                    @forelse ($categorias as $categoria)
                        <tr data-nombre="{{ Str::lower($categoria->nombre) }}" data-id="{{ $categoria->id }}">
                            <td class="asa-arrastre">⠿</td>
                            <td data-label="Orden"><span class="num-orden">{{ str_pad($categoria->orden, 2, '0', STR_PAD_LEFT) }}</span></td>
                            <td data-label="Nombre"><span class="nombre-categoria">{{ $categoria->nombre }}</span></td>
                            <td data-label="Estado">
                                <span class="badge {{ $categoria->activo ? 'badge-activo' : 'badge-inactivo' }}">
                                    {{ $categoria->activo ? 'Activa' : 'Inactiva' }}
                                </span>
                            </td>
                            <td class="acciones">
                                <button class="enlace-accion editar"
    onclick="abrirModalEditar({{ $categoria->id }}, '{{ addslashes($categoria->nombre) }}', {{ $categoria->activo ? 'true' : 'false' }}, '{{ $categoria->imagen }}')">
    Editar
</button>
                                <button class="enlace-accion eliminar" onclick="confirmarEliminar({{ $categoria->id }}, '{{ addslashes($categoria->nombre) }}')">Eliminar</button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="vacio">No hay categorías todavía. Crea la primera con el botón de arriba.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal crear/editar -->
    <div class="modal-fondo" id="modal-categoria">
        <div class="modal-caja">
            <div class="modal-encabezado">
                <h2 id="modal-titulo">Nueva categoría</h2>
                <button class="modal-cerrar" onclick="cerrarModal()">&times;</button>
            </div>
            <div class="modal-cuerpo">
                <form id="form-categoria" enctype="multipart/form-data">
                    <input type="hidden" id="categoria-id" value="">

                    <div class="campo">
                        <label>Nombre</label>
                        <input type="text" name="nombre" id="categoria-nombre" required>
                        <div class="campo-error" id="error-nombre"></div>
                    </div>

                    <div class="campo">
                        <label>Imagen de portada</label>
                        <input type="file" name="imagen" id="categoria-imagen" accept="image/*">
                        <p id="imagen-actual" class="texto-ayuda"></p>

                        <div class="contenedor-recorte" id="contenedor-recorte">
                            <img id="cropper-imagen" src="" alt="">
                        </div>
                        <p class="texto-recorte" id="texto-recorte">
                            Arrastra o haz zoom para elegir qué parte de la foto se va a mostrar.
                        </p>
                    </div>

                    <div class="campo">
                        <label class="campo-checkbox">
                            <input type="checkbox" name="activo" id="categoria-activo" value="1" checked>
                            Activa (visible en el catálogo)
                        </label>
                    </div>

                    <div class="modal-pie">
                        <button type="button" class="btn btn-secundario" onclick="cerrarModal()">Cancelar</button>
                        <button type="submit" class="btn btn-primario">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        const modal = document.getElementById('modal-categoria');
        const form = document.getElementById('form-categoria');

        // ===== Recortador de imagen =====
        // Proporción vertical (3:4), la misma que usan las tarjetas de categoría en móvil,
        // que es donde prioritariamente se van a ver estas fotos.
        const PROPORCION_RECORTE = 3 / 4;

        const inputImagen = document.getElementById('categoria-imagen');
        const contenedorRecorte = document.getElementById('contenedor-recorte');
        const imgRecorte = document.getElementById('cropper-imagen');
        const textoRecorte = document.getElementById('texto-recorte');
        let cropper = null;

        function destruirRecorte() {
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
            contenedorRecorte.style.display = 'none';
            textoRecorte.style.display = 'none';
            imgRecorte.src = '';
        }

        inputImagen.addEventListener('change', function (e) {
            const archivo = e.target.files[0];
            if (!archivo) {
                destruirRecorte();
                return;
            }

            const lector = new FileReader();
            lector.onload = function (ev) {
                imgRecorte.src = ev.target.result;
                contenedorRecorte.style.display = 'block';
                textoRecorte.style.display = 'block';

                if (cropper) cropper.destroy();
                cropper = new Cropper(imgRecorte, {
                    aspectRatio: PROPORCION_RECORTE,
                    viewMode: 1,
                    autoCropArea: 1,
                    background: false,
                    responsive: true,
                });
            };
            lector.readAsDataURL(archivo);
        });

        function obtenerImagenRecortada() {
            if (!cropper) return null;

            return new Promise(function (resolve) {
                cropper.getCroppedCanvas({
                    width: 900,
                    height: Math.round(900 / PROPORCION_RECORTE),
                    imageSmoothingQuality: 'high',
                }).toBlob(resolve, 'image/jpeg', 0.9);
            });
        }

        function abrirModalCrear() {
    document.getElementById('modal-titulo').textContent = 'Nueva categoría';
    document.getElementById('categoria-id').value = '';
    document.getElementById('categoria-nombre').value = '';
    document.getElementById('categoria-activo').checked = true;
    document.getElementById('imagen-actual').textContent = '';
    document.getElementById('error-nombre').textContent = '';
    inputImagen.value = '';
    destruirRecorte();
    modal.classList.add('abierto');
}

function abrirModalEditar(id, nombre, activo, imagen) {
    document.getElementById('modal-titulo').textContent = 'Editar categoría';
    document.getElementById('categoria-id').value = id;
    document.getElementById('categoria-nombre').value = nombre;
    document.getElementById('categoria-activo').checked = activo;
    document.getElementById('imagen-actual').textContent = imagen ? 'Imagen actual: ' + imagen : '';
    document.getElementById('error-nombre').textContent = '';
    inputImagen.value = '';
    destruirRecorte();
    modal.classList.add('abierto');
}

        function cerrarModal() {
            modal.classList.remove('abierto');
        }

        form.addEventListener('submit', async function (e) {
            e.preventDefault();

            const id = document.getElementById('categoria-id').value;
            const datos = new FormData(form);
            const esEdicion = !!id;

            // Si hay una foto seleccionada y recortada, se reemplaza el archivo
            // original por la versión ya recortada antes de enviarla.
            const imagenRecortada = await obtenerImagenRecortada();
            if (imagenRecortada) {
                datos.delete('imagen');
                datos.append('imagen', imagenRecortada, 'categoria.jpg');
            }

            if (esEdicion) {
                datos.append('_method', 'PUT');
            }

            const url = esEdicion ? `/admin/categorias/${id}` : '/admin/categorias';

            try {
                const respuesta = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: datos,
                });

                const resultado = await respuesta.json();

                if (respuesta.status === 422) {
                    document.getElementById('error-nombre').textContent = resultado.errors?.nombre?.[0] ?? '';
                    return;
                }

                if (!respuesta.ok) {
                    throw new Error('Error del servidor');
                }

                cerrarModal();
                await Swal.fire({
                    icon: 'success',
                    title: resultado.mensaje,
                    timer: 1600,
                    showConfirmButton: false,
                });
                location.reload();
            } catch (error) {
                Swal.fire({ icon: 'error', title: 'Algo salió mal', text: 'Intenta de nuevo.' });
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

                try {
                    const respuesta = await fetch(`/admin/categorias/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        },
                    });

                    const data = await respuesta.json();

                    await Swal.fire({
                        icon: 'success',
                        title: data.mensaje,
                        timer: 1600,
                        showConfirmButton: false,
                    });
                    location.reload();
                } catch (error) {
                    Swal.fire({ icon: 'error', title: 'No se pudo eliminar', text: 'Intenta de nuevo.' });
                }
            });
        }

        const sortableCategorias = new Sortable(document.getElementById('tabla-categorias'), {
    handle: '.asa-arrastre',
    animation: 150,
    ghostClass: 'fila-fantasma',
    dragClass: 'fila-arrastrando',
    onEnd: async function () {
        const filas = [...document.querySelectorAll('#tabla-categorias tr[data-id]')];
        const ids = filas.map(fila => fila.dataset.id);

        try {
            await fetch('{{ route('admin.categorias.reordenar') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ ids }),
            });

            filas.forEach(function (fila, posicion) {
                const etiquetaOrden = fila.querySelector('.num-orden');
                if (etiquetaOrden) {
                    etiquetaOrden.textContent = String(posicion).padStart(2, '0');
                }
            });
        } catch (error) {
            Swal.fire({ icon: 'error', title: 'No se pudo guardar el nuevo orden', text: 'Intenta de nuevo.' });
        }
    }
});

        document.getElementById('buscador-categorias').addEventListener('input', function (e) {
            const texto = e.target.value.toLowerCase();
            sortableCategorias.option('disabled', texto.length > 0);
            document.querySelectorAll('#tabla-categorias tr[data-nombre]').forEach(function (fila) {
                fila.style.display = fila.dataset.nombre.includes(texto) ? '' : 'none';
            });
        });
    </script>

@endsection