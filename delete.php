<?php
include "db.php";
include "config.php";

session_start();

if (!isset($_SESSION["type"]))
    header('Location: ' . URL . 'login.php');

$tid= $_GET["tid"]; 
if (!$tid){
    header("Refresh:0; url=index.php");
    return;
}
$query= "DELETE FROM tbl_tournaments_211 WHERE tournament_num= $tid";
$result= mysqli_query($connection, $query) or die(mysqli_error());
if ($result )
    header('Location: ' . URL . 'index.php');
?>