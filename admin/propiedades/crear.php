<?php 
    //Verifica si esta autenticado
    require '../../includes/app.php';
    use App\Propiedad;
    use Intervention\Image\ImageManager;
    use Intervention\Image\Drivers\Gd\Driver;

    estaAutenticado();

    //Base de datos
    $db = conectarDB();

    $propiedad = new Propiedad;

    $query = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db, $query);

    $errores = Propiedad::getErrores();

    $errors = [];

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        /** crea una nueva instancia */
        $propiedad = new Propiedad($_POST);
        /**Uploading files**/
        //Create unique number for the image
        $nombreImagen = md5(uniqid(rand(), true)) . $_FILES['imagen']['name'];
        //Setea el nombre
        //Upload the image
        //Realiza un resize con intervetion
        if($_FILES['imagen']['tmp_name']){
            $manager = new ImageManager(new Driver());
            $image = $manager->read($_FILES['imagen']['tmp_name'])->scale(width: 300);;
            $propiedad->setImagen($nombreImagen);
        }

        
        $errores = $propiedad->validar();
        

        if(empty($errores)){
            //crea la carpeta para subir imagenes
            if(!is_dir(CARPETA_IMAGENES)) mkdir(CARPETA_IMAGENES);

            //Guarda la imagen en el servidor
            $image->save(CARPETA_IMAGENES . $nombreImagen);

            //Guardar en la DB
            $resultado = $propiedad->guardar();

            if($resultado){
                header('Location: /bienesraices_inicio/admin/index.php?resultado=1');
            }
        }
    }

    incluirTemplate('header');
?>
    
    <main class="contenedor seccion">
        <h1>Crear Propiedad</h1>

        <?php foreach ($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>   

        <a href="/bienesraices_inicio/admin/index.php"class="boton boton-verde">Volver</a>

        <form class="formulario" method="POST" action="/bienesraices_inicio/admin/propiedades/crear.php" enctype="multipart/form-data">
            
            <?php
                include '../../includes/templates/formulario_propiedades.php';
                // incluirTemplate('formulario_propiedades');
            ?>

            <input type="submit" value="Crear Propiedad" class="boton boton-verde">
        </form>

    </main>

<?php
    incluirTemplate('footer');
?>