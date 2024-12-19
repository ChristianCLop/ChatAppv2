<?php
session_start();
include_once "config.php";
$outgoing_id = $_SESSION['unique_id'];

$userTypeQuery = mysqli_query($conn, "SELECT userType FROM users WHERE unique_id = {$outgoing_id}");
$userTypeRow = mysqli_fetch_assoc($userTypeQuery);
$userType = $userTypeRow['userType'];

$sql = "SELECT * FROM users WHERE NOT unique_id = {$outgoing_id} AND userType = '{$userType}' ORDER BY user_id DESC";
$query = mysqli_query($conn, $sql);
$output = "";

if(mysqli_num_rows($query) == 0){
    $output .= "No se encontraron usuarios con el mismo rol";
}elseif(mysqli_num_rows($query) > 0){
    include_once "data.php";
}
echo $output;
?>