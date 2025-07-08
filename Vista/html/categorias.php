<?php
if (!isset($_SESSION['admin'])) {
    header("Location: index.php?accion=login");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorias</title>
    <link rel="stylesheet" href="Vista/css/master.css">
    <script src="Vista/Script/script.js"></script>
</head>

<body>
    <header>
        <h1>Tienda de Computadores</h1>
        <nav>
            <a href="index.php?accion=inicio">Inicio</a>
            <a href="index.php?accion=catalogo">Catálogo</a>
            <a href="index.php?accion=login">Zona Admin</a>
            <a href="index.php?accion=panel">Panel</a>
            <a href="index.php?accion=categorias">Categorias</a>
            <a href="index.php?accion=pedidos">Pedidos</a>
            <a href="index.php?accion=logout" style="color:red;">Cerrar Sesión</a>
        </nav>
    </header>


    <!---agregar categorias, etc--->
    <div class="admin-section">
        <h3>Categorías</h3>
        <form class="form-admin" action="index.php?accion=add_categoria" method="POST">
            <input type="text" name="nombre_categoria" placeholder="Nombre de la categoría" required>
            <button type="submit">Guardar Categoría</button>
        </form>
        <ul>
            <?php
            require_once "Modelo/Conexion.php";
            $conexion = new Conexion();
            $conexion->abrir();
            $result = $conexion->consulta("SELECT * FROM categorias");
            if ($result === false) {
                die("Error en la consulta: " . $conexion->mysqli->error);
            }
            while ($cat = $result->fetch_assoc()) {
                $nombre = htmlspecialchars($cat['nombre']);
                $id = $cat['id'];
                echo "<li id='cat-$id'>$nombre
                        <form method='POST' action='index.php?accion=eliminar_categoria' style='display:inline;' onsubmit=\"return confirm('¿Eliminar esta categoría?');\">
                            <input type='hidden' name='id_categoria' value='$id'>
                            <button type='submit' class='btn-admin'>Eliminar</button>
                        </form>
                        <button type='button' class='btn-admin' style='margin-left:5px;' onclick=\"mostrarFormularioEditar($id, '$nombre')\">Editar</button>
                    </li>";
            }
            $conexion->cerrar();
            ?>
        </ul>

        <!-- Modal para editar categoría -->
        <div id="modalEditarCategoria" class="modal">
            <div class="modal-content">
                <h4>Editar Categoría</h4>
                <form id="editarCategoriaForm" method="POST" action="index.php?accion=actualizar_categoria">
                    <input type="hidden" name="id_categoria" id="edit_id_categoria">
                    <input type="text" name="nombre_categoria" id="edit_nombre_categoria" required>
                    <button type="submit">Actualizar</button>
                    <button type="button" onclick="ocultarFormularioEditar()">Cancelar</button>
                </form>
            </div>
        </div>

        <footer>
            <p>&copy; 2025 Tienda de Computadores. Todos los derechos reservados.</p>
        </footer>
</body>

</html>