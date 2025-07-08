<?php
class Conexion {
    public $mysqli = null;
    private $sql;
    private $resultados;

    public function abrir() {
        $this->mysqli = new mysqli("localhost", "root", "", "tienda_pc");
        if ($this->mysqli->connect_error) {
            die("Error de conexión: " . $this->mysqli->connect_error);
        }
    }

    public function consulta($sql) {
        $this->sql = $sql;
        return $this->mysqli->query($sql);
    }

    public function obtenerResult() {
        return $this->mysqli->use_result() ?: $this->mysqli->store_result();
    }

    public function obtenerResultados() {
        return $this->resultados = $this->mysqli->query($this->sql);
    }



    public function cerrar() {
        if ($this->mysqli) {
            $this->mysqli->close();
        }
    }
}
?>