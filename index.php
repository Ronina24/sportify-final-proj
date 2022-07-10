<?php
include "db.php";
include "config.php";

session_start();

if (!isset($_SESSION["type"]))
    header('Location: ' . URL . 'login.php');
if ($_SESSION["type"] != 'admin') {
    $notAdmin = 1;
} else {
    $notAdmin = 2;
}
$query  = "SELECT * FROM tbl_tournaments_211";
$result = mysqli_query($connection, $query);
$data = []; 

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://demos.themeselection.com/sneat-bootstrap-html-admin-template-free/assets/vendor/css/core.css">
    <link rel="stylesheet" href="https://demos.themeselection.com/sneat-bootstrap-html-admin-template-free/assets/vendor/css/theme-default.css">
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

        <div class="menu-bg"></div>
        <main class="layout-page">
            <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                    <div id="hamburger"><i class="fa-solid fa-bars bar-icon"></i></div>
                    <i class="fa-solid fa-magnifying-glass bar-icon"></i>
                    <div class="navbar-nav align-items-center">
                        <div class="nav-item d-flex align-items-center">
                            <input type="text" id="search" class="form-control border-0 shadow-none" placeholder="Search..." aria-label="Search...">
                        </div>
                    </div>
                    <div class="avatar avatar-online">
                    <img src="<?php echo $_SESSION["image"] ?>" alt=""
                        class="w-px-40 h-auto rounded-circle">
                    </div>
                </div>
            </nav>
            <div id="filters" class="container-lg container-p-y">
                <div class="btn-group">
                    <div class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        Filters
                    </div>
                    <div id="filterResult"></div>
                    <div class="dropdown-menu dropdown-menu-right" id="centerFilter">
                        <h6 class="dropdown-header">Category</h6>
                        <button class="dropdown-item filterBth" onclick="filterSelection('national')">National</button>
                        <button class="dropdown-item filterBth" onclick="filterSelection('international')">International</button>
                        <button class="dropdown-item filterBth" onclick="filterSelection('regional')">Reginal</button>
                        <button class="dropdown-item filterBth" onclick="filterSelection('municipal')">Municipal</button>
                        <h6 class="dropdown-header">Gender</h6>
                        <button class="dropdown-item filterBth" onclick="filterSelection('male')">Male</button>
                        <button class="dropdown-item filterBth" onclick="filterSelection('female')">Female</button>
                        <button class="dropdown-item filterBth" onclick="filterSelection('involved')">Involved</button>
                        <h6 class="dropdown-header">Tennis Center</h6>
                    </div>
                </div>
                <?PHP if ($_SESSION["type"] == 'admin') {
                    echo '<button type="button" class="createBtn action-web btn rounded-pill btn-dark">+
                                Create Tournamet</button>';
                } ?>
            </div>

            <!-- Tournaments container -->
            <section id="tournaments" class="container-xxl flex-grow-1 container-p-y">
            </section>
            <!-- /Tournaments container-->
            <?PHP if ($_SESSION["type"] == 'admin') {
                echo '<div class="action-mobile mb-4 justify-content-center"><button type="button" class="btn rounded-pill btn-xl btn-icon btn-dark"><span>+</span></button>
                    </div>';
            } ?>

        </main>
    </div>
    <div class="error-message"><?php if (isset($message)) {
                                        echo $message;
                                    } ?></div>
    <script>
        var tournaments = <?php echo json_encode($data); ?>;
        var noAdmin = <?php echo $notAdmin; ?>;
    </script>
    <script src="./js/scripts.js"></script>
    <?php
        mysqli_free_result($result);
    ?>
</body>
</html>
<?php
    mysqli_close($connection);
?>
