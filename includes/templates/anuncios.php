<?php
    //Importar DB
    require 'includes/config/database.php';
    $db = conectarDB();

    //Consultar
    $query = "SELECT * FROM propiedades LIMIT ".$limite;

    //Obtener resultado
    $resultado = mysqli_query($db, $query);
?>

<div class="contenedor-anuncios">
    <?php while($propiedad = mysqli_fetch_assoc($resultado)) : ?>
    <div class="anuncio">
        <img loading="lazy" src="imagenes/<?php echo $propiedad['imagen']; ?>" alt="Anuncio">
        <div class="contenido-anuncio">
            <h3><?php echo $propiedad['titulo']; ?></h3>
            <!-- <p>Casa en el lago con excelente vista, acabados de lujo a un excelente precio</p> -->
            <p class="precio">$<?php echo $propiedad['precio']; ?></p>
            <ul class="iconos-caracteristicas">
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="Icono wc">
                    <p><?php echo $propiedad['WC']; ?></p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="Icono Estacionamiento">
                    <p><?php echo $propiedad['estacionamiento']; ?></p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="Icono Dormitorio">
                    <p><?php echo $propiedad['habitaciones']; ?></p>
                </li>
            </ul>
            <a class="boton-amarillo-block" href="anuncio.php?id=<?php echo $propiedad['id']; ?>">
                Ver Propiedad
            </a>
        </div>
    </div><!--anuncio-->
    <?php endwhile; ?>
</div> <!--contenedor-anuncio-->

<?php
    //Cerrar conexion a la DB
    mysqli_close($db);    
?>
