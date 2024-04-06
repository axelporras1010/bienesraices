<?php

require '../../includes/app.php';
use App\Vendedor;
estaAutenticado();


//Validar el ID

$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if(!$id) header('location: /bienesraices_inicio/admin/index.php');

//Obtener el arreglo del vendedor
$vendedor = Vendedor::find($id);

//Posibles errores
$errores = Vendedor::getErrores();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    //asignar los valores
    $args = $_POST['vendedor'];
    //Sincronizar objeto en memoria
    $vendedor->sincronizar($args);
    //Validacion
    $errores = $vendedor->validar();
    
    if(empty($errores)) $vendedor->guardar();
}

incluirTemplate('header');

?>

    <main class="contenedor seccion">
        <h1>Actualizar vendedor</h1>

        <?php foreach ($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>   

        <a href="/bienesraices_inicio/admin/index.php"class="boton boton-verde">Volver</a>

        <form class="formulario" method="POST">
            
            <?php
                include '../../includes/templates/formulario_vendedores.php';
                // incluirTemplate('formulario_propiedades');
            ?>

            <input type="submit" value="Guardar cambios" class="boton boton-verde">
        </form>

    </main>

<?php
    incluirTemplate('footer');
?>