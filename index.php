<?php
session_start();
require_once "Controlador/Controlador.php";

$controlador = new Controlador();

if (isset($_GET["accion"])) {
    switch ($_GET["accion"]) {
        case "vista":
            $controlador->verpagina('Vista/html/inicio.html');
            break;
        case "login":
            $controlador->loginVista();
            break;
        case "add":
            $controlador->agregarProducto();
            break;
        case "eliminar":
            $controlador->eliminarProducto();
            break;
        case "actualizar":
            $controlador->actualizarProducto();
            break;
        case "add_categoria":
            $controlador->agregarCategoria();
            break;
        case "eliminar_categoria":
            $controlador->eliminarCategoria();
            break;
        case "registro_cliente":
            $controlador->registrarCliente();
            break;
        case "inicio":
            $controlador->verpagina('Vista/html/inicio.html');
            break;
        case "catalogo":
            $controlador->verpagina('Vista/html/catalogo.php');
            break;
        case "panel":
            $controlador->verpagina('Vista/html/panel.php');
            break;
        case "categorias":
            $controlador->verpagina('Vista/html/categorias.php');
            break;
        case "pedidos":
            $controlador->mostrarPedidos();
            break;
        case "actualizar_categoria":
            $controlador->actualizarCategoria();
            break;
        case "logout":
            $controlador->cerrarSesion();
            break;
        case "cambiar_estado_pedido":
            $controlador->cambiarEstadoPedido();
            break;
        case "agregar_al_carrito":
            $controlador->agregarAlCarrito();
            break;
        case "carrito":
            $controlador->verpagina('Vista/html/carrito.php');
            break;
        case "confirmar_pedido":
            $controlador->confirmarPedido();
            break;
        default:
            $controlador->verpagina('Vista/html/inicio.html');
    }
} else {
    $controlador->verpagina('Vista/html/inicio.html');
}
