<?php


$linksQuery = "SELECT `nav_item_id`, `href`, `title` FROM `nav_items`";

$links = $conn->query($linksQuery)->fetchAll();



?>
<!--footer -->
<footer class="py-lg-5 py-3">
    <div class="container px-lg-5 px-3">
        <div class="row footer-top-w3layouts">
            <div class="col-lg-4 footer-grid-w3ls">
                <div class="footer-title">
                    <h3>About Us</h3>
                </div>
                <div class="footer-text">
                    <p>Bioptik is a premier sunglasses shop offering a wide variety of stylish and high-quality eyewear options for those who want to protect their eyes and look fashionable at the same time.</p>
                    <ul class="footer-social text-left mt-lg-4 mt-3">
                        <?php foreach ($footerIcons as $icon): ?>
                            <li class="mx-2">
                                <a href="<?= $icon["href"] ?>">
                                    <i class="<?= $icon["class"] ?>"></i>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 footer-grid-w3ls">
                <div class="footer-title">
                    <h3>Get in touch</h3>
                </div>
                <div class="contact-info">
                    <h4>Location :</h4>
                    <p>0926k 4th block building, king Avenue, New York City.</p>
                    <div class="phone">
                        <h4>Contact :</h4>
                        <p>Phone : +381 69 333 11 00</p>
                        <p>Email :
                            <a href="mailto:info@example.com">info@bioptik.com</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 footer-grid-w3ls">
                <div class="footer-title">
                    <h3>Quick Links</h3>
                </div>
                <ul class="links">
                    <?php foreach ($links as $item): ?>
                        <li>
                            <a href="<?= $item["href"] ?>"><?= $item["title"] ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="copyright-w3layouts mt-4">
            <p class="copy-right text-center ">&copy; 2023 Bioptik. All Rights Reserved
            </p>
        </div>
    </div>
</footer>
<!-- //footer -->