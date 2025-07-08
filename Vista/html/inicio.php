<?php
require_once "Modelo/Conexion.php";
require_once "Modelo/GestorCatalogo.php";
//session_start(); // Asegúrate de tener la sesión iniciada

$cliente_logueado = isset($_SESSION['cliente']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>inicio</title>
    <link rel="stylesheet" href="Vista/css/master.css">
    <script src="Vista/Script/script.js"></script>
</head>
<body>

    <header>
        <h1>Tienda de Computadores</h1>
        <nav>
                <a href="index.php?accion=inicio">Inicio</a>
                <a href="index.php?accion=catalogo">Catálogo</a>                    
                <?php 
                // CONDICIONAL PARA QUE CUANDO UN CLIENTE ESTGE LOGUEADO LA OPC DE ZONA ADMIN NO LE SALGA PERO SI AGREGRE EL CARRITO Y EL CERRAR SESION
                    if ($cliente_logueado) {
                        // ESTO LO MUESTRA SOLO SI EL USER TIPO CLIENTE ESTA LOGUEADO
                        echo "<a href='index.php?accion=carrito'>Carrito</a>";
                        echo "<a href='index.php?accion=cerrar_sesion' style='color:red;'>Cerrar Sesión</a>";
                    } else {
                        // ESTO LO MUESTRA SI NO AHI NINGUN USUARIO LOGUEADO
                        echo "<a href='index.php?accion=login'>Zona Admin</a>";
                    } 
                ?>
            </nav>
    </header>


    <h1>Bienvenido a la Tienda de Tenis</h1>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Totam esse, repellendus dolor numquam ducimus eos sed qui. Suscipit explicabo corporis aliquam tempora, illum molestiae ipsam sed ullam, quos impedit enim. Lorem ipsum dolor sit amet consectetur adipisicing elit. Labore rem laudantium cupiditate corporis repellendus reiciendis dicta at! Et iusto quaerat eaque eos temporibus. Commodi ab, magni laudantium debitis tenetur aperiam? Lorem ipsum, dolor sit amet consectetur adipisicing elit. Alias laboriosam eius ipsum id quod cum similique sit suscipit dolorem itaque? Iste eaque odit similique corrupti eveniet suscipit impedit aspernatur quisquam. Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloremque, voluptatibus. Lorem ipsum dolor sit amet consectetur adipisicing elit. Labore rem laudantium cupiditate corporis repellendus reiciendis dicta at! Et iusto quaerat eaque eos temporibus. Commodi ab, magni laudantium debitis tenetur aperiam? Lorem ipsum, dolor sit amet consectetur adipisicing elit. Alias laboriosam eius ipsum id quod cum similique sit suscipit dolorem itaque? Iste eaque odit similique corrupti eveniet suscipit impedit aspernatur quisquam.</p>    



    <footer>
        <p>&copy; 2025 Tienda de Computadores. Todos los derechos reservados.</p>
    </footer>

</body>
</html>