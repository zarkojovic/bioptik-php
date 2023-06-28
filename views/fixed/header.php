<?php

if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
    $u_id = $_SESSION["user_id"];

    $userQuery = "SELECT * FROM users WHERE user_id = $u_id";

    $row = $conn->query($userQuery)->fetch();
}
$query = "SELECT * FROM nav_items";

$rez = $conn->query($query)->fetchAll();



?>

<div id="myAlert" class="alert alert-notification alert-success fade show" role="alert">
    This is a pop-up message.
</div>
<!-- header -->
<header>
    <div class="row">
        <div class="col-md-3 top-info text-left mt-lg-4">
            <h6>Need Help</h6>
            <ul>
                <li>
                    <i class="fas fa-phone"></i> Call
                </li>
                <li class="number-phone mt-3">12345678099</li>
            </ul>
        </div>
        <div class="col-md-6 logo-w3layouts text-center">
            <h1 class="logo-w3layouts">
                <a class="navbar-brand" href="index.html">
                    Bioptik </a>
            </h1>
        </div>

        <div class="col-md-3 top-info-cart text-right mt-lg-4">
            <ul class="cart-inner-info">
                <?php if (isset($username)): ?>


                    <li class="button-log">

                        <a class="btn-open" href="index.php?page=profile">
                            <?= $username ?> <img width="20px" src="assets/img/<?= $row["image"] ?>" alt="">
                        </a>
                    </li>
                    <li class="galssescart cart cart box_1">

                        <!--                        <input type="hidden" name="cmd" value="_cart">-->
                        <!--                        <input type="hidden" name="display" value="1">-->
                        <a href="index.php?page=checkout" class="p-3 text-muted border top_googles_cart" id="cartHeader" type="submit" name="submit" value="">

                            <i class="fas fa-cart-arrow-down"></i>
                        </a>
                    </li>


                <?php else: ?>
                    <li class="button-log">
                        <a class="btn-open" href="index.php?page=login">
                            Sign in / Sign up
                        </a>
                    </li>
                <?php endif; ?>


                <?php if (isset($username)): ?>

                    <a class="btn-open ml-3 primary-text" data-toggle="tooltip" data-placement="left" title="Logout"
                        href="models/logout.php"><i class="fas fa-sign-out-alt"></i></a>

                <?php endif; ?>
            </ul>
        </div>
    </div>
    <div class="search">
        <div class="mobile-nav-button">
            <button id="trigger-overlay" type="button">
                <i class="fas fa-search"></i>
            </button>
        </div>
        <!-- open/close -->
        <div class="overlay overlay-door">
            <button type="button" class="overlay-close">
                <i class="fa fa-times" aria-hidden="true"></i>
            </button>
            <form action="index.php?page=shop" method="get" class="d-flex">
                <input type="hidden" name="page" id="page" value="shop">
                <input class="form-control" type="search" placeholder="Search here..." name="name" required="">
                <button type="submit" class="btn btn-primary submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>

        </div>
        <!-- open/close -->
    </div>
    <label class="top-log mx-auto"></label>
    <nav class="navbar navbar-expand-lg navbar-light bg-light top-header mb-2">

        <button class="navbar-toggler mx-auto" type="button" data-toggle="collapse"
            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">

            </span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav nav-mega mx-auto">
                <?php foreach ($rez as $nav_item): ?>
                    <li class="nav-item ">
                        <a class="nav-link" href="<?= $nav_item["href"] ?>">
                            <?= $nav_item["title"] ?>
                        </a>
                    </li>
                <?php endforeach; ?>
                <?php if (isset($_SESSION["username"]) && $_SESSION["role_id"] == 2): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="admin/index.php">Admin Panel</a>
                    </li>
                <?php endif; ?>
                <?php if (isset($_SESSION["username"])): ?>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="includes/logic/logout.php">Logout</a>
                    </li> -->
                <?php endif; ?>
            </ul>

        </div>
    </nav>
</header>
<!-- //header -->