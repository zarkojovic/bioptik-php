<?php
if (isset($_POST["submitSurvey"])) {
    if (!isset($_SESSION["user_id"])) {
        echo "Nisi se ulogovao";
        die;
    }
    $unosi = $_POST["answer"];
    $q_id = $_POST["qid"];
    $u_id = $_SESSION["user_id"];
    if (is_array($unosi)) {
        $insertSurvey = "INSERT INTO `surveys`(`user_id`, `question_id`) VALUES ('$u_id','$q_id');";
        $conn->query($insertSurvey);
        $sid = $conn->lastInsertId();
        foreach ($unosi as $unos) {
            $insertQuery = "INSERT INTO `surveys_answers`(`survey_id`, `answer_id`) VALUES ('$sid','$unos')";
            $conn->query($insertQuery);
        }

    } else {
        $insertSurvey = "INSERT INTO `surveys`(`user_id`, `question_id`) VALUES ('$u_id','$q_id');";
        $conn->query($insertSurvey);
        $sid = $conn->lastInsertId();
        $insertQuery = "INSERT INTO `surveys_answers`(`survey_id`, `answer_id`) VALUES ('$sid','$unosi')";
        $conn->query($insertQuery);
    }
}


//$featuredArticles = "SELECT  a.article_id,a.name,a.old_price,a.discount,a.current_price,a.photo,a.rating,t.class,t.tag_name,b.brand_name FROM  articles a LEFT JOIN tags t ON a.tag_id = t.tag_id LEFT JOIN brands b ON  b.brand_id = a.brand_id WHERE 1 = 1 ";
//
//
//if (isset($_GET["name"]) && trim($_GET["name"]) != "") {
//    $name = strtolower(trim($_GET["name"]));
//    $featuredArticles .= "AND a.name LIKE '%$name%' ";
//}
//if (isset($_GET["searchFilters"])) {
//    if (isset($_GET["brand"])) {
//        $filterBrands = $_GET["brand"];
//        $fb = implode(",", $filterBrands);
//        $featuredArticles .= " AND a.brand_id IN ($fb) ";
//    }
//    if (isset($_GET["tag"])) {
//        $filterTags = $_GET["tag"];
//        $ft = implode(",", $filterTags);
//        $featuredArticles .= " AND a.tag_id IN ($ft) ";
//    }
//    if (isset($_GET["sortArticles"])) {
//        $sortArticles = $_GET["sortArticles"];
//        switch ($sortArticles) {
//            case 'priceDesc':
//                $featuredArticles .= " ORDER BY a.current_price DESC ";
//                break;
//            case 'priceAsc':
//                $featuredArticles .= " ORDER BY a.current_price ASC ";
//                break;
//            case 'nameDesc':
//                $featuredArticles .= " ORDER BY a.name DESC ";
//                break;
//            case 'nameAsc':
//                $featuredArticles .= " ORDER BY a.name ASC ";
//                break;
//        }
//    }
//}
//$articles = $conn->query($featuredArticles)->fetchAll();


$pricesArticlesQuery = "SELECT MIN(current_price) as 'min',MAX(current_price) as 'max' FROM `articles`";

$prices = $conn->query($pricesArticlesQuery)->fetch();

$minPrice = $prices["min"];
$maxPrice = $prices["max"];

$allBrands = "SELECT `brand_id`, `brand_name` FROM `brands`";
$allTags = "SELECT `tag_id`, `tag_name` FROM `tags`";

$brands = $conn->query($allBrands)->fetchAll();
$tags = $conn->query($allTags)->fetchAll();

$saleArticles = "SELECT  a.article_id,a.name,a.discount,a.old_price,a.current_price,a.photo,a.rating,t.class,t.tag_name,b.brand_name FROM articles a, tags t, brands b WHERE b.brand_id = a.brand_id AND a.tag_id = t.tag_id AND t.tag_name = 'Sale' LIMIT 4";

$sales = $conn->query($saleArticles)->fetchAll();
if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];
    $surveyQuery = "SELECT * FROM `questions` WHERE question_id NOT IN (SELECT DISTINCT question_id FROM surveys WHERE user_id = $user_id) AND status = 1";
    $getQuestion = $conn->query($surveyQuery)->fetch();
}


if (isset($getQuestion["question_id"])) {

    $answersQuery = "SELECT * FROM `answers` WHERE question_id = {$getQuestion["question_id"]}";
    $answers = $conn->query($answersQuery)->fetchAll();

}

?>

<div class="banner-top container-fluid" id="home">
</div>
<!-- banner -->
<div class="banner_inner">
    <div class="services-breadcrumb">
        <div class="inner_breadcrumb">

            <ul class="short">
                <li>
                    <a href="index.html">Home</a>
                    <i>|</i>
                </li>
                <li>Shop</li>
            </ul>
        </div>
    </div>

</div>
<!--//banner -->
<!--/shop-->
<section class="banner-bottom-wthreelayouts py-lg-5 py-3">
    <div class="container-fluid">
        <div class="inner-sec-shop px-lg-4 px-3">
            <h3 class="tittle-w3layouts my-lg-4 mt-3">Our selection</h3>
            <div class="row">
                <!-- product left -->
                <div class="side-bar col-lg-3">
                    <div class="search-hotel">
                        <h3 class="agileits-sear-head">Search Here..</h3>
                        <form action="<?= $_SERVER["PHP_SELF"] ?>" method="get">
                            <input type="hidden" name="page" id="page" value="shop">
                            <input class="form-control" type="search" name="name" id="searchName"
                                   placeholder="Search here..."
                                   value="<?php if (isset($_GET["name"]))
                                       echo $_GET["name"]; ?>">
                            <button type="button" class="btn1" id="searchFind" name="searchFilters" value="Submit">
                                <i class="fas fa-search"></i>
                            </button>
                            <div class="clearfix"></div>
                    </div>
                    <div class="left-side mt-0 mb-4">
                        <h3 class="agileits-sear-head">Sort articles</h3>

                        <select name="sortArticles" id="sortArticles" class="form-control border-radius-0">
                            <option
                                value="0" <?= (isset($_GET["sortArticles"]) && $_GET["sortArticles"] == "0") ? "selected" : "" ?>>
                                Sort By...
                            </option>
                            <option
                                value="priceDesc" <?= (isset($_GET["sortArticles"]) && $_GET["sortArticles"] == "priceDesc") ? "selected" : "" ?>>
                                Price Desc
                            </option>
                            <option
                                value="priceAsc" <?= (isset($_GET["sortArticles"]) && $_GET["sortArticles"] == "priceAsc") ? "selected" : "" ?>>
                                Price
                                Asc
                            </option>
                            <option
                                value="nameAsc" <?= (isset($_GET["sortArticles"]) && $_GET["sortArticles"] == "nameAsc") ? "selected" : "" ?>>
                                Name
                                Asc
                            </option>
                            <option
                                value="nameDesc" <?= (isset($_GET["sortArticles"]) && $_GET["sortArticles"] == "nameDesc") ? "selected" : "" ?>>
                                Name
                                Desc
                            </option>
                            <option
                                value="rating" <?= (isset($_GET["sortArticles"]) && $_GET["sortArticles"] == "rating") ? "selected" : "" ?>>
                                By
                                rating
                            </option>
                        </select>
                    </div>
                    <!-- price range -->
                    <div class="range">
                        <h3 class="agileits-sear-head">Price range</h3>
                        <ul class="dropdown-menu6">
                            <li>
                                <div class="row">
                                    <div class="col">
                                        <input type="number" class="form-control" value="<?= $minPrice ?>"
                                               min="<?= $minPrice ?>" max="<?= $maxPrice ?>" name="minPrice"
                                               id="minPrice">
                                    </div>
                                    <div class="col">
                                        <input type="number" class="form-control" value="<?= $maxPrice ?>"
                                               min="<?= $minPrice ?>" max="<?= $maxPrice ?>" name="maxPrice"
                                               id="maxPrice">
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!-- //price range -->
                    <!--preference -->
                    <div class="left-side">
                        <h3 class="agileits-sear-head">Brands</h3>
                        <ul>
                            <?php foreach ($brands as $b): ?>
                                <li>
                                    <input type="checkbox" class="filterCheck brandChb"
                                           name="brand[]" <?php if (isset($filterBrands)) {
                                        if (in_array($b["brand_id"], $filterBrands)) {
                                            echo "checked";
                                        }
                                    } ?> value="<?= $b["brand_id"] ?>" id="brand<?= $b["brand_id"] ?>">
                                    <span class="span">
											<?= $b["brand_name"] ?>
										</span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <!-- // preference -->
                    <!--preference -->
                    <div class="left-side">
                        <h3 class="agileits-sear-head">Tags</h3>
                        <ul>
                            <?php foreach ($tags as $t): ?>
                                <li>
                                    <input type="checkbox" class="filterCheck tagChb" name="tag[]"
                                           id="tag<?= $t["tag_id"] ?>"
                                        <?php if (isset($filterTags)) {
                                            if (in_array($t["tag_id"], $filterTags)) {
                                                echo "checked";
                                            }
                                        } ?> value="<?= $t["tag_id"] ?>">
                                    <span class="span">
											<?= $t["tag_name"] ?>
                                    </span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <!-- // preference -->
                    <!--                    <div class="left-side">-->
                    <!--                        <input type="submit" class="submit-button w-100" name="searchFilters" id="searchFilters"-->
                    <!--                               value="Search"/>-->
                    <!--                    </div>-->
                    </form>
                    <!-- deals -->
                    <div class="deal-leftmk left-side">
                        <h3 class="agileits-sear-head">Special Deals</h3>
                        <?php foreach ($sales as $sale): ?>
                            <div class="special-sec1">
                                <a href="index.php?page=single&id=<?= $sale["article_id"] ?>">
                                    <div class="img-deals">
                                        <img src="assets/images/<?= $sale["photo"] ?>" alt="<?= $sale["name"] ?>">
                                    </div>
                                    <div class="img-deal1">
                                        <h3>
                                            <?= $sale["name"] ?>
                                        </h3>
                                        <a href="single.html">$
                                            <?= $sale["current_price"] ?>
                                        </a>
                                    </div>
                                    <div class="clearfix"></div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div id="surveyWrap">
                        <?php if (isset($_SESSION["user_id"])): ?>
                            <?php if (isset($getQuestion["question_id"])): ?>
                                <!-- //deals -->
                                <div class="deal-leftmk left-side">
                                    <h3 class="agileits-sear-head">Complete a Survey</h3>
                                    <h4 class="mb-3">
                                        <?= $getQuestion["question"] ?>
                                    </h4>
                                    <form action="<?= $_SERVER["PHP_SELF"] ?>" name="surveyForm" method="POST">
                                        <input type="hidden" name="page" id="page" value="shop">
                                        <?php if ($getQuestion["type"]): ?>
                                            <?php foreach ($answers as $a): ?>
                                                <input type="radio" name="answer" required
                                                       id="answer<?= $a["answer_id"] ?>"
                                                       value="<?= $a["answer_id"] ?>"> <?= $a["answer"] ?>
                                                <br/>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <?php foreach ($answers as $a): ?>
                                                <input type="checkbox" name="answer[]" value="<?= $a["answer_id"] ?>"
                                                       id="answer<?= $a["answer_id"] ?>"> <?= $a["answer"] ?>
                                                <br/>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                        <input type="hidden" name="qid" id="qid"
                                               value="<?= $getQuestion["question_id"] ?>">
                                        <input type="button" value="Submit" class="mt-3 submit-button" required name="submitSurvey"
                                               id="submitSurvey"
                                               placeholder="Search"/>
                                    </form>
                                </div>
                            <?php else: ?>
                                <h3>No more surveys to complete!</h3>
                            <?php endif; ?>
                        <?php else: ?>
                            <h3><a href="index.php?page=login"> Sign in</a> to complete surveys!</h3>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- //product left -->
                <!--/product right-->
                <div class="left-ads-display col-lg-9">
                    <div class="wrapper_top_shop">
                        <div class="row" id="productsWrap">
                        </div>
                        <nav aria-label="Page navigation example" id="paginationWrap">
                        </nav>
                    </div>

                </div>
                <!--//product right-->
            </div>
        </div>
    </div>
</section>

<script src="assets/js/jquery-2.2.3.min.js"></script>
<script src="assets/js/jquery-ui.js"></script>


<script>
    $(document).ready(function () {
        renderSurvey();
        filterArticles();
    });

</script>

