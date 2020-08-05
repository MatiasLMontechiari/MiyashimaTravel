<?php
    //Se toman los compos del formulario eliminando el contenidod del html
    $nombre = strip_tags(trim($_POST["nombre"]));
    $nombre = str_replace(array("\r","\n"),array(" "," "),$nombre);
    $to = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $file = "folleto.jpg";

    //remitente del correo
    $from = 'contacto@miyashimatravel.com';
    $fromName = 'MiyashimaTravel';
    
    //Asunto del email
    $subject = "Gracias por tu contacto $nombre"; 
    
    //Ruta del archivo adjunto
    $file = "folleto.jpg";
    
    //Contenido del Email
    $htmlContent = '<h1>Recibimos tu mensaje correctamente, en breve responderemos tus dudas</h1>
        <p>Te adjuntamos la guia de viaje de Miyashima para que la disfrutes y puedas ver la veriedad de lugares que podes visitar</p>';
    
    //Encabezado para información del remitente
    $headers = "From: $fromName"." <".$from.">";
    
    //Limite Email
    $semi_rand = md5(time()); 
    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 
    
    //Encabezados para archivo adjunto 
    $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 
    
    //límite multiparte
    $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
    "Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n"; 
    
    //preparación de archivo y validacion de existensia del archivo en el servidor
    if(!empty($file) > 0){
        if(is_file($file)){
            $message .= "--{$mime_boundary}\n";
            $fp =    @fopen($file,"rb");
            $data =  @fread($fp,filesize($file));
    
            @fclose($fp);
            $data = chunk_split(base64_encode($data));
            $message .= "Content-Type: application/octet-stream; name=\"".basename($file)."\"\n" . 
            "Content-Description: ".basename($files[$i])."\n" .
            "Content-Disposition: attachment;\n" . " filename=\"".basename($file)."\"; size=".filesize($file).";\n" . 
            "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
        }
    }
    $message .= "--{$mime_boundary}--";
    $returnpath = "-f" . $from;
    
    //Enviar EMail
    $mail = @mail($to, $subject, $message, $headers, $returnpath); 
    
    // Se re dirige a la seccion GRACIAS cuando se realizo el envio del mail correctamente
    header("Location: https://miyashimatravel.000webhostapp.com/gracias.html");
?>