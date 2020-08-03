<?php
    //Se toman los compos del formulario eliminando el contenidod del html
    $nombre = strip_tags(trim($_POST["nombre"]));
    $nombre = str_replace(array("\r","\n"),array(" "," "),$nombre);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $mensaje = trim($_POST["mensaje"]);

    // Se valida el contenido de los datos y en caso de error se dirige a una pagina de error
    if (empty($nombre) OR empty($mensaje) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: https://miyashimatravel.netlify.app/contacto.html");
        exit;
    }

    // Se reciben los mail aca
    $recipient = "matias.monte@davinci.edu.ar";

    // Establecemos el asunto del mail
    $subject = "New contact from $nombre";

    // Establecemos el cuerpo del mail
    $email_content = "nombre: $nombre\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "mensaje:\n$mensaje\n";

    // Establecemose el encabezado del correo
    $email_headers = "From: $nombre <$email>";

    // funcion de envio mails php
    mail($recipient, $subject, $email_content, $email_headers);
    
    // Se re dirige a la seccion gracias cuando se realizo el envio del mail correctamente
    header("Location: https://miyashimatravel.netlify.app/index.html");
?>