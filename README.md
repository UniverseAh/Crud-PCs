# -----------CRUD VENTA DE PCS------------
Aplicación web en PHP para la administración de productos (computadores y repuestos) y un catálogo público
---

## Características

- **Administrador**
  - Login seguro (solo rol admin)
  - CRUD de productos (computadores o repuestos)
  - Gestión de categorías
  - Gestión de pedidos y cambio de estado (Pendiente, Enviado, Entregado, Cancelado)
  - Apartado Dashboard para ver estadísticas de ventas 

- **Cliente**
  - Catálogo público con búsqueda y filtros por categoría
  - Capacidad para crear una Cuenta
  - Opción de agregar productos al carrito una vez iniciada sesión
  - Poder pedir todos los productos del carrito en un mismo pedido

---

## Instalación

1. **Clona o descarga este repositorio**
2. **Copia la carpeta en tu servidor local**
3. **Crea la base de datos**

   - Nombre: `tienda_pc`
   - Importa las tablas necesarias (usuarios, productos, categorias, pedidos e imagenes_producto)

4. **Configura la conexión a la base de datos**

   - Editar en `Modelo/Conexion.php` si el usuario o contraseña de MySQL es diferente.

---

## Usuarios de prueba

**Administradores**
- Correo: `admin@gmail.com`
- Contraseña: `123456`

- Correo: `arteaga@gmail.com`
- Contraseña: `admin`

---

## Estructura del proyecto

```
Modelo/
    Conexion.php
    GestorProductos.php
    GestorCategorias.php
    GestorUsuarios.php
    GestorPedidos.php
    GestorCatalogo.php
    GestorPC.php
    GestorUsuarios.php
    PC.php
Controlador/
    Controlador.php
Vista/
    html/
        catalogo.php
        carrito.php
        pedidos.php
        panel.php
        categorias.php
        login.php
        inicio.php
        loginCliente.php
        tabla.php
    css/
      master.css
    imagenes/
    Script/
index.php
```

---

## Funcionalidades principales

- **CRUD de productos y categorías** desde el panel de administración.
- **Cambio de estado de pedidos** por el administrador.
- **Control de acceso**: solo el admin puede acceder al panel y gestionar productos/categorías/pedidos.
-**Capacidad de hacer pedidos**: una vez el Cliente cree una cuenta e inicie sesión podrá agregar cosas al carrito y hacer el pedido

---

## Notas

- Contraseñas de clientes almacenadas con hash seguro (`password_hash`).
- El proyecto sigue el patrón MVC básico.
- El diseño es responsive y sencillo, personalizado a través de `Vista/css/master.css`.

---
