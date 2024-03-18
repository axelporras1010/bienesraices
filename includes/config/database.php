<?php

function conectarDB() : mysqli{
    $db = new mysqli('localhost','root', 'root', 'bienesraices_crud');
    if(!$db) {
        echo 'No se pudor realizar la coneccion';
        exit;
    }
    return $db;
}