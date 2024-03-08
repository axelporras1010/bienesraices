<?php
    require 'includes/app.php';
    incluirTemplate('header');
?>


    <main class="contenedor seccion">
        <h1>Conoce Sobre Nosotros</h1>
        <div class="principal">
            <div class="imagen-nosotros">
                <picture>
                    <source srcset="build/img/nosotros.webp" type="img/webp">
                    <source srcset="build/img/nosotros.jpg" type="img/jepg">
                    <img src="build/img/nosotros.jpg" alt="Imagen Nosotros">
                </picture>
            </div>
            <div class="informacion-nosotros">
                <h3>25 años de experiencia</h3>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Perferendis quod autem est explicabo, similique a nulla voluptate repellendus maxime quas id nesciunt aliquam, nihil cupiditate laborum pariatur, reprehenderit corrupti quisquam. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quis quos, facilis odio laudantium recusandae magnam vero, ab suscipit harum architecto vel accusantium eligendi dolorum maiores asperiores dolores ea? Recusandae, quod.</p>
                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quis quos, facilis odio laudantium recusandae magnam vero, ab suscipit harum architecto vel accusantium eligendi dolorum maiores asperiores dolores ea? Recusandae, quod. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quis quos, facilis odio laudantium recusandae magnam vero, ab suscipit harum architecto vel accusantium eligendi dolorum maiores asperiores dolores ea? Recusandae, quod.</p>
            </div>
        </div> 
    </main>

    <section class="contenedor seccion">
        <h1>Mas sobre nosotros</h1>

        <div class="iconos-nosotros">
            <div class="icono">
                <img src="build/img/icono1.svg" alt="Icono Seguridad">
                <h3>Seguridad</h3>
                <p>Dolor sit amet consectetur adipisicing elit. Nostrum obcaecati reprehenderit quam aperiam, alias sapiente. Magni, nobis aliquid, neque molestias pariatur quidem sapiente eaque impedit maxime dicta rerum aspernatur! Ad?</p>
            </div>
            <div class="icono">
                <img src="build/img/icono2.svg" alt="Icono Precio">
                <h3>Precio</h3>
                <p>Dolor sit amet consectetur adipisicing elit. Nostrum obcaecati reprehenderit quam aperiam, alias sapiente. Magni, nobis aliquid, neque molestias pariatur quidem sapiente eaque impedit maxime dicta rerum aspernatur! Ad?</p>
            </div>
            <div class="icono">
                <img src="build/img/icono3.svg" alt="Icono Tiempo">
                <h3>Tiempo</h3>
                <p>Dolor sit amet consectetur adipisicing elit. Nostrum obcaecati reprehenderit quam aperiam, alias sapiente. Magni, nobis aliquid, neque molestias pariatur quidem sapiente eaque impedit maxime dicta rerum aspernatur! Ad?</p>
            </div>
        </div>
    </section>

<?php
    incluirTemplate('footer');
?>