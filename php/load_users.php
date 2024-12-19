<?php
include_once "config.php";

$search = isset($_GET['search']) ? $_GET['search'] : '';

// Consulta SQL para buscar usuarios
$sql = "SELECT * FROM users WHERE fname LIKE '%$search%' OR lname LIKE '%$search%'";
$query = mysqli_query($conn, $sql);

if (mysqli_num_rows($query) > 0) {
  while ($row = mysqli_fetch_assoc($query)) {
    ?>
    <a href="javascript:void(0);" onclick="loadChat(<?php echo $row['unique_id']; ?>)" class="user">
      <img src="php/images/<?php echo $row['img']; ?>" alt="">
      <div class="user-details">
        <span><?php echo $row['fname'] . " " . $row['lname']; ?></span>
        <p><?php echo $row['status']; ?></p>
      </div>
    </a>
    <?php
  }
} else {
  echo "No se encontraron usuarios.";
}
?>
