<?php
session_start();
include_once("../../../models/functions.php");
include_once("../../../config/conn.php");

if (isset($_SESSION["role_id"]) && $_SESSION["role_id"] == 2) {
    $username = $_SESSION["username"];
    $u_id = $_SESSION["user_id"];
    $getUser = "SELECT * FROM users WHERE user_id = $u_id";

    if (isset($_POST["submitEditUser"])) {
        $brGresaka = 0;
        $errors = "";
        // $email;
        $userUpdateId = $_POST["user_id"];
        $checkNames = "/^[a-zA-Z,.'-]+$/";
        $checkUsername = "/^[a-zA-Z0-9]+([._]?[a-zA-Z0-9]+)*$/";
        $checkPassword = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/";
        if (isset($_POST["firstName"])) {
            $firstName = $_POST["firstName"];
            if ($firstName == "") {
                $brGresaka++;
                $errors .= "<li>Ime ne sme biti prazno!</li>";
            } else
                if (!preg_match($checkNames, $firstName)) {
                    $brGresaka++;
                    $errors .= "<li>Lose Upisano ime</li>";
                }
        }
        if (isset($_POST["lastName"])) {
            $lastName = $_POST["lastName"];
            if ($firstName == "") {
                $brGresaka++;
                $errors .= "<li>Prezime ne sme biti prazno!</li>";
            } else
                if (!preg_match($checkNames, $lastName)) {
                    $brGresaka++;
                    $errors .= "<li>Lose Upisano prezime. Npr.</li>";
                }
        }
        if (isset($_POST["username"])) {
            $username = $_POST["username"];

            if ($username == "") {
                $brGresaka++;
                $errors .= "<li>Korisnicko ime ne sme biti prazno!</li>";
            } else
                if (!preg_match($checkUsername, $username)) {
                    $brGresaka++;
                    $errors .= "<li>Lose Upisano korisnicko ime</li>";
                }
        }
        if (isset($_POST["user_email"])) {
            $email = $_POST["user_email"];


            if ($email == "") {
                $brGresaka++;
                $errors .= "<li>Email ne sme biti prazno!</li>";
            } else
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $brGresaka++;
                    $errors .= "<li>Lose Upisan email</li>";
                }
        }
        if (isset($_POST["password"])) {

            $password = $_POST["password"];

            // $new_pw = $_POST["new_password"];
            // if ($new_pw != "") {
            //     if (!preg_match($checkPassword, $new_pw)) {
            //         $new_pw = md5($_POST["new_password"]);
            //         $brGresaka++;
            //         $errors .= "<li>Lose Upisana nova lozinka</li>";
            //     } else
            //         if (isset($_POST["old_password"])) {
            //             $old_pw = $_POST["old_password"];
            //             if ($old_pw != "") {
            //                 $old_pw = md5($old_pw);
            //                 $checkPwQuery = "SELECT * FROM users WHERE user_id = {$_SESSION["user_id"]} AND password = :old_pw";
            //                 $pwCheck = $conn->prepare($checkPwQuery);
            //                 $pwCheck->bindParam(":old_pw", $old_pw);

            //                 $pwCheck->execute();
            //                 $row = $pwCheck->fetch();

            //             } else {
            //                 $brGresaka++;
            //                 $errors .= "<li>Moras da uneses staru lozinku!</li>";
            //             }
            //         }
            // }


        }

        if (isset($_POST["roles"])) {
            $role_id = $_POST["roles"];
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
            redirect("edit_user.php?id={$_POST["user_id"]}&errors={$errors}");
        } else {
            if ($fajl["size"] > 0) {
                $noviNazivFajla = time() . "_" . $nazivFajla;
                $putanja = "../../../images/" . $noviNazivFajla;
                if (moveImages($fajl,true,"../../../")) {

                    if ($password != '') {
                        $password = md5($password);
                        $addedPw = ",`password`='$password'";
                    } else {
                        $addedPw = "";
                    }

                }
                    $updateUserQuery = "UPDATE `users` SET `email`='$email'" . $addedPw . ",`first_name`='$firstName',`last_name`='$lastName',`role_id`=$role_id,`image`='$noviNazivFajla' WHERE user_id = $userUpdateId";
            } else {
                if ($password != '') {
                    $password = md5($password);
                    $addedPw = ",`password`='$password'";
                } else {
                    $addedPw = "";
                }
                $updateUserQuery = "UPDATE `users` SET `email`='$email'" . $addedPw . ",`role_id`=$role_id,`first_name`='$firstName',`last_name`='$lastName' WHERE user_id = $userUpdateId";
            }

            $rez = $conn->exec($updateUserQuery);

            if ($rez) {
                redirect("edit_user.php?id={$_POST["user_id"]}&success=1");
            }

        }
    }

    $user = $conn->query($getUser)->fetch();

    $rolesQuery = "SELECT `role_id`, `role_name` FROM `roles`";

    $roles = $conn->query($rolesQuery)->fetchAll();

    $usersQuery = "SELECT u.user_id,u.username, u.email, u.first_name, u.last_name, r.role_name, u.created_at, u.image FROM `users`u, roles r WHERE r.role_id = u.role_id";

    $users = $conn->query($usersQuery)->fetchAll();

    if (isset($_GET["id"])) {
        $editUserId = $_GET["id"];
        $userQuery = "SELECT `user_id`, `username`, `email`, `password`, `first_name`, `last_name`, `role_id`,  `image` FROM `users` WHERE user_id = $editUserId";
        $editUser = $conn->query($userQuery)->fetch();
    } else {
        redirect("../../index.php");
    }

} else {
  redirect("../../index.php");
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel | Edit User</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="../../index.php" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                    aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>

                <!-- Messages Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-comments"></i>
                        <span class="badge badge-danger navbar-badge">3</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="../../dist/img/user1-128x128.jpg" alt="User Avatar"
                                    class="img-size-50 mr-3 img-circle">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        Brad Diesel
                                        <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">Call me whenever you can...</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="../../dist/img/user8-128x128.jpg" alt="User Avatar"
                                    class="img-size-50 img-circle mr-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        John Pierce
                                        <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">I got your message bro</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <!-- Message Start -->
                            <div class="media">
                                <img src="../../dist/img/user3-128x128.jpg" alt="User Avatar"
                                    class="img-size-50 img-circle mr-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        Nora Silvester
                                        <span class="float-right text-sm text-warning"><i
                                                class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">The subject goes here</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            <!-- Message End -->
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                    </div>
                </li>
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">15</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">15 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> 4 new messages
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> 8 friend requests
                            <span class="float-right text-muted text-sm">12 hours</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> 3 new reports
                            <span class="float-right text-muted text-sm">2 days</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->


        <?php include_once("../../includes/sidemenu.php"); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Edit User</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">DataTables</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <?= $editUser["username"] ?>
                                    </h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form action="<?= $_SERVER["PHP_SELF"] ?>?id=<?= $_GET["id"] ?>" method="POST"
                                    enctype="multipart/form-data">
                                    <div class="card-body">
                                        <img src="<?= ROOT_FOLDER ?>/assets/img/<?= $editUser["image"] ?>" width="150px"
                                            height="150px" class="mb-3" alt="avatar">
                                        <div class="form-group">
                                            <label for="firstName">First Name</label>
                                            <input type="text" class="form-control" id="firstName" name="firstName"
                                                value="<?= $editUser["first_name"] ?>" placeholder="First Name">
                                        </div>
                                        <div class="form-group">
                                            <label for="lastName">Last Name</label>
                                            <input type="text" class="form-control" id="lastName" name="lastName"
                                                value="<?= $editUser["last_name"] ?>" placeholder="Last Name">
                                        </div>
                                        <div class="form-group">
                                            <label for="user_email">Email address</label>
                                            <input type="email" class="form-control" id="user_email" name="user_email"
                                                value="<?= $editUser["email"] ?>" placeholder="Enter email">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Role</label>
                                            <div class="form-group">
                                                <select class=" form-control" id="roles" name="roles">
                                                    <?php foreach ($roles as $role): ?>
                                                        <option value="<?= $role["role_id"] ?>"
                                                            <?= $role["role_id"] == $editUser["role_id"] ? "selected" : "" ?>>
                                                            <?= $role["role_name"] ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="password">New password</label>
                                            <input type="password" class="form-control" id="password" name="password"
                                                placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputFile">File input</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="image"
                                                        id="image">
                                                    <label class="custom-file-label" for="image">Choose
                                                        file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Upload</span>
                                                </div>
                                            </div>
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
                                    <!-- /.card-body -->
                                    <input type="hidden" name="user_id" value="<?= $editUserId ?>">
                                    <div class="card-footer">
                                        <button type="submit" name="submitEditUser"
                                            class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 3.2.0
            </div>
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights
            reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete user</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this user?
                </div>
                <div class="modal-footer">
                    <form action="<?= $_SERVER["PHP_SELF"] ?>" name="deleteForm" method="POST">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="hidden" name="user_id" value="0">
                        <button type="submit" name="submitDelete" class="btn btn-danger">Delete it</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="../../plugins/jszip/jszip.min.js"></script>
    <script src="../../plugins/pdfmake/pdfmake.min.js"></script>
    <script src="../../plugins/pdfmake/vfs_fonts.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
    <!-- Page specific script -->
    <script>
        $(function () {
            $("#example1").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
</body>

</html>
