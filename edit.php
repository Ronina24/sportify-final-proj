<?php
include "db.php";
include "config.php";

session_start();

if (!isset($_SESSION["type"]))
    header('Location: ' . URL . 'login.php');

$json_data = json_decode(file_get_contents("https://se.shenkar.ac.il/students/2021-2022/web1/dev_211/tennis_centers.json"), true);
$selected_center = "";
$centers = $json_data["Tennis_centers"];

$tid = $_GET["tid"];
if (!$tid) {
    header("Refresh:0; url=index.php");
    return;
}
$query  = "SELECT * FROM tbl_tournaments_211 WHERE tournament_num= $tid";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);
for ($i = 0; $i < count($centers); $i++) {

    if ($centers[$i]['id'] == $row['tennis_center']) {
        $selected_center = $centers[$i]['name'] ;
        $selected_center_id = $centers[$i]['id'] ;

    }
}

/* three bottom*/
$query_bottom  = "SELECT * FROM tbl_tournaments_211 order by date desc limit 3";
$result_bottom = mysqli_query($connection, $query_bottom);

/*updae edit*/
if (isset($_POST['save'])) {
    $update_date = date("Y-m-d H:i:s");
    $name = $_POST['name'];
    $category = $_POST['category'];
    $age = $_POST['age'];
    $reward = $_POST['reward'];
    $max = $_POST['max'];
    $center = $_POST['center'];
    $gender = $_POST['gender'];
    $date = $_POST['date'];
    $query_update  = "UPDATE tbl_tournaments_211 SET
        name='$name', date='$date', category='$category', age=$age, tennis_center='$center', 
    award=$reward, participants_num=$max, gender='$gender', time_stamp='$update_date' WHERE tournament_num=$tid";

    $result_update = mysqli_query($connection, $query_update) or die(mysqli_error());
    if ($result_update) {
        header("Refresh:0; url=index.php");
        return;
    } else {
        echo "Form not submitted";
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
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">
    <link rel="stylesheet" href="https://demos.themeselection.com/sneat-bootstrap-html-admin-template-free/assets/vendor/css/core.css">
    <link rel="stylesheet" href="https://demos.themeselection.com/sneat-bootstrap-html-admin-template-free/assets/vendor/css/theme-default.css">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/style.css">
    <title>Sportify</title>
</head>

<body>
    <div id="wrapper">
        <aside id="side-menu">
            <div id="side-menu-header">
                <a id="logo-main" href="https://se.shenkar.ac.il/students/2021-2022/web1/dev_211/index.php"></a>
                <div class="btn-group">
                    <div class="avatar avatar-online dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?php echo $_SESSION["image"] ?>" alt="" class="w-px-40 h-auto rounded-circle">
                    </div>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div>
                            <img src="<?php echo $_SESSION["image"] ?>" alt="" class="w-px-40 h-auto rounded-circle">
                            <b> <?php echo $_SESSION["name"] ?></b><span id="profileSpan"> &nbsp; (<?php echo $_SESSION["type"] ?>)</span>
                        </div>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item filterBth">Edit profile</a>
                        <a class="dropdown-item filterBth">Settings</a>
                        <a class="dropdown-item filterBth">Language</a>
                        <a class="dropdown-item" href="https://se.shenkar.ac.il/students/2021-2022/web1/dev_211/logout.php">Log Out</a>
                    </div>
                </div>
            </div>
            <ul>
                <li class="menu-list-item active"><a class="menu-list-item-link selected" href="https://se.shenkar.ac.il/students/2021-2022/web1/dev_211/index.php"><i class="fa-solid fa-award"></i>Tournaments</a></li>
                <li class="menu-list-item"><a class="menu-list-item-link" href=""><i class="fa-solid fa-user-group"></i>Referees</a></li>
                <li class="menu-list-item"><a class="menu-list-item-link" href=""><i class="fa-solid fa-bars-progress"></i>categories</a></li>
                <li class="menu-list-item"><a class="menu-list-item-link" href=""><i class="fa-solid fa-bullseye"></i>Tennis
                        Centers</a></li>
                <li class="menu-list-item"><a class="menu-list-item-link" href=""><i class="fa-solid fa-chart-simple"></i>Statistics</a></li>
            </ul>
        </aside>
        <!-- /side-bar -->
        <div class="menu-bg"></div>
        <main class="layout-page">
            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="d-flex justify-content-between" id="navbar-mobile">
                    <div id="hamburger"><i class="fa-solid fa-bars bar-icon"></i></div>
                    <div class="avatar avatar-online">
                        <img src="<?php echo $_SESSION["image"] ?>" alt="" class="w-px-40 h-auto rounded-circle">
                    </div>
                </div>
                <h4 class="fw-bold py-3 mb-4">
                    <a href="https://se.shenkar.ac.il/students/2021-2022/web1/dev_211/index.php"><span class="text-muted fw-light">Tournaments / </span></a><span><?php echo $row['name'] ?></span>
                </h4>
                <form method="post" action="edit.php?tid=<?php echo $tid ?>">
                    <div class="col-md-12">
                        <div class="card me-sm-5">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="tournament-name" class="form-label">Name of tournament<span> *</span></label>
                                        <input type="text" name="name" class="form-control" id="tournament-name" placeholder="<?php echo $row['name'] ?>" aria-describedby="defaultFormControlHelp" required value="<?php echo $row['name'] ?>">
                                    </div>
                                    <div class="col mb-3">
                                        <label for="catagory" class="form-label">Category</label>
                                        <select id="catagory" name="category" class="form-select color-dropdown">
                                            <option selected="<?php echo $row['category'] ?>" value="<?php echo $row['category'] ?>"><?php echo $row['category'] ?></optin>
                                            <option value="National">National</option>
                                            <option value="International">International</option>
                                            <option value="Regional">Regional</option>
                                            <option value="Municipal">Municipal</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="date" class="form-label">Date<span> *</span></label> 
                                        <input type="date" name="date" id="date" value="<?php echo $row['date'];?>" placeholder="<?php echo $row['date'];?>" class="form-control"  aria-describedby="defaultFormControlHelp" required>
                                    </div>
                                    <div class="col mb-3">
                                                <label for="Registration" class="form-label">Registration Date</label>
                                                <input type="date" name="Registration" class="form-control" id="Registration" aria-describedby="defaultFormControlHelp" 
                                                value="<?php echo date('Y-m-d', strtotime($row['date']. ' - 30 days'));?>" readonly>
                                            </div>
                                </div>
                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="gender" class="form-label">Gender</label>
                                        <select id="gender" name="gender" class="form-select color-dropdown">
                                            <option selected="<?php echo $row['gender'] ?>" value="<?php echo $row['gender'] ?>"><?php echo $row['gender'] ?></optin>
                                            <option value="male">male</option>
                                            <option value="female">female</option>
                                            <option value="involved">involved</option>
                                        </select>
                                    </div>
                                    <div class="col mb-3">
                                        <label for="ages" class="form-label">Ages</label>
                                        <input type="number" name="age" class="form-control" id="ages" aria-describedby="defaultFormControlHelp" value="<?php echo $row['age'] ?>" placeholder="<?php echo $row['age'] ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="center" class="form-label">Tennis Center</label>
                                        <select id="center" name="center" class="form-select color-dropdown">
                                            <option selected="<?php echo $selected_center ?>" value="<?php echo $selected_center_id?>" id="<?php echo $selected_center_id?>" placeholder="<?php echo $selected_center ?>"><?php echo  $selected_center ?></option>
                                        </select>
                                    </div>
                                    <div class="col mb-3">
                                        <label for="maximum" class="form-label">Max participants:</label>
                                        <input type="number" name="max" class="form-control" id="maximum" aria-describedby="defaultFormControlHelp" value="<?php echo $row['participants_num'] ?>" placeholder="<?php echo $row['participants_num'] ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mb-3">
                                        <label for="reward" class="form-label">reward<span> *</span></label>
                                        <input type="number" name="reward" value="<?php echo $row['award'] ?>" placeholder="<?php echo $row['award'] ?>" class="form-control" id="reward" aria-describedby="defaultFormControlHelp" required>
                                    </div>
                                    <div class="col mb-3">
                                        <label for="update" class="form-label">Update time</label>
                                        <input type="text" name="update_date" class="form-control" readonly aria-describedby="defaultFormControlHelp" value="<?php echo $row['time_stamp'] ?>">
                                    </div>
                                </div>
                                <div class="action-section"> <button type="submit" name="save" class="btn rounded-pill btn-dark">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <section id="tournaments-updates" class="container-xxl flex-grow-1 container-p-y">
                <h4 class="py-3 mb-4 text-muted fw-light">
                    Upcoming tournaments
                </h4>
                <div class="row mb-5 me-sm-5">

                    <?php
                    while ($row_bottom = mysqli_fetch_assoc($result_bottom)) {
                        echo "
                        <div class='col-md-4'>
                        <div class='card'>
                            <div class='card-header'>
                                <span>" . $row_bottom["name"] . "</span><i class='fa-solid fa-ellipsis-vertical'></i>
                            </div>
     
                            <div class='card-body'>
                                <div class='progress'>
                                    <div class='progress-bar bg-success' role='progressbar' style='width:" . $row_bottom["status"] . "%'
                                        aria-valuenow=" . $row_bottom["status"] . " aria-valuemin='0' aria-valuemax='100'>
                                    </div>
                                </div>
                                <div class='card-meta'>
                                    <div class='tournament-attribute'><i
                                            class='fa-solid fa-xl fa-people-group'></i><span>" . $row_bottom["participants_num"] . "</span>
                                    </div>
                                    <div class='tournament-attribute'><i
                                            class='fa-solid fa-xl fa-calendar'></i><span>" . $row_bottom["date"] . "</span>
                                    </div>
                                    <div class='tournament-attribute'><i
                                            class='fa-solid fa-xl fa-table-cells'></i><span>" . $row_bottom["age"] . "</span>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>";
                    }
                    ?>

                </div>
            </section>
        </main>
    </div>
    <div class="error-message"><?php if (isset($message)) {
                                    echo $message;
                                } ?></div>
    <script src="js/scripts.js"></script>
    <?php
    mysqli_free_result($result);
    ?>
</body>

</html>
<?php
mysqli_close($connection);
?>