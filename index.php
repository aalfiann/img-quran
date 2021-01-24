<?php
header('Content-Type: application/json');

$sub_dir = "img-quran";     // Leave blank if you upload this file in root public_html

/**
 * Determine server protocol (support flexible SSL cloudflare)
 * @return bool
 */
function isHttps() {
    $whitelist = array(
        '127.0.0.1',
        '::1'
    );
    
    if(!in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
        if (!empty($_SERVER['HTTP_CF_VISITOR'])){
            return isset($_SERVER['HTTPS']) ||
            ($visitor = json_decode($_SERVER['HTTP_CF_VISITOR'])) &&
            $visitor->scheme == 'https';
        } else {
            return isset($_SERVER['HTTPS']);
        }
    } else {
        return 0;
    }
}

$web = ((isHttps())?'https://':'http://').$_SERVER['SERVER_NAME']."/".$sub_dir;

$data = [
    "cover" => $web."/img/holy-quran-standard-english-001.jpg",
    "title" => "The Holy Qur'an - Arabic Text and English Transalation",
    "release_date" => "2015",
    "translator" => "Maulawi Sher 'Ali",
    "language" => "Arabic and English",
    "description" => "Published by Islam International Publications Ltd.\nIslamabad, Sheephatch Lane.\nTilford, Surrey GU 10 2AQ\nUK",
    "download" => $web."/Holy-Quran-English.pdf"
];

$images = [];
for($i =0; $i< 836;$i++) {
    $num = str_pad(($i+1), 3, '0', STR_PAD_LEFT);
    $images[$i] = $web."/img/holy-quran-standard-english-".$num.".jpg";
}
$data['images'] = $images;

echo  json_encode($data);