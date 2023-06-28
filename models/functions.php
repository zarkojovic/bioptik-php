<?php
function redirect($page)
{
    header("Location: {$page}");
}

function moveImages($file, $profile = false,$root = "")
{
    $tmp = $file["tmp_name"];
    $name = $file["name"];
    $type = $file["type"];
    list($sirina, $visina) = getimagesize($tmp);

    if ($profile) {
        $novaSirina = 100;
        $novaVisina = 100;
    } else {
        $novaSirina = $sirina / 2;
        $novaVisina = $visina / 2;
    }
    $prazna = imagecreatetruecolor($novaSirina, $novaVisina);
    $ex = pathinfo($name,PATHINFO_EXTENSION);

    if($ex == "jpeg" || $ex == "jpg") $ex = "jpeg";
    $nazivFormata = "imagecreatefrom". $ex;

    if(function_exists($nazivFormata)){
        $source_image = call_user_func($nazivFormata,$tmp);
    }

    imagecopyresampled($prazna, $source_image, 0, 0, 0, 0, $novaSirina, $novaVisina, $sirina, $visina);

    move_uploaded_file($tmp, $root."assets/images/" . time() . "_" . $name);

    $nazivFunkcije = "image".$ex;

    if(function_exists($nazivFunkcije)){
        call_user_func($nazivFunkcije,$prazna, $root."assets/img/" . time() . "_" . $name);
    }

//    if ($type == 'image/jpeg') {
//        imagejpeg($prazna, $root."assets/img/" . time() . "_" . $name);
//    }
//    if ($type == 'image/png') {
//        imagepng($prazna, $root."assets/img/" . time() . "_" . $name);
//    }

}

function getLoggedUserInfo(){
    global $conn;
    $u_id = $_SESSION["user_id"];
    $getUser = "SELECT * FROM users WHERE user_id = ".$u_id;

    return $conn->query($getUser)->fetch();
}

?>