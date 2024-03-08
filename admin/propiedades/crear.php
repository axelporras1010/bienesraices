<?php 
    //Verifica si esta autenticado
    require '../../includes/app.php';
    use App\Propiedad;

    $propiedad = new Propiedad;

    estaAutenticado();

    //Base de datos
    $db = conectarDB();

    $query = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db, $query);

    $errors = [];

    $titulo = '';
    $precio = '';
    $descripcion = '';
    $habitaciones = '';
    $wc = '';
    $estacionamiento = '';
    $vendedorId = '';

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
        if(!$imagen['name'] || $imagen['error']) $errores[] = 'La imagen es obligatoria';

        //Validate image by size (1mb)
        $medida = 1000 * 1000;
        if($imagen['size'] > $medida ) $errores[] = 'La imagen es muy grande';

        if(empty($errores)){
            /**Uploading files**/
            //Create folder
            $carpetaImagenes = '../../imagenes/';
            if(!is_dir($carpetaImagenes)) mkdir($carpetaImagenes);
            //Create unique number for the image
            $nombreImagen = md5(uniqid(rand(), true)) . $imagen['name'];
            //Upload the image
            move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);

            //Inserting in the database
            $query = "INSERT INTO propiedades (titulo, precio, imagen, descripcion, habitaciones, wc, estacionamiento, creado, vendedores_id) VALUES ('$titulo', '$precio', '$nombreImagen', '$descripcion', '$habitaciones', '$wc', '$estacionamiento', '$creado', '$vendedorId')";

            $resultado = mysqli_query($db, $query);

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
            <fieldset>
                <legend>Informacion General</legend>

                <label for="titulo">Titulo</label>
                <input type="text" id="titulo" name="titulo" placeholder="Titulo Propiedad" value="<?php echo $titulo; ?>">

                <label for="precio">Precio</label>
                <input type="number" id="precio" name="precio" placeholder="Precio Propiedad" value="<?php echo $precio; ?>">

                <label for="imagen">Imagen</label>
                <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">

                <label for="descripcion">Descripcion</label>
                <textarea id="descripcion" name="descripcion"><?php echo $descripcion; ?></textarea>
            </fieldset>
            <fieldset>
                <legend>Informacion de la Propiedad</legend>

                <label for="habitaciones">Habitaciones</label>
                <input type="number" id="habitaciones" name="habitaciones" min="1" max="9" value="<?php echo $habitaciones; ?>">

                <label for="wc">Baños</label>
                <input type="number" id="wc" name="wc" min="1" max="9" value="<?php echo $wc; ?>">

                <label for="estacionamiento">Estacionamiento</label>
                <input type="number" id="estacionamiento" name="estacionamiento" min="1" max="9" value="<?php echo $estacionamiento; ?>">
            </fieldset>
            <fieldset>
                <legend>Vendedor</legend>

                <label for="vendedor">Vendedor</label>
                <select id="vendedor" name="vendedor">
                    <option value="" disabled selected>Selecciona</option>
                    <?php while ($vendedor = mysqli_fetch_assoc($resultado)) : ?>
                        <option <?php echo ($vendedorId === $vendedor['id']) ? 'selected' : '' ; ?>  value="<?php echo $vendedor['id']; ?>"><?php echo  $vendedor['nombre'] . " " . $vendedor['apellido']; ?></option>
                    <?php endwhile; ?>
                </select>
            </fieldset>

            <input type="submit" value="Crear Propiedad" class="boton boton-verde">
        </form>

    </main>

<?php
    incluirTemplate('footer');
?>