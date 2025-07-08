<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="Vista/css/master.css">
    <script src="Vista/Script/script.js"></script>
</head>
<body>
    <header>
        <h1>Tienda de Computadores</h1>
        <nav>
            <a href="index.php?accion=inicio">Inicio</a>
            <a href="index.php?accion=catalogo">Catálogo</a>
            <a href="index.php?accion=login">Zona Admin</a>
        </nav>
    </header>

    <section id="admin">
        <h2>Zona Clientes</h2>
        <p><strong>Iniciar sesión:</strong></p>
        <form action="index.php?accion=loginCliente" method="POST">
            <input type="email" placeholder="correo" name="correo" required>
            <input type="password" placeholder="contraseña" name="contraseña" required>
            <button type="submit">Ingresar</button>
        </form>
    </section>

    <footer>
        <p>&copy; 2025 Tienda de Computadores. Todos los derechos reservados.</p>
    </footer>
</body>
</html>