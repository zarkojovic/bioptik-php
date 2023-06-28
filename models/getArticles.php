<?php
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once("../config/conn.php");
    $tag = $_POST["tag"];
    $limit = $_POST["limit"];
    $query = "SELECT  a.article_id,a.name,a.discount,a.old_price,a.current_price,a.photo,a.rating,t.class,t.tag_name,b.brand_name FROM articles a, tags t, brands b WHERE b.brand_id = a.brand_id AND a.tag_id = t.tag_id AND t.tag_id = $tag LIMIT $limit";

    echo json_encode($conn->query($query)->fetchAll());
}else{
    http_response_code(404);
}
?>