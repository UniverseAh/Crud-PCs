<?php
require_once "Conexion.php";

class GestorCategorias {
    public static function agregar($nombre) {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "INSERT INTO categorias (nombre) VALUES ('$nombre')";
        $conexion->consulta($sql);
        $conexion->cerrar();
        echo "<script>window.location='index.php?accion=panel';</script>";
    }
//////////Eliminar Categoria
    public static function eliminar($id) {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "DELETE FROM categorias WHERE id = '$id'";
        $conexion->consulta($sql);
        $conexion->cerrar();
        echo "<script>window.location='index.php?accion=panel';</script>";
    }
//////////Actualizar Categoría
    public static function actualizar($id, $nombre) {
        require_once "Conexion.php";
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "UPDATE categorias SET nombre = '$nombre' WHERE id = '$id'";
        $conexion->consulta($sql);
        $conexion->cerrar();
        echo "<script>alert('Categoría actualizada correctamente');window.location='index.php?accion=categorias';</script>";
    }
}
?>