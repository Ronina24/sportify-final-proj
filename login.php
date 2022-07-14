<?php
include 'db.php';
include "config.php";

session_start();

if (!empty($_POST["email-username"])) {
    $query  = "SELECT * FROM tbl_users_211 WHERE 
 email='" . $_POST["email-username"] .
        "' and password= '" . $_POST["password"] . "'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_array($result);
    if (is_array($row)) {
        $_SESSION["name"] = $row['name'];
        $_SESSION["type"] = $row['type'];
        $_SESSION["email"] = $row['email'];
        $_SESSION["image"] = $row['image'];
        mysqli_free_result($result);
        mysqli_close($connection);
        header('Location:' . URL . 'index.php');
    } else {
        $message = "Invalid Username or Password";
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
    <link rel="stylesheet" href="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/assets/vendor/css/pages/page-auth.css" >
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="./css/style.css">
    <title>Sportify</title>
</head>

<body>
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <div class="card">
                    <div class="card-body">
                        <div class="app-brand justify-content-center">
                            <a href="index.html" class="app-brand-link gap-2" id="logo"></a>
                        </div>
                        <h5 class="mb-2">Welcom to Sportify!</h5>
                        <form action="#" method="post">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" id="loginEmail" class="form-control" name="email-username" placeholder="Enter your email or username" autofocus>
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Password:</label>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" class="form-control" name="password" id="password" placeholder="············" aria-describedby="password">
                                    <span class="input-group-text cursor-pointer">
                                        <i class="bx bx-hide"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit" id="login">Sign in</button>
                            </div>
                            <div class="error-message"><?php if (isset($message)) {
                                                                echo $message;
                                                            } ?></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php
mysqli_close($connection);
?>