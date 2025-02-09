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
    $password = $_POST["password"];
    $confirmpassword = $_POST['confirmpassword'];
    $city = $_POST['city'];
    $dateOfBirth = $_POST["birthDate"];
    $gender = $_POST["gender"];
    $hobby = $_POST["hobby"];
    $Job = $_POST["Job"];
    
    

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
                        $insertQueryForRegister = "INSERT INTO datingdb.profile(email,password,firstName,lastName,city,birthDate,gender,imgUrl,user_role) values('$email','$password','$firstName','$lastName','$city','$dateOfBirth','$gender','$imageURL','premium')";
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
    <style>
        .tab {
            display: none;
        }

        #prevBtn, #nextBtn {
            background-color: red;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 17px;
        }

        #prevBtn:hover, #nextBtn:hover {
            opacity: 0.8;
        }

        .step {
        height: 20px;
        width: 20px;
        margin: 0 4px;
        background-color: red; /* Red color */
        border: none;
        display: inline-block;
        opacity: 0.5;
        border-radius: 50%; /* Circle shape */
    }

    .step.active {
        opacity: 1;
        background-color: red; /* Red color for active step */
    }

    .step.finish {
        background-color: red; /* Red color for finished step */
    }
    </style>
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
                        background-image: url('/datingSite/images/site_images/REGISTER2.svg');
                        background-size: cover;
                        background-position: center;">
                    </div>
                    <div class="card-body" style="border-radius: 20px; overflow: hidden;">
                        <h5 class="card-title text-center">Register</h5>
                        <form id="regForm" class="form-signin" action="register.php" method="post" enctype="multipart/form-data">
                            <div class="tab">
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
                                <hr>
                            </div>
                            <div class="tab">
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
                                    <input type="text" name="job" id="inputJob" class="form-control"
                                           placeholder="Occupation" required style="border-radius: 20px; overflow: hidden;">
                                    <label for="inputJob">Occupation</label>
                                </div>
                                <div class="form-label-group">
                                    <input type="date" id="birthDate" name="birthDate" class="form-control" required style="border-radius: 20px; overflow: hidden;">
                                    <label for="birthDate">Birth Date</label>
                                </div>
                            </div>
                            <div class="tab">
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
                                        <input class="form-check-input" type="radio" name="disabledStats" id="disabledYes"
                                               value="Y" checked required>
                                        <label class="form-check-label" for="disabledYes">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="disabledStats" id="disabledNo"
                                               value="N" required>
                                        <label class="form-check-label" for="disabledNo">No</label>
                                    </div>
                                </div>
                                <hr>
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-radius: 30px; overflow: hidden;">
                                        If Yes, Choose Which
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="#">Deaf</a>
                                        <a class="dropdown-item" href="#">Locomotive</a>
                                        <a class="dropdown-item" href="#">Mute</a>
                                    </div>
                                </div>
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
                                    <button type="button" class="btn btn-success preview-btn" onclick="removePreview()" style="border-radius: 30px; overflow: hidden;">
                                        X
                                    </button>
                                </div>
                            </div>
                            <div style="overflow:auto;">
                                <div style="float:right;">
                                    <button type="button" id="prevBtn" onclick="nextPrev(-1)" style="border-radius: 30px; overflow: hidden;">Previous</button>
                                    <button type="button" id="nextBtn" onclick="nextPrev(1)" style="border-radius: 30px; overflow: hidden;">Next</button>
                                </div>
                            </div>
                            <div style="text-align:center;margin-top:40px;">
                                <span class="step"></span>
                                <span class="step"></span>
                                <span class="step"></span>
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
    let currentTab = 0;
    showTab(currentTab);

    function showTab(n) {
        const x = document.getElementsByClassName("tab");
        x[n].style.display = "block";
        document.getElementById("prevBtn").style.display = n === 0 ? "none" : "inline";
        document.getElementById("nextBtn").innerHTML = n === (x.length - 1) ? "Submit" : "Next";
        fixStepIndicator(n);
    }

    function nextPrev(n) {
        const x = document.getElementsByClassName("tab");
        if (n === 1 && !validateForm()) return false;
        x[currentTab].style.display = "none";
        currentTab = currentTab + n;
        if (currentTab >= x.length) {
            document.getElementById("regForm").submit();
            return false;
        }
        showTab(currentTab);
    }

    function validateForm() {
        let valid = true;
        const x = document.getElementsByClassName("tab");
        const y = x[currentTab].getElementsByTagName("input");
        for (let i = 0; i < y.length; i++) {
            if (y[i].value === "") {
                y[i].className += " invalid";
                valid = false;
            }
        }
        if (valid) {
            document.getElementsByClassName("step")[currentTab].className += " finish";
        }
        return valid;
    }

    function fixStepIndicator(n) {
        const x = document.getElementsByClassName("step");
        for (let i = 0; i < x.length; i++) {
            x[i].className = x[i].className.replace(" active", "");
        }
        x[n].className += " active";
    }

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
