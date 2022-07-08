<?php
include "db.php";
include "config.php";

session_start();

if (!isset($_SESSION["type"]))
    header('Location: ' . URL . 'login.php');

$query  = "SELECT * FROM tbl_tournaments_211";
$result = mysqli_query($connection, $query);
$data = []; // Save the data into an arbitrary array.

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// if ($_GET['submit'] == 'delete') {
//   $row_id = (int)$_POST['row_id'];
//   mysql_query("DELETE FROM tbl_tournaments_211 WHERE id=" . $row_id); 
// }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://demos.themeselection.com/sneat-bootstrap-html-admin-template-free/assets/vendor/css/core.css">
    <link rel="stylesheet" href="https://tinyurl.com/theme-default-rr">
    <link
    href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
                <div class="avatar avatar-online dropdown">
                    <img src="https://www.varietyinsight.com/images/honoree/Lady_Gaga.png" alt="" class="w-px-40 h-auto rounded-circle" id="profileImage">
                </div>
            </div>
            <ul class="dropdown-menu d-none" id="profile">
                <li>
                    <img src="https://www.varietyinsight.com/images/honoree/Lady_Gaga.png" alt="" class="w-px-40 h-auto rounded-circle">
                    <b> <?php echo $_SESSION["name"] ?></b><span id="profileSpan"> &nbsp; (<?php echo $_SESSION["type"] ?>)</span>
                </li>
                <li><a class="dropdown-item" href="#">Edit profile</a></li>
                <li><a class="dropdown-item" href="http://localhost/CheckwithRacheli/logout.php">Log Out</a></li>
            </ul>
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

        <div class="menu-bg"></div>
        <!-- main page content -->
        <main class="layout-page">
            <!-- search+user navbar -->
            <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                    <div id="hamburger"><i class="fa-solid fa-bars bar-icon"></i></div>
                    <i class="fa-solid fa-magnifying-glass bar-icon"></i>
                    <!-- Search -->
                    <div class="navbar-nav align-items-center">
                        <div class="nav-item d-flex align-items-center">
                            <i class="bx bx-search fs-4 lh-0"></i>
                            <input type="text" id="search" class="form-control border-0 shadow-none" placeholder="Search..." aria-label="Search...">
                        </div>
                    </div>
                    <!-- /Search -->
                    <!-- userAvatar -->
                    <div class="avatar avatar-online">
                        <img src="https://www.varietyinsight.com/images/honoree/Lady_Gaga.png" alt="" class="w-px-40 h-auto rounded-circle more-info-menu">
                    </div>
                    <!-- /userAvatar -->
                </div>
            </nav>

            <!-- /search+user navbar -->
            <div id="filters" class="container-lg container-p-y">
                <div class="btn-group">
                    <div class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        Filters
                    </div>
                    <div id="filterResult"></div>
                    <div class="dropdown-menu dropdown-menu-right">
                        <h6 class="dropdown-header">Category</h6>
                        <button class="dropdown-item filterBth" onclick="filterSelection('national')">National</button>
                        <button class="dropdown-item filterBth" onclick="filterSelection('international')">International</button>
                        <button class="dropdown-item filterBth" onclick="filterSelection('regional')">Reginal</button>
                        <button class="dropdown-item filterBth" onclick="filterSelection('municipal')">Municipal</button>
                        <h6 class="dropdown-header">Gender</h6>
                        <button class="dropdown-item filterBth" onclick="filterSelection('male')">Male</button>
                        <button class="dropdown-item filterBth" onclick="filterSelection('female')">Female</button>
                        <button class="dropdown-item filterBth" onclick="filterSelection('involved')">Involved</button>
                        <h6 class="dropdown-header" id="centerFilter">Tennis Center</h6>
                    </div>
                </div>
                <button type="button" class="createBtn action-web btn rounded-pill btn-dark">+
                    Create Tournamet</button>
            </div>

            <!-- Tournaments container -->
            <section id="tournaments" class="container-xxl flex-grow-1 container-p-y">
            </section>
            <!-- /Tournaments container-->
            <div class="action-mobile mb-4 justify-content-center"><button type="button" class="btn rounded-pill btn-xl btn-icon btn-dark"><span>+</span></button>
            </div>

        </main>
        <!-- /main page content -->
    </div>
    <!-- <div class="error-message"><?php if (isset($message)) {
                                        echo $message;
                                    } ?></div> -->
    <script>
        var tournaments = <?php echo json_encode($data); ?>;
    </script>
    <script src="./js/menu.js"></script>
</body>

</html>