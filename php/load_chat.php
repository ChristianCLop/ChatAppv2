<?php
// Inicia la sesión
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['unique_id'])) {
    header("Location: login.php");
    exit();
}

// Incluir el archivo de configuración para la base de datos
include_once 'config.php';

// Verifica si la conexión se realizó correctamente
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Obtener el ID del usuario con el que se va a chatear
if (isset($_GET['user_id'])) {
    $chat_user_id = $_GET['user_id'];

    // Consulta para obtener el historial de chat entre los usuarios
    $sql = "SELECT * FROM messages 
            WHERE (incoming_msg_id = " . $_SESSION['unique_id'] . " AND outgoing_msg_id = $chat_user_id) 
            OR (incoming_msg_id = $chat_user_id AND outgoing_msg_id = " . $_SESSION['unique_id'] . ") 
            ORDER BY msg_id"; // Se utiliza msg_id para ordenar los mensajes

    $result = mysqli_query($conn, $sql);
} else {
    echo "No user selected.";
}
?>

<?php include_once "../header.php"; ?>

<body>
  <div class="wrapper">
    <section class="chat-area">
      <header>
        <?php
        $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$user_id}");
        if (mysqli_num_rows($sql) > 0) {
          $row = mysqli_fetch_assoc($sql);
        } else {
          header("location: users.php");
        }
        ?>
        <a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
        <img src="php/images/<?php echo $row['img']; ?>" alt="">
        <div class="details">
          <span><?php echo $row['fname'] . " " . $row['lname'] ?></span>
          <p><?php echo $row['status']; ?></p>
        </div>
      </header>
      <div class="chat-box">
        <!-- Bucle que recorre los mensajes -->
        <?php
        $query = mysqli_query($conn, "SELECT * FROM messages WHERE (incoming_msg_id = {$user_id} AND outgoing_msg_id = {$_SESSION['unique_id']}) OR (outgoing_msg_id = {$user_id} AND incoming_msg_id = {$_SESSION['unique_id']}) ORDER BY msg_id ASC");

        while ($row = mysqli_fetch_assoc($query)) {
          ?>
          <!-- Mensaje saliente -->
          <?php if ($row['outgoing_msg_id'] == $_SESSION['unique_id']) : ?>
            <div class="outgoing-msg">
              <div class="sent-msg">
                <p><?php echo $row['msg']; ?></p>
                <!-- Verificar si el mensaje tiene un archivo adjunto -->
                <?php if (!empty($row['archivo'])) : ?>
                  <div class="file-container">
                    <a href="php/download.php?msg_id=<?php echo $row['msg_id']; ?>" target="_blank">
                      Descargar Archivo: <?php echo $row['archivo']; ?>
                    </a>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          <?php else : ?>
            <!-- Mensaje entrante -->
            <div class="incoming-msg">
              <div class="received-msg">
                <p><?php echo $row['msg']; ?></p>
                <!-- Verificar si el mensaje tiene un archivo adjunto -->
                <?php if (!empty($row['archivo'])) : ?>
                  <div class="file-container">
                    <a href="php/download.php?msg_id=<?php echo $row['msg_id']; ?>" target="_blank">
                      Descargar Archivo: <?php echo $row['archivo']; ?>
                    </a>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          <?php endif; ?>
        <?php } ?>
      </div>
      <form action="#" class="typing-area" enctype="multipart/form-data">
        <input type="file" name="archivo" id="archivo">
        <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $user_id; ?>" hidden>
        <input type="text" name="message" class="input-field" placeholder="Escribe tu mensaje aquí..." autocomplete="off">
        <button><i class="fab fa-telegram-plane"></i></button>
      </form>
    </section>
  </div>

  <script src="javascript/chat.js"></script>

</body>

</html>

<style>
</style>