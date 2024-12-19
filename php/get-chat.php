<?php
session_start();
if (isset($_SESSION['unique_id'])) {
    include_once "config.php";
    $outgoing_id = $_SESSION['unique_id'];
    $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
    $output = "";
    $sql = "SELECT * FROM messages LEFT JOIN users ON users.unique_id = messages.outgoing_msg_id
                WHERE (outgoing_msg_id = {$outgoing_id} AND incoming_msg_id = {$incoming_id})
                OR (outgoing_msg_id = {$incoming_id} AND incoming_msg_id = {$outgoing_id}) ORDER BY msg_id";
    $query = mysqli_query($conn, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            if ($row['outgoing_msg_id'] === $outgoing_id) {
                // Modifica el código según tus necesidades, aquí un ejemplo básico
                $output .= '<div class="chat outgoing">
                                <div class="details">
                                    <p>' . $row['msg'] . '</p>';
                // Verificar si hay archivo adjunto
                if (!empty($row['archivo'])) {
                    $output .= '<a href="php/uploads/' . $row['archivo'] . '" target="_blank">Descargar archivo</a>';
                }
                $output .= '    </div>
                            </div>';
            } else {
                // Mensaje entrante
                $output .= '<div class="chat incoming">
                                            <img src="php/images/' . $row['img'] . '" alt="">
                                            <div class="details">
                                                <p>' . $row['msg'] . '</p>';
                // Verificar si hay archivo adjunto
                if (!empty($row['archivo'])) {
                    $output .= '<a href="php/uploads/' . $row['archivo'] . '" target="_blank">Descargar archivo</a>';
                }
                $output .= '</div>
                                        </div>';
            }
        }
    } else {
        $output .= '<div class="text">No existen mensajes, cuando cuando comienzan una conversación aparecera aqui.</div>';
    }
    echo $output;
} else {
    header("location: ../login.php");
}
