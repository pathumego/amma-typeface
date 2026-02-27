<?php
/**
 * Template Name: Unicode Template
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in Twenty Twelve consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

 ?>
 <?php
/**
 * Template Name: Home Page
 */

?>
<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="utf-8">
<title>A Few Other Kinds</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="සිංහල හා දෙමල  අක්ෂර  දෙමුහුම - சிங்கள தமிழ் எழுத்துரு இடையேயான தொடர்புகள் - A Fusion of Sinhala and Tamil Letters - Exploring the boundries that divde us. Living the fantasy of breaking them down. Doing what we can to realize that fantasy">
<meta name="author" content="">
<meta property="og:image" content="http://la-ulu.com/afewotherkinds/images/avatar.png"/>
<meta property="og:title" content="A Few Other Kinds"/>
<meta property="og:description" content="සිංහල හා දෙමල  අක්ෂර  දෙමුහුම - சிங்கள தமிழ் எழுத்துரு இடையேயான தொடர்புகள் - A Fusion of Sinhala and Tamil Letters - சிங்கள தமிழ் எழுத்துரு இடையேயான தொடர்புகள் - Exploring the boundries that divde us. Living the fantasy of breaking them down. Doing what we can to realize that fantasy /සහජීවනය අපහසු නැත. වෙනස්කම් වෙනුවට සමානකම්  දකින්නට හැකිනම් එදිනට අප දෙදෙනාටම  එකම ලෝකයක ජීවත් වන්නට හැකිවනු ඇත"/>
<meta property="og:site_name" content="A Few Other Kinds"/>
<meta property="og:type" content="website"/>
<meta itemprop="name" content="A Few Other Kinds">
<meta itemprop="description" content="සිංහල හා දෙමල  අක්ෂර  දෙමුහුම - சிங்கள தமிழ் எழுத்துரு இடையேயான தொடர்புகள் - A Fusion of Sinhala and Tamil Letters - சிங்கள தமிழ் எழுத்துரு இடையேயான தொடர்புகள் -  Exploring the boundries that divde us. Living the fantasy of breaking them down. Doing what we can to realize that fantasy /සහජීවනය අපහසු නැත. වෙනස්කම් වෙනුවට සමානකම්  දකින්නට හැකිනම් එදිනට අප දෙදෙනාටම  එකම ලෝකයක ජීවත් වන්නට හැකිවනු ඇත">
<meta itemprop="image" content="http://la-ulu.com/afewotherkinds/images/avatar.png">

<script src="http://la-ulu.com/afewotherkinds/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="http://la-ulu.com/afewotherkinds/scripts/client-side.js"></script>
<script type="text/javascript" src="http://la-ulu.com/afewotherkinds/scripts/charCount.js"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>

  <script type="text/javascript">

      // Load the Google Transliterate API
      google.load("elements", "1", {
            packages: "transliteration"
          });

      function onLoad() {
        var options = {
          sourceLanguage: 'en',
          destinationLanguage: ['ta','si'],
          shortcutKey: 'ctrl+g',
          transliterationEnabled: true
        };

        // Create an instance on TransliterationControl with the required
        // options.
        var control =
            new google.elements.transliteration.TransliterationControl(options);

        // Enable transliteration in the textfields with the given ids.
        var ids = [ "transl2" ];
        control.makeTransliteratable(ids);

        // Show the transliteration control which can be used to toggle between
        // English and Hindi and also choose other destination language.
        control.showControl('translControl');
      }
      google.setOnLoadCallback(onLoad);

    </script>


<script language="JavaScript">
function showDiv() {
   document.getElementById('message').style.display = "block";
}

</script>
<SCRIPT TYPE="text/javascript">

$(document).ready(
    function(){
        $("#phrase").focus(function () {
            $(".hideme").slideDown("slow");;
        });

    });
</SCRIPT>
<script type="text/javascript">
 $(function() {
    $('a.slideto').bind('click',function(event){
        var $anchor = $(this);
 
        $('html, body').stop().animate({
            scrollTop: $($anchor.attr('href')).offset().top
        }, 1000,'easeInOutExpo');
        /*
        if you don't want to use the easing effects:
        $('html, body').stop().animate({
            scrollTop: $($anchor.attr('href')).offset().top
        }, 1000);
        */
        event.preventDefault();
    });
});
</script>
<script type="text/javascript">
$(document).ready(function(){ 
    $('.example3').hide().before('<h5 class="textcenter"><a href="#" id="toggle-example3" class="button">keyboard support&nbsp;&#8597;</a></h5');
  $('a#toggle-example3').click(function() {
    $('.example3').slideToggle(1000);
    return false;
  });
});
</script>
<script type="text/javascript">
$(document).ready(function(){ 
    $('.example').hide().before('<h4 class="textcenter">its free to share and&nbsp;<a href="#" id="toggle-example" class="button">re-produce!</a>&nbsp;</h4');
  $('a#toggle-example').click(function() {
    $('.example').slideToggle(1000);
    return false;
  });
});
</script>


<!-- Hide share buttons when input empty -->

<script type="text/javascript">
$(document).ready(function() {

    if($('#phrase').val() == '' ){$('.navbar').hide();}  

    $('#phrase').on('change' , function() {

         if( this.value != ''){

               $('.hideme').show(); 
          }
          else{
               $('.hideme').hide(); 
         }
    });
  });
    </script>

<!-- Charactor counter -->

<script type="text/javascript">
  $(document).ready(function(){ 
   
    //custom usage
    $(".3").charCount({
      allowed: 30,    
      warning: 5,
      counterText: ' '  
    });
  });
</script>


<!-- download link creator -->
<script type="text/javascript">

function changeText2(){
    var userInput = document.getElementById('phrase').value;
    var lnk = document.getElementById('lnk');
    lnk.href = "http://la-ulu.com/afewotherkinds/scripts/server-side.php?phrase=" + userInput;
    lnk.innerHTML = lnk.href;


//save output
  ajax_output( userInput );
}

function ajax_output( parm )
{
  var ajax_data = {
    user_input: parm,
    ajax: '1'
  };
  
  $.ajax({
    url: "ajax.php",
    type: 'POST',
    data: ajax_data,
    success: function(msg) {
      //alert(msg);
    }
  });
}
</script>
<!-- slider -->
<script type="text/javascript">
  $(document).ready(function() {
    $('#glyph-slider').coinslider({ width: 960,height: 500, navigation: false, delay: 55, links : false, effect: 'fadeout',hoverPause: false, });
  });
</script>

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
img {
  border:none;
}
</style>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-42452049-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
<body>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=557750137576961";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-42452049-1', 'la-ulu.com');
  ga('send', 'pageview');

</script>
</head>
<body>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=213549262128546";
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
  Share your opinions, ideas and feedback on this project. Take the readbility test and help to develop the typeface further.
  <a href="mailto:someone@example.com?Subject=Few%20other%20Kinds" target="_blank">Or drop a mail </a>
     <div id="blog_sidebar">
        <?php if ( !function_exists('dynamic_sidebar')|| !dynamic_sidebar('blog-sidebar') ) : ?> <?php endif; ?>
      </div>
 	</div>

  </div>
 <div class="span3">
	
  </div>



 <div class="span9">
    <div class="demo-browser-action">
    <div id='translControl'></div>
   
    <br><br><textarea id="transl2" style="width:600px;height:200px"></textarea>
    
    
 </div>

</div>
	



</div>


	

<?php get_footer(); ?>