<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Index-Dating Site</title>
    <?php include("./includes/header.php") ?>
    <link href="./css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
    
<div>
    <?php
    include("./includes/nav-bar.php")
    ?>

<?php
    // Display the message if the user is not logged in
    if ($userId == 0) {
        ?>
        <div class="row mt-10 mb-10">
            <div class="col-md-12">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    You have not signed in. <a href="./login.php">LOG IN</a> or <a href="./register.php">REGISTER</a> to continue<strong>
                </div>
            </div>
        </div>
        <?php
    }
    ?>

    <div class="container-fluid p-0">

        <div id="carouselExampleIndicators" class="carousel slide w-100" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active" style="border-radius: 10px; overflow: hidden;"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1" style="border-radius: 10px; overflow: hidden;"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100" src="./images/site_images/1.png" alt="First slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100" src="./images/site_images/2.png" alt="Second slide">
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        <div class="row mr-0">
            <!-- Hidethe testimonial if user is logged in -->
            <?php if ($userId == 0) { ?>
                <section id="sec-testimonials" class="sec-testimonials w-100">
                    <div class="container">
                        <h1 class="h4 mb-5 text-center">Words from our users</h1>

                        <div id="carouselIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carouselIndicators" data-slide-to="0" class="active" style="border-radius: 20px; overflow: hidden;"></li>
                                <li data-target="#carouselIndicators" data-slide-to="1" style="border-radius: 20px; overflow: hidden;"></li>
                                <li data-target="#carouselIndicators" data-slide-to="2" style="border-radius: 20px; overflow: hidden;"></li>
                            </ol>

                            <div class="carousel-inner" role="listbox">
                                <div class="carousel-item active">
                                    <div class="row justify-content-center">
                                        <div class="col-md-6">
                                            <blockquote class="blockquote">
                                                <small>
                                                    Welcome to KOODE
                                                </small>
                                                <footer class="blockquote-footer mt-2">Adithyan & Bhavana</footer>
                                            </blockquote>
                                        </div>
                                    </div>
                                </div>

                                <div class="carousel-item">
                                    <div class="row justify-content-center">
                                        <div class="col-md-6">
                                            <blockquote class="blockquote">
                                                <small>I've been a member for over 3 years. This is by far the best
                                                    site.</small>
                                                <footer class="blockquote-footer mt-2">Angel</footer>
                                            </blockquote>
                                        </div>
                                    </div>
                                </div>

                                <div class="carousel-item">
                                    <div class="row justify-content-center">
                                        <div class="col-md-6">
                                            <blockquote class="blockquote">
                                                <small>I joined since its opening and I couldn't have found a better dating
                                                    space. Being a member is so inspiring and I love to date individuals like me!</small>
                                                <footer class="blockquote-footer mt-2">Eldhose</footer>
                                            </blockquote>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <a class="carousel-control-prev" href="#carouselIndicators" role="button" data-slide="prev">
                                <span class="fa fa-angle-left fa-2x"></span>
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>

                            <a class="carousel-control-next" href="#carouselIndicators" role="button" data-slide="next">
                                <span class="fa fa-angle-right fa-2x"></span>
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </section>
            
        </div>

        <div class="row mr-0">
            <section id="sec-about" class="sec-about pt-5 pb-5 w-100">
                <div class="container">
                    <div class="row justify-content-center text-center">
                        <div class="col-md-10 col-lg-8">
                            <h1 class="h4">About Koode</h1>
                            <p class="mt-4 mb-4">
                            According to a 2011 census, the latest data available, there were about 26.8 million people living with disabilities in India. At the time, 40% were not married. 
                            Though dating and navigating romantic relationships can be hard for anyone, 
                            people with disabilities can find the process to be particularly exclusionary and they can be met with discrimination and prejudice.
                            Through KOODE, we want to enable genuine connections and make it easier for people with disabilities to find people who understand them</p>
                        </div>
                    </div>
                </div>
            </section><?php } ?>
        </div>
        <?php 
if ($userId == 0) { 
    
    ?>
    
<?php 
} else {

    ?>
                <div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-12 text-center">
            <h2 class="h4 mb-4">Welcome, <?= $user['firstName']; ?>!</h2>
            <div class="btn-group w-100 d-flex justify-content-between" style="gap: 10px;">
                <a href="./view-profiles.php" class="btn btn-danger mb-2" style="border-radius: 30px; overflow: hidden; flex: 1 1 30%;">
                    <i class="fas fa-magnifying-glass"></i>&nbsp;View Profiles
                </a>
                <a href="./favourite_list.php" class="btn btn-danger mb-2" style="border-radius: 30px; overflow: hidden; flex: 1 1 30%;">
                    <i class="fas fa-heart"></i>&nbsp;Favourite List
                </a>
                <a href="./edit-profile.php" class="btn btn-danger mb-2" style="border-radius: 30px; overflow: hidden; flex: 1 1 30%;">
                    <i class="fas fa-pen-to-square"></i>&nbsp;Edit Profile
                </a>
                <a href="./logout.php" class="btn btn-danger mb-2" style="border-radius: 30px; overflow: hidden; flex: 1 1 30%;">
                    <i class="fas fa-arrow-right-from-bracket"></i>&nbsp;<b>Logout</b>
                </a>
                <a href="./chat-users.php?id=<?= $userId ?>" class="btn btn-danger mb-2" style="border-radius: 30px; overflow: hidden; flex: 1 1 30%;">
                    <i class="fas fa-comments"></i>&nbsp;Messages
                </a>
            </div>
        </div>
    </div>
</div>


            </div>
        </div>
    </div>
<?php 
} 
?>
        <div class="row mr-0">
            <section id="sec-contact" class="sec-contact pt-5 pb-5pt-5 pb-5 w-100">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-10 col-lg-7">
                            <h1 class="h4">Have a question? Get in touch with us!</h1>

                            <form action="support.php" method="post">
                                <fieldset class="form-group">
                                    <label for="formName">Your Name:</label>
                                    <input id="formName" class="form-control" type="text" placeholder="Your Name"
                                           required style="border-radius: 20px; overflow: hidden;">
                                </fieldset>

                                <fieldset class="form-group">
                                    <label for="formEmail1">Email address:</label>
                                    <input id="formEmail1" class="form-control" type="email" placeholder="Enter email"
                                           required style="border-radius: 20px; overflow: hidden;">
                                </fieldset>

                                <fieldset class="form-group">
                                    <label for="formMessage">Your Message:</label>
                                    <textarea id="formMessage" class="form-control" rows="3" placeholder="Your message"
                                              required style="border-radius: 20px; overflow: hidden;"></textarea>
                                </fieldset>

                                <fieldset class="form-group text-center">
                                    <button class="btn btn-danger" type="submit" style="border-radius: 30px; overflow: hidden;">Send Message</button>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- footer -->
    <?php include("./includes/footer.php") ?>
    <!-- end of footer -->
</div>

</body>
</html>