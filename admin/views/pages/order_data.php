<?php
if (isset($_SESSION["role_id"]) && $_SESSION["role_id"] == 2) {
  $username = $_SESSION["username"];
  $u_id = $_SESSION["user_id"];
  $getUser = "SELECT * FROM users WHERE user_id = $u_id";


  $user = $conn->query($getUser)->fetch();

  $purchacesQuery = "SELECT atc.`atc_id`, atc.`article_id`,u.username, atc.`user_id`, atc.`quantity`, atc.`bought_at`, a.current_price,a.name, atc.quantity * a.current_price AS 'SUM' FROM `articles_to_cart` AS atc JOIN articles a ON a.article_id = atc.article_id JOIN users u ON u.user_id = atc.user_id";

  $userCarts = "SELECT DISTINCT atc.bought_at,u.username FROM `articles_to_cart` atc JOIN users u ON atc.user_id = u.user_id";

  $carts = $conn->query($userCarts)->fetchAll();

  $items = $conn->query($purchacesQuery)->fetchAll();

  $new_items = array(array());

  // foreach ($carts as $cart) {
  //     foreach ($items as $item) {

  //     }
  // }


  for ($i = 0; $i < count($carts); $i++) {
    for ($j = 0; $j < count($items); $j++) {
      if ($carts[$i]["bought_at"] == $items[$j]["bought_at"]) {
        $new_items[$i][] = $items[$j];
      }
    }
  }
} else {
  redirect("../../index.php");
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Orders</h1>

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
          <?php if (count($new_items[0]) > 0): ?>
            <div class="accordion mt-3" id="accordionExample">
              <?php $index = 0;
              foreach ($new_items as $new): ?>
                <div class="card">
                  <div class="card-header" id="headingOne">
                    <h2 class="mb-0">
                      <button class="btn btn-link btn-block text-left" type="button"
                              data-toggle="collapse" data-target="#collapseOne<?= $index ?>"
                              aria-expanded="true" aria-controls="collapseOne">
                        ORDER #
                        <?= $new_items[$index][0][0] ?> - <?= $new_items[$index][0][1] ?> - <?= $new_items[$index][0][2] ?>
                      </button>
                    </h2>
                  </div>

                  <div id="collapseOne<?= $index ?>" class="collapse " aria-labelledby="headingOne"
                       data-parent="#accordionExample">
                    <div class="card-body">
                      <?php $sum = 0;
                      foreach ($new as $i):
                        $sum += $i["SUM"]; ?>
                        <p class="text-dark">
                          <?= $i["name"] ?>
                        </p>
                        <p class="ml-3">
                          Price per unit:
                          <?= $i["current_price"] ?>$

                        </p>
                        <p class="ml-3">
                          Quantity:
                          <?= $i["quantity"] ?>

                        </p>

                      <?php endforeach; ?>
                      Total:
                      <b>
                        <?= $sum; ?>$
                      </b>
                      <p class="ml-3">
                        Date of order:
                        <?= $i["bought_at"] ?>

                      </p>
                    </div>
                  </div>
                </div>
                <?php $index++; endforeach; ?>
            </div>
          <?php else: ?>
            <p> No previous purchaceses</p>
          <?php endif; ?>
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
          <input type="hidden" name="role_id" value="0">
          <button type="submit" name="submitDelete" class="btn btn-danger">Delete it</button>
        </form>
      </div>
    </div>
  </div>
</div>

