<?php
session_start();
require_once("./Connector/DbConnectorPDO.php");
include("./helper/helperFunctions.php");
$connection = getConnection();
$userId = isset($_SESSION["userId"]) && !empty($_SESSION["userId"]) ? $_SESSION["userId"] : 0;
if ($userId !== 0) {
    header("Location: ./index.php");
}

$errors = array();
$image_uploaded = false;
$imageURL = "./images/user_images/";
$registerSuccessfully = false;
if (isset($_POST['Submit'])) {
    $email = $_POST['email'];
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $bio = $_POST["bio"];
    $password = $_POST["password"];
    $confirmpassword = $_POST['confirmpassword'];
    $city = $_POST['city'];
    $dateOfBirth = $_POST["birthDate"];
    $gender = $_POST["gender"];
    $hobby = $_POST["hobby"];
    $Job = $_POST["Job"];
    $disabledStats=$_POST["disabledStats"];

    
    

    if($password === $confirmpassword) {

        if (!IsVariableIsSetOrEmpty($email) && !IsVariableIsSetOrEmpty($firstName) && !IsVariableIsSetOrEmpty($lastName) && !IsVariableIsSetOrEmpty($password) && !IsVariableIsSetOrEmpty($dateOfBirth) && !IsVariableIsSetOrEmpty($gender)) {
            if (!IsVariableIsSetOrEmpty($_FILES['fileUpload'])) {
                $file_name = $email . "_" . $_FILES['fileUpload']['name'];
                $file_size = $_FILES['fileUpload']['size'];
                $file_tmp = $_FILES['fileUpload']['tmp_name'];
                $file_type = $_FILES['fileUpload']['type'];
                $array = explode('.', $_FILES['fileUpload']['name']);
                $file_ext = strtolower(end($array));

                $extensions = array("jpeg", "jpg", "png", "gif");

                if ($file_size > 5120000) {
                    array_push($errors, 'File size must be less than 5 MB');
                }

                if (empty($errors) == true) {

                    $imageURL = $imageURL . $file_name;
                    move_uploaded_file($file_tmp, $imageURL);
                    $image_uploaded = true;
                    try {
                        $insertQueryForRegister = "INSERT INTO datingdb.profile(email,password,firstName,lastName,bio,city,birthDate,gender,hobby,Job,imgUrl,disabled_status,user_role) values('$email','$password','$firstName','$lastName','$bio','$city','$dateOfBirth','$gender','$hobby','$Job','$imageURL','$disabledStats','premium')";
                        $insertQueryForRegisterstmt = $connection->prepare($insertQueryForRegister);
                        $insertQueryForRegisterstmt->execute();
                        $registerSuccessfully = true;
                    } catch (PDOException $exception) {
                        throw $exception;
                    }

                }
            }
        }
    }else{
        array_push($errors, 'Password and Confirm Password doesnt match');
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
    <title>View Profiles</title>
    <?php include("./includes/header.php") ?>
    <link href="css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div>
    <?php include("./includes/nav-bar.php") ?>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12" style="border-radius: 20px; overflow: hidden;">
            <div class="col-lg-10 col-xl-9 mx-auto" style="border-radius: 20px; overflow: hidden;">
                <div class="row mt-5">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <?php
                        if (count($errors) > 0) {
                            ?>
                            <div class="alert alert-danger" role="alert">
                                <p>List of errors: </p>
                                <ul>
                                    <?php
                                    foreach ($errors as $error) { ?>
                                        <li><?= $error ?></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        <?php } elseif ($registerSuccessfully === true) {
                            ?>
                            <div class="alert alert-success" role="alert">
                                <p>Registered Successfully. Click <a href="./login.php">here</a> to login.</p>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="card card-signin flex-row" style="border-radius: 20px; overflow: hidden; border:1px solid red;">
                    <div class="card-img-left d-none d-md-flex" style="
                        background-image: url('images/site_images/REGISTER2.svg');
                        background-size: cover;
                        background-position: center;">
                    </div>
                    <div class="card-body" style="border-radius: 20px; overflow: hidden;">
                        <h5 class="card-title text-center">Register</h5>
                        <form class="form-signin" action="register.php" method="post" enctype="multipart/form-data">
                            <div class="form-label-group">
                                <input type="email" name="email" id="inputEmail" class="form-control"
                                       placeholder="Email address" pattern="^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$"
                                       required autofocus style="border-radius: 20px; overflow: hidden;">
                                <label for="inputEmail">Email address</label>
                            </div>

                            <div class="form-label-group">
                                <input type="text" name="firstName" id="firstName" class="form-control"
                                       placeholder="First Name" required style="border-radius: 20px; overflow: hidden;">
                                <label for="firstName">First Name</label>
                            </div>
                            <div class="form-label-group">
                                <input type="text" id="lastName" name="lastName" class="form-control"
                                       placeholder="Last Name" required style="border-radius: 20px; overflow: hidden;">
                                <label for="lastName">Last Name</label>
                            </div>
                            <div class="form-label-group">
                                <textarea id="bio" name="bio" class="form-control" placeholder="" required style="border-radius: 20px; overflow: hidden;"></textarea>
                                <label for="bio">Bio</label>
                            </div>

                            <hr>

                            <div class="form-label-group">
                                <input type="password" name="password" id="inputPassword" class="form-control"
                                       placeholder="Password" required style="border-radius: 20px; overflow: hidden;">
                                <label for="inputPassword">Password</label>
                            </div>

                            <div class="form-label-group">
                                <input type="password" name="confirmpassword" id="inputConfirmPassword" class="form-control"
                                       placeholder="Password" required style="border-radius: 20px; overflow: hidden;">
                                <label for="inputConfirmPassword">Confirm password</label>
                            </div>
                            <hr>
                            <div class="form-label-group">
                                <input type="text" name="city" id="inputCity" class="form-control"
                                       placeholder="City" required style="border-radius: 20px; overflow: hidden;">
                                <label for="inputCity">City</label>
                            </div>
                            <div class="form-label-group">
                                <input type="text" name="hobby" id="inputHobby" class="form-control"
                                       placeholder="Hobbies" style="border-radius: 20px; overflow: hidden;">
                                <label for="inputHobby">Hobbies</label>
                            </div>
                            <div class="form-label-group">
                                <input type="text" name="Job" id="inputJob" class="form-control"
                                       placeholder="Occupation" required style="border-radius: 20px; overflow: hidden;">
                                <label for="inputJob">Occupation</label>
                            </div>
                            <div class="form-label-group">
                                <input type="date" id="birthDate" name="birthDate" class="form-control" required style="border-radius: 20px; overflow: hidden;">
                                <label for="birthDate">Birth Date</label>
                            </div>
                            
                            <div class="form-group">
                                <div class="form-check form-check-inline">
                                    Gender:&nbsp;
                                    <input class="form-check-input" type="radio" name="gender" id="genderMale"
                                           value="male" checked required>
                                    <label class="form-check-label" for="genderMale">Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="genderFemale"
                                           value="female" required>
                                    <label class="form-check-label" for="genderFemale">Female</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="genderOther"
                                           value="other" required>
                                    <label class="form-check-label" for="genderOther">Other</label>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group">
                            <div class="form-check form-check-inline">
                                Are you disabled?&nbsp;
                                <input class="form-check-input" type="radio" name="disabledStats" id="disabledYes" value="Y" required onclick="toggleDisabilityDropdown(true)">
                                <label class="form-check-label" for="disabledYes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="disabledStats" id="disabledNo" value="N" required onclick="toggleDisabilityDropdown(false)">
                                <label class="form-check-label" for="disabledNo">No</label>
                            </div>
                        </div>

                        <hr>

                        <!-- Disability Dropdown (Initially Disabled) -->
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-radius: 30px; overflow: hidden;" disabled>
                                If Yes, Choose Which
                            </button>
                            <input type="hidden" id="disabilityType" name="disabilityType" value=""> <!-- Hidden input to capture value -->
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#" onclick="selectDisabilityType('Deaf')">Deaf</a>
                                <a class="dropdown-item" href="#" onclick="selectDisabilityType('Locomotive')">Locomotive</a>
                                <a class="dropdown-item" href="#" onclick="selectDisabilityType('Mute')">Mute</a>
                            </div>
                        </div>

                        <script>
                            // Function to toggle the disability dropdown
                            function toggleDisabilityDropdown(isEnabled) {
                                document.getElementById('dropdownMenuButton').disabled = !isEnabled;
                                if (!isEnabled) {
                                    document.getElementById('disabilityType').value = ""; // Clear value if "No" is selected
                                }
                            }

                            // Function to capture the selected disability type
                            function selectDisabilityType(type) {
                                document.getElementById('disabilityType').value = type;
                            }
                        </script>
                            <hr>
                            <div class="input-group mb-3" style="border:1px solid blue; border-radius: 20px; overflow: hidden;">
                                <div class="custom-file">
                                    <input accept="image/*" type="file" name="fileUpload"
                                           class="form-control custom-file-input"
                                           id="fileUpload" required>
                                    <label class="custom-file-label" for="fileUpload">Upload Image..</label>
                                </div>
                            </div>

                            <div class="preview-img-container form-group" style="display: none">
                                <img id="img_preview" class="rounded mx-auto d-block" src="#"
                                     alt="your image" width="100"
                                     height="100"/>
                                <button type="button" class="btn btn-success preview-btn" onclick="removePreview()">
                                    X
                                </button>
                            </div>
                            <button name="Submit" id="Submit"
                                    class="btn btn-lg btn-danger btn-block text-uppercase" type="submit" style="border-radius: 30px; overflow: hidden;">
                                Register
                            </button>
                            <div class="sign-up">
                                Have an account? <a href="./login.php">Login</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<hr>
<hr>
    <?php include("./includes/footer.php") ?>
</div>

<script>
    function removePreview() {
        $('#img_preview').attr('src', "");
        $(".preview-img-container").css("display", "none");
        $('#fileUpload').val('');
    }

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#img_preview').attr('src', e.target.result);
                $(".preview-img-container").css("display", "block");
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#fileUpload").change(function () {
        readURL(this);
    });
</script>
</body>
</html>
