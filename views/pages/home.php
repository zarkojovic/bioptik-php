<?php

$featuredArticles = "SELECT  a.article_id,a.name,a.discount,a.old_price,a.current_price,a.photo,a.rating,t.class,t.tag_name,b.brand_name FROM articles a, tags t, brands b WHERE b.brand_id = a.brand_id AND a.tag_id = t.tag_id AND t.tag_name = 'New Arrival' LIMIT 4";

if (!empty($conn)) {
    $articles = $conn->query($featuredArticles)->fetchAll();
}

?>

<div class="banner-top container-fluid" id="home">

    <!-- banner -->
    <div class="banner">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
                <?php if (isset($carouselData)) {
                    foreach ($carouselData as $carousel): ?>
                        <div class="carousel-item  <?= $carousel["class"] ?>">
                            <div class="carousel-caption text-center">
                                <h3>
                                    <?= $carousel["title"] ?>
                                </h3>
                                <a href="<?= $carousel["link"] ?>"
                                   class="btn btn-sm animated-button gibson-three mt-4"><?= $carousel["button"] ?></a>
                            </div>
                        </div>
                    <?php endforeach;
                } ?>
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
        <!--//banner -->
    </div>
</div>
<!--//banner-sec-->
<section class="banner-bottom-wthreelayouts py-lg-5 py-3">
    <div class="container-fluid">
        <div class="inner-sec-shop px-lg-4 px-3">
            <h3 class="tittle-w3layouts my-lg-4 my-4">New Arrivals for you </h3>
            <div class="row" id="newArrivalsWrap">
            </div>
            <!-- //womens -->
            <!--//row-->
            <!--/meddle-->
            <div class="row">
                <div class="col-md-12 middle-slider my-4 ">
                    <div class="middle-text-info">
                        <div class="wrap">
                            <h3 class="tittle-w3layouts two text-center ">Summer Flash sale</h3>
                            <div class="simply-countdown-custom" id="countDownDeal"></div>
                            <p class="text-center">
                            <a href="index.php?page=shop"
                               class="btn btn-sm animated-button gibson-three mt-4">
                                Explore
                            </a></p>
                        </div>
                    </div>
                </div>
            </div>
            <!--//meddle-->
            <!-- /testimonials -->
            <div class="testimonials py-lg-4 py-3 mt-4">
                <div class="testimonials-inner py-lg-4 py-3">
                    <h3 class="tittle-w3layouts text-center my-lg-4 my-4">Tesimonials</h3>
                    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner" role="listbox">
                            <?php $index = 0;
                            if (isset($testimonialData)) {
                                foreach ($testimonialData as $testimonial): ?>
                                    <div class="carousel-item <?= $index == 0 ? "active" : "" ?>">
                                        <div class="testimonials_grid text-center">
                                            <h3>
                                                <?= $testimonial["name"] ?>
                                                <span>
                                                        <?= $testimonial["role"] ?>
                                                    </span>
                                            </h3>
                                            <label>
                                                <?= $testimonial["country"] ?>
                                            </label>
                                            <p>
                                                <?= $testimonial["comment"] ?>
                                            </p>
                                        </div>
                                    </div>
                                    <?php $index++; endforeach;
                            } ?>
                            <a class="carousel-control-prev test" href="#carouselExampleControls" role="button"
                               data-slide="prev">
                                <span class="fas fa-long-arrow-alt-left"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next test" href="#carouselExampleControls" role="button"
                               data-slide="next">
                                <span class="fas fa-long-arrow-alt-right" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>

                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- //testimonials -->
            <div class="row galsses-grids pt-lg-5 pt-3">
                <div class="col-lg-6 galsses-grid-left">
                    <figure class="effect-lexi">
                        <img src="assets/images/banner4.jpg" alt="" class="img-fluid">
                        <figcaption>
                            <h3>Editor's
                                <span>Pick</span>
                            </h3>
                            <p> Express your style now.</p>
                        </figcaption>
                    </figure>
                </div>
                <div class="col-lg-6 galsses-grid-left">
                    <figure class="effect-lexi">
                        <img src="assets/images/banner1.jpg" alt="" class="img-fluid">
                        <figcaption>
                            <h3>Editor's
                                <span>Pick</span>
                            </h3>
                            <p>Express your style now.</p>
                        </figcaption>
                    </figure>
                </div>
            </div>
            <!-- /grids -->
            <div class="bottom-sub-grid-content py-lg-5 py-3">
                <div class="row">
                    <?php if (isset($featuresData)) {
                        foreach ($featuresData as $feature): ?>
                            <div class="col-lg-4 bottom-sub-grid text-center">
                                <div class="bt-icon">

                                    <span class="<?= $feature["icon"] ?>"></span>
                                </div>

                                <h4 class="sub-tittle-w3layouts my-lg-4 my-3">
                                    <?= $feature["title"] ?>
                                </h4>
                                <p>
                                    <?= $feature["description"] ?>
                                </p>
                                <p>
                                    <a href="<?= $feature["href"] ?>"
                                       class="btn btn-sm animated-button gibson-three mt-4">
                                        <?= $feature["button"] ?>
                                    </a>
                                </p>
                            </div>
                        <?php endforeach;
                    } ?>
                </div>
            </div>
            <!-- //grids -->
            <!-- /clients-sec -->
            <div class="testimonials p-lg-5 p-3 mt-4">
                <div class="row last-section">
                    <?php if (isset($iconsData)) {
                        foreach ($iconsData as $i): ?>
                            <div class="col-lg-3 footer-top-w3layouts-grid-sec">
                                <div class="mail-grid-icon text-center">
                                    <i class="<?= $i["icon"] ?>"></i>
                                </div>
                                <div class="mail-grid-text-info">
                                    <h3>
                                        <?= $i["title"] ?>
                                    </h3>
                                    <p>
                                        <?= $i["description"] ?>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach;
                    } ?>
                </div>
            </div>
            <!-- //clients-sec -->
        </div>
    </div>
</section>
<!-- about -->


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
    })
</script>
<!-- //cart-js -->
<script>


    // Start the countdown
    countdown();

    callBack("models/getArticles.php", "POST", {limit: 4, tag: 3}, function (data) {
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
            for (let i = 0; i < el.rating; i++) {
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
        $("#newArrivalsWrap").html(html);
    })


</script>