<?php

class PC {
    private $nombre;
    private $descripcion;
    private $precio;
    private $imagen;
    private $id_categoria;
    
    public function __construct($title, $descripcion, $precio, $imagen, $id_categoria)
    {
        $this->nombre=$title;
        $this->descripcion=$descripcion;
        $this->precio=$precio;
        $this->imagen=$imagen;
        $this->id_categoria=$id_categoria;
        
    }
    public function obtenertitle(){
        return $this->nombre;
    }
    public function obtenerdescripcion(){
        return $this->descripcion;
    }
    public function obtenerprecio(){
        return $this->precio;
    }

    public function obtenerimagen(){
        return $this->imagen;
    }
    public function obtenerid_categoria(){
        return $this->id_categoria;
    }





}

?>