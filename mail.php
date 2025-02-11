<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $projectName = $_POST['project_name'];
    $adminEmail = $_POST['admin_email'];
    $formSubject = $_POST['form_subject'];

    $name = $_POST['Name'];
    $company = $_POST['Company'];
    $email = $_POST['E-mail'];
    $phone = $_POST['Phone'];
    $message = $_POST['Message'];


    $body = "Nombre: " . $name . "\n";
    if (!empty($company)) {
        $body .= "Compañía: " . $company . "\n";
    }
    $body .= "Email: " . $email . "\n";
    $body .= "Teléfono: " . $phone . "\n";
    $body .= "Mensaje: " . $message . "\n";

    // Para enviar un correo HTML, configura los encabezados
    $headers = "From: " . $email . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n"; // o text/html si usas HTML en el mensaje

    // Envía el correo
    $success = mail($adminEmail, $formSubject, $body, $headers);

    if ($success) {
        // Redirige al usuario a una página de agradecimiento (opcional)
        header("Location: gracias.html"); // Crea un archivo gracias.html
        exit();
    } else {
        // Muestra un mensaje de error
        echo "Hubo un error al enviar el mensaje. Inténtalo de nuevo más tarde.";
    }
}
?>