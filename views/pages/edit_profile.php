<?php


    if (!isset($_SESSION["username"])) {
        redirect("index.php");
    } else {

        if (isset($_SESSION["user_id"])) {
            $u_id = $_SESSION["user_id"];
            $userInfoQUery = "SELECT * FROM users WHERE user_id = $u_id";
            $user = $conn->query($userInfoQUery)->fetch();

            if (isset($_POST["submit"])) {
                $brGresaka = 0;
                $errors = "";
                // $email;
                $checkNames = "/^[a-zA-Z,.'-]+$/";
                $checkUsername = "/^[a-zA-Z0-9]+([._]?[a-zA-Z0-9]+)*$/";
                $checkEmail = "/^([A-Z|a-z|0-9](\.|_){0,1})+[A-Z|a-z|0-9]\@([A-Z|a-z|0-9])+((\.){0,1}[A-Z|a-z|0-9]){2}\.[a-z]{2,3}$/";
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
                if (isset($_POST["user_email"])) {
                    $email = $_POST["user_email"];


                    if ($email == "") {
                        $brGresaka++;
                        $errors .= "<li>You didn't insert email!</li>";
                    } else
                        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            $brGresaka++;
                            $errors .= "<li>Invalid email format!</li>";
                        }
                }
                if (isset($_POST["new_password"])) {
                    $new_pw = $_POST["new_password"];
                    if ($new_pw != "") {
                        if (!preg_match($checkPassword, $new_pw)) {
                            $new_pw = md5($_POST["new_password"]);
                            $brGresaka++;
                            $errors .= "<li>Invalid password format!</li>";
                        } else
                            if (isset($_POST["old_password"])) {
                                $old_pw = $_POST["old_password"];
                                if ($old_pw != "") {
                                    $old_pw = md5($old_pw);
                                    $checkPwQuery = "SELECT * FROM users WHERE user_id = {$_SESSION["user_id"]} AND password = :old_pw";
                                    $pwCheck = $conn->prepare($checkPwQuery);
                                    $pwCheck->bindParam(":old_pw", $old_pw);

                                    $pwCheck->execute();
                                    $row = $pwCheck->fetch();

                                } else {
                                    $brGresaka++;
                                    $errors .= "<li>You didn't insert old passwords!</li>";
                                }
                            }
                    }


                }
                if (isset($_FILES["image"])) {
                    $fajl = $_FILES["image"];
                    if ($fajl["size"] > 0) {

                        $nazivFajla = $fajl['name'];
                        $tmpFajl = $fajl['tmp_name'];
                        $velicinaFajla = $fajl['size'];
                        $tipFajla = $fajl['type'];
                        $greskeFajl = $fajl['error'];

                        $dozvoljeniTipovi = ["image/png", "image/jpeg"];

                        if (!in_array($tipFajla, $dozvoljeniTipovi)) {
                            $brGresaka++;
                            $errors .= "Greška prilikom upload-a fajla. Dozvoljeni tipovi: jpeg, png.";
                        }
                    }
                }
                if ($brGresaka > 0) {
                    redirect("index.php?page=edit_profile&errors={$errors}");
                } else {
                    if ($fajl["size"] > 0) {

                        $noviNazivFajla = time() . "_" . $nazivFajla;
                        $putanja = "images/" . $noviNazivFajla;

                        if (moveImages($fajl,true)) {
                            if ($new_pw != '') {
                                $new_pw = md5($new_pw);
                                $addedPw = ",`password`='$new_pw'";
                            } else {
                                $addedPw = "";
                            }
                        }
                            $updateUserQuery = "UPDATE `users` SET `email`='$email'" . $addedPw . ",`first_name`='$firstName',`last_name`='$lastName',`image`='$noviNazivFajla' WHERE user_id = {$_SESSION["user_id"]}";
                    } else {
                        if ($new_pw != '') {
                            $new_pw = md5($new_pw);
                            $addedPw = ",`password`='$new_pw'";
                        } else {
                            $addedPw = "";
                        }
                        $updateUserQuery = "UPDATE `users` SET `email`='$email'" . $addedPw . ",`first_name`='$firstName',`last_name`='$lastName' WHERE user_id = {$_SESSION["user_id"]}";
                    }

                    $rez = $conn->exec($updateUserQuery);

                    if ($rez) {
                        redirect("index.php?page=edit_profile&success=1");
                    }

                }
            }



        }
    }

?>
<!-- top Products -->
<section class="banner-bottom-wthreelayouts py-lg-5 py-3">
    <div class="container">
        <h3 class="tittle-w3layouts text-center my-lg-4 my-4">Edit your profile
        </h3>

        <div class="inner_sec">
            <p class="sub text-center  ">
                Here you can edit your profile information
            </p>
            <div class="contact_grid_right pt-3">

                <form action="<?= $_SERVER["PHP_SELF"] ?>?page=edit_profile" method="post" enctype="multipart/form-data">
                    <div class="row contact_left_grid">
                        <div class="col-md-6 con-left">
                            <?php
                            if (isset($_GET["success"])) {
                                echo " <div class='alert alert-success' role='alert'>Profile updated!</div>";
                            }
                            ?>
                            <div class="form-group">
                                <label class="my-2">Username</label>
                                <input class="form-control" type="text" name="username" disabled
                                       value="<?= $user["username"] ?>" />
                            </div>
                            <div class="form-group">
                                <label class="my-2">First name</label>
                                <input class="form-control" type="text" name="firstName"
                                       value="<?= $user["first_name"] ?>" />
                            </div>
                            <div class="form-group">
                                <label class="my-2">Last name</label>
                                <input class="form-control" type="text" name="lastName"
                                       value="<?= $user["last_name"] ?>" />
                            </div>
                            <div class="form-group">
                                <label class="my-2">Email</label>
                                <input class="form-control" type="text" name="user_email"
                                       value="<?= $user["email"] ?>" />
                            </div>
                            <div class="form-group">
                                <label>Old password</label>
                                <input class="form-control" type="password" name="old_password" />
                            </div>
                            <div class="form-group">
                                <label>New password</label>
                                <input class="form-control" type="password" name="new_password" />
                            </div>
                            <div class="form-group">
                                <label>Upload image</label>
                                <input class="form-control" type="file" name="image" />
                            </div>
                            <div class="form-group mt-3">
                                <input class="form-control" type="submit" name="submit" value="Submit" />
                            </div>
                            <div class="form-group">
                                <?php if (isset($_GET["errors"])): ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?= $_GET["errors"]; ?>
                                    </div>
                                <?php elseif (isset($_GET["errors"])): ?>
                                    <div class="alert alert-success" role="alert">
                                        <?=
                                        "Success"; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6 con-right">
                            <img src="assets/images/<?= $user["image"] ?>" alt="" class="img-fluid rounded-circle">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

