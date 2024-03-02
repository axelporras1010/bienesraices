<?php
    require 'includes/funciones.php';
    incluirTemplate('header');
?>

    <main class="contenedor seccion contenido-centrado">
        <h1>Casa Frente al Bosque</h1>
        <div class="info-anuncio">
            <picture>
                <source srcset="build/img/estacada.webp" type="img/webp">
                <source srcset="build/img/estacada.jpg" type="img/jpeg">
                <img loading="lazy" src="build/img/destacada.jpg" alt="Imagen Anuncio">
            </picture>
            <div class="resumen-propiedad">
                <p class="precio">$3.000.000</p>
                <ul class="iconos-caracteristicas">
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="Icono wc">
                        <p>3</p>
                    </li>
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="Icono Estacionamiento">
                        <p>3</p>
                    </li>
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="Icono Dormitorio">
                        <p>4</p>
                    </li>
                </ul>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Perferendis quod autem est explicabo, similique a nulla voluptate repellendus maxime quas id nesciunt aliquam, nihil cupiditate laborum pariatur, reprehenderit corrupti quisquam. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quis quos, facilis odio laudantium recusandae magnam vero, ab suscipit harum architecto vel accusantium eligendi dolorum maiores asperiores dolores ea? Recusandae, quod.</p>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quis quos, facilis odio laudantium recusandae magnam vero, ab suscipit harum architecto vel accusantium eligendi dolorum maiores asperiores dolores ea? Recusandae, quod. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quis quos, facilis odio laudantium recusandae magnam vero, ab suscipit harum architecto vel accusantium eligendi dolorum maiores asperiores dolores ea? Recusandae, quod.</p>
            </div>
        </div>
    </main>

<?php
    incluirTemplate('footer');
?>