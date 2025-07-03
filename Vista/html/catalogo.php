<?php
require_once "Modelo/Conexion.php";
$conexion = new Conexion();
$conexion->abrir();

// Filtros para productos
$por_pagina = 6;
$pagina = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
$busqueda = isset($_GET['busqueda']) ? $conexion->mysqli->real_escape_string($_GET['busqueda']) : '';
$categoria = isset($_GET['categoria']) ? intval($_GET['categoria']) : 0;

// Filtros
$where = "WHERE 1";
if ($busqueda) {
    $where .= " AND p.nombre LIKE '%$busqueda%'";
}
if ($categoria) {
    $where .= " AND p.id_categoria = $categoria";
}

$total_result = $conexion->consulta("SELECT COUNT(*) as total FROM productos p $where");
$total_row = $total_result->fetch_assoc();
$total_productos = $total_row['total'];
$total_paginas = max(1, ceil($total_productos / $por_pagina));
$offset = ($pagina - 1) * $por_pagina;

// Consulta de productos
$sql = "SELECT p.id, p.nombre, p.marca, p.modelo, p.tipo, p.precio, p.especificaciones, c.nombre AS categoria,
    (SELECT url_imagen FROM imagenes_producto WHERE id_producto = p.id LIMIT 1) AS imagen
    FROM productos p
    INNER JOIN categorias c ON p.id_categoria = c.id
    $where
    ORDER BY p.id DESC
    LIMIT $por_pagina OFFSET $offset";
$result = $conexion->consulta($sql);

// Consulta categorías para filtro
$categorias_result = $conexion->consulta("SELECT id, nombre FROM categorias");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tienda De Computadores - Catálogo</title>
    <link rel="stylesheet" href="Vista/css/master.css">
    <script src="Vista/Script/script.js"></script>
</head>
<body>
    <main class="catalogo">
        <header>
            <h1>Tienda de Computadores</h1>
            <nav>
                <a href="index.php?accion=inicio">Inicio</a>
                <a href="index.php?accion=catalogo">Catálogo</a>
                <a href="index.php?accion=login">Zona Admin</a>
            </nav>
        </header>
        <section id="catalogo">
            <h2>Catálogo de Productos</h2>

            <!-- Filtros -->
            <form class="catalogo-filtros" method="get" action="index.php">
                <input type="hidden" name="accion" value="catalogo">
                <input type="text" name="busqueda" placeholder="Buscar por nombre..." value="<?php echo htmlspecialchars($busqueda); ?>">
                <select name="categoria">
                    <option value="0">Todas las categorías</option>
                    <?php while($cat = $categorias_result->fetch_assoc()): ?>
                        <option value="<?php echo $cat['id']; ?>" <?php if($categoria == $cat['id']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($cat['nombre']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
                <button type="submit">Filtrar</button>
            </form>

            <!-- Productos -->
            <div class="productos">
                <?php if($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <div class="producto">
                            <img src="<?php echo $row['imagen'] ? htmlspecialchars($row['imagen']) : 'Vista/imagenes/sin-imagen.png'; ?>" alt="Producto">
                            <h3><?php echo htmlspecialchars($row['nombre']); ?></h3>
                            <p>Categoría: <?php echo htmlspecialchars($row['categoria']); ?></p>
                            <p>Marca: <?php echo htmlspecialchars($row['marca']); ?></p>
                            <p>Modelo: <?php echo htmlspecialchars($row['modelo']); ?></p>
                            <p>Tipo: <?php echo htmlspecialchars($row['tipo']); ?></p>
                            <p>Precio: $<?php echo number_format($row['precio'], 0, ',', '.'); ?></p>
                            <p>Especificaciones: <?php echo htmlspecialchars($row['especificaciones']); ?></p>
                            <button type="button" onclick="abrirModalRegistro()">Solicitar Compra</button>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No se encontraron productos.</p>
                <?php endif; ?>
            </div>

            <!-- Paginación(?) -->
            <div class="paginacion">
                <?php if($pagina > 1): ?>
                    <a href="index.php?accion=catalogo&pagina=1&busqueda=<?php echo urlencode($busqueda); ?>&categoria=<?php echo $categoria; ?>">&laquo; Primero</a>
                    <a href="index.php?accion=catalogo&pagina=<?php echo $pagina-1; ?>&busqueda=<?php echo urlencode($busqueda); ?>&categoria=<?php echo $categoria; ?>">&lt; Anterior</a>
                
                    <?php endif; ?>
                <span class="actual">Página <?php echo $pagina; ?> de <?php echo $total_paginas; ?></span>
                <?php if($pagina < $total_paginas): ?>

                    <a href="index.php?accion=catalogo&pagina=<?php echo $pagina+1; ?>&busqueda=<?php echo urlencode($busqueda); ?>&categoria=<?php echo $categoria; ?>">Siguiente &gt;</a>
                    <a href="index.php?accion=catalogo&pagina=<?php echo $total_paginas; ?>&busqueda=<?php echo urlencode($busqueda); ?>&categoria=<?php echo $categoria; ?>">Última &raquo;</a>
                <?php endif; ?>
            </div>
        </section>

        <!-- Modal de registro clientes -->
        <div id="modalRegistro" style="display:none;" class="modal-bg">
            <div class="modal-content">
                <span class="close-modal" onclick="cerrarModalRegistro()">&times;</span>
                <h3>Regístrate para comprar</h3>
                <form id="formRegistro" action="index.php?accion=registro_cliente" method="POST">
                    <input type="text" name="nombre" placeholder="Nombre completo" required>
                    <input type="email" name="correo" placeholder="Correo electrónico" required>
                    <input type="text" name="telefono" placeholder="Teléfono" required>
                    <input type="password" name="contraseña" placeholder="Contraseña" required>
                    <button type="submit">Registrarme</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
<?php $conexion->cerrar(); ?>