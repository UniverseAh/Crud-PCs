<?php
if (!isset($_SESSION['cliente'])) {
    header("Location: index.php?accion=loginCliente");
    exit;
}
$carrito = $_SESSION['carrito'] ?? [];
$cliente_logueado = isset($_SESSION['cliente']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="Vista/css/master.css">
    <script src="Vista/Script/script.js"></script>
</head>
<body>
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

    <section id="carrito">
        <h2>Carrito de compras</h2>
        <table>
            <tr><th>Producto</th><th>Cantidad</th><th>Accion</th></tr>
            <?php foreach ($carrito as $id_producto => $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['nombre']); ?></td>
                    <td><?php echo $item['cantidad']; ?></td>
                    <td><a href="index.php?accion=eliminarItem&id=<?= $id_producto ?>">Eliminar</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <form method="POST" action="index.php?accion=confirmarPedido">
            <button type="submit">Confirmar pedido</button>
        </form>
    </section>

    <footer>
        <p>&copy; 2025 Tienda de Tenis. Todos los derechos reservados.</p>
    </footer>
</body>
</html>