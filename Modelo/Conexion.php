<?php
class Conexion {
    public $mysqli = null;

    public function abrir() {
        $this->mysqli = new mysqli("localhost", "root", "", "tienda_pc");
        if ($this->mysqli->connect_error) {
            die("Error de conexión: " . $this->mysqli->connect_error);
        }
    }

    public function consulta($sql) {
        return $this->mysqli->query($sql);
    }

    public function obtenerResult() {
        return $this->mysqli->use_result() ?: $this->mysqli->store_result();
    }

    public function cerrar() {
        if ($this->mysqli) {
            $this->mysqli->close();
        }
    }
}
?>