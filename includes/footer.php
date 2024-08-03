<?php
include_once("./helper/helperFunctions.php");
$userId = 0;
$user = [];
if (isset($_SESSION["userId"])) {
    $userId = !IsVariableIsSetOrEmpty($_SESSION['userId']) ? $_SESSION['userId'] : 0;
    $user = $userId !== 0 && !IsVariableIsSetOrEmpty($_SESSION['user']) ? $_SESSION['user'] : [];
}
?>
<footer class="mt-10 bg-dark">
    <div class="container">
        <div class="row ">
            <div class="col-md-4 text-center text-md-left ">

                <div class="py-0">
                    <h3 class="my-4 text-white">KOODE<span class="mx-2 font-italic text-warning ">With You</span>
                    </h3>

                    <p class="footer-links font-weight-bold">
                        <a class="text-white" href="./index.php">Home</a>
                        |
                        <a class="text-white" href="./view-profiles.php">View Profiles</a>
                        <?php
                        if ($userId === 0) {
                            ?>
                            |
                            <a class="text-white" href="./login.php">Login</a>
                            |
                            <a class="text-white" href="./register.php">Sign Up</a>
                            <?php
                        } else {
                            ?>
                            |
                            <a class="text-white" href="./edit-profile.php">Edit Profile</a>
                            <?php
                        }
                        ?>

                    </p>
                    <p class="text-light py-4 mb-4">&copy;<?php echo date("Y"); ?> ADITHYAN AND BHAVANA</p>
                </div>
            </div>

 <div class="col-md-4 text-white my-4 text-center text-md-left ">
                <span class=" font-weight-bold ">About Us</span>
                <p class="text-warning my-2">We started this as our 5th sem mini project</p>
            </div>
        </div>
    </div>
</footer>