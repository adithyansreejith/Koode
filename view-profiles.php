<?php
session_start();
require_once("./Connector/DbConnectorPDO.php");
require("./helper/helperFunctions.php");
$connection = getConnection();
$userId = isset($_SESSION["userId"]) && !empty($_SESSION["userId"]) ? $_SESSION["userId"] : 0;
//if ($userId !== 0) {
//    $q = "SELECT * from profile WHERE id =:userId";
//    $s = $connection->prepare($q);
//    $s->bindParam(':userId', $userId);
//    $s->execute();
//    $row = $s->fetch(PDO::FETCH_ASSOC);
//
//    $_SESSION['user'] = $row;
//    $userObj = $row;
//}
$userObj = $userId !== 0 && !IsVariableIsSetOrEmpty($_SESSION["user"]) ? $_SESSION["user"] : "";

$isSearchCriteria = false;
$firstName = "";
$disabled_status = "";
$gender = "";
$ageToSearch = "18";
$isWinkSent = false;
$isUserAlreadyFavourited = false;
$query = "select * from profile ";
$profileList = [];
if ($userId !== 0) {
    $query .= "where id <> :userId";
}

if (isset($_POST["Search"]) && !IsVariableIsSetOrEmpty($_POST["Search"])) {

    $searchCount = 0;
    $firstName = $_POST["firstName"];
    $disabled_status = $_POST["disabled_status"];
    $gender = $_POST["gender"];
    $ageToSearch = $_POST["age"];
    $searchQuery = "";

    if (!IsVariableIsSetOrEmpty($firstName)) {
        $searchQuery .= " firstName like :firstName";
        $searchCount++;
    }
    if (!IsVariableIsSetOrEmpty($disabled_status)) {
        if ($searchCount > 0) {
            $searchQuery .= " and ";
        }
        $searchQuery .= " disabled_status like :disabled_status";
        $searchCount++;
    }
    if (!IsVariableIsSetOrEmpty($gender)) {
        if ($searchCount > 0) {
            $searchQuery .= " and ";
        }
        $searchQuery .= " gender=:gender";
        $searchCount++;
    }
    if (!IsVariableIsSetOrEmpty($ageToSearch)) {
        $ageToSearch = intval($ageToSearch);
        if ($searchCount > 0) {
            $searchQuery .= " and ";
        }
        if ($ageToSearch === 18) {
            $searchQuery .= " (YEAR(CURDATE()) - YEAR(birthDate)) >=:age";
        } else {
            $searchQuery .= " (YEAR(CURDATE()) - YEAR(birthDate)) BETWEEN  18 and :age";
        }
        $searchCount++;
    }

    if ($searchCount > 0) {
        $isSearchCriteria = true;
        if ($userId === 0) {
            $query .= " where " . $searchQuery;
        } else {
            $query .= " and " . $searchQuery . "";
        }
    }
}

$profileListStmt = $connection->prepare($query);
if ($userId !== 0) {
    $profileListStmt->bindParam(':userId', $userId, PDO::PARAM_INT);
}

if ($isSearchCriteria === true) {
    if (!empty($firstName)) {
        $newFirstNameString = "%{$firstName}%";
        $profileListStmt->bindParam(':firstName', $newFirstNameString, PDO::PARAM_STR);
    }
    if (!empty($disabled_status)) {
        $newCityString = "%{$disabled_status}%";
        $profileListStmt->bindParam(':disabled_status', $newCityString, PDO::PARAM_STR);
    }
    if (!empty($gender)) {
        $profileListStmt->bindParam(':gender', $gender, PDO::PARAM_STR);
    }
    if (!empty($ageToSearch)) {
        $profileListStmt->bindParam(':age', $ageToSearch, PDO::PARAM_INT);
    }
}
$profileListStmt->execute();
//$profileList = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$profileList = $profileListStmt->fetchAll();

if (isset($_GET["sendWinkTo"])) {
    $sendWinkToId = isset($_GET["sendWinkTo"]) && !IsVariableIsSetOrEmpty($_GET["sendWinkTo"]) ? intval($_GET["sendWinkTo"]) : 0;
    if ($sendWinkToId !== 0) {
        $queryGetLastMessage = "SELECT * 
                            FROM messages 
                            WHERE msg_from_user_id=:sendWinkToId and msg_to_user_id=:userId and is_msg_read=0
                            order by msg_date desc limit 1";
        $getLastMessageStmt = $connection->prepare($queryGetLastMessage);
        $getLastMessageStmt->bindParam(':sendWinkToId', $sendWinkToId);
        $getLastMessageStmt->bindParam(':userId', $userId);
        $getLastMessageStmt->execute();
        $getLastMessageList = $getLastMessageStmt->fetchAll();
        if (isset($getLastMessageList) && !IsVariableIsSetOrEmpty($getLastMessageList) && count($getLastMessageList) > 0) {
            $getFirstRow = $getLastMessageList[0];
            if (!IsVariableIsSetOrEmpty($getFirstRow)) {
                $updateAllMsgReadQuery = "UPDATE messages set is_msg_read=1,msg_read_date=NOW() where msg_from_user_id=:sentToUserID and msg_to_user_id=:userId and is_msg_read=0";
                $updateAllMsgRead = $connection->prepare($updateAllMsgReadQuery);
                $updateAllMsgRead->bindParam(':sentToUserID', $sendWinkToId);
                $updateAllMsgRead->bindParam(':userId', $userId);
                $updateAllMsgRead->execute();
            }
        }

        $insertMessageQuery = "INSERT INTO messages(msg_from_user_id,msg,msg_to_user_id,msg_date,is_msg_read) 
                               values(:userId,'Liked your profile',:sendWinkToId,NOW(),0)";
        $insertStmt = $connection->prepare($insertMessageQuery);
        $insertStmt->bindParam(':userId', $userId);
        $insertStmt->bindParam(':sendWinkToId', $sendWinkToId);
        $insertStmt->execute();
        $isWinkSent = true;
    }
}

if (isset($_GET['addToFavouriteId']) && $userObj["user_role"] === "premium") {
    $addToFavouriteUserId = isset($_GET["addToFavouriteId"]) && !IsVariableIsSetOrEmpty($_GET["addToFavouriteId"]) ? intval($_GET["addToFavouriteId"]) : 0;
    if ($addToFavouriteUserId !== 0) {
        $queryGetAlreadyFavRecord = "Select * from user_favourite_list WHERE user_id = :userId AND user_id_favourited = :addFavourtieUserId";
        $queryGetAlreadyFavRecordStmt = $connection->prepare($queryGetAlreadyFavRecord);
        $queryGetAlreadyFavRecordStmt->bindParam(':userId', $userId);
        $queryGetAlreadyFavRecordStmt->bindParam(':addFavourtieUserId', $addToFavouriteUserId);
        $queryGetAlreadyFavRecordStmt->execute();
        $getAlreadyFavRecordList = $queryGetAlreadyFavRecordStmt->fetchAll();
        if (!isset($getAlreadyFavRecordList) || IsVariableIsSetOrEmpty($getAlreadyFavRecordList) || count($getAlreadyFavRecordList) <= 0) {

            $addUserToFavQuery = "INSERT INTO user_favourite_list (user_id,user_id_favourited,dateCreated) 
                                    VALUES (:userId,:userIdFavourited,NOW())";
            $addUserToFavStmt = $connection->prepare($addUserToFavQuery);
            $addUserToFavStmt->bindParam(':userId', $userId);
            $addUserToFavStmt->bindParam(':userIdFavourited', $addToFavouriteUserId);
            $addUserToFavStmt->execute();
//            $isUserAlreadyFavourited = true;
        } else {
            $isUserAlreadyFavourited = true;
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
    <?php include("./includes/header.php") ?>
    <link href="./css/style.css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"><!-- awesome fonts -->
    
    <title>View Profiles</title>
    <style>
        .card-img-top {
  transition: transform 0.2s ease-in-out;
}

.card-img-top:hover {
  transform: scale(1.05);
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
  
}
    </style>
</head>
<body>
<div>
    <?php
    include("./includes/nav-bar.php")
    ?>

    <?php
    if ($isWinkSent && isset($_GET["sendWinkTo"])) {
        ?>
        <div class="row mt-10 mb-10">
            <div class="col-md-12">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Like sent to user successfully! Click <strong><a
                                href="./chat-users.php?id=<?= $_GET["sendWinkTo"] ?>">here</a></strong> to start
                    chatting.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
        <?php
    }
    ?>

    <?php
    if (isset($_GET["addToFavouriteId"])) {
        $classToAdd = "";
        $msg = "";
        if ($isUserAlreadyFavourited === false) {
            $classToAdd = "alert-success";
            $msg = "Successfully added user to favourite list!.";
        } else {
            $classToAdd = "alert-danger";
            $msg = "User already added to favourite list!.";
        }
        ?>
        <div class="row mt-10 mb-10">
            <div class="col-md-12">
                <div class="alert <?= $classToAdd ?> alert-dismissible fade show" role="alert">
                    <?= $msg ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
        <?php
    }
    ?>

    <div class="mb15" style="margin-top:10px">
        <div class="row mt-10 mb-10">
            <div class="col-md-12 text-center">
                <h2>Search Profiles</h2>
            </div>
        </div>
        <div class="row mb-10" >
            <div class="col-md-12">
                <form method="post" action="view-profiles.php">
                    <div class="form-row mb-10" style="margin-left:auto; margin-right: auto;">
                        <div class="col">
                            <div class="form-group">
                                <label for="firsName">Search by first name</label>
                                <input name="firstName" id="firstName" type="text" class="form-control"
                                       placeholder="First name" value="<?= $firstName ?>" style="border-radius: 20px; overflow: hidden; border:2px solid red;">
                            </div>
                        </div>
                        <div class="col" style="margin-left:auto; margin-right: auto;">
                            <div class="form-group">
                                <label for="lastName">Search for Differently abled</label>
                                <input name="disabled_status" id="disabled_status" type="text" class="form-control"
                                       placeholder="Y or N" value="<?= $disabled_status ?>" style="border-radius: 20px; overflow: hidden; border:2px solid red;">
                            </div>
                        </div>
                    </div>
                    <div class="form-row" style="margin-left:auto; margin-right: auto;">
                        <div class="col">
                            <div class="form-group">
                                <label for="gender">Search by gender</label>
                                <select id="gender" class="form-control" name="gender" style="border-radius: 20px; overflow: hidden; border:2px solid red;">
                                    <option value="" <?php if (empty($gender)) {
                                        echo "selected";
                                    } ?>>-- Select gender
                                        --
                                    </option>
                                    <option value="male" <?php if ($gender === "male") {
                                        echo "selected";
                                    } ?>>Male
                                    </option>
                                    <option value="female" <?php if ($gender === "female") {
                                        echo "selected";
                                    } ?>>Female
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="formControlRange">Select age range between to search</label>

                                <input type="range" min="18" value="<?= $ageToSearch ?>" max="90"
                                       class="form-control-range" name="age"
                                       id="ageInputId">
                                <output name="ageOutputName" id="ageOutputId">Search profiles with age above 18</output>
                            </div>

                            <!--                            <select class="form-control" name="age">-->
                            <!--                                <option value="">-- Select age --</option>-->
                            <!--                                --><?php
                            //                                for ($i = 18; $i <= 90; $i++) { ?>
                            <!--                                    <option value="--><? //= $i ?><!--">-->
                            <!--                                        --><? //= $i
                            ?><!--</option>-->
                            <!--                                    --><?php
                            //                                }
                            //
                            ?>
                            <!--                            </select>-->
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-10 col-sm-12">
                            <input type="submit" name="Search" value="Search" class="btn btn-danger w-100" style="border-radius: 15px; overflow: hidden;">
                        </div>
                        <div class="col-md-2 col-sm-12">
                            <input type="submit" name="Reset" value="Reset filters" class="btn btn-dark w-100" style="border-radius: 20px; overflow: hidden;">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <hr>
        <div style="text-align:center;">
            <i>Click on the image for more details!</i>
        </div>
        <hr>

        <?php
        if (count($profileList) > 0) {
            $counter = 0;
            foreach ($profileList as $profile) {
                if ($profile['email'] == 'admin@koode.com') {
                    continue; // Skip the iteration if the email is admin@koode.com
                }
                $counter++;
                if ($counter === 1) {
                    echo '<div class="row mb-10">';
                }
                ?>
                <div class="col-md-3">
                    <div class="card card-container" style="border-radius: 20px; overflow: hidden; margin-left:auto; margin-right: auto;">
                    <a href="./full-profile.php?id=<?= $profile["id"] ?>"
                    name="ViewProf">
                        <img class="card-img-top"
                             src="<?= $profile["imgUrl"] ?>"
                             alt="profile image">
                             </a>
                        <div class="card-body">
                            <h5 class="card-title">Name: <?= $profile["firstName"] . ' ' . $profile['lastName'] ?></h5>
                            <p class="card-text bio-desc-container"><?= $profile["bio"] ?></p>
                        </div>
                        <ul class="list-group list-group-flush">
                        <li class="list-group-item">DoB: <?= $profile["birthDate"] ?></li>
                        <li class="list-group-item">Age: 
                            <?php
                            try {
                                $birthDay = new DateTime($profile["birthDate"]);
                                $today = new DateTime(date('Y-m-d'));
                                $diff = $today->diff($birthDay);
                                echo $diff->y . " years";
                            } catch (Exception $e) {
                                echo "N/A";
                            }
                            ?>
                        </li>

                                <li class="list-group-item">Disabled: <?= $profile["disabled_status"] ?></li>
                            <li class="list-group-item">Location: <?= $profile["city"] ?></li>
                            <li class="list-group-item">
                                Gender:
                                <span style="text-transform: capitalize">
                                    <?= $profile["gender"] ?>
                                </span>
                            </li>
                            
                            <!--                            <li class="list-group-item">Likes: ABCD, EFGH, IJKL</li>-->
                            <!--                            <li class="list-group-item">Interested in: Female</li>-->
                            <!--                            <li class="list-group-item">Looking for : Longterm Relation, Short term</li>-->
                        </ul>
                        <div class="card-body">
                        <!-- Buttons for all users -->
                        <?php
                            if ($userId === 0) {
                                ?>
                                <div class="row mb-10">
                                    <div class="col-md-12 col-sm-12">
                                        <button class="btn btn-success w-100" data-toggle="modal"
                                                data-target="#loginModal" style="border-radius: 25px; overflow: hidden;">
                                            Send Message
                                        </button>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-md-6 col-sm-12">
                                        <button class="btn btn-info w-100" data-toggle="modal"
                                                data-target="#loginModal" style="border-radius: 25px; overflow: hidden;">
                                            Like
                                        </button>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <button class="btn btn-danger w-100" data-toggle="modal"
                                                data-target="#loginModal" style="border-radius: 25px; overflow: hidden;">
                                            Favourite
                                        </button>
                                    </div>
                                </div>

                                <?php
                            } else {
                                ?>
                                <div class="row mb-10">
                                <div class="col-md-12 col-sm-12">
                                <?php 
                                $buttonClass = ($profile["disabled_status"] === 'Y') ? 'btn-warning' : 'btn-danger'; 
                                ?>
                                <a href="./chat-users.php?id=<?= $profile["id"] ?>"
                                class="btn <?= $buttonClass ?> w-100" style="border-radius: 25px; overflow: hidden;">
                                    Send Message
                                </a>
                            </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <a href="./view-profiles.php?sendWinkTo=<?= $profile["id"] ?>"
                                           name="SendWink" class="btn btn-info w-100" style="border-radius: 25px; overflow: hidden;">Like</a>

                                    </div>


                                    <div class="col-md-6 col-sm-12">
                                        <?php
                                        if ($userObj["user_role"] === "regular") {
                                            ?>
                                            <button class="btn btn-danger w-100" data-toggle="modal"
                                                    data-target="#addToFavouriteModal" style="border-radius: 25px; overflow: hidden;">
                                                Favourite
                                            </button>

                                            <?php
                                        } else {
                                            ?>
                                            <a class="btn btn-danger w-100"
                                               href="./view-profiles.php?addToFavouriteId=<?= $profile["id"] ?>" style="border-radius: 25px; overflow: hidden;">
                                                Favourite
                                            </a>
                                            <?php
                                        } ?>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                    </div>

                </div>
                </div>
                <?php
                if ($counter === 4) {
                    echo '</div>';
                    $counter = 0;
                }
            }
        } else {
            ?>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="alert alert-info text-center" role="alert" style="border-radius: 25px; overflow: hidden;">
                        <?php
                        if ($userId !== 0) {
                            ?>
                            No profiles found!.
                            <?php
                        } else {
                            ?>
                            No profiles found!. Click <a href="./register.php">here</a> to register!.
                        <?php } ?>
                    </div>
                </div>

            </div>
            <?php
        }
        ?>

    </div>



    <script>
        $(document).ready(function () {
            <?php
            if ($isWinkSent && isset($_GET["sendWinkTo"]) || isset($_GET["addToFavouriteId"]) ) {
            ?>
            setTimeout(function () {
                $(".alert").alert('close');
            }, 5000);
            <?php
            }
            ?>
            $("#ageInputId").on('input', function () {
                if (parseInt($("#ageInputId").val()) < 18) {
                    $("#ageInputId").val("18");
                }
                if (parseInt($("#ageInputId").val()) === 18) {
                    $("#ageOutputId").val("Search profiles above age " + $("#ageInputId").val());
                } else {
                    $("#ageOutputId").val("Search between age 18 and " + $("#ageInputId").val());
                }
            })
        });
    </script>
    <!-- footer -->

    <?php include("./includes/footer.php") ?>
    <!-- end of footer -->
</div>

</body>
</html>