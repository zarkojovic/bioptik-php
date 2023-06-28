<?php

    $picksArray[] = array(
        "image" => "banner4.jpg",
        "title" => "Editor's <span>Pick</span>",
        "description" => "Express your style now."
    );

    $picksArray[] = array(
        "image" => "banner1.jpg",
        "title" => "Editor's <span>Pick</span>",
        "description" => "Express your style now."
    );
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
                    <li>About Us</li>
                </ul>
            </div>
        </div>

    </div>
    <!--//banner -->
</div>
<!--// header_top -->
<!-- top Products -->
<section class="banner-bottom-wthreelayouts py-lg-5 py-3">
    <div class="container-fluid">

        <div class="inner-sec-shop px-lg-4 px-3">
            <div class="about-content py-lg-5 py-3">

                <div class="row">
                    <div class="col-lg-6 p-0">
                        <img src="assets/images/<?= $aboutInfo["image"] ?>" alt="Goggles" class="img-fluid">
                    </div>
                    <div class="col-lg-6 about-info">
                        <h3 class="tittle-w3layouts text-left mb-lg-5 mb-3">
                            <?= $aboutInfo["title"] ?>
                        </h3>
                        <p class="my-xl-4 my-lg-3 my-md-4 my-3">
                            <?= $aboutInfo["description"] ?>
                        </p>

                        <a href="<?= $aboutInfo["href"] ?>" class="btn btn-sm animated-button gibson-three mt-4">
                            <?= $aboutInfo["button"] ?>
                        </a>

                    </div>
                </div>
            </div>
            <h3 class="tittle-w3layouts text-center my-lg-4 my-4">Our Team</h3>
            <div class="partners-info">
                <div class="row mt-lg-5 mt-3">
                    <?php foreach ($teamArray as $team): ?>
                        <div class="col-md-3 team-main-gd">
                            <div class="team-grid text-center">
                                <div class="team-img">
                                    <img class="img-fluid rounded" src="assets/images/<?= $team["picture"] ?>" alt="">
                                </div>
                                <div class="team-info">
                                    <h4>
                                        <?= $team["name"] ?>
                                    </h4>
                                    <span class="mb-3">
											<?= $team["description"] ?>
										</span>

                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <!-- /grids -->
            <div class="bottom-sub-grid-content py-lg-5 py-3">
                <div class="row">
                    <?php foreach ($featuresData as $feature): ?>
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
                                <a href="<?= $feature["href"] ?>" class="btn btn-sm animated-button gibson-three mt-4">
                                    <?= $feature["button"] ?>
                                </a>
                            </p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <!-- //grids -->
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
            <!-- /testimonials -->
            <div class="testimonials py-lg-4 py-3 mt-4">
                <div class="testimonials-inner py-lg-4 py-3">
                    <h3 class="tittle-w3layouts text-center my-lg-4 my-4">Tesimonials</h3>
                    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner" role="listbox">
                            <?php $index = 0; foreach ($testimonialData as $testimonial): ?>
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
                                <?php $index++; endforeach; ?>
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
                <?php foreach ($picksArray as $pick): ?>
                    <div class="col-lg-6 galsses-grid-left">
                        <figure class="effect-lexi">
                            <img src="assets/images/<?= $pick["image"] ?>" alt="" class="img-fluid">
                            <figcaption>
                                <h3>
                                    <?= $pick["title"] ?>
                                </h3>
                                <p>
                                    <?= $pick["description"] ?>
                                </p>
                            </figcaption>
                        </figure>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- /clients-sec -->
            <div class="testimonials p-lg-5 p-3 mt-4">
                <div class="row last-section">
                    <?php foreach ($iconsData as $i): ?>
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
                    <?php endforeach; ?>
                </div>
            </div>
            <!-- //clients-sec -->

        </div>
    </div>
</section>

<script>
    countdown();
</script>