<?php
if (isset($_SESSION["username"])) {
    redirect("index.php");

}

if (isset($_POST["submit"])) {
    $brGresaka = 0;
    $errors = "";
    $checkUsername = "/^[a-zA-Z0-9]+([._]?[a-zA-Z0-9]+)*$/";
    if (isset($_POST["username"])) {
        $username = $_POST["username"];
        if ($username == "") {
            $brGresaka++;
            $errors = "<li>You didn't insert username!</li>";
        } else if (!preg_match($checkUsername, $username)) {
            $brGresaka++;
            $errors .= "<li>Invalid username format!</li>";
        }
    }
    if (isset($_POST["password"])) {
        if ($_POST["password"] == "") {
            $brGresaka++;
            $errors .= "<li>You didn't insert password!</li>";
        } else {

            $password = md5($_POST["password"]);
        }
    }
    if ($brGresaka > 0) {
        redirect("index.php?page=login&errors={$errors}");

    } else {
        $existQuery = "SELECT * FROM users WHERE username = :username";

        $userExist = $conn->prepare($existQuery);
        $userExist->bindParam(":username",$username);
        $userExist->execute();

        $check = $userExist->fetch();

        if($check){
            $query = "SELECT * FROM users WHERE username = :username AND password = :password";

            $iskaz = $conn->prepare($query);
            $iskaz->bindParam(":username", $username);
            $iskaz->bindParam(":password", $password);
            $iskaz->execute();
            $Userrez = $iskaz->fetch();

            if ($Userrez) {
                if($Userrez["isBanned"] == "1"){
                    redirect("index.php?page=login&errors=User is banned!");
                }else{

                    $_SESSION["username"] = $Userrez["username"];
                    $_SESSION["user_id"] = $Userrez["user_id"];
                    $_SESSION["role_id"] = $Userrez["role_id"];

                    redirect("index.php");
                }
            } else {
                $podaci = file("data/loginLog.txt");
                $br = 0;
                $time = strtotime("-5 minutes");
                foreach ($podaci as $item){
                    $elems = explode("\t",$item);
                    if($elems[0] == $username){
                        if($time < $elems[2]){
                            $br++;
                        }
                    }
                }
                if($br >= 3){
                    $banQuery = "UPDATE `users` SET `isBanned`='1' WHERE username = '$username'";
                    $ban = $conn->exec($banQuery);

                    if($ban){

                        $email = $check["email"];
                        $to = "gamerisub@gmail.com";
                        $subject = 'Your acconut has been banned';
                        $message = 'Due to too many attempts in your login, we suspended your account. Contact admin for more details.';

                        // Additional headers

                        $headers = "From: gamerisub@gmail.com\r\n";
                        $headers .= "Reply-To: gamerisub@gmail.com\r\n";
                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-type:text/html;charset=UTF-8\r\n";
                        // Send the email
                        $mailSent = mail($to, $subject, $message, $headers);

                        if ($mailSent) {
                            $mes = 'Email sent successfully.';
                        } else {
                            $mes = 'Failed to send email.';
                        }

                        redirect("index.php?page=login&errors=User is banned!");
                    }

                }else{

                    $fajl = fopen("data/loginLog.txt","a");
                    $upisPodataka = "$username\t{$_SERVER["REMOTE_ADDR"]}\t".time()."\t\n";
                    fwrite($fajl,$upisPodataka);
                    fclose($fajl);
                    redirect("index.php?page=login&errors=Username and password don't match!");
                }

            }
        }else{
            redirect("index.php?page=login&errors=User does not exist!");
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

<section class="banner-bottom-wthreelayouts py-lg-5 py-3">
    <div class="container">
        <h3 class="tittle-w3layouts text-center my-lg-4 my-4">Login</h3>
        <div class="inner_sec">
            <p class="sub text-center  ">
                Welcome back! It's good to see you again.
            </p>
            <div class="contact_grid_right pt-3">
                <form action="<?= $_SERVER["PHP_SELF"] ?>?page=login" method="post">
                    <div class="row contact_left_grid">
                        <div class="col-md-6 offset-md-3 con-left">
                            <div class="form-group">
                                <label class="my-2">Username</label>
                                <input class="form-control" type="text" name="username" />
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input class="form-control" type="password" name="password" />
                            </div>
                            <div class="form-group mt-3">
                                <!-- <label class="my-2">Subject</label> -->

                                <input class="form-control" type="submit" name="submit" value="Submit" />
                                <!-- <input class="form-control" type="text" name="Subject" placeholder="" required="" /> -->
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
                            <p class="text-center"><a href="index.php?page=register">Don't have an acccount? Register now!</a></p>

                        </div>
                        <div class="col-md-6 con-right">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>