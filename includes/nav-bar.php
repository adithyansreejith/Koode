<?php
include_once("./helper/helperFunctions.php");
$userId = 0;
$user = [];
if (isset($_SESSION["userId"])) {
    $userId = !IsVariableIsSetOrEmpty($_SESSION['userId']) ? $_SESSION['userId'] : 0;
    $user = $userId !== 0 && !IsVariableIsSetOrEmpty($_SESSION['user']) ? $_SESSION['user'] : [];
}

//just testing 

?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            overflow-x: hidden;
        }
        .dropdown-menu {
            max-width: 100%;
            overflow: hidden;
            background-color: white; 
            border-radius: 0.5rem;
        }
        .dropdown-item {
            color: red;
        }
        
            
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-dark bg-danger navbar-expand-sm">
            <a class="navbar-brand" href="./index.php">
                KOODE <span class="text-warning">With You</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-list-2"
                    aria-controls="navbar-list-2" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbar-list-2">
                <ul class="navbar-nav">
                    <?php
                    if ($userId !== 0 && count($user) > 0) {
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="./full-profile.php?id=<?= $userId ?>" style="color: #ffe600;" onclick="return true">Hello <?= $user["firstName"] . " " . $user["lastName"] ?>!</a>
                        </li>
                        <?php
                    }
                    ?>

                    <?php
                    if ($userId !== 0) {
                        ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Menu</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="./edit-profile.php">Edit Profile</a></li>
                                <li><a class="dropdown-item" href="./view-profiles.php">View Profiles</a></li>
                                <li><a class="dropdown-item" href="./favourite_list.php">Favourite List</a></li>
                                <li><a class="dropdown-item" href="./chat-users.php?id=<?= $userId ?>">Inbox</a></li>
                                <li><a class="dropdown-item" href="./logout.php">Logout</a></li>
                            </ul>
                        </li>
                        <?php
                    } else {
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="./login.php">Login</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="./register.php">Sign Up</a>
                        </li>
                        <?php
                    }
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="./index.php">Home</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
</body>
</html>
