<?php
include "db.php";
include "config.php";

session_start();

if (!isset($_SESSION["type"]))
    header('Location: ' . URL . 'login.php');

$tid= $_GET["tid"]; // url queries are stored in $_GET
if (!$tid){
    echo "HWERR";
 //   header("Refresh:0; url=index.php");
    return;
}
$query= "DELETE FROM tbl_tournaments_211 WHERE tournament_num= $tid";
echo $query;
$result= mysqli_query($connection, $query) or die(mysqli_error());
if ($result )
    header('Location: ' . URL . 'index.php');
?>