<?php
require_once "Conexion.php";

class GestorPedidos {
    public static function obtenerPedidos() {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT 
                    pedidos.id, 
                    usuarios.nombre AS cliente, 
                    productos.nombre AS producto, 
                    pedidos.cantidad, 
                    pedidos.fecha, 
                    pedidos.estado
                FROM pedidos
                JOIN usuarios ON pedidos.id_usuario = usuarios.id
                JOIN productos ON pedidos.id_producto = productos.id";
        $result = $conexion->consulta($sql);

        if (!$result) {
            die("Error en la consulta de pedidos: " . $conexion->mysqli->error);
        }

        $pedidos = [];
        while ($row = $result->fetch_assoc()) {
            $pedidos[] = $row;
        }
        $conexion->cerrar();
        return $pedidos;
    }
}
?>