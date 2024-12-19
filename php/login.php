<?php
session_start();
include_once "config.php";

// Verifica si el formulario fue enviado
if (isset($_POST['phone']) && isset($_POST['password'])) {
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Verifica que los campos no estén vacíos
    if (!empty($phone) && !empty($password)) {
        // Prepara la consulta para evitar inyecciones SQL
        $sql = mysqli_prepare($conn, "SELECT * FROM users WHERE phone = ?");
        mysqli_stmt_bind_param($sql, "s", $phone);
        mysqli_stmt_execute($sql);
        $result = mysqli_stmt_get_result($sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            // Verifica la contraseña utilizando password_verify
            if (password_verify($password, $row['password'])) {
                $status = "Conectado";
                // Actualiza el estado del usuario
                $sql2 = mysqli_prepare($conn, "UPDATE users SET status = ? WHERE unique_id = ?");
                mysqli_stmt_bind_param($sql2, "si", $status, $row['unique_id']);
                $sql2_result = mysqli_stmt_execute($sql2);

                if ($sql2_result) {
                    // Almacena el ID único del usuario en la sesión
                    $_SESSION['unique_id'] = $row['unique_id'];
                    echo "success"; // Redirige a la página de usuarios o lo que desees
                } else {
                    echo "Algo salió mal, intenta de nuevo!";
                }
            } else {
                echo "Contraseña incorrectos!";
            }
        } else {
            echo "$phone - Este telefono no existe!";
        }
    } else {
        echo "Todos los campos son requeridos!";
    }
} else {
    echo "Por favor, completa todos los campos!";
}
?>
