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
    <link rel="stylesheet" href="./css/core.css">
    <!-- <link rel="stylesheet" href="./css/theme-default.css"> -->
    <link rel="stylesheet" href="http://tinyurl.com/theme-default-rr">
    <link
    href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet">
    <script src="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/assets/vendor/js/helpers.js"></script>
    <script src="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/assets/vendor/js/bootstrap.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="./css/style.css">
    <title>Sportify</title>
</head>

<body>
    <div id="wrapper">
        <!-- side-bar -->
        <aside id="side-menu">
            <div id="side-menu-header">
                <a id="logo-main" href="http://localhost/CheckwithRacheli/index.php"></a>
                <div class="avatar avatar-online">
                    <img src="<?php echo $_SESSION["image"] ?>" alt=""
                        class="w-px-40 h-auto rounded-circle">
                </div>
            </div>
            <ul>
                <li class="menu-list-item active"><a class="menu-list-item-link selected" href="http://localhost/CheckwithRacheli/index.php"><i
                            class="fa-solid fa-award"></i>Tournaments</a></li>
                <li class="menu-list-item"><a class="menu-list-item-link" href=""><i
                            class="fa-solid fa-user-group"></i>Referees</a></li>
                <li class="menu-list-item"><a class="menu-list-item-link" href=""><i
                            class="fa-solid fa-bars-progress"></i>categories</a></li>
                <li class="menu-list-item"><a class="menu-list-item-link" href=""><i
                            class="fa-solid fa-bullseye"></i>Tennis
                        Centers</a></li>
                <li class="menu-list-item"><a class="menu-list-item-link" href=""><i
                            class="fa-solid fa-chart-simple"></i>Statistic</a></li>
            </ul>
        </aside>
        <!-- /side-bar -->
        <div class="menu-bg"></div>
        <!-- main page content -->
        <main class="layout-page modal-open">
            <!-- search+user navbar -->
            <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                id="layout-navbar">
                <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                    <div id="hamburger"><i class="fa-solid fa-bars bar-icon"></i></div>
                    <i class="fa-solid fa-magnifying-glass bar-icon"></i>
                    <!-- Search -->
                    <div class="navbar-nav align-items-center">
                        <div class="nav-item d-flex align-items-center">
                            <i class="bx bx-search fs-4 lh-0"></i>
                            <input type="text" id="search" class="form-control border-0 shadow-none" placeholder="Search..."
                                aria-label="Search...">
                        </div>
                    </div>
                    <!-- /Search -->
                    <!-- userAvatar -->
                    <div class="avatar avatar-online">
                        <img src="https://www.varietyinsight.com/images/honoree/Lady_Gaga.png" alt=""
                            class="w-px-40 h-auto rounded-circle">
                    </div>
                    <!-- /userAvatar -->
                </div>
            </nav>
            <!-- /search+user navbar -->
            <div id="filters" class="container-lg container-p-y">
                <div>Filiters</div>
                <button type="button" class="createBtn action-web btn rounded-pill btn-dark">+
                    Create Tournamet</button>
            </div>
            <!-- Tournaments container -->
            <section id="tournaments" class="container-xxl flex-grow-1 container-p-y">
            </section>
            <!-- /Tournaments container-->
            <div class="action-mobile mb-4 justify-content-center"><button type="button"
                    class="btn rounded-pill btn-xl btn-icon btn-dark"
                   ><span>+</span></button>
            </div>
        
        </main>
        <!-- /main page content -->
    </div>
     <div class="error-message"><?php if(isset($message)) { echo $message; } ?></div>
     <script>var tournaments = <?php echo json_encode($data); ?> ;
     </script>
    <script src="./js/menu.js"></script>
</body>

</html>