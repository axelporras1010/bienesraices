<?php
    //Importar la conexion a la DB
    require '../includes/config/database.php';
    $db = conectarDB();

    //Escribir el query
    $query = "SELECT * FROM propiedades";

    //Consultar la DB
    $consulta = mysqli_query($db, $query);

    //Muestra el mensaje condicional
    $resultado = $_GET['resultado'] ?? null;

    //Incluir el header
    require '../includes/funciones.php';
    incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Administrador de Bienes Raices</h1>
        <?php if(intval($resultado) === 1 ): ?>
            <div class="alerta exito">
                <p>El anuncio ha sido creado correctamente</p>
            </div>
        <?php endif; ?>    

        <a href="/bienesraices_inicio/admin/propiedades/crear.php" class="boton boton-verde">Crear</a>
        
        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Imagen</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($propiedad = mysqli_fetch_assoc($consulta)): ?>
                <tr>
                    <td><?php echo $propiedad['id']; ?></td>
                    <td><?php echo $propiedad['titulo']; ?></td>
                    <td><img src="/bienesraices_inicio/imagenes/<?php echo $propiedad['imagen']; ?>" alt="Imagen casa" class="imagen-tabla"></td>
                    <td>$<?php echo $propiedad['precio']; ?></td>
                    <td>
                        <a href="" class="boton-amarillo-block">Actualizar</a>
                        <a href="" class="boton-rojo-block">Eliminar</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>

<?php
    incluirTemplate('footer');
?>