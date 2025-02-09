<?php
session_start();
require_once("./Connector/DbConnectorPDO.php");
include("./helper/helperFunctions.php");
$connection = getConnection();
$userId = isset($_SESSION["userId"]) && !empty($_SESSION["userId"]) ? $_SESSION["userId"] : 0;

if ($userId !== 0) {
    header("Location: ./index.php");
    exit(); // Add exit() to stop executing the script
}

$errors = array();
if (isset($_POST['Submit'])) {
    $email = $_POST['email'];
    $password = $_POST["password"];

    if (!IsVariableIsSetOrEmpty($email) && !IsVariableIsSetOrEmpty($password)) {
        if (empty($errors) == true) {
            $query = "SELECT * from profile WHERE email = :email && password = :password";
            $stmt = $connection->prepare($query);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->rowCount();
            $row   = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($count === 0) {
                array_push($errors, 'Incorrect Username / Password');
            } else {
                $_SESSION['userId'] = $row['id'];
                $_SESSION['user'] = $row;

                // Redirect based on user ID
                if ($_POST['email'] == 'admin@koode.com') {
                    header("Location: admin.php");
                } else {
                    header("Location: index.php");
                }
                exit(); 
            }
        }
    }
}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Page</title>
    <?php include("./includes/header.php") ?>
    <link href="./css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div>
    <?php
    include("./includes/nav-bar.php")
    ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="col-lg-10 col-xl-9 mx-auto">
                        <div class="row mt-5">
                            <?php
                            // if any errors are there we can display them
                            if (count($errors) > 0) {
                                ?>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="alert alert-danger" role="alert">
                                            <?php
                                            foreach ($errors as $error) { ?>
                                                <li><?= $error ?></li>
                                            <?php } ?>
                                    </div>
                                </div>

                            <?php } ?>
                        </div>
                    <div class="card card-signin flex-row my-5" style="border-radius: 20px; border:1px solid red">
                        <div class="login-card-img-left d-none d-md-flex">
                        <img src="./images/site_images/login-background.png" alt="Login Image" style="width: 125%; background-size: cover;">
                        </div>

                        <div class="card-body" style="border-radius: 20px; overflow: hidden;">
                            <h5 class="card-title text-center">Login</h5>
                            <form class="form-signin" action="login.php" method="post" >
                                <div class="form-label-group">
                                    <input type="email" id="inputUserame" name="email" pattern="^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$" class="form-control" placeholder="Username" required autofocus style="border-radius: 20px; overflow: hidden;">
                                    <label for="inputUserame">Username</label>
                                </div>
                               <hr>

                                <div class="form-label-group">
                                    <input type="password" id="inputPassword" style="border-radius: 20px; overflow: hidden;" name="password" class="form-control" placeholder="Password" required>
                                    <label for="inputPassword">Password</label>
                                </div>

                                <button class="btn btn-lg btn-danger btn-block text-uppercase" name="Submit" type="submit" style="border-radius: 30px; overflow: hidden;">Login</button>
                                <div class="sign-up">
                                    Don't have an account? <a href="./register.php">Register</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- footer -->
    <?php include("./includes/footer.php") ?>
    <!-- end of footer -->
</div>

</body>
</html>