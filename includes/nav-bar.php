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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"> <!-- Font Awesome CSS -->
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
        .nav-link.dropdown-toggle i {
            color: white;
        }
            
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-dark bg-danger navbar-expand-sm">
            <a class="navbar-brand" href="./index.php">
                &nbsp; KOODE <span class="text-warning">With You</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-list-2"
                    aria-controls="navbar-list-2" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbar-list-2">
                <ul class="navbar-nav">
                    <?php if ($userId !== 0 && count($user) > 0): ?>
                        <li class="nav-item">
                            <a class="nav-link text-warning" href="./full-profile.php?id=<?= $userId ?>">
                                Hello <?= $user["firstName"] . " " . $user["lastName"] ?>!
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ($userId !== 0): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-list" style="font-size: 1rem;"></i> 
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="./view-profiles.php">
                                    <i class="fas fa-magnifying-glass"></i>&nbsp;View Profiles</a></li>
                                <li><a class="dropdown-item" href="./favourite_list.php">
                                    <i class="fas fa-heart"></i>&nbsp;Favourite List</a></li>
                                <li><a class="dropdown-item" href="./edit-profile.php">
                                    <i class="fas fa-pen-to-square"></i>&nbsp;Edit Profile</a></li>
                                <li><a class="dropdown-item text-danger" href="./logout.php">
                                    <i class="fas fa-arrow-right-from-bracket"></i>&nbsp;<b>Logout</b></a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./chat-users.php?id=<?= $userId ?>">
                                <i class="fas fa-comments" style="font-size: 1rem;"></i> Messages
                            </a>
                        </li>
                   
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="./login.php">
                                <i class="fa-solid fa-right-to-bracket"></i>&nbsp;Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./register.php">
                                <i class="fas fa-user-plus"></i>&nbsp;Sign Up
                            </a>
                        </li>
                    
                    <?php endif; ?>

                    <li class="nav-item">
                        <a class="nav-link" href="./index.php">
                            <i class="fas fa-home"></i>&nbsp;Home
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
</body>
</html>
