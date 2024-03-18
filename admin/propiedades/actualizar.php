<?php
    //Verifica si esta autenticado
    require '../../includes/app.php';
    estaAutenticado();

    //Validar por URL un id Valido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);
    if(!$id){
        header('Location: /bienesraices_inicio/admin/index.php');
    }

    //Base de datos
    $db = conectarDB();

    //Consultas
    $query = "SELECT * FROM propiedades WHERE id=".$id;
    $resultado = mysqli_query($db, $query);
    $propiedad = mysqli_fetch_assoc($resultado);

    $query = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db, $query);

    $errors = [];

    $titulo = $propiedad['titulo'];
    $precio = $propiedad['precio'];
    $descripcion = $propiedad['descripcion'];
    $habitaciones = $propiedad['habitaciones'];
    $wc = $propiedad['WC'];
    $estacionamiento = $propiedad['estacionamiento'];
    $vendedorId = $propiedad['vendedores_id'];
    $imagenId = $propiedad['imagen'];

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $titulo = mysqli_real_escape_string( $db,  $_POST['titulo']);
        $precio = mysqli_real_escape_string( $db,  $_POST['precio']);
        $descripcion = mysqli_real_escape_string( $db,  $_POST['descripcion']);
        $habitaciones = mysqli_real_escape_string( $db,  $_POST['habitaciones']);
        $wc = mysqli_real_escape_string( $db,  $_POST['wc']);
        $estacionamiento = mysqli_real_escape_string( $db,  $_POST['estacionamiento']);
        $vendedorId = mysqli_real_escape_string( $db,  $_POST['vendedor']);
        $creado = date('y/m/d');
        $imagen = $_FILES['imagen'];

        if(!$titulo) $errores[] = 'El titulo es obligatorio';
        if(!$precio) $errores[] = 'El precio es obligatorio';
        if(strlen($descripcion) < 50 ) $errores[] = 'La descripcion es obligatoria y debe ser mayor a 50 caracteres';
        if(!$habitaciones) $errores[] = 'El numero de habitaciones obligatorio';
        if(!$wc) $errores[] = 'El numero de baños es obligatorio';
        if(!$estacionamiento) $errores[] = 'El numero de estacionamientos es obligatorio';
        if(!$vendedorId) $errores[] = 'El vendedor es obligatorio';

        //Validate image by size (1mb)
        $medida = 1000 * 1000;
        if($imagen['size'] > $medida ) $errores[] = 'La imagen es muy grande';

        if(empty($errores)){
            /**Uploading files**/
            //Create folder
            $carpetaImagenes = '../../imagenes/';
            if(!is_dir($carpetaImagenes)) mkdir($carpetaImagenes);

            $nombreImagen = '';

            if($imagen['name']){
                //Delete old image
                unlink($carpetaImagenes . $propiedad['imagen']);
                //Create unique number for the image
                $nombreImagen = md5(uniqid(rand(), true)) . $imagen['name'];
                //Upload the image
                move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);
            }else{
                $nombreImagen = $propiedad['imagen'];
            }

            //Inserting in the database
            $query = "UPDATE propiedades SET titulo = '$titulo', precio='$precio', imagen='$nombreImagen', descripcion = '$descripcion', habitaciones=$habitaciones, wc = $wc, estacionamiento = $estacionamiento, vendedores_id=$vendedorId WHERE id = $id";

            $resultado = mysqli_query($db, $query);

            if($resultado){
                header('Location: /bienesraices_inicio/admin/index.php?resultado=2');
            }
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