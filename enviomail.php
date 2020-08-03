<?php
    // Get the form fields, removes html tags and whitespace.
    $nombre = strip_tags(trim($_POST["nombre"]));
    $nombre = str_replace(array("\r","\n"),array(" "," "),$nombre);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $mensaje = trim($_POST["mensaje"]);

    // Check the data.
    if (empty($nombre) OR empty($mensaje) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: https://miyashimatravel.netlify.app/contacto.html");
        exit;
    }

    // Set the recipient email address. Update this to YOUR desired email address.
    $recipient = "contact@miyashimatravel.com";

    // Set the email subject.
    $subject = "New contact from $nombre";

    // Build the email content.
    $email_content = "nombre: $nombre\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "mensaje:\n$mensaje\n";

    // Build the email headers.
    $email_headers = "From: $nombre <$email>";

    // Send the email.
    mail($recipient, $subject, $email_content, $email_headers);
    
    // Redirect to the index.html page with success code
    header("Location: https://miyashimatravel.netlify.app/index.html");
?>