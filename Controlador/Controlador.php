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
            $correo = $_POST["correo"];
            $contraseña = $_POST["contraseña"];

            $conexion = new Conexion();
            $conexion->abrir();

////////// Busca el usuario con rol admin
            $sql = "SELECT * FROM usuarios WHERE correo = '$correo' AND rol = 'admin'";
            $result = $conexion->consulta($sql);

            if ($result && $result->num_rows > 0) {
                $usuario = $result->fetch_assoc();
                if ($usuario['contraseña'] == $contraseña) {
                    session_start();
                    $_SESSION['admin'] = $correo;
                    $conexion->cerrar();
                    header("Location: index.php?accion=panel");
                    exit;
                }
                if (password_verify($contraseña, $usuario['contraseña'])) {
                    session_start();
                    $_SESSION['admin'] = $correo;
                    $conexion->cerrar();
                    header("Location: index.php?accion=panel");
                    exit;
                }
            }
            $conexion->cerrar();
            echo "<script>alert('Usuario o contraseña incorrectos');window.location='index.php?accion=login';</script>";
            exit;
        } else {
            $this->verpagina('Vista/html/login.php');
        }
    }

    public function loginClienteVista() {
        if (isset($_POST["correo"]) && isset($_POST["contraseña"])) {
            $correo = $_POST["correo"];
            $contraseña = $_POST["contraseña"];

            $conexion = new Conexion();
            $conexion->abrir();

            $sql = "SELECT * FROM usuarios WHERE correo = '$correo' AND rol = 'cliente'";
            $result = $conexion->consulta($sql);

            if ($result && $result->num_rows > 0) {
                $usuario = $result->fetch_assoc();
                if ($usuario['contraseña'] == $contraseña) {
                    session_start();
                    $_SESSION['cliente'] = $correo;
                    $_SESSION['user'] = [
                        "id" => $usuario['id'],
                        "correo" => $usuario['nombre'],
                        "nombre" => $usuario['correo']
                    ];
                    $conexion->cerrar();
                    header("Location: index.php?accion=catalogo");
                    exit;
                }
                    if (password_verify($contraseña, $usuario['contraseña'])) {
                        session_start();
                        $_SESSION['cliente'] = $correo;
                        $conexion->cerrar();
                        header("Location: index.php?accion=catalogo");
                        exit;
                    }
            }
            $conexion->cerrar();
            echo "<script>alert('Usuario o contraseña incorrectos');window.location='index.php?accion=loginCliente';</script>";
            exit;
        } else {
            $this->verpagina('Vista/html/loginCliente.php');
        }
    }

    
/////////productos
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

            session_start();
            $_SESSION['cliente'] = $_POST['correo'];

            header("Location: index.php?accion=catalogo");
            exit;
        }
    }
//////////////pedidos
    public function mostrarPedidos() {
        $pedidos = GestorPedidos::obtenerPedidos();
        require "Vista/html/pedidos.php";
    }
    public function cerrarSesion() {
        session_start();
        session_unset();
        session_destroy();
        header("Location: index.php?accion=catalogo");
        exit;
    }
    public function cambiarEstadoPedido() {
        if (isset($_POST['id_pedido'], $_POST['nuevo_estado'])) {
            $id = intval($_POST['id_pedido']);
            $estado = $_POST['nuevo_estado'];

            $conexion = new Conexion();
            $conexion->abrir();
            $sql = "UPDATE pedidos SET estado = '$estado' WHERE id = $id";
            $conexion->consulta($sql);
            $conexion->cerrar();
        }
        header("Location: index.php?accion=pedidos");
        exit;
    }
    public function agregarAlCarrito() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $id_producto = intval($_POST['id_producto']);
        $nombre = trim($_POST['nombre']);
        $cantidad = intval($_POST['cantidad']);

        if ($cantidad < 1) {
            $cantidad = 1;
        }
        if (empty($nombre) || $id_producto <= 0) {
            header("Location: index.php?accion=catalogo&error=invalid_product");
            exit;
        }

        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        if (isset($_SESSION['carrito'][$id_producto])) {
            $_SESSION['carrito'][$id_producto]['cantidad'] += $cantidad;
        } else {
            $_SESSION['carrito'][$id_producto] = [
                'nombre' => $nombre,
                'cantidad' => $cantidad
            ];
        }

        header("Location: index.php?accion=catalogo");
        exit;
    }

    public function remoCard($id) {
        session_start();

        if ($id !== null && isset($_SESSION['carrito'][$id])) {
            if ($_SESSION['carrito'][$id]['cantidad'] > 1) {
                $_SESSION['carrito'][$id]['cantidad'] -= 1;
            } else {
                unset($_SESSION['carrito'][$id]); // Elimina solo si es 1
            }
            header("Location: index.php?accion=carrito");
        } else {
            header("Location: index.php?accion=carrito");
        }
    }
    public function confirmarPedido() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['cliente']) || empty($_SESSION['carrito'])) {
        header("Location: index.php?accion=carrito");
        exit;
    }

    $correo = $_SESSION['cliente'];
    $carrito = $_SESSION['carrito'];

    $conexion = new Conexion();
    $conexion->abrir();

    // Obtener el ID del usuario mediante su correo
    $conexion->consulta("SELECT id FROM usuarios WHERE correo = '$correo'");
    $res = $conexion->obtenerResultados();
    
    if (!$res) {
        $conexion->cerrar();
        die("Error al buscar el usuario.".$correo);
    }

    $usuario = $res->fetch_assoc();
    if (!$usuario || !isset($usuario['id'])) {
        $conexion->cerrar();
        die("Usuario no encontrado.");
    }

    $id_usuario = intval($usuario['id']);

    // Insertar cada producto del carrito como pedido
    foreach ($carrito as $id_producto => $item) {
        $id_producto = intval($id_producto);
        $cantidad = intval($item['cantidad']);

        $sql = "INSERT INTO pedidos (id_usuario, id_producto, cantidad, estado) 
                VALUES ($id_usuario, $id_producto, $cantidad, 'pendiente')";

        $conexion->consulta($sql);
    }

    $conexion->cerrar();
    unset($_SESSION['carrito']);

    header("Location: index.php?accion=catalogo");
    exit;
}

}
?>