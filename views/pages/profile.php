<?php
if (!isset($_SESSION["username"])) {
    redirect('index.php');
} else {
    $user_id = $_SESSION["user_id"];
    $query = "SELECT * FROM users WHERE user_id = {$user_id}";
    $user = $conn->query($query)->fetch();

    $username = $user["username"];
    $email = $user["email"];
    $role = $user["role_id"];
    $firstName = $user["first_name"];
    $lastName = $user["last_name"];
    $image = $user["image"];


    $roleQuery = "SELECT role_name FROM roles WHERE role_id = {$_SESSION["role_id"]}";

    $roleName = $conn->query($roleQuery)->fetch()["role_name"];

    $purchacesQuery = "SELECT c.cart_id,ca.quantity,a.name,a.current_price,(a.current_price * ca.quantity) AS 'SUM',c.created_at FROM `carts` c, carts_articles ca,articles a WHERE c.user_id = $user_id AND c.cart_id = ca.cart_id AND a.article_id = ca.article_id ORDER BY c.cart_id DESC";

    $userCarts = "SELECT c.cart_id FROM `carts` c WHERE user_id = $user_id GROUP BY c.cart_id";

    $carts = $conn->query($userCarts)->fetchAll();

    $items = $conn->query($purchacesQuery)->fetchAll();

    $new_items = array(array());


    for ($i = 0; $i < count($carts); $i++) {

        for ($j = 0; $j < count($items); $j++) {
            if ($carts[$i]["cart_id"] == $items[$j]["cart_id"]) {
                $new_items[$i][] = $items[$j];
            }
        }
    }

}

?>
<div class="container">
    <div class="row my-5">
        <div class="col">
            <div class="row d-flex align-items-center">
                <img class="rounded-circle" width="100px" src="assets/img/<?= $image ?>" alt="<?= $username ?>">
                <h3 class="ml-3">
                    <?= $username ?>
                </h3>
            </div>
            <hr>
            <h3> First Name :
                <?= $firstName ?>
            </h3>
            <h3> Last Name :
                <?= $lastName ?>
            </h3>

            <h3> Email :
                <?= $email ?>
            </h3>
            <h3> Role :
                <?= $roleName ?>
            </h3>
            <p class=" mt-4">
                <a href="index.php?page=edit_profile" class="bg-info p-3 text-white">
                    Edit your profile
                </a>
            </p>
        </div>
        <div class="col">
            <h3>Your purchaces</h3>
                <div class="accordion mt-3" id="accordionExample">
                </div>
        </div>
    </div>

</div>
<script>

    $(document).ready(function () {

        $.ajax({
            url: "models/getUserPurchases.php",
            method: "POST",
            success: function (data){
                let html = "";
                let res = JSON.parse(data);
                if(res[0].length > 0){
                    var index = 0;
                    res[0].forEach(el => {
                        html += `<div class="card">
                            <div class="card-header" id="headingOne">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                                            data-target="#collapseOne${index}" aria-expanded="true"
                                            aria-controls="collapseOne">
                                        ORDER #
                                        ${index+1}
                                    </button>
                                </h2>
                            </div>

                            <div id="collapseOne${index}" class="collapse " aria-labelledby="headingOne"
                                 data-parent="#accordionExample">
                                <div class="card-body">`;
                        var sum = 0;
                        res[1].forEach(item => {
                            sum += item.current_price * item.quantity;
                            if(el.bought_at == item.bought_at){
                                html += `<p class="text-dark">
                                            ${item.bought_at}
                                        </p>
                                        <p class="ml-3">
                                            Price per unit:
                                            ${item.current_price}$
                                        </p>
                                        <p class="ml-3">
                                            Quantity:
                                            ${item.quantity}
                                        </p>
                                `;
                            }
                        })
                                html += `Total: $ ${sum}
                                    <p class="ml-3">
                                        Date of order:
                                        ${el.bought_at}
                                    </p>
                                </div>
                            </div>
                        </div>
                        `
                        index++;
                    });

                }else{
                    html = "No previous purchases!";
                }

                $("#accordionExample").html(html);
                console.log(JSON.parse(data));
            }
        });
        $("#myModal").modal();
    });
</script>