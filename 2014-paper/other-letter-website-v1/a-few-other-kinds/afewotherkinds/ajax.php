<?php
$ajax = $_POST['ajax'];

if ( $ajax == '1' )
{
	$user_input = $_POST['user_input'];
	echo '$$ ' . $user_input . ' $$';
	
	//write text file
	$file_path = "userInput.data";
	
	$fh = fopen($file_path, 'a') or die("can't open file");
	
	//$str = "\r\n";
	$str = $user_input . "\r\n";
	
	fwrite($fh, $str);
	fclose($fh);


}

// EOF.