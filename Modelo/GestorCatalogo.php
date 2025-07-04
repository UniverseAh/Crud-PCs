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

// Consulta d categorías para filtro
$categorias_result = $conexion->consulta("SELECT id, nombre FROM categorias");