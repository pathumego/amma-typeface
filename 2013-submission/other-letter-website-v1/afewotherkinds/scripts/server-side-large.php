<?php
header ("Content-type: image/png");
$phrase = $_GET["phrase"];


$rand_no = rand(0, 10);
$handle = imagecreatefrompng( 'template_' . $rand_no . '.png' );
$brown = ImageColorAllocate ($handle, 84, 48, 26);
$lightBrown = ImageColorAllocate ($handle, 145, 116, 94);
$white = ImageColorAllocate ($handle, 255, 255, 255);
$peach = ImageColorAllocate ($handle, 52, 73, 94);

$lines = explode('|', wordwrap($string, 10, '|'));





//phrase
ImageTTFText ($handle, 60, 0, 20, 150, $white, "otherletter.ttf", $phrase);




imagealphablending( $handle, false );
imagesavealpha( $handle, true );
ImagePng ($handle);
imagedestroy( $handle );

?>