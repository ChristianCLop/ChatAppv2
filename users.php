<?php
session_start();
include_once "php/config.php";
if (!isset($_SESSION['unique_id'])) {
  header("location: login.php");
}
?>
<?php include_once "header.php"; ?>

<body>
  <div class="wrapper">
    <section class="users">
      <header>
        <div class="content">
          <?php
          $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}");
          if (mysqli_num_rows($sql) > 0) {
            $row = mysqli_fetch_assoc($sql);
          }
          ?>
          <img src="php/images/<?php echo $row['img']; ?>" alt="">
          <div class="details">
            <span><?php echo $row['fname'] . " " . $row['lname'] ?></span>
            <p><?php echo $row['status']; ?></p>
          </div>
        </div>
        <a href="php/logout.php?logout_id=<?php echo $row['unique_id']; ?>" class="logout">Cerrar Sesión</a>
      </header>
      <div class="search">
        <input type="text" id="search-user" placeholder="Buscar por nombre...">
        <button><i class="fas fa-search"></i></button>
      </div>
      <div class="users-list" id="users-list">
        <!-- Los usuarios serán cargados aquí con AJAX -->
      </div>
    </section>

    <section class="chat-area" id="chat-area">
      <!-- El chat se actualizará aquí -->
    </section>
  </div>

  <script src="javascript/chat.js"></script>
  <script>
    // Función para cargar la lista de usuarios
    function loadUsers() {
      const searchQuery = document.getElementById('search-user').value;
      const xhr = new XMLHttpRequest();
      xhr.open('GET', 'php/load_users.php?search=' + searchQuery, true);
      xhr.onload = function () {
        if (xhr.status == 200) {
          document.getElementById('users-list').innerHTML = xhr.responseText;
        }
      };
      xhr.send();
    }

    // Función para cargar el chat cuando se selecciona un usuario
    function loadChat(userId) {
      const xhr = new XMLHttpRequest();
      xhr.open('GET', 'php/load_chat.php?user_id=' + userId, true);
      xhr.onload = function () {
        if (xhr.status == 200) {
          document.getElementById('chat-area').innerHTML = xhr.responseText;
        }
      };
      xhr.send();
    }

    // Ejecutar búsqueda de usuarios al escribir en el campo de búsqueda
    document.getElementById('search-user').addEventListener('input', loadUsers);

    // Llamar a la función loadUsers al cargar la página para mostrar todos los usuarios
    window.onload = loadUsers;
  </script>
</body>
</html>
<style>
  /* Estilos Generales */
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #e5ddd5;
    color: #4a4a4a;
  }

  .wrapper {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    height: 100vh;
    background-color: #f7f7f7;
    padding: 10px;
  }

  /* Sección de usuarios */
  .users {
    width: 40%;
    max-width: 400px;
    background-color: #ffffff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 1px 10px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    height: 100%;
  }

  /* Sección de chat */
  .chat-area {
    width: 55%;
    max-width: 600px;
    background-color: #ffffff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 1px 10px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    height: 100%;
  }

  /* Encabezado */
  header {
    background-color: #25d366;
    padding: 10px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: white;
  }

  header .content {
    display: flex;
    align-items: center;
  }

  header img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin-right: 10px;
  }

  header .details {
    display: flex;
    flex-direction: column;
  }

  header .details span {
    font-size: 16px;
    font-weight: bold;
  }

  header .details p {
    font-size: 14px;
    color: #f0f0f0;
  }

  header .logout {
    font-size: 14px;
    color: white;
    text-decoration: none;
  }

  /* Barra de búsqueda */
  .search {
    padding: 10px;
    background-color: #f0f0f0;
    display: flex;
    align-items: center;
    border-top: 1px solid #ddd;
  }

  .search .text {
    flex: 1;
    font-size: 14px;
    color: #666;
  }

  .search input {
    border: none;
    padding: 10px;
    width: 80%;
    border-radius: 10px;
    margin-right: 10px;
  }

  .search button {
    background-color: #25d366;
    border: none;
    padding: 8px 12px;
    border-radius: 50%;
    color: white;
    cursor: pointer;
  }

  .search button i {
    font-size: 18px;
  }

  /* Lista de usuarios */
  .users-list {
    overflow-y: auto;
    max-height: 400px;
    padding: 10px;
  }

  .users-list .user {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
    background-color: #ffffff;
    border-radius: 10px;
    margin-bottom: 10px;
    box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
    cursor: pointer;
  }

  .users-list .user:hover {
    background-color: #f1f1f1;
  }

  .users-list .user img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin-right: 10px;
  }

  .users-list .user .user-details {
    flex: 1;
  }

  .users-list .user .user-details span {
    font-size: 16px;
    font-weight: bold;
  }

  .users-list .user .user-details p {
    font-size: 14px;
    color: #888;
  }

  /* Estilos para los mensajes */
  .chat-box {
    overflow-y: auto;
    padding: 15px;
    flex: 1;
  }

  .outgoing-msg,
  .incoming-msg {
    display: flex;
    margin-bottom: 15px;
  }

  .outgoing-msg .sent-msg,
  .incoming-msg .received-msg {
    background-color: #25d366;
    color: white;
    padding: 10px;
    border-radius: 10px;
    max-width: 70%;
  }

  .incoming-msg .received-msg {
    background-color: #f1f1f1;
    color: black;
  }

  .file-container {
    margin-top: 5px;
    font-size: 12px;
    color: #888;
  }

  .file-container a {
    text-decoration: none;
    color: #25d366;
  }

  /* Área de escritura */
  .typing-area {
    padding: 10px;
    display: flex;
    align-items: center;
    border-top: 1px solid #ddd;
  }

  .typing-area input[type="text"] {
    flex: 1;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 20px;
    margin-right: 10px;
  }

  .typing-area button {
    background-color: #25d366;
    border: none;
    padding: 8px 12px;
    border-radius: 50%;
    color: white;
    cursor: pointer;
  }

  .typing-area input[type="file"] {
    display: none;
  }

  .typing-area input[type="file"]:checked {
    display: block;
  }

  .wrapper {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    height: 100vh;
    padding: 10px;
  }

  .users {
    width: 40%;
    /* Ajusta el tamaño de la sección de usuarios */
  }

  .chat-area {
    width: 60%;
    /* Ajusta el tamaño de la sección de chat */
    max-width: 800px;
    /* Controla el máximo tamaño del área de chat */
  }
</style>