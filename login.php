<?php 
    //Autenticado el usuario
    require 'includes/app.php';
    $db = conectarDB();

    $errores = [];

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $password = mysqli_real_escape_string($db, $_POST['password']);

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) $errores[] = "El email es obligatorio o no valido";
        if(!$password) $errores[] = "El password es obligatorio";

        if(empty($errores)){
            //Revisar si el usuario existe
            $query = "SELECT * FROM usuarios WHERE email='$email'";
            $resultado = mysqli_query($db, $query);

            if($resultado->num_rows){
                //Revisar si el password es correcto
                $usuario = mysqli_fetch_assoc($resultado);
                $auth = password_verify($password, $usuario['password']);
                if($auth){
                    //El usuario ha sido autenticado
                    session_start();
                    $_SESSION['usuario'] = $usuario['email'];
                    $_SESSION['login'] = true;
                    header('location: /bienesraices_inicio/admin/index.php');
                }else{
                    $errores[] = "La contraseña no es correcta";
                }
            }else{
                $errores[] = "El usuario no existe";
            }
        }
    }

    //Incluyendo el header
    incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Iniciar sesión</h1>
        <form class="formulario contenido-centrado" method="POST">
            <?php foreach($errores as $error): ?>
                <div class="alerta error">
                    <?php echo $error; ?>
                </div>
            <?php endforeach; ?>
            <fieldset>
                <legend>Email y Password</legend>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Tu email" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Tu password" required >
            </fieldset>
            <input type="submit" value="Iniciar sesión" class="boton boton-verde">
        </form>
    </main>

<?php
    incluirTemplate('footer');
?>