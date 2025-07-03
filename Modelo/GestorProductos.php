<?php
require_once "Conexion.php";

class GestorProductos {
    public static function agregar($datos, $archivos) {
        $conexion = new Conexion();
        $conexion->abrir();

        $nombre = $datos['nombre'];
        $marca = $datos['marca'];
        $modelo = $datos['modelo'];
        $tipo = $datos['tipo'];
        $especificaciones = $datos['especificaciones'];
        $precio = $datos['precio'];
        $id_categoria = $datos['id_categoria'];

        $sql = "INSERT INTO productos (nombre, marca, modelo, tipo, especificaciones, precio, id_categoria)
                VALUES ('$nombre', '$marca', '$modelo', '$tipo', '$especificaciones', $precio, $id_categoria)";
        $conexion->consulta($sql);

        $id_producto = $conexion->mysqli->insert_id;

        $imagenesGuardadas = [];
        if (isset($archivos['imagenes']) && count($archivos['imagenes']['tmp_name']) > 0 && $archivos['imagenes']['tmp_name'][0] != "") {
            foreach ($archivos['imagenes']['tmp_name'] as $key => $tmp_name) {
                if ($tmp_name) {
                    $nombre_img = basename($archivos['imagenes']['name'][$key]);
                    $ruta_destino = "Vista/imagenes/" . $nombre_img;
                    if (move_uploaded_file($tmp_name, $ruta_destino)) {
                        $imagenesGuardadas[] = $ruta_destino;
                    }
                }
            }
        }

        // Si no se subió ninguna imagen, usar esta imagen por defecto
        if (count($imagenesGuardadas) === 0) {
            $imagenesGuardadas[] = "Vista/imagenes/SinImagen.jpeg";
        }

        foreach ($imagenesGuardadas as $ruta) {
            $conexion->consulta("INSERT INTO imagenes_producto (id_producto, url_imagen) VALUES ($id_producto, '$ruta')");
        }

        $conexion->cerrar();
        echo "<script>alert('Producto guardado con éxito');window.location='index.php?accion=panel';</script>";
    }

/////Eliminar producto
    public static function eliminar($id) {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "DELETE FROM productos WHERE id = '$id'";
        $conexion->consulta($sql);
        $conexion->cerrar();
        echo "<script>alert('Producto eliminado');window.location='index.php?accion=panel';</script>";
    }

/////Actualizar producto
    public static function actualizar($data, $files) {
        $id = $data['id'];
        $nombre = $data['nombre'];
        $precio = $data['precio'];
        $talla = $data['talla'];
        $id_categoria = $data['id_categoria'];

        if (!empty($files['imagen']['name'])) {
            $imagen = $files['imagen']['name'];
            $ruta_destino = "Uploads/" . $imagen;
            move_uploaded_file($files['imagen']['tmp_name'], $ruta_destino);
            $sql = "UPDATE productos SET nombre='$nombre', precio='$precio', descripcion='$talla', imagen='$imagen', id_categoria='$id_categoria' WHERE id='$id'";
        } else {
            $sql = "UPDATE productos SET nombre='$nombre', precio='$precio', descripcion='$talla', id_categoria='$id_categoria' WHERE id='$id'";
        }

        $conexion = new Conexion();
        $conexion->abrir();
        $conexion->consulta($sql);
        $conexion->cerrar();

        echo "<script>alert('Producto actualizado con éxito');window.location='index.php?accion=panel';</script>";
    }
}
?>