<?php
$root = "/sajtpraktikum";
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">

        <span class="brand-text font-weight-light">Admin Panel</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= $root ?>/assets/img/<?= $user["image"] ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="index.php" class="d-block">
                    <?= $username ?>
                </a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <!-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> -->
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item ">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                            Tables
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= $root ?>/admin/index.php?page=user_data" class="nav-link ">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Users</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= $root ?>/admin/index.php?page=articles_data" class="nav-link ">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Articles</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= $root ?>/admin/index.php?page=survey_data" class="nav-link ">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Surveys</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= $root ?>/admin/index.php?page=messages_data" class="nav-link ">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Messages</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= $root ?>/admin/index.php?page=role_data" class="nav-link ">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Roles</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= $root ?>/admin/index.php?page=nav_data" class="nav-link ">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Nav Items</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= $root ?>/admin/index.php?page=brands_data" class="nav-link ">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Brands</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= $root ?>/admin/index.php?page=tag_data" class="nav-link ">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tags</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= $root ?>/admin/index.php?page=question_data" class="nav-link ">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Questions</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= $root ?>/admin/index.php?page=answers_data" class="nav-link ">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Answers</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= $root ?>/admin/index.php?page=order_data" class="nav-link ">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Orders</p>
                            </a>
                        </li>
                    </ul>
                </li>
                </li>
            </ul>
        </nav>

    </div>
    <!-- /.sidebar -->
</aside>
