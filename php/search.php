<?php
session_start();
include_once "config.php";

$outgoing_id = $_SESSION['unique_id'];
$searchTerm = mysqli_real_escape_string($conn, $_POST['searchTerm']);

$userTypeQuery = mysqli_query($conn, "SELECT userType FROM users WHERE unique_id = {$outgoing_id}");
$userTypeRow = mysqli_fetch_assoc($userTypeQuery);
$userType = $userTypeRow['userType'];

$sql = "SELECT * FROM users 
        WHERE NOT unique_id = {$outgoing_id} 
        AND (fname LIKE '%{$searchTerm}%' OR lname LIKE '%{$searchTerm}%') 
        AND userType = '{$userType}'";
$output = "";

$query = mysqli_query($conn, $sql);

if(mysqli_num_rows($query) > 0){
    include_once "data.php";
}else{
    $output .= 'Ningun usuario se encontro';
}
echo $output;
?>
