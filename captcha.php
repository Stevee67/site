<?php
    session_start();
    $rand = mt_rand(1000, 9999);
    $im = imagecreatetruecolor(90,50);
    $_SESSION["rand"] = $rand;
    $c = imagecolorallocate($im, 255, 255, 255);
    imagettftext($im, 20, -10, 10, 30, $c, "fonts/verdana.ttf", $rand);
    header("Content-type: image/png");
    imagepng($im);
    imagedestroy($im);

?>