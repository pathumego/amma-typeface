<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gallery</title>
<style type="text/css">

	img {clear: both; border:1px solid #333;}

</style>

</head>

<body>

<?php
	// Get all userinputs
	$file_path = "userInput.data";
	$fh = fopen($file_path, 'r') or die("Can't open file dumb fuck");
	$op = '';
	
	while(!feof($fh))
  	{
  		$op .= '<img src="scripts/server-side.php?companyName=' . fgets($fh) . '"> <br/>';
  	}
	
	fclose($fh);
	
	echo $op;
?>

</body>
</html>