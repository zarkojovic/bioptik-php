<?php
define("ROOT_FOLDER","/sajtpraktikum");
define("ABSOLUTE_PATH",$_SERVER["DOCUMENT_ROOT"].ROOT_FOLDER);
define("LOG_FAJL",ABSOLUTE_PATH."/data/log.txt");
define("ENV_FAJL",ABSOLUTE_PATH."/config/.env");


define("SERVER",env("SERVER"));
define("DATABASE",env("DBNAME"));
define("USERNAME",env("USERNAME"));
define("PASSWORD",env("PASSWORD"));

const _PAGES = ["home","shop","about","single","contact","login","register","profile","edit_profile","author","checkout"];
const _ADMIN_PAGES =    ["home","answers_data","answers_edit","answers_insert","articles_data","articles_edit","articles_insert"
                        ,"brands_data","brands_edit","brands_insert","messages_data","nav_data","nav_item_edit","nav_item_insert",
                        "order_data","question_data","question_edit","question_insert","role_data","role_edit","role_insert",
                        "survey_data","tag_data","tag_edit","tag_insert","user_data","user_edit"
                        ];


function env($naziv){
    $open = fopen(ENV_FAJL,"r");
    $podaci = file(ENV_FAJL);
    $vrednost = "";
    foreach ($podaci as $key=>$value){
        $konfig = explode("=",$value);
        if($konfig[0] == $naziv){
            return $konfig[1];
        }
    }
}

$carouselData[] = array(
    "title" => "Men's eyewear <span>Cool summer sale 50% off</span>",
    "link" => "index.php?page=shop",
    "button" => "Shop now",
    "class" => "active"
);
$carouselData[] = array(
    "title" => "Women's eyewear <span>Want to Look Your Best?</span>",
    "link" => "index.php?page=shop",
    "button" => "Shop now",
    "class" => "item2"
);
$carouselData[] = array(
    "title" => "Men's eyewear <span>Cool summer sale 50% off</span>",
    "link" => "index.php?page=shop",
    "button" => "Shop now",
    "class" => "item3"
);
$carouselData[] = array(
    "title" => "Men's eyewear <span>Cool summer sale 50% off</span>",
    "link" => "index.php?page=shop",
    "button" => "Shop now",
    "class" => "item4"
);


$testimonialData[] = array(
    "name" => "Anamaria",
    "role" => "Customer",
    "country" => "USA",
    "comment" => "The Stealth Shadow sunglasses from Bioptik are definitely worth the investment. The sleek design is perfect for any occasion and the polarized lenses make a huge difference in my vision on sunny days."
);
$testimonialData[] = array(
    "name" => "Edward",
    "role" => "Customer",
    "country" => "Canada",
    "comment" => "I recently purchased the Nimbus Horizon sunglasses from Bioptik and they're fantastic. The polarized lenses are incredibly effective at reducing glare and the two-tone frame design looks great. "
);
$testimonialData[] = array(
    "name" => "Maria",
    "role" => "Customer",
    "country" => "Mexico",
    "comment" => "I recently purchased the Eclipse Elite sunglasses from Bioptik and they exceeded my expectations. The combination of the matte black frame and the reflective blue lenses looks amazing and I've received many compliments on them."
);


$featuresData[] = array(
    "icon" => "far fa-hand-paper",
    "title" => "Satisfaction Guaranteed",
    "description" => "At Bioptik, we are committed to providing the highest level of customer satisfaction. We believe in our products and stand behind them with a guarantee of satisfaction to ensure that our customers are completely happy with their purchases.",
    "button" => "Shop Now",
    "href" => "index.php?page=shop"
);
$featuresData[] = array(
    "icon" => "fas fa-rocket",
    "title" => "Fast Shipping",
    "description" => "We understand that our customers are eager to receive their new sunglasses, which is why we prioritize fast and reliable shipping options to ensure that their purchases arrive quickly and in excellent condition.",
    "button" => "Shop Now",
    "href" => "index.php?page=shop"
);
$featuresData[] = array(
    "icon" => "far fa-sun",
    "title" => "UV Protection",
    "description" => "Protecting your eyes from harmful UV rays is crucial for maintaining good eye health, and at Bioptik, we offer a wide range of sunglasses that provide excellent UV protection to safeguard your eyes from the sun's harmful rays.",
    "button" => "Shop Now",
    "href" => "index.php?page=shop"
);

$iconsData[] = array(
    "icon" => "fas fa-gift",
    "title" => "Genuine Product",
    "description" => "At Bioptik, we offer only genuine products."
);
$iconsData[] = array(
    "icon" => "fas fa-shield-alt",
    "title" => "Secure Products",
    "description" => "At Bioptik, we secure our products for safe shipping."
);
$iconsData[] = array(
    "icon" => "fas fa-dollar-sign",
    "title" => "Cash on Delivery",
    "description" => "Bioptik offers cash on delivery for convenience."
);
$iconsData[] = array(
    "icon" => "fas fa-truck",
    "title" => "Easy Delivery",
    "description" => "Bioptik offers easy delivery options for our customers' convenience."
);

$footerIcons[] = array(
    "class" => "fab fa-linkedin-in",
    "href" => "https://www.linkedin.com/in/zarko-jovic-b3b78223a/"
);
$footerIcons[] = array(
    "class" => "fas fa-sitemap",
    "href" => "sitemap.xml"
);
$footerIcons[] = array(
    "class" => "fas fa-file",
    "href" => "dokumentacija.pdf"
);
$teamArray[] = array(
    "name" => "John Smith",
    "picture" => "team1.jpg",
    "description" => "Sales Manager",
);

$teamArray[] = array(
    "name" => "Michael Brown",
    "picture" => "team2.jpg",
    "description" => "Marketing Coordinator",
);

$teamArray[] = array(
    "name" => "Sarah Lee",
    "picture" => "team3.jpg",
    "description" => "Product Development Manager",
);

$teamArray[] = array(
    "name" => "David Nguyen",
    "picture" => "team4.jpg",
    "description" => "Customer Service Representative",
);
$contactArray[] = array(
    "icon" => "far fa-map",
    "title" => "Address",
    "text" => "California, USA"
);

$contactArray[] = array(
    "icon" => "far fa-envelope",
    "title" => "Email",
    "text" => "Email : mail@example.com"
);

$contactArray[] = array(
    "icon" => "fas fa-mobile-alt",
    "title" => "Phone",
    "text" => "+1 234 567 8901"
);

$aboutInfo = array(
    "image" => "banner1.jpg",
    "title" => "About Us",
    "description" => "Bioptik is a rising star in the world of sunglasses. With their commitment to both style and sustainability, they have quickly become a popular choice among fashion-forward consumers who want to look good and feel good about their purchases.",
    "button" => "SHOP NOW",
    "href" => "index.php?page=shop"
);


?>