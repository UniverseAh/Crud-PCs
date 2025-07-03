<?php
require_once "Conexion.php";

class GestorUsuarios {
    public static function registrarCliente($data) {
        $nombre = $data['nombre'];
        $correo = $data['correo'];
        $telefono = $data['telefono'];
        $contraseña = password_hash($data['contraseña'], PASSWORD_DEFAULT);
        $rol = 'Cliente';

        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "INSERT INTO usuarios (nombre, correo, contraseña, rol) VALUES ('$nombre', '$correo', '$contraseña', '$rol')";
        $conexion->consulta($sql);
        $conexion->cerrar();

        echo "<script>alert('Registro exitoso. Ahora puedes solicitar tu compra.');window.location='index.php?accion=catalogo';</script>";
    }

    public static function validarUsuario($correo, $contraseña) {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT * FROM usuarios WHERE correo = '$correo'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $usuario = $result->fetch_assoc();
        $conexion->cerrar();
        if ($usuario && password_verify($contraseña, $usuario['contraseña'])) {
            return $usuario;
        }
        return false;
    }
}
?>