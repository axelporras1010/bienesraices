<?php
    use App\Propiedad;

    if($_SERVER["REQUEST_URI"] === "/bienesraices_inicio/anuncios.php"){
        $propiedades = Propiedad::all();
    }else{
        $propiedades = Propiedad::get(3);
    }
?>

<div class="contenedor-anuncios">
    <?php foreach($propiedades as $propiedad) { ?>
    <div class="anuncio">
        <img loading="lazy" src="imagenes/<?php echo $propiedad->imagen; ?>" alt="Anuncio">
        <div class="contenido-anuncio">
            <h3><?php echo $propiedad->titulo; ?></h3>
            <!-- <p>Casa en el lago con excelente vista, acabados de lujo a un excelente precio</p> -->
            <p class="precio">$<?php echo $propiedad->precio; ?></p>
            <ul class="iconos-caracteristicas">
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="Icono wc">
                    <p><?php echo $propiedad->WC; ?></p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="Icono Estacionamiento">
                    <p><?php echo $propiedad->estacionamiento; ?></p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="Icono Dormitorio">
                    <p><?php echo $propiedad->habitaciones; ?></p>
                </li>
            </ul>
            <a class="boton-amarillo-block" href="anuncio.php?id=<?php echo $propiedad->id; ?>">
                Ver Propiedad
            </a>
        </div>
    </div><!--anuncio-->
    <?php } ?>
</div> <!--contenedor-anuncio-->
