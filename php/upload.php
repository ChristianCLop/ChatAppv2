<?php

include "config.php";

// Comprobar si se ha cargado un archivo
if (isset($_FILES['archivo'])) {
    $incoming_id = $_POST['incoming_id'];
    $outgoing_id = $_SESSION['unique_id'];
    // Definir la carpeta de destino
    $carpeta_destino = "uploads/";
    // Obtener el nombre y la extensión del archivo
    $nombre_archivo = basename($_FILES["archivo"]["name"]);
    $extension = strtolower(pathinfo($nombre_archivo, PATHINFO_EXTENSION));
    // Validar la extensión del archivo
    if ($extension == "pdf" || $extension == "doc" || $extension == "docx") {
        // Mover el archivo a la carpeta de destino
        if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $carpeta_destino . $nombre_archivo)) {
            // Insertar la información del archivo en la tabla messages
            $sql = "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg, archivo) 
            VALUES ({$incoming_id}, {$outgoing_id}, '', '$nombre_archivo')";
            $resultado = mysqli_query($conn, $sql);
            if ($resultado) {
                echo "Archivo subido exitosamente.";
            } else {
                echo "Error al subir el archivo a la base de datos.";
            }
        } else {
            echo "Error al mover el archivo a la carpeta de destino.";
        }
    } else {
        echo "Solo se permiten archivos PDF, DOC y DOCX.";
    }
}
