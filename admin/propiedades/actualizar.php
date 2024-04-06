<?php
    //Verifica si esta autenticado

use App\Propiedad;
use App\Vendedor;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

    require '../../includes/app.php';
    estaAutenticado();

    //Validar por URL un id Valido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);
    if(!$id){
        header('Location: /bienesraices_inicio/admin/index.php');
    }

    $propiedad = Propiedad::find($id);

    $vendedores  = Vendedor::all();

    $errores = Propiedad::getErrores();

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $args = $_POST['propiedad'];

        $propiedad->sincronizar($args);
        
        //Validacion
        $errores = $propiedad->validar();

        //Subida de archivos
        $nombreImagen = md5(uniqid(rand(), true)) . $_FILES['propiedad']['name']['imagen'];
        if($_FILES['propiedad']['tmp_name']['imagen']){
            $manager = new ImageManager(new Driver());
            $image = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->scale(width: 300);;
            $propiedad->setImagen($nombreImagen);
        }

        if(empty($errores)){
            if($_FILES['propiedad']['tmp_name']['imagen']){
                $image->save(CARPETA_IMAGENES . $nombreImagen);
            }
            $propiedad->guardar();
        }
    }

    incluirTemplate('header');
?>
    
    <main class="contenedor seccion">
        <h1>Actualizar Propiedad</h1>

        <?php foreach ($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>   

        <a href="/bienesraices_inicio/admin/index.php"class="boton boton-verde">Volver</a>

        <form class="formulario" method="POST" enctype="multipart/form-data">
            <?php
                include '../../includes/templates/formulario_propiedades.php';
                // incluirTemplate('formulario_propiedades');
            ?>
            <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
        </form>

    </main>

<?php
    incluirTemplate('footer');
?>