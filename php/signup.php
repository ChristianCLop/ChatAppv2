<?php
session_start();
include_once "config.php";

$fname = mysqli_real_escape_string($conn, $_POST['fname']);
$lname = mysqli_real_escape_string($conn, $_POST['lname']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$userType = isset($_POST['rol']) ? mysqli_real_escape_string($conn, $_POST['rol']) : '';

if (!empty($fname) && !empty($lname) && !empty($phone) && !empty($password)) {
    if (filter_var($phone)) {
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE phone = '{$phone}'");
        if (mysqli_num_rows($sql) > 0) {
            echo "$phone - Este teléfono ya existe!";
        } else {
            if (isset($_FILES['image'])) {
                $img_name = $_FILES['image']['name'];
                $img_type = $_FILES['image']['type'];
                $tmp_name = $_FILES['image']['tmp_name'];
                
                $img_explode = explode('.', $img_name);
                $img_ext = end($img_explode);

                $extensions = ["jpeg", "png", "jpg"];
                if (in_array($img_ext, $extensions)) {
                    $types = ["image/jpeg", "image/jpg", "image/png"];
                    if (in_array($img_type, $types)) {
                        $time = time();
                        $new_img_name = $time . $img_name;
                        if (move_uploaded_file($tmp_name, "images/" . $new_img_name)) {
                            $ran_id = rand(time(), 100000000);
                            $status = "Conectado";
                            $encrypt_pass = password_hash($password, PASSWORD_DEFAULT); // Cambiado de md5 a password_hash
                            $insert_query = mysqli_query($conn, "INSERT INTO users (unique_id, fname, lname, phone, password, userType, img, status)
                                VALUES ({$ran_id}, '{$fname}', '{$lname}', '{$phone}', '{$encrypt_pass}', '{$userType}', '{$new_img_name}', '{$status}')");
                            if ($insert_query) {
                                $select_sql2 = mysqli_query($conn, "SELECT * FROM users WHERE phone = '{$phone}'");
                                if (mysqli_num_rows($select_sql2) > 0) {
                                    $result = mysqli_fetch_assoc($select_sql2);
                                    $_SESSION['unique_id'] = $result['unique_id'];
                                    echo "success";
                                } else {
                                    echo "Este teléfono no existe!";
                                }
                            } else {
                                echo "Algo salió mal, pruebe de nuevo!";
                            }
                        }
                    } else {
                        echo "Por favor, cargue una imagen de tipo - jpeg, png, jpg";
                    }
                } else {
                    echo "Por favor, cargue una imagen de tipo - jpeg, png, jpg";
                }
            }
        }
    } else {
        echo "$phone no es un teléfono válido!";
    }
} else {
    echo "Todos los campos son requeridos!";
}
?>
