<?php 
    //Verifica si esta autenticado
    require '../includes/app.php';
    estaAutenticado();

    //Importar la conexion a la DB
    $db = conectarDB();

    //Escribir el query
    $query = "SELECT * FROM propiedades";

    //Consultar la DB
    $consulta = mysqli_query($db, $query);

    //Muestra el mensaje condicional
    $resultado = $_GET['resultado'] ?? null;
    if($_SERVER['REQUEST_METHOD'] === 'POST'){    
        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if($id){
            //Delete the image
            $query = "SELECT imagen FROM propiedades WHERE id =".$id;
            $resultado = mysqli_query($db, $query);
            $propiedad = mysqli_fetch_assoc($resultado);
            
            unlink('../imagenes/' . $propiedad['imagen']);
            //Delete the image
            $query = "DELETE FROM propiedades WHERE id=".$id;
            $resultado = mysqli_query($db, $query);
            if($resultado){
                header("Location: /bienesraices_inicio/admin/index.php?resultado=3");
            }
        }
    }
    //Incluir el header
    incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Administrador de Bienes Raices</h1>
        <?php if(intval($resultado) === 1 ): ?>
            <div class="alerta exito">
                <p>El anuncio ha sido creado correctamente</p>
            </div>
        <?php elseif(intval($resultado) === 2): ?>
            <div class="alerta exito">
                <p>El anuncio ha sido actualizado correctamente</p>
            </div>
        <?php elseif(intval($resultado) === 3): ?>
            <div class="alerta exito">
                <p>El anuncio ha sido eliminado correctamente</p>
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
                        <a href="/bienesraices_inicio/admin/propiedades/actualizar.php?id=<?php echo $propiedad['id']; ?>" class="boton-amarillo-block">Actualizar</a>
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $propiedad['id'];?>">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>

<?php
    incluirTemplate('footer');
?>