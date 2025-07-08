<?php
if (!isset($_SESSION['admin'])) {
    header("Location: index.php?accion=login");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="Vista/css/master.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <header>
        <h1>Dashboard - Zona Admin</h1>
        <nav>
            <a href="index.php?accion=inicio">Inicio</a>
            <a href="index.php?accion=catalogo">Catálogo</a>
            <a href="index.php?accion=login">Zona Admin</a>
            <a href="index.php?accion=panel">Panel</a>
            <a href="index.php?accion=categorias">Categorias</a>
            <a href="index.php?accion=pedidos">Pedidos</a>
            <a href="index.php?accion=dashboard">Dashboard</a>
            <a href="index.php?accion=logout" style="color:red;">Cerrar Sesión</a>
        </nav>
    </header>
    <section class="admin-section">
        <h2>Estadísticas del mes actual</h2>
        <div class="dashboard-cards">
            <div class="dashboard-card">
                <h3>Total productos vendidos</h3>
                <p style="font-size:2em;"><?php echo $estadisticas['total_vendidos']; ?></p>
            </div>
            <div class="dashboard-card">
                <h3>Producto más vendido</h3>
                <?php if ($estadisticas['mas_vendido']): ?>
                    <p><strong><?php echo htmlspecialchars($estadisticas['mas_vendido']['nombre']); ?></strong></p>
                    <p>Vendidos: <?php echo $estadisticas['mas_vendido']['vendidos']; ?></p>
                <?php else: ?>
                    <p>No hay ventas este mes.</p>
                <?php endif; ?>
            </div>
        </div>
        <h2>Productos vendidos por producto (mes actual)</h2>
        <canvas id="ventasPorProducto" width="600" height="250"></canvas>
    </section>
    <script>
        ////// Datos para la gráfica de productos
        const productosLabels = <?php echo json_encode($estadisticas['productos_nombres'] ?? []); ?>;
        const productosData = <?php echo json_encode($estadisticas['productos_vendidos'] ?? []); ?>;

        const ctxProd = document.getElementById('ventasPorProducto').getContext('2d');
        new Chart(ctxProd, {
            type: 'bar',
            data: {
                labels: productosLabels,
                datasets: [{
                    label: 'Cantidad vendida',
                    data: productosData,
                    backgroundColor: '#8458b0'
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <footer>
        <p>&copy; 2025 Tienda de Computadores. Todos los derechos reservados.</p>
    </footer>
</body>

</html>