function abrirModalEditar(producto) {
    document.getElementById('edit_id').value = producto.id;
    document.getElementById('edit_nombre').value = producto.nombre;
    document.getElementById('edit_precio').value = producto.precio;
    document.getElementById('edit_marca').value = producto.marca;
    document.getElementById('edit_modelo').value = producto.modelo;
    document.getElementById('edit_tipo').value = producto.tipo;
    document.getElementById('edit_categoria').value = producto.id_categoria;
    document.getElementById('edit_especificaciones').value = producto.especificaciones;
    document.getElementById('modalEditar').style.display = 'flex';
}


function cerrarModal() {
    document.getElementById('modalEditar').style.display = 'none';
}

///////////////////Registro
function abrirModalRegistro() {
    document.getElementById('modalRegistro').style.display = 'flex';
}

function cerrarModalRegistro() {
    document.getElementById('modalRegistro').style.display = 'none';
}

////////////////Editar Categoria
function mostrarFormularioEditar(id, nombre) {
    document.getElementById('modalEditarCategoria').style.display = 'flex';
    document.getElementById('edit_id_categoria').value = id;
    document.getElementById('edit_nombre_categoria').value = nombre;
}
function ocultarFormularioEditar() {
    document.getElementById('modalEditarCategoria').style.display = 'none';
}