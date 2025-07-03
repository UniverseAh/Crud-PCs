<?php

require_once "Modelo/Conexion.php";
$conexion = new Conexion();
$conexion->abrir();
$result = $conexion->consulta("SELECT productos.id, productos.nombre, productos.marca, productos.modelo, productos.tipo, productos.precio, productos.especificaciones, productos.id_categoria, categorias.nombre AS categoria FROM productos
INNER JOIN categorias ON productos.id_categoria = categorias.id");

while ($row = $result->fetch_assoc()) {
    $productoJS = json_encode([
        "id" => $row['id'],
        "nombre" => $row['nombre'],
        "marca" => $row['marca'],
        "modelo" => $row['modelo'],
        "tipo" => $row['tipo'],
        "precio" => $row['precio'],
        "especificaciones" => $row['especificaciones'],
        "id_categoria" => $row['id_categoria']
    ]);

    echo "<tr>";
    echo "<td>{$row['id']}</td>";
    echo "<td>{$row['nombre']}</td>";
    echo "<td>{$row['marca']}</td>";
    echo "<td>{$row['modelo']}</td>";
    echo "<td>{$row['tipo']}</td>";
    echo "<td>{$row['categoria']}</td>";
    echo "<td>\${$row['precio']}</td>";
    echo "<td>{$row['especificaciones']}</td>";

    echo "<td>
        <button type='button' class='btn-admin' onclick='abrirModalEditar($productoJS)'>Editar</button>
        <form method='POST' action='index.php?accion=eliminar' style='display:inline' onsubmit=\"return confirm('¿Seguro que deseas eliminar este producto?');\">
            <input type='hidden' name='id' value='{$row['id']}'>

            <button type='submit' class='btn-admin'>Eliminar</button>
        </form>
    </td>";
    echo "</tr>";
}
$conexion->cerrar();
?>