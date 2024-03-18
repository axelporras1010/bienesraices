<?php

define('TEMPLATES_URL', __DIR__ . '/templates');
define('FUNCIONES_URL', __DIR__ . 'funciones.php');
define('CARPETA_IMAGENES', __DIR__ . '/../imagenes/');

function incluirTemplate(string $nombre, bool $inicio = false) {
    include TEMPLATES_URL . "/" . $nombre . ".php";
}

function estaAutenticado(): void{
    session_start();
    if(!$_SESSION['login']){
        header('location: /bienesraices_inicio/index.php');
    }
}

function debuguear($variable){
    echo '<pre>';
    var_dump($variable);
    echo '<pre/>';
    exit;
}

//Escapa el html
function s($html) : string{
    $s = htmlspecialchars($html);
    return $s;
}