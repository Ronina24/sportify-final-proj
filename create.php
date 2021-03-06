<?php
include "db.php";
include "config.php";
session_start();

if (($_SESSION["type"] != 'admin'))
    header('Location: ' . URL . 'login.php');

if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $category = $_POST['category'];
        $age = $_POST['age'];
        $reward = $_POST['reward'];
        $max = $_POST['max'];
        $center = $_POST['center'];
        $gender = $_POST['gender'];
        $date = $_POST['date'];
        $query  = "INSERT INTO tbl_tournaments_211(name,date,category,age,status,tennis_center,award,participants_num,gender) VALUES('$name','$date','$category','$age','0','$center','$reward','$max','$gender')";
        $result = mysqli_query($connection, $query);
         if ($result) { header('Location: ' . URL . 'index.php');}
}
/* three bottom*/
$query_bottom  = "SELECT * FROM tbl_tournaments_211 order by date desc limit 3";
$result_bottom = mysqli_query($connection, $query_bottom);

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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <title>Sportify</title>
</head>

<body>
    <div id="wrapper">
        <!-- side-bar -->
        <aside id="side-menu">
            <div id="side-menu-header">
                <a id="logo-main" href="https://se.shenkar.ac.il/students/2021-2022/web1/dev_211/index.php"></a>
                <div class="btn-group">
                    <div class="avatar avatar-online dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="<?php echo $_SESSION["image"] ?>" alt="" class="w-px-40 h-auto rounded-circle">
                    </div>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div>
                        <img src="<?php echo $_SESSION["image"] ?>" alt=""
                        class="w-px-40 h-auto rounded-circle">
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
        <div class="menu-bg"></div>
        <main class="layout-page">
            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="d-flex justify-content-between" id="navbar-mobile">
                    <div id="hamburger"><i class="fa-solid fa-bars bar-icon"></i></div>
                    <div class="avatar avatar-online">
                    <img src="<?php echo $_SESSION["image"] ?>" alt=""
                        class="w-px-40 h-auto rounded-circle">
                    </div>
                </div>
                <h4 class="fw-bold py-3 mb-4">
                <a href="https://se.shenkar.ac.il/students/2021-2022/web1/dev_211/index.php"><span class="text-muted fw-light">Tournaments / </span></a>
                    Create New Tournament
                </h4>
                <!-- create form -->
                <form method="post" action="#">
                    <div class="col-md-12">
                        <div class="card me-sm-5">
                            <div id="multi-step-form-container">
                                <!-- Form Steps / Progress Bar -->
                                <ul class="form-stepper form-stepper-horizontal text-center mx-auto pl-0">
                                    <!-- Step 1 -->
                                    <li class="form-stepper-active text-center form-stepper-list" step="1">
                                        <a class="mx-2">
                                            <span class="form-stepper-circle">
                                                <span>1</span>
                                            </span>
                                            <div class="label">Tournaments Details</div>
                                        </a>
                                    </li>
                                    <!-- Step 2 -->
                                    <li class="form-stepper-unfinished text-center form-stepper-list" step="2">
                                        <a class="mx-2">
                                            <span class="form-stepper-circle text-muted">
                                                <span>2</span>
                                            </span>
                                            <div class="label text-muted">Tournaments date</div>
                                        </a>
                                    </li>
                                    <!-- Step 3 -->
                                    <li class="form-stepper-unfinished text-center form-stepper-list" step="3">
                                        <a class="mx-2">
                                            <span class="form-stepper-circle text-muted">
                                                <span>3</span>
                                            </span>
                                            <div class="label text-muted">Tournaments</div>
                                        </a>
                                    </li>
                                </ul>
                                <!-- Step Wise Form Content -->
                                <!-- end -->
                                <div class="card-body">
                                    <section id="step-1" class="form-step">
                                        <div class="row">
                                
                                            <div class="col mb-3">
                                                <label for="tournament-name" class="form-label">Name<span> *</span></label>
                                                <input type="text" name="name" class="form-control" id="tournament-name" aria-describedby="defaultFormControlHelp" placeholder="Name of tournament" required>
                                                <div id="errorMessageName" class="errorMessage"></div>
                                            </div>
                                            <div class="col mb-3">
                                                <label for="catagory" class="form-label">Category</label>
                                                <select id="catagory" name="category" class="form-select color-dropdown">
                                                    <option value="National">National</option>
                                                    <option value="International">International</option>
                                                    <option value="Regional">Regional</option>
                                                    <option value="Municipal">Municipal</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mt-3 action-section">
                                            <button class="btn rounded-pill btn-dark btn-navigate-form-step" type="button" step_number="2">Next</button>
                                        </div>
                                    </section>
                                    <section id="step-2" class="form-step d-none">
                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="date" class="form-label">Date<span> *</span></label>
                                                <input type="date" name="date" class="form-control" id="date" aria-describedby="defaultFormControlHelp" onchange="setRegistration(value)" required>
                                                <div id="errorMessageDate" class="errorMessage"></div>
                                            </div>
                                            <div class="col mb-3">
                                                <label for="Registration" class="form-label">Registration Date</label>
                                                <input type="date" name="Registration" class="form-control" id="Registration" aria-describedby="defaultFormControlHelp" readonly>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="gender" class="form-label">Gender</label>
                                                <select id="gender" name="gender" class="form-select color-dropdown">
                                                    <option value="male">male</option>
                                                    <option value="female">female</option>
                                                    <option value="involved">involved</option>
                                                </select>
                                            </div>
                                            <div class="col mb-3">
                                                <label for="ages" class="form-label">Ages</label>
                                                <input type="number" name="age" class="form-control" id="ages" aria-describedby="defaultFormControlHelp" min="6" max="60">
                                            </div>
                                        </div>
                                        <div class="mt-3 action-section">
                                        <button class="btn rounded-pill btn-dark btn-navigate-form-step" type="button" step_number="3">Next</button>
                                            <button class="btn rounded-pill btn-dark btn-navigate-form-step" type="button" step_number="1">Prev</button>
                                        </div>
                                    </section>
                                    <section id="step-3" class="form-step d-none">
                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="center" class="form-label">Tennis Center</label>
                                                <select id="center" name="center" class="form-select color-dropdown">
                                                </select>
                                            </div>
                                            <div class="col mb-3">
                                                <label for="maximum" class="form-label">participants</label>
                                                <input type="number" name="max" class="form-control" id="maximum" aria-describedby="defaultFormControlHelp">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col mb-3">
                                                <label for="reward" class="form-label">reward<span> *</span></label>
                                                <input type="number" name="reward" class="form-control" id="reward" aria-describedby="defaultFormControlHelp" required>
                                            </div>
                                            <div class="col mb-3">
                                                <label for="nameOfAdmin" class="form-label">Name</label>
                                                <input type="text" name="nameOfAdmin" class="form-control" id="nameOfAdmin" readonly aria-describedby="defaultFormControlHelp" value=<?php echo $_SESSION["name"] ?>>
                                            </div>
                                        </div>
                                        <div class="mt-3 action-section">
                                            <button class="btn rounded-pill btn-dark submit-btn" type="submit" name="submit" step_number="4">Create</button>
                                            <button class="btn rounded-pill btn-dark btn-navigate-form-step" type="button" step_number="2">Prev</button>        
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                        <!-- /Create form -->
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
                                        ". $row_bottom["status"] . "%'
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
    <script src="js/scripts.js"></script>
    <?php
        mysqli_free_result($result_bottom);
    ?>
</body>
</html>
<?php
    mysqli_close($connection);
?>
