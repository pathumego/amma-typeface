<?php
header ("Content-type: image/png");
$phrase = $_GET["phrase"];
$companySlogan = $_GET["companySlogan"];
$fullName = $_GET["fullName"];
$jobTitle = $_GET["jobTitle"];
$businessAddress = $_GET["businessAddress"];
$businessAddress = str_replace("\\n","\n",$businessAddress);
$businessAddress = str_replace("\\","",$businessAddress);
$phoneOne = $_GET["phoneOne"];
$phoneTwo = $_GET["phoneTwo"];
$emailAddress = $_GET["emailAddress"];
$siteUrl = $_GET["siteUrl"];

$rand_no = rand(0, 10);
$handle = imagecreatefrompng( 'template_' . $rand_no . '.png' );
$brown = ImageColorAllocate ($handle, 84, 48, 26);
$lightBrown = ImageColorAllocate ($handle, 145, 116, 94);
$white = ImageColorAllocate ($handle, 255, 255, 255);
$peach = ImageColorAllocate ($handle, 52, 73, 94);

$lines = explode('|', wordwrap($string, 10, '|'));


//company name


//company slogan
ImageTTFText ($handle, 45, 0, 20, 150, $white, "otherletter.ttf", $phrase);

//full name
ImageTTFText ($handle, 14, 0, 20, 110, $white, "times.ttf", $fullName);

//job title
ImageTTFText ($handle, 9, 0, 19, 122, $peach, "GOTHIC.TTF", $jobTitle);

//business address
ImageTTFText ($handle, 10, 0, 20, 160, $brown, "GOTHIC.TTF", $businessAddress);

//phone number #1
ImageTTFText ($handle, 9, 0, 317, 160, $brown, "GOTHIC.TTF", $phoneOne); 

//phone number #2
ImageTTFText ($handle, 9, 0, 317, 175, $brown, "GOTHIC.TTF", $phoneTwo);

//email address
ImageTTFText ($handle, 9, 0, 275, 190, $brown, "GOTHIC.TTF", $emailAddress);

//site url (exmple of how to center copy)
// $fontSize = "40";
// $width = "940";
// $textWidth = $fontSize * strlen($phrase);
// $position_center = $width / 2 - $textWidth / 2.6;
// $quality = 95;
// ImageTTFText ($handle, $fontSize, 0, $position_center, 150, $white, "83repulsion.ttf", $phrase);



imagealphablending( $handle, false );
imagesavealpha( $handle, true );
ImagePng ($handle);
imagedestroy( $handle );

?>