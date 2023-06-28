<?php
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: ../index.php");
    die;
} else {
    include_once("../config/conn.php");
    $featuredArticles = "SELECT  a.article_id,a.name,a.old_price,a.discount,a.current_price,a.photo,a.rating,t.class,t.tag_name,b.brand_name FROM  articles a LEFT JOIN tags t ON a.tag_id = t.tag_id LEFT JOIN brands b ON  b.brand_id = a.brand_id WHERE 1 = 1 ";
    if (isset($_POST["name"]) && trim($_POST["name"]) != "") {
        $name = strtolower(trim($_POST["name"]));
        $featuredArticles .= "AND a.name LIKE '%$name%' ";
    }
//if (isset($_GET["searchFilters"])) {
    if (isset($_POST["brand"])) {
        $filterBrands = $_POST["brand"];
        $fb = implode(",", $filterBrands);
        $featuredArticles .= " AND a.brand_id IN ($fb) ";
    }
    if (isset($_POST["tag"])) {
        $filterTags = $_POST["tag"];
        $ft = implode(",", $filterTags);
        $featuredArticles .= " AND a.tag_id IN ($ft) ";
    }

    if (isset($_POST["min"])) {
        $min = $_POST["min"];
        $featuredArticles .= " AND a.current_price >=  $min";
    }
    if (isset($_POST["max"])) {
        $max = $_POST["max"];
        $featuredArticles .= " AND a.current_price <=  $max";
    }

    if (isset($_POST["sortArticles"])) {
        $sortArticles = $_POST["sortArticles"];
        switch ($sortArticles) {
            case 'priceDesc':
                $featuredArticles .= " ORDER BY a.current_price DESC ";
                break;
            case 'priceAsc':
                $featuredArticles .= " ORDER BY a.current_price ASC ";
                break;
            case 'nameDesc':
                $featuredArticles .= " ORDER BY a.name DESC ";
                break;
            case 'nameAsc':
                $featuredArticles .= " ORDER BY a.name ASC ";
                break;
            case 'rating':
                $featuredArticles .= " ORDER BY a.rating DESC ";
                break;
        }
    }
//}
    $articles = $conn->query($featuredArticles)->fetchAll();

    echo json_encode($articles);
}