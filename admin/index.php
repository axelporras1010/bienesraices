<?php 
    //Verifica si esta autenticado
    require '../includes/app.php';
    estaAutenticado();

    //Importar clases
    use App\Propiedad;
    use App\Vendedor;
    
    //Implementar el metodo para obtener todas las propiedades
    $propiedades = Propiedad::all();
    $vendedores = Vendedor::all();

    //Muestra el mensaje condicional
    $resultado = $_GET['resultado'] ?? null;
    
    //Borrar propiedad
    if($_SERVER['REQUEST_METHOD'] === 'POST'){   
        //Validar ID
        $id = $_POST['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        $tipo = $_POST['tipo'];
        if(validarTipoContenido($tipo)){
            if($tipo === 'propiedad'){
                $propiedad = Propiedad::find($id);
                $propiedad->eliminar();
            }else{
                $vendedor = Vendedor::find($id);
                $vendedor->eliminar();
            }
        }
    }
    //Incluir el header
    incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Administrador de Bienes Raices</h1>
        <?php 
            $mensaje = mostrarNotificacion(intval($resultado));
            if($mensaje){ ?>
                <p class="alerta exito"><?php echo s($mensaje); ?></p>
        <?php }; ?>
           

        <a href="/bienesraices_inicio/admin/propiedades/crear.php" class="boton boton-verde">Crear Propiedad</a>
        <a href="/bienesraices_inicio/admin/vendedores/crear.php" class="boton boton-amarillo">Crear Vendedor</a>
        <h2>Propiedades</h2>
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
                <?php foreach ($propiedades as $propiedad): ?>
                <tr>
                    <td><?php echo $propiedad->id; ?></td>
                    <td><?php echo $propiedad->titulo; ?></td>
                    <td><img src="/bienesraices_inicio/imagenes/<?php echo $propiedad->imagen; ?>" alt="Imagen casa" class="imagen-tabla"></td>
                    <td>$<?php echo $propiedad->precio; ?></td>
                    <td>
                        <a href="/bienesraices_inicio/admin/propiedades/actualizar.php?id=<?php echo $propiedad->id; ?>" class="boton-amarillo-block">Actualizar</a>
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $propiedad->id;?>">
                            <input type="hidden" name="tipo" value="propiedad">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        

        <h2>Vendedores</h2>
        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Telefono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vendedores as $vendedor): ?>
                <tr>
                    <td><?php echo $vendedor->id; ?></td>
                    <td><?php echo $vendedor->nombre . " " . $vendedor->apellido; ?></td>
                    <td><?php echo $vendedor->telefono; ?></td>
                    <td>
                        <a href="/bienesraices_inicio/admin/vendedores/actualizar.php?id=<?php echo $vendedor->id; ?>" class="boton-amarillo-block">Actualizar</a>
                        <form method="POST" class="w-100">
                            <input type="hidden" name="id" value="<?php echo $vendedor->id;?>">
                            <input type="hidden" name="tipo" value="vendedor">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

<?php
    incluirTemplate('footer');
?>