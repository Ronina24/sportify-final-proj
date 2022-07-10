<?php
include "db.php";
include "config.php";

session_start();

if (!isset($_SESSION["type"]))
    header('Location: ' . URL . 'login.php');

$json_data = json_decode(file_get_contents("http://localhost/CheckwithRacheli/tennis_centers.json"), true);
$selected_center = "";
$centers = $json_data["Tennis_centers"];

$tid = $_GET["tid"]; // url queries are stored in $_GET
if (!$tid) {
    header("Refresh:0; url=index.php");
    return;
}
$query  = "SELECT * FROM tbl_tournaments_211 WHERE tournament_num= $tid";
$query_join = "SELECT * FROM tbl_tournaments_211 JOIN tbl_messages_211 using(tournament_num) 
    WHERE tournament_num= $tid";
$result = mysqli_query($connection, $query);
$msgs = mysqli_query($connection, $query_join);
$row = mysqli_fetch_assoc($result);

for ($i = 0; $i < count($centers); $i++) {

    if ($centers[$i]['id'] == $row['tennis_center']) {

        $selected_center = $centers[$i]['name'];
    }
}

if (!empty($_GET['new_msg'])) {
    $new_msg = $_GET['new_msg'];
    $query  = "INSERT INTO tbl_messages_211(txt,tournament_num) VALUES('$new_msg',$tid)";
    //  $result = mysqli_query($connection, $query) or die(mysqli_error());
    if ($result) {
        unset($_GET['new_msg']);
        header("Refresh:0; url=tournement.php?tid=$tid");
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/core.css">
    <!-- <link rel="stylesheet" href="./css/theme-default.css"> -->
    <link rel="stylesheet" href="http://tinyurl.com/theme-default-rr">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Sportify</title>
</head>

<body>
    <div id="wrapper">
        <!-- side-bar -->
        <aside id="side-menu">
            <div id="side-menu-header">
                <a id="logo-main" href="http://localhost/CheckwithRacheli/index.php"></a>
                <div class="btn-group">
                    <div class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://www.varietyinsight.com/images/honoree/Lady_Gaga.png" alt="" class="w-px-40 h-auto rounded-circle">
                    </div>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div>
                            <img src="https://www.varietyinsight.com/images/honoree/Lady_Gaga.png" alt="" class="w-px-40 h-auto rounded-circle">
                            <b> <?php echo $_SESSION["name"] ?></b><span id="profileSpan"> &nbsp; (<?php echo $_SESSION["type"] ?>)</span>
                        </div>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item filterBth">Edit profile</a>
                        <a class="dropdown-item filterBth">Settings</a>
                        <a class="dropdown-item filterBth">Language</a>
                        <a class="dropdown-item" href="http://localhost/CheckwithRacheli/logout.php">Log Out</a>
                    </div>
                </div>
            </div>
            <ul>
                <li class="menu-list-item active"><a class="menu-list-item-link selected" href="http://localhost/CheckwithRacheli/index.php"><i class="fa-solid fa-award"></i>Tournaments</a></li>
                <li class="menu-list-item"><a class="menu-list-item-link" href=""><i class="fa-solid fa-user-group"></i>Referees</a></li>
                <li class="menu-list-item"><a class="menu-list-item-link" href=""><i class="fa-solid fa-bars-progress"></i>categories</a></li>
                <li class="menu-list-item"><a class="menu-list-item-link" href=""><i class="fa-solid fa-bullseye"></i>Tennis
                        Centers</a></li>
                <li class="menu-list-item"><a class="menu-list-item-link" href=""><i class="fa-solid fa-chart-simple"></i>Statistic</a></li>
            </ul>

        </aside>
        <!-- /side-bar -->
        <!-- main page content -->
        <main class="layout-page">
            <div class="container-xxl flex-grow-1 container-p-y">
                <h4 class="fw-bold py-3 mb-4">
                    <span class="text-muted fw-light">Tournaments /</span>
                    <?php echo $row['name']; ?>
                </h4>
                <div class="card">
                    <div class="card-body">
                        <div class="t-messages-container">
                            <h4 class="mb-0 mt-4">Live Updates</h4>
                            <ul id="t-updates" class="mt-4">
                                <?php
                                while ($msg = mysqli_fetch_assoc($msgs)) {
                                    echo '<li><div><i class="fa-solid fa-bell"></i>' . $msg["txt"] . "</div>
                                <small>" . $msg["time_stamp"] . "</small>
                              </li>
                                    ";
                                }

                                ?>

                            </ul>
                        </div>
                        <div class="card-meta">
                            <div class="tournament-attribute"><i class="fa-solid fa-xl fa-people-group"></i><span>Participant</span>
                                <h6><?php echo $row['participants_num']; ?></h6>
                            </div>
                            <div class="tournament-attribute"><i class="fa-solid fa-xl fa-calendar"></i><span>Date</span>
                                <h6><?php echo $row['date']; ?></h6>
                            </div>
                            <div class="tournament-attribute"><i class="fa-solid fa-xl fa-image-portrait"></i><span>age</span>
                                <h6><?php echo $row['age']; ?></h6>
                            </div>
                            <div class="tournament-attribute"><i class="fa-solid fa-xl fa-location-dot"></i><span>location</span>
                                <h6><?php echo $selected_center; ?></h6>
                            </div>
                            <div class="tournament-attribute"><i class="fa-solid fa-xl fa-award"></i><span>award</span>
                                <h6><?php echo $row['award']; ?>$</h6>
                            </div>
                            <div class="tournament-attribute"><i class="fa-solid fa-xl fa-children"></i><span>category</span>
                                <h6><?php echo $row['category']; ?></h6>
                            </div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $row['status']; ?>%" aria-valuenow="<?php echo $row['status']; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $row['status']; ?>%</div>
                        </div>
                    </div>
                </div>
                <div class="card mt-4">
                    <h5 class="card-header">Create Update</h5>
                    <div class="card-body">
                        <form action="#" method="get">
                            <input type="hidden" name="tid" value="<?php echo $tid ?>">
                            <input type="text" class="form-control" name="new_msg" id="new_msg" <?PHP if ($_SESSION["type"] == 'admin') {
                                                                                                    echo 'placeholder= Add update';
                                                                                                } ?><?PHP if ($_SESSION["type"] != 'admin') {
                                                                                                                                                                                echo 'placeholder="to send message please sign in as Administrator" readonly';
                                                                                                                                                                            } ?>>
                            <?PHP if ($_SESSION["type"] == 'admin') {
                                echo '<button type="submit" nme="submit" class="btn rounded-pill btn-primary mt-4 pull-right">Send</button>';
                            } ?>
                        </form>
                    </div>
                </div>
            </div>


        </main>
        <!-- /main page content -->
    </div>
    <script src="./js/menu.js"></script>
</body>

</html>