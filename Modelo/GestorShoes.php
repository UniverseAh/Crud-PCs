<?php 

    class GestorShoes{
        public function login($correo, $contraseña){
            $conexion = new Conexion();
            $conexion->abrir();
            $sql = "SELECT * FROM usuarios WHERE correo='$correo' AND contraseña='$contraseña' AND rol='admin'";
            $conexion->consulta($sql);
            $result = $conexion->obtenerResult();
            $num = $result->num_rows;
            $conexion->cerrar();
            return $num;
        }
        
    }
?>