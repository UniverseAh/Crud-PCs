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
    <title>Document</title>
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

    <section id="panel-admin">
        <h2>Panel de Administración</h2>


        <?php
        require_once "Modelo/Conexion.php";
        $conexion = new Conexion();
        $conexion->abrir();
        $conexion->consulta("SELECT id, nombre FROM categorias");
        $categorias = $conexion->consulta("SELECT id, nombre FROM categorias"); 
        ?>
        <div class="admin-section">
            <h3>Productos</h3>
            <form class="form-admin" action="index.php?accion=add" method="POST" enctype="multipart/form-data">
                <input type="text" name="nombre" id="add_nombre" required placeholder="Nombre">
                <input type="text" name="marca" id="add_marca" required placeholder="Marca">
                <input type="text" name="modelo" id="add_modelo" required placeholder="Modelo">
                <select name="tipo" id="add_tipo" required>
                    <option value="">Seleccionar tipo</option>
                    <option value="Computador">Computador</option>
                    <option value="Repuesto">Repuesto</option>
                </select>
                <textarea name="especificaciones" id="add_especificaciones" required placeholder="Especificaciones"></textarea>
                <input type="number" name="precio" id="add_precio" required placeholder="Precio">
                <select name="id_categoria" id="add_categoria" required>
                    <option value="">Seleccionar categoría</option>

                    <?php while ($cat = $categorias->fetch_assoc()): ?>
                        <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['nombre']); ?></option>
                    <?php endwhile; ?>
                    
                </select>
                <input type="file" name="imagenes[]" multiple>
                <button type="submit">Agregar Producto</button>
            </form>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Tipo</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Especificaciones</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php include 'tabla.php'; ?>
                </tbody>
            </table>
        </div>
    </section>

    <!--------- Modal para editar --------->
    <div id="modalEditar">
        <div class="modal-content">
            <span class="close-modal" onclick="cerrarModal()">&times;</span>
            <h3>Editar Producto</h3>

            <form id="formEditar" action="index.php?accion=actualizar" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" id="edit_id">
                <input type="text" name="nombre" id="edit_nombre" required placeholder="Nombre">
                <input type="text" name="marca" id="edit_marca" required placeholder="Marca">
                <input type="text" name="modelo" id="edit_modelo" required placeholder="Modelo">

                <select name="tipo" id="edit_tipo" required>
                    <option value="">Seleccionar tipo</option>
                    <option value="Computador">Computador</option>
                    <option value="Repuesto">Repuesto</option>
                </select>

                <textarea name="especificaciones" id="edit_especificaciones" required placeholder="Especificaciones"></textarea>
                <input type="number" name="precio" id="edit_precio" required placeholder="Precio">

                <select name="id_categoria" id="edit_categoria" required>
                    <option value="">Seleccionar categoría</option>
                    <?php
                    require_once "Modelo/Conexion.php";
                    $conexion_modal = new Conexion();
                    $conexion_modal->abrir();
                    $categorias_modal = $conexion_modal->consulta("SELECT id, nombre FROM categorias");
                    while ($cat = $categorias_modal->fetch_assoc()):
                    ?>
                        <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['nombre']); ?></option>
                    <?php endwhile; ?>
                    <?php $conexion_modal->cerrar(); ?>
                </select>

                <input type="file" name="imagenes[]" multiple>
                <button type="submit">Actualizar</button>

            </form>
        </div>
    </div>


    <footer>
        <p>&copy; 2025 Tienda de Tenis. Todos los derechos reservados.</p>
    </footer>

</body>

</html>