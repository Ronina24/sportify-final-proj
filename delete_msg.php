<?php
include "db.php";
include "config.php";

session_start();

if (!isset($_SESSION["type"]))
    header('Location: ' . URL . 'login.php');

$tid= $_GET["tid"]; 

$msg_id= $_GET["msg_id"]; 
if (!$msg_id){
    header("Refresh:0; url=index.php");
    return;
}
$query= "DELETE FROM tbl_messages_211 WHERE msg_id= $msg_id";

$result= mysqli_query($connection, $query) or die(mysqli_error());
if ($result )
    header('Location: ' . URL . "tournament.php?tid=$tid");
?>