<?php
session_start();
if (!isset($_SESSION['cliente'])) {
    header("Location: index.php?accion=login");
    exit;
}
$carrito = $_SESSION['carrito'] ?? [];
?>

<h2>Carrito de compras</h2>
<table>
    <tr><th>Producto</th><th>Cantidad</th></tr>
    <?php foreach ($carrito as $id_producto => $cantidad): ?>
        <tr>
            <td><?php echo $id_producto;?></td>
            <td><?php echo $cantidad; ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<form method="POST" action="index.php?accion=confirmar_pedido">
    <button type="submit">Confirmar pedido</button>
</form>

<!--NO SIRVE AAAAAAAAAAAAAAAAAAAAA-->