<?php
    if (isset($_SESSION["user_id"])) {
        redirect("index.php");
    }

    if (isset($_POST["submit"])) {
        $brGresaka = 0;
        $errors = "";
        $checkNames = "/^[a-zA-Z,.'-]+$/";
        $checkUsername = "/^[a-zA-Z0-9]+([._]?[a-zA-Z0-9]+)*$/";
        $checkEmail = "/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/";
        $checkPassword = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/";
        if (isset($_POST["firstName"])) {
            $firstName = $_POST["firstName"];
            if ($firstName == "") {
                $brGresaka++;
                $errors .= "<li>You didn't fill the first name!</li>";
            } else
                if (!preg_match($checkNames, $firstName)) {
                    $brGresaka++;
                    $errors .= "<li>Invalid first name format! Example : Josh</li>";
                }
        }
        if (isset($_POST["lastName"])) {
            $lastName = $_POST["lastName"];
            if ($firstName == "") {
                $brGresaka++;
                $errors .= "<li>You didn't fill the last name!</li>";
            } else
                if (!preg_match($checkNames, $lastName)) {
                    $brGresaka++;
                    $errors .= "<li>Invalid last name format! Example : Morgan</li>";
                }
        }
        if (isset($_POST["username"])) {
            $username = $_POST["username"];
            if ($username == "") {
                $brGresaka++;
                $errors .= "<li>You didn't insert username!</li>";
            } else
                if (!preg_match($checkUsername, $username)) {
                    $brGresaka++;
                    $errors .= "<li>Invalid username format!</li>";
                }
        }
        if (isset($_POST["email"])) {
            $email = $_POST["email"];

            if ($email == "") {
                $brGresaka++;
                $errors .= "<li>You didn't insert email!</li>";
            } else
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    echo $email;
                    $brGresaka++;
                    $errors .= "<li>Invalid email format!</li>";
                }
        }
        if (isset($_POST["password"])) {
            $password = $_POST["password"];
            if ($password == "") {
                $brGresaka++;
                $errors .= "<li>You didn't insert password!</li>";
            } else {
                $password = md5($_POST["password"]);
            }
        }

        $query = "SELECT * FROM users WHERE username = :username OR email = :email";

        $iskaz = $conn->prepare($query);
        $iskaz->bindParam(":username", $username);
        $iskaz->bindParam(":email", $email);

        $iskaz->execute();

        $rez = $iskaz->fetch();
        var_dump($rez);
        if ($rez != 0) {
            $brGresaka++;
            $errors .= "<li>Username or email is taken already!</li>";
        }
        if ($brGresaka > 0) {
            redirect("index.php?page=register&errors={$errors}");
        } else {
            // redirect("register.php?success=1");
            $insert = "INSERT INTO users(username, email, password, first_name, last_name) VALUES (:username,:email,:password,:firstName,:lastName)";

            $insertIskaz = $conn->prepare($insert);
            $insertIskaz->bindParam(":username", $username);
            $insertIskaz->bindParam(":email", $email);
            $insertIskaz->bindParam(":password", $password);
            $insertIskaz->bindParam(":firstName", $firstName);
            $insertIskaz->bindParam(":lastName", $lastName);

            $rez = $insertIskaz->execute();


            if ($rez) {
                redirect("index.php?page=login");
            }

        }
    }
?>
<div class="banner-top container-fluid" id="home">
    <!-- banner -->
    <div class="banner_inner">
        <div class="services-breadcrumb">
            <div class="inner_breadcrumb">
                <ul class="short">
                    <li>
                        <a href="index.html">Home</a>
                        <i>|</i>
                    </li>
                    <li>Contact Us</li>
                </ul>
            </div>
        </div>
    </div>
    <!--//banner -->
</div>
<!--// header_top -->
<!-- top Products -->
<section class="banner-bottom-wthreelayouts py-lg-5 py-3">
    <div class="container">
        <h3 class="tittle-w3layouts text-center my-lg-4 my-4">Register</h3>
        <div class="inner_sec">
            <p class="sub text-center  ">
                Create your account today!
            </p>
            <div class="contact_grid_right pt-3">
                <form action="<?= $_SERVER["PHP_SELF"] ?>?page=register" method="post">
                    <div class="row contact_left_grid">
                        <div class="col-md-6 offset-md-3 con-left">
                            <div class="form-group">
                                <label class="my-2">First Name</label>
                                <input class="form-control" type="text" name="firstName" placeholder="" value="<?php
                                if (isset($_POST["firstName"]))
                                    echo $_POST["firstName"];
                                ?>" />
                            </div>
                            <div class="form-group">
                                <label>Last Name</label>
                                <input class="form-control" type="text" name="lastName" placeholder="" value="<?php
                                if (isset($_POST["lastName"]))
                                    echo $_POST["lastName"];
                                ?>" />
                            </div>
                            <div class="form-group">
                                <label>Username</label>
                                <input class="form-control" type="text" name="username" placeholder="" value="<?php
                                if (isset($_POST["username"]))
                                    echo $_POST["username"];
                                ?>" />
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" type="email" name="email" placeholder="" value="<?php
                                if (isset($_POST["email"]))
                                    echo $_POST["email"];
                                ?>" />
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input class="form-control form-input" type="password" name="password"
                                       placeholder="" />
                            </div>
                            <div class="form-group mt-3">
                                <!-- <label class="my-2">Subject</label> -->

                                <input class="form-control" name="submit" type="submit" value="Submit" />
                                <!-- <input class="form-control" type="text" name="Subject" placeholder="" required="" /> -->
                            </div>
                            <div class="form-group">
                                <?php if (isset($_GET["errors"])): ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?= $_GET["errors"]; ?>
                                    </div>
                                <?php endif;
                                if (isset($_GET["success"])): ?>
                                    <div class="alert alert-success" role="alert">
                                        <?= "success" ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6 con-right">
                            <!-- <div class="form-group">
              <label>Message</label>
              <textarea id="textarea" placeholder="" required=""></textarea>
            </div>
            <input class="form-control" type="submit" value="Submit" /> -->
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
