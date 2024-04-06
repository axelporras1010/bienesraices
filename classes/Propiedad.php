<?php

namespace App;

class Propiedad extends ActiveRecord {
    protected static $columnasDB = ['id','titulo','precio','imagen','descripcion', 'habitaciones','WC','estacionamiento', 'creado', 'vendedores_id'];
    protected static $tabla = 'propiedades';

    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $WC;
    public $estacionamiento;
    public $creado;
    public $vendedores_id;

    
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->WC = $args['WC'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedores_id = $args['vendedores_id'] ?? '';
    }

    public function validar(){
        if(!$this->titulo) self::$errores[] = 'El titulo es obligatorio';
        if(!$this->precio) self::$errores[] = 'El precio es obligatorio';
        if(strlen($this->descripcion) < 50 ) self::$errores[] = 'La descripcion es obligatoria y debe ser mayor a 50 caracteres';
        if(!$this->habitaciones) self::$errores[] = 'El numero de habitaciones obligatorio';
        if(!$this->WC) self::$errores[] = 'El numero de baños es obligatorio';
        if(!$this->estacionamiento) self::$errores[] = 'El numero de estacionamientos es obligatorio';
        if(!$this->vendedores_id) self::$errores[] = 'El vendedor es obligatorio';
        if(!$this->imagen) self::$errores[] = 'La imagen de la propiedad es obligatoria';

        return self::$errores;
    }
}