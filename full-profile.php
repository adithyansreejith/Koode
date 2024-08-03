<html>
    <head>
        <?php
        session_start();
        require_once("./Connector/DbConnectorPDO.php");
        require("./helper/helperFunctions.php");
        $userId = isset($_SESSION["userId"]) && !IsVariableIsSetOrEmpty($_SESSION["userId"]) ? $_SESSION["userId"] : 0;
        ?>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include("./includes/header.php") ?>
    <link href="./css/style.css" rel="stylesheet" type="text/css">
        <style>

img {
  transition: transform 0.2s ease-in-out;
}

img:hover {
  transform: scale(1.05);
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
  border: 10px solid #FFBF00;
}

 .profile-container {
    width: 80%;
    margin: 40px auto;
    padding: 20px;
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
}

.profile-header {
    text-align: center;
    margin-bottom: 20px;
}

.profile-info {
    margin-top: 20px;
}

.profile-field {
    margin-bottom: 10px;
}

.error-message {
    text-align: center;
    color: #f44336;
    font-weight: bold;
    margin-top: 20px;
}

img {
  
  width: 200px;height: 200px;
  border-radius: 50%;
  border: 10px solid grey;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.profile-container{
    text-align: center;
}
</style>

    </head>
<body>
<div class="container-fluid wrapper">
    <?php
    include("./includes/nav-bar.php")
    ?>
    </div>

<?php

$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'datingdb';

$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_GET['id'];

$sql = "SELECT * FROM profile WHERE id = '$user_id'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    ?>
    <div class="profile-container">
        <h1 class="profile-header"><?php echo $user['firstName']; ?></h1>
        <div class="profile-info">
        <a href="<?php echo $user['imgUrl']; ?>" alt="Profile Pic" onerror="this.src='images/alt.png';" target="_blank"><!--to open in another window -->
            <img src="<?php echo $user['imgUrl']; ?>" alt="Profile Pic" onerror="this.src='images/alt.png';">
            </a>
            <p class="profile-field"><strong>First Name:</strong> <?php echo $user['firstName']; ?></p>
            <p class="profile-field"><strong>Last Name:</strong> <?php echo $user['lastName']; ?></p>
            <p class="profile-field"><strong>City:</strong> <?php echo $user['city']; ?></p>
            <p class="profile-field"><strong>Bio:</strong> <?php echo $user['bio']; ?></p>
            <p class="profile-field"><strong>Birth Date:</strong> <?php echo $user['birthDate']; ?></p>
            <p class="profile-field"><strong>Gender:</strong> <?php echo $user['gender']; ?></p>
            <!--<p class="profile-field"><strong>Image URL:</strong> <?php echo $user['imgUrl']; ?></p>
            <p class="profile-field"><strong>Created Date:</strong> <?php echo $user['created_date']; ?></p>-->
        </div>
        <div>
        <div class="row mb-10">
                                    <div class="col-md-12 col-sm-12">
                                        <a href="./chat-users.php?id=<?= $user_id ?>"
                                           class="btn btn-success w-100">
                                            Send Message
                                        </a>
                                    </div>
                                </div>
                                
        </div>
    </div>

    <?php
} else {
    echo "<p class='error-message'>User not found.</p>";
}
$conn->close();
?>
 </body>

<?php include("./includes/footer.php") ?>
 </html>
