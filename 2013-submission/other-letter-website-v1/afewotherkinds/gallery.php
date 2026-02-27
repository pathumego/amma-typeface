<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8">
<title>Gallery -A Few Other Kinds-</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Exploring the boundries that divdes us. Living the fantasy of breaking them down. Doing what we can to realize that fantasy">
<meta name="author" content="A Few Other Kinds">
<meta property="og:image" content="http://la-ulu.com/afewotherkinds/images/avatar.png"/>
<meta property="og:title" content="Gallery/A Few Other Kinds"/>
<meta property="og:description" content="Exploring the boundries that divdes us. Living the fantasy of breaking them down. Doing what we can to realize that fantasy /සහජීවනය අපහසු නැත. වෙනස්කම් වෙනුවට සමානකම්  දකින්නට හැකිනම් එදිනට අප දෙදෙනාටම  එකම ලෝකයක ජීවත් වන්නට හැකිවනු ඇත"/>
<meta property="og:site_name" content="A Few Other Kinds"/>
<meta property="og:type" content="website"/>
<meta itemprop="name" content="A Few Other Kinds">
<meta itemprop="description" content="Exploring the boundries that divdes us. Living the fantasy of breaking them down. Doing what we can to realize that fantasy /සහජීවනය අපහසු නැත. වෙනස්කම් වෙනුවට සමානකම්  දකින්නට හැකිනම් එදිනට අප දෙදෙනාටම  එකම ලෝකයක ජීවත් වන්නට හැකිවනු ඇත">
<meta itemprop="image" content="http://la-ulu.com/afewotherkinds/images/avatar.png">

<script src="http://la-ulu.com/afewotherkinds/js/jquery-1.8.3.min.js"></script> 
<script type="text/javascript" src="http://la-ulu.com/afewotherkinds/scripts/client-side.js"></script>
<script type="text/javascript" src="http://la-ulu.com/afewotherkinds/scripts/charCount.js"></script>
<!-- Loading Bootstrap -->
<link href="http://la-ulu.com/afewotherkinds/bootstrap/css/bootstrap.css" rel="stylesheet">

<!-- Loading Flat UI -->
<link href="http://la-ulu.com/afewotherkinds/css/flat-ui.css" rel="stylesheet">
<link rel="shortcut icon" href="http://la-ulu.com/afewotherkinds/images/favicon.ico">
<link href="http://la-ulu.com/afewotherkinds/css/keyboard_style.css" rel="stylesheet">
<link rel="stylesheet" href="http://la-ulu.com/afewotherkinds/css/coin-slider-styles.css" type="text/css" />
<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
    <![endif]-->
<style type="text/css">

	

</style>

</head>

<body>

  <script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=557750137576961";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
  
<div id="sitename">
  <h1>a<br/>few<br/>other<br/>kinds:</h1>

  <h3>
  
  <h3>
   <fb:like href="http://la-ulu.com/afewotherkinds/index.php" layout="button_count" show-faces="false" width="450" action="like" colorscheme="light" />

 </div>
<div class="container">

<div id= "about" class="row">
<div class="span3"style="position: fixed;">

  <div id="page_sidebar">
   A gallery of all the messages shared on facebook by users.
     <div id="blog_sidebar">
        <?php if ( !function_exists('dynamic_sidebar')|| !dynamic_sidebar('blog-sidebar') ) : ?> <?php endif; ?>
      </div>
 	</div>
 </div>

<div class="span3">

 </div>



	<div id="gallery" class="span9">
	    <div class="demo-browser-action">

		<?php
		// Get all userinputs
		$file_path = "userInput.data";
		$fh = fopen($file_path, 'r') or die("can't open file");
		$op = '';
		
		while(!feof($fh))
	  	{
	  		$op .= '<img src="scripts/server-side.php?phrase=' . fgets($fh) . '">';
	  	}
		
		fclose($fh);
		
		echo $op;
		?>
		</div>
	</div>
</div>
</div>
</body>
</html>