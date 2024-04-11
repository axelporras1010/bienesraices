<?php

namespace App;

use PDO;

class ActiveRecord{

    protected static $db;
    protected static $columnasDB = [];
    protected static $errores = [];
    protected static $tabla = '';

    public function guardar(){
        if(!is_null($this->id)){
            $this->actualizar();
        }else{
            $this->crear();
        }
    }

    public function crear(){
        //Sanitizar datos
        $atributos = $this->sanitizarAtributos();

        //Inserting in the database
        $query = "INSERT INTO " . static::$tabla . " ( ";
        $query .= join(", ", array_keys($atributos));
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";

        $resultado = self::$db->query($query);

        //Mensaje de exito
        if($resultado){
            header('Location: /bienesraices_inicio/admin/index.php?resultado=1');
        }
    }

    public function actualizar(){
        //Sanitizar datos
        $atributos = $this->sanitizarAtributos();
        
        $valores = [];
        foreach($atributos as $key => $value ){
            $valores[] = $key . "='" . $value . "'";
        }
        $query = "UPDATE " . static::$tabla . " SET ";
        $query .= join(", ", $valores);
        $query .= " WHERE id= '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";

        $resultado = self::$db->query($query);

        if($resultado){
            header('Location: /bienesraices_inicio/admin/index.php?resultado=2');
        }
    }
    //Eliminar un registro
    public function eliminar(){
        //Eliminar la propiedad
        $query = "DELETE FROM " . static::$tabla . " WHERE id=". self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);

        if($resultado){
            $this->borrarImagen();
            header("Location: /bienesraices_inicio/admin/index.php?resultado=3");
        }
    }

    //Identificar y unir las columnas de la base de datos
    public function atributos() {
        $atributos = [];
        foreach(static::$columnasDB as $columna){
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
        if(!is_null($this->id)){
            $this->borrarImagen();
        }
        if($imagen) $this->imagen = $imagen;
    }

    //Eliminar archivo
    public function borrarImagen(){
        //Comprobar que el archivo existe
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
        if($existeArchivo){
            unlink(CARPETA_IMAGENES . $this->imagen);
        }
    }

    //Validacion
    public static function getErrores(){
        return static::$errores;
    }

    public function validar(){
        static::$errores = [];
        
        return static::$errores;
    }

    //Listar todos los registros
    public static function all(){
        //Escribir el query
        $query = "SELECT * FROM " . static::$tabla;
        //obten el resultado del query
        $resultado = self::consultarSQL($query);

        return $resultado;
    }
    //Obtiene determinado numero de registros.
    public static function get($cantidad){
        //Escribir el query
        $query = "SELECT * FROM " . static::$tabla . " LIMIT " . $cantidad;
        //obten el resultado del query
        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    // Busca un registro por su id
    public static function find($id){
        //Consultas
        $query = "SELECT * FROM " . static::$tabla . " WHERE id=". $id;
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

    public static function consultarSQL($query){
        //Consultar de la DB
        $resultado = self::$db->query($query);
        //Iterar los resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()):
            $array[] = static::crearObjetos($registro);
        endwhile;
        //liberar la memoria
        $resultado->free();
        //retornar los resultados
        return $array;
    }

    protected static function crearObjetos($registro){
        $objeto = new static;
        foreach($registro as $key => $value){
            if(property_exists($objeto, $key)){
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }

    //Sincroniza el objeto con los cambios realizados por el usuario
    public function sincronizar($args = []){
        foreach($args as $key => $value){
            if(property_exists($this, $key) && !is_null($value)){
                $this->$key = $value;
            }
        }
    }
}