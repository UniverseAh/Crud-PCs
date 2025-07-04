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
    <title>Pedidos</title>
    <link rel="stylesheet" href="Vista/css/master.css">
    <script src="Vista/Script/script.js"></script>
</head>

<body>
    <header>
        <h1>Tienda de Tenis</h1>
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


    <div class="admin-section">
        <h3>Pedidos</h3>
        <table>
            <thead>
                <tr>
                    <th>ID Pedido</th>
                    <th>Cliente</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                </tr>
            </thead>


            <tbody>
                <?php if (!empty($pedidos)): ?>
                    <?php foreach ($pedidos as $pedido): ?>
                        <tr>
                            <td><?php echo $pedido['id']; ?></td>
                            <td><?php echo htmlspecialchars($pedido['cliente']); ?></td>
                            <td><?php echo htmlspecialchars($pedido['producto']); ?></td>
                            <td><?php echo $pedido['cantidad']; ?></td>
                            <td><?php echo $pedido['fecha']; ?></td>
                            <td>
                                <form method="POST" action="index.php?accion=cambiar_estado_pedido">
                                    <input type="hidden" name="id_pedido" value="<?php echo $pedido['id']; ?>">
                                    <select name="nuevo_estado" onchange="this.form.submit()">
                                        <option value="pendiente"   <?php if($pedido['estado']=='pendiente') echo 'selected'; ?>>Pendiente</option>
                                        <option value="enviado"     <?php if($pedido['estado']=='enviado') echo 'selected'; ?>>Enviado</option>
                                        <option value="entregado"   <?php if($pedido['estado']=='entregado') echo 'selected'; ?>>Entregado</option>
                                        <option value="cancelado"   <?php if($pedido['estado']=='cancelado') echo 'selected'; ?>>Cancelado</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No hay pedidos registrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>


        </table>
    </div>
    </section>


    <footer>
        <p>&copy; 2025 Tienda de Tenis. Todos los derechos reservados.</p>
    </footer>

</body>

</html>