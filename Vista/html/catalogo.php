<?php
require_once "Modelo/Conexion.php";
require_once "Modelo/GestorCatalogo.php";
//session_start(); // Asegúrate de tener la sesión iniciada

$cliente_logueado = isset($_SESSION['cliente']);
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
                <?php 
                // CONDICIONAL PARA QUE CUANDO UN CLIENTE ESTGE LOGUEADO LA OPC DE ZONA ADMIN NO LE SALGA PERO SI AGREGRE EL CARRITO Y EL CERRAR SESION
                    if ($cliente_logueado) {
                        // ESTO LO MUESTRA SOLO SI EL USER TIPO CLIENTE ESTA LOGUEADO
                        echo "<a href='index.php?accion=carrito'>Carrito</a>";
                        echo "<a href='index.php?accion=cerrar_sesion' style='color:red;'>Cerrar Sesión</a>";
                    } else {
                        // ESTO LO MUESTRA SI NO AHI NINGUN USUARIO LOGUEADO
                        echo "<a href='index.php?accion=loginCliente'>Login Cliente</a>";
                        echo "<a href='index.php?accion=login'>Zona Admin</a>";
                        
                    } 
                ?>
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
                    <?php while ($cat = $categorias_result->fetch_assoc()): ?>
                        <option value="<?php echo $cat['id']; ?>" <?php if ($categoria == $cat['id']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($cat['nombre']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
                <button type="submit">Filtrar</button>
            </form>

            <!-- Productos -->
            <div class="productos">
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="producto">


                            <?php
                            ///cosito pa mostrar todas las fotos de tin y de tan
                            // Obtener todas las imágenes del producto
                            $imagenes = [];
                            $imagenes_result = $conexion->consulta("SELECT url_imagen FROM imagenes_producto WHERE id_producto = " . intval($row['id']));
                            while ($img = $imagenes_result->fetch_assoc()) {
                                $imagenes[] = $img['url_imagen'];
                            }
                            // Si no hay imágen usar la imagen por defecto
                            if (count($imagenes) === 0) {
                                $imagenes[] = 'Vista/imagenes/SinImagen.jpeg';
                            }
                            ?>
                            <div class="galeria-imagenes">
                                <?php foreach ($imagenes as $img_url): ?>
                                    <img src="<?php echo htmlspecialchars($img_url); ?>" alt="Producto" style="width:100px; margin:3px;">
                                <?php endforeach; ?>


                            </div>
                            <h3><?php echo htmlspecialchars($row['nombre']); ?></h3>
                            <p>Categoría: <?php echo htmlspecialchars($row['categoria']); ?></p>
                            <p>Marca: <?php echo htmlspecialchars($row['marca']); ?></p>
                            <p>Modelo: <?php echo htmlspecialchars($row['modelo']); ?></p>
                            <p>Tipo: <?php echo htmlspecialchars($row['tipo']); ?></p>
                            <p>Precio: $<?php echo number_format($row['precio'], 0, ',', '.'); ?></p>
                            <p>Especificaciones: <?php echo htmlspecialchars($row['especificaciones']); ?></p>
                            <?php if ($cliente_logueado): ?>
                                <form method="POST" action="index.php?accion=agregar_al_carrito" style="display:inline;">
                                    <input type="hidden" name="id_producto" value="<?php echo $row['id']; ?>">
                                    <input type="hidden" name="nombre" value="<?php echo $row['nombre']; ?>">
                                    <input type="number" name="cantidad" value="1" min="1" style="width:50px;">
                                    <button type="submit">Solicitar Compra</button>
                                </form>
                                
                            <?php else: ?>
                                <button type="button" onclick="abrirModalRegistro()">Solicitar Compra</button>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No se encontraron productos.</p>
                <?php endif; ?>
            </div>

            <!-- Paginación(?) -->
            <div class="paginacion">
                <?php if ($pagina > 1): ?>
                    <a href="index.php?accion=catalogo&pagina=1&busqueda=<?php echo urlencode($busqueda); ?>&categoria=<?php echo $categoria; ?>">&laquo; Primero</a>
                    <a href="index.php?accion=catalogo&pagina=<?php echo $pagina - 1; ?>&busqueda=<?php echo urlencode($busqueda); ?>&categoria=<?php echo $categoria; ?>">&lt; Anterior</a>

                <?php endif; ?>
                <span class="actual">Página <?php echo $pagina; ?> de <?php echo $total_paginas; ?></span>
                <?php if ($pagina < $total_paginas): ?>

                    <a href="index.php?accion=catalogo&pagina=<?php echo $pagina + 1; ?>&busqueda=<?php echo urlencode($busqueda); ?>&categoria=<?php echo $categoria; ?>">Siguiente &gt;</a>
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
    <footer>
        <p>&copy; 2025 Tienda de Computadores. Todos los derechos reservados.</p>
    </footer>
    
</body>

</html>
<?php $conexion->cerrar(); ?>