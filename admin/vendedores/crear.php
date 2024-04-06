<?php

require '../../includes/app.php';

use App\Vendedor;

estaAutenticado();

$vendedor = new Vendedor;

//Posibles errores
$errores = Vendedor::getErrores();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    //Crear una nueva instancia
    $vendedor = new Vendedor($_POST['vendedor']);

    //Validar que no hallan campos vacios
    $errores = $vendedor->validar();
    
    if(empty($errores)){
        $vendedor->guardar();
    }
}

incluirTemplate('header');

?>

    <main class="contenedor seccion">
        <h1>Registrar vendedor</h1>

        <?php foreach ($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>   

        <a href="/bienesraices_inicio/admin/index.php"class="boton boton-verde">Volver</a>

        <form class="formulario" method="POST" action="/bienesraices_inicio/admin/vendedores/crear.php">
            
            <?php
                include '../../includes/templates/formulario_vendedores.php';
                // incluirTemplate('formulario_propiedades');
            ?>

            <input type="submit" value="Registrar Vendedor" class="boton boton-verde">
        </form>

    </main>

<?php
    incluirTemplate('footer');
?>