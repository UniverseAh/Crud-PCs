<?php
require_once "Modelo/Conexion.php";
require_once "Modelo/GestorProductos.php";
require_once "Modelo/GestorCategorias.php";
require_once "Modelo/GestorUsuarios.php";
require_once "Modelo/GestorPedidos.php";

class Controlador {
    public function verpagina($ruta) {
        require $ruta;
    }

//////////login
    public function loginVista() {
        if (isset($_POST["correo"]) && isset($_POST["contraseña"])) {
        } else {
            $this->verpagina('Vista/html/login.php');
        }
    }

    
////////productos
    public function agregarProducto() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            GestorProductos::agregar($_POST, $_FILES);
        }
    }

    public function eliminarProducto() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            GestorProductos::eliminar($_POST['id']);
        }
    }

    public function actualizarProducto() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            GestorProductos::actualizar($_POST, $_FILES);
        }
    }
////////////Categorias
    public function agregarCategoria() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            GestorCategorias::agregar($_POST['nombre_categoria']);
        }
    }

    public function eliminarCategoria() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            GestorCategorias::eliminar($_POST['id_categoria']);
        }
    }

    public function actualizarCategoria() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            require_once "Modelo/GestorCategorias.php";
            $id = $_POST['id_categoria'];
            $nombre = $_POST['nombre_categoria'];
            GestorCategorias::actualizar($id, $nombre);
        }
    }
///////////clientes
    public function registrarCliente() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            GestorUsuarios::registrarCliente($_POST);
        }
    }
//////////////pedidos
    public function mostrarPedidos() {
        $pedidos = GestorPedidos::obtenerPedidos();
        require "Vista/html/pedidos.php";
    }
    public function cerrarSesion() {
        session_unset();
        session_destroy();
        echo "<script>alert('Sesión cerrada correctamente');window.location='index.php?accion=catalogo';</script>";
    }
}
?>