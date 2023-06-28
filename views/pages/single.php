<?php
if (isset($_GET["id"])) {
    global $conn;
    $id = $_GET["id"];
    $selectSingle = "SELECT *, b.brand_name FROM articles a, brands b WHERE article_id = :id AND b.brand_id = a.brand_id";

    $upit = $conn->prepare($selectSingle);

    $upit->bindParam(":id", $id);

    $upit->execute();

    $item = $upit->fetch();

    if (!$item) {
        redirect("404.php");
    }

    $featuredArticles = "SELECT  a.article_id,a.name,a.old_price,a.current_price,a.photo,a.rating,t.class,t.tag_name,b.brand_name FROM articles a, tags t, brands b WHERE b.brand_id = a.brand_id AND a.tag_id = t.tag_id AND t.tag_name = 'Featured' LIMIT 4";
    $articles = $conn->query($featuredArticles)->fetchAll();
} else {
    redirect("404.php");
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
                    <li>Single Page</li>
                </ul>
            </div>
        </div>

    </div>

</div>
<!--//banner -->
<!--/shop-->
<section class="banner-bottom-wthreelayouts py-lg-5 py-3">
    <div class="container">
        <div class="inner-sec-shop pt-lg-4 pt-3">
            <div class="row">
                <div class="col-lg-4 single-right-left ">
                    <div class="grid images_3_of_2">
                        <div class="flexslider1">

                            <ul class="slides">
                                <li data-thumb="assets/images/<?= $item["photo"] ?>">
                                    <div class="thumb-image"><img src="assets/images/<?= $item["photo"] ?>"
                                                                  data-imagezoom="true" class="img-fluid" alt=" "></div>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 single-right-left simpleCart_shelfItem">
                    <h3>
                        <?= $item["name"] ?>
                    </h3>
                    <h6 class="text-dark">
                        <?= $item["brand_name"] ?>
                    </h6>
                    <p><span class="item_price">$
								<?= $item["current_price"] ?>
							</span>
                        <?= $item["old_price"] != null ? "
								<del>$
								{$item["old_price"]}</del>
								
							" : "" ?>
                    </p>
                    <p class="mb-0 small">Rating:
                        <?= $item["rating"] ?>/5.00
                    </p>
                    <div class="rating1">
                        <ul class="stars">
                            <?php for ($i = 0; $i < $item["rating"]; $i++) { ?>
                                <li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="description">
                        <h5>
                            <?= $item["description"] ?>
                        </h5>
                    </div>
                    <div class="occasion-cart">
                        <div class="googles single-item singlepage">
                            <form action="#" method="post">
                                <form action="#" method="post">
                                    <input type="hidden" name="cmd" value="_cart">
                                    <input type="hidden" name="add" value="1">
                                    <input type="hidden" name="image" value="<?= $item["photo"] ?>">
                                    <input type="hidden" name="id" value="<?= $item["article_id"] ?>">
                                    <input type="hidden" name="googles_item" value="<?= $item["name"] ?>">
                                    <input type="hidden" name="amount" value="<?= $item["current_price"] ?>">

                                    <button type="button" class="googles-cart pgoogles-cart addToCartBtn"
                                            data-action="add" data-id="<?= $item["article_id"] ?>">
                                        Add To Cart
                                    </button>


                                </form>

                        </div>
                    </div>

                </div>
                <div class="clearfix"></div>
                <!--/tabs-->

            </div>
        </div>
    </div>
    <div class="container-fluid">
        <!--/slide-->
        <div class="slider-img mid-sec mt-lg-5 mt-2 px-lg-5 px-3">
            <!--//banner-sec-->
            <h3 class="tittle-w3layouts text-left my-lg-4 my-3">Featured Products</h3>
            <div class="mid-slider">
                <div class="row" id="featuredArticlesWrap">
               </div>
            </div>
        </div>
        <!--//slider-->
    </div>
</section>

<script src="../../assets/js/jquery-2.2.3.min.js"></script>
<script>
    $(document).ready(function () {
        $('.owl-carousel').owlCarousel({
            loop: true,
            margin: 10,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    nav: true
                },
                600: {
                    items: 2,
                    nav: false
                },
                900: {
                    items: 3,
                    nav: false
                },
                1000: {
                    items: 4,
                    nav: true,
                    loop: false,
                    margin: 20
                }
            }
        })
// Show the alert and set a timeout to hide it after 3 seconds



        callBack("models/getArticles.php","POST",{limit : 4,tag : 2},function (data){
            let items = JSON.parse(data);
            let html = '';
            items.forEach(el => {
                html += `    <div class="col-md-3 product-men women_two">
                        <div class="product-googles-info googles">
                            <div class="men-pro-item">
                                <div class="men-thumb-item">
                                    <img src="assets/img/${el.photo}" class="img-fluid" alt="">
                                    <div class="men-cart-pro">
                                        <div class="inner-men-cart-pro">
                                            <a href="index.php?page=single&id=${el.article_id}"
                                               class="link-product-add-cart">Quick
                                                View</a>
                                        </div>
                                    </div>
                                    <span class="product-new-top ${el.class}"> ${el.tag_name}</span>


                                </div>
                                <div class="item-info-product">
                                    <div class="info-product-price">
                                        <div class="grid_meta">
                                            <div class="">
                                                <h4>
                                                    <a href="single.html" class="primary-text fw-bold">
                                                        ${el.name}
                                                    </a>
                                                </h4>
                                                <h5>
                                                    <a href="single.html" class="text-dark">
                                                        ${el.brand_name}
                                                    </a>
                                                </h5>
                                                <div class="grid-price mt-2">
														<span class="money h3">$
															${el.current_price}
														</span>
                                                </div>

                                            </div>
                                            <ul class="stars">`;
                for(let i = 0;i< el.rating;i++){
                    html += `<li>
                                                                <a href="#">
                                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                                </a>
                                                            </li>`;
                }
                html += `</ul>
                                        </div>
                                        <button type="submit" class="googles-cart addToCartBtn" data-action="add" data-id="${el.article_id}">
                                                        <i class="fas fa-cart-plus"></i>
                                                    </button>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
               `
            });
            $("#featuredArticlesWrap").html(html);
        })

    })
</script>
