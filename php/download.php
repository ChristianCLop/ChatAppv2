<?php
include_once "config.php"; // Asegúrate de incluir el archivo de configuración correctamente

if (isset($_GET['msg_id'])) {
    $msg_id = mysqli_real_escape_string($conn, $_GET['msg_id']);

    $query = mysqli_query($conn, "SELECT * FROM messages WHERE msg_id = {$msg_id}");
    $row = mysqli_fetch_assoc($query);

    $file_path = 'php/uploads/' . $row['archivo']; // Ajusta la ruta del archivo según tu estructura

    if (file_exists($file_path)) {
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
        header('Content-Length: ' . filesize($file_path));

        readfile($file_path);
        exit;
    } else {
        echo "El archivo no existe.";
    }
} else {
    echo "ID de mensaje no proporcionado.";
}
