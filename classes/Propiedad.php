<?php

namespace App;

use PDO;

class Propiedad{

    protected static $db;
    protected static $columnasDB = ['id','titulo','precio','imagen','descripcion', 'habitaciones','wc','estacionamiento', 'creado', 'vendedores_id'];
    protected static $errores = [];

    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedores_id;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? '';
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedores_id = $args['vendedores_id'] ?? '';
    }

    public function guardar(){
        //Sanitizar datos
        $atributos = $this->sanitizarAtributos();

        //Inserting in the database
        $query = "INSERT INTO propiedades ( ";
        $query .= join(", ", array_keys($atributos));
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";

        $resultado = self::$db->query($query);

        return $resultado;
    }

    //Identificar y unir las columnas de la base de datos
    public function atributos() {
        $atributos = [];
        foreach(self::$columnasDB as $columna){
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizarAtributos(){
        $atributos = $this->atributos();
        $sanitizado = [];

        foreach($atributos as $key => $value){
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    public static function setDB($database){
        self::$db = $database;
    }

    //Subida de archivos
    public function setImagen($imagen){
        if($imagen) $this->imagen = $imagen;
    }

    //Validacion
    public static function getErrores(){
        return self::$errores;
    }

    public function validar(){
        if(!$this->titulo) self::$errores[] = 'El titulo es obligatorio';
        if(!$this->precio) self::$errores[] = 'El precio es obligatorio';
        if(strlen($this->descripcion) < 50 ) self::$errores[] = 'La descripcion es obligatoria y debe ser mayor a 50 caracteres';
        if(!$this->habitaciones) self::$errores[] = 'El numero de habitaciones obligatorio';
        if(!$this->wc) self::$errores[] = 'El numero de baños es obligatorio';
        if(!$this->estacionamiento) self::$errores[] = 'El numero de estacionamientos es obligatorio';
        if(!$this->vendedores_id) self::$errores[] = 'El vendedor es obligatorio';
        if(!$this->imagen) self::$errores[] = 'La imagen es obligatoria';

        return self::$errores;
    }

    //Devuelve todas las propiedades
    public static function all(){
        //Escribir el query
        $query = "SELECT * FROM propiedades";
        //obten el resultado del query
        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    public static function consultarSQL($query){
        //Consultar de la DB
        $resultado = self::$db->query($query);
        //Iterar los resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()):
            $array[] = self::crearObjetos($registro);
        endwhile;
        //liberar la memoria
        $resultado->free();
        //retornar los resultados
        return $array;
    }

    protected static function crearObjetos($registro){
        $objeto = new self;
        foreach($registro as $key => $value){
            if(property_exists($objeto, $key)){
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }
}