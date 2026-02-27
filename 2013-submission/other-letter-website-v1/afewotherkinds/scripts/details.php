<?php
	$name = $_POST['phrase'];
	$rno = $_POST['id'];

	$file = 'texts.txt';
	// Write the contents to the file, 
	// using the FILE_APPEND flag to append the content to the end of the file
	// and the LOCK_EX flag to prevent anyone else writing to the file at the same time
	file_put_contents($file, $name . "\r\n", FILE_APPEND | LOCK_EX);

	echo $row['address'];
?>