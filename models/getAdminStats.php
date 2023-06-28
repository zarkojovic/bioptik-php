<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
//    echo "startt";
    $file = file("../data/log.txt");
    $pages = ['home', 'shop', 'profile', 'edit_profile', 'about', 'author', 'single', 'contact', 'checkout'];

    $stats = [];

    foreach ($pages as $page){
        $stats[$page] = 0;
    }

    foreach ($file as $data) {
        $elems = explode("\t", $data);

        $timeChecked = strtotime($elems[2]);
        $twentyFourHoursAgo = strtotime('-24 hours'); // Timestamp for 24 hours ago

        if ($timeChecked > $twentyFourHoursAgo) {

            foreach ($pages as $page){
                if (str_contains($data, $page)) {
                    $stats[$page]++;
                }
            }
        }
    }

    echo json_encode($stats);

} else {
    http_response_code(404);
}