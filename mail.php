<?php

$method = $_SERVER['REQUEST_METHOD'];
$message = '';

// Inicializamos la variable c para la tabla
$c = true;

if ($method === 'POST' || $method === 'GET') {
    $project_name = trim($method === 'POST' ? $_POST["project_name"] : $_GET["project_name"]);
    $admin_email  = trim($method === 'POST' ? $_POST["admin_email"] : $_GET["admin_email"]);
    $form_subject = trim($method === 'POST' ? $_POST["form_subject"] : $_GET["form_subject"]);

    foreach ($method === 'POST' ? $_POST : $_GET as $key => $value) {
        if ($value != "" && $key != "project_name" && $key != "admin_email" && $key != "form_subject") {
            // Escapar salida para evitar inyección HTML
            $key = htmlspecialchars($key);
            $value = htmlspecialchars($value);
            $message .= "
            " . (($c = !$c) ? '<tr>':'<tr style="background-color: #f8f8f8;">') . "
                <td style='padding: 10px; border: #e9e9e9 1px solid;'><b>$key</b></td>
                <td style='padding: 10px; border: #e9e9e9 1px solid;'>$value</td>
            </tr>
            ";
        }
    }
    
    $message = "<table style='width: 100%;'>$message</table>";

    // Función adopt
    function adopt($text) {
        return '=?UTF-8?B?'.Base64_encode($text).'?=';
    }

    // Encabezados del correo
    $headers = "MIME-Version: 1.0" . PHP_EOL .
               "Content-Type: text/html; charset=utf-8" . PHP_EOL .
               'From: '.adopt($project_name).' <'.$admin_email.'>' . PHP_EOL .
               'Reply-To: '.$admin_email.'' . PHP_EOL;

    // Enviar el correo y manejar errores
    if (!mail($admin_email, adopt($form_subject), $message, $headers)) {
        echo "Error al enviar el correo.";
    } else {
        echo "Correo enviado con éxito.";
    }
} else {
    echo "Método no permitido.";
}
