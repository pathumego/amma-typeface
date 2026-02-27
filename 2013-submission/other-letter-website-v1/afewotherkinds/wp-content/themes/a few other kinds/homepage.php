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
<meta property="fb:admins" content="1492908859" />
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

  //     // Load the Google Transliterate API
  //     google.load("elements", "1", {
  //           packages: "transliteration"
  //         });

  //     function onLoad() {
  //       var options = {
  //         sourceLanguage: 'en',
  //         destinationLanguage: ['ta','si'],
  //         shortcutKey: 'ctrl+g',
  //         transliterationEnabled: true
  //       };

  //       // Create an instance on TransliterationControl with the required
  //       // options.
  //       var control =
  //           new google.elements.transliteration.TransliterationControl(options);

  //       // Enable transliteration in the textfields with the given ids.
  //       var ids = [ "phrase"];
  //       control.makeTransliteratable(ids);

  //       // Show the transliteration control which can be used to toggle between
  //       // English and Hindi and also choose other destination language.
  //       control.showControl('translControl');
  //     }
  //     google.setOnLoadCallback(onLoad);

  //   </script>


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
<link href='http://fonts.googleapis.com/css?family=Inconsolata:400,700' rel='stylesheet' type='text/css'>
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
<div class="container">
<div class="container">
</div>

</div>
<div id="sitename">
  <h1>a<br/>few<br/>other<br/>kinds:</h1>

  <h3>
  
  <h3>
   <fb:like href="http://la-ulu.com/afewotherkinds/index.php" layout="button_count" show-faces="false" width="450" action="like" colorscheme="light" />
</div>
<div class="container">
  <div class="demo-headline">
    <h1 class="demo-logo">
    <header>
      <div class="preview hideme"> <img src="http://la-ulu.com/afewotherkinds/scripts/server-side.php" /> </div>
    </header>
    <div class="row demo-row share-row">
      <div class="navbar navbar-inverse hideme">
        <input type="button" class="toplinks sharelink" onclick='javascript:changeText2();showDiv();' value="share on FB" id="enter"/>
        <input id="gal_link" class="toplinks addlink" type='button' onclick='javascript:changeText2();showDiv();' value='add to gallery'/>
        <a href="http://la-ulu.com/afewotherkinds/scripts/server-side.php" class="toplinks show_hide sharelink" id=lnk download="Hybrid" title="Hybrid"></a> <a id="reflectedlink2" class="toplinks downlink"  href="http://la-ulu.com/afewotherkinds/scripts/server-side.php?" download="Hybrid" title="Hybrid">download</a> </div>
      <div id="message">
        <p>image added to <a href="#home_gallery">phrase gallery</a></p>
      </div>
      <script type="text/javascript">

$(document).ready(function() {

    $("#enter").click(function() {
        window.open("http://www.facebook.com/share.php?u=http://la-ulu.com/afewotherkinds/scripts/server-side-large.php?phrase=" + $("#phrase").val());
    });                          
                  
});


</script>
      <script type="text/javascript">

 $(document).ready(function() {
var link= document.getElementById('reflectedlink2');
  
    var input= document.getElementById('phrase');


    input.onchange=input.onkeyup= function() {
        link.search= '?phrase='+encodeURIComponent(input.value);
        link.firstChild.data= link.href;
    };
    });
</script> 
 
    </div>
    <!-- /row --> 
    
  </div>
  <!-- /demo-headline -->
  
  <div class="row demo-row">
    <div id='translControl'></div>
    <fieldset>
      <form id="realtime-form" action="#" method="post">
        <label for="message"></label>

        <input ass="span4" type="text" class="3" id="phrase" name="phrase" maxlength="30" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Type something here / ටයිප් කරන්න / டிபே யுவர் உரை'"placeholder="Type something here / ටයිප් කරන්න / டிபே யுவர் உரை"   >
        </input>
        </input>
      </form>
    </fieldset>
    <br/>
    <!-- keyboard -->
    <p style="text-align:center;">Use SHIFT + 2,3,4.. and {,},[,] for additional symbols (ෙැු/கொ)<br> Click the link for keyboard help</P>
    <div class="example3">
      <h4 class="textcenter">The font uses a phonetic layout.('a' for 'අ' and 'அ') <br/>Vowel modifiers are mapped to the different keys(See the table below)<br/> Unicode support will be added by end of Augest 2013, and you will be able to input test using Google transliterate.</h4>
      <img src="http://la-ulu.com/afewotherkinds/images/keyboard.png">
    </div>
    <!-- keyboard end -->
    
    <div class="row intro_row">
      <div class="span4">
        <div class="demo-text-box prl">
          <p>A Fusion of Sinhala and Tamil Letters<br/><br/>

Harmony is not difficult. We will rejoice living in one world when we learn to see our similarities instead of differences.

Our isolation in our own worlds is a construct of our cultures, not a part of who we are. It is not harmony that is difficult, but understanding the true nature of that which divides us.

<br/><br/>This is a recognition of a linguistic obstacle that separated us as Sinhala and Tamil.
</p>
          <a href="#about" class="slideto">Find out more</a> </div>
      </div>
      <!-- /text box -->
      
      <div class="span4 sinhala">
        <div class="demo-text-box prl">
          <p>සිංහල හා දෙමල  අක්ෂර  දෙමුහුම<br/><br/>

සහජීවනය අපහසු නැත. වෙනස්කම් වෙනුවට සමානකම් දකින්නට හැකිනම් එදිනට අප දෙදෙනාටම එකම ලෝකයක ජීවත් වන්නට හැකිවනු ඇත. 

මම ඔබේ ලොවේත් ඔබ මගේ ලොවෙත් අනෙකෙකු කලේ අප ගොඩනැගූ සංස්කෘතිය මිස ලේ, මස්, ඇට නහර නොවේ. අපහසු වන්නේ සහජීවනය නොව , ඒ බෙදා වෙන්කරන වෙනස්කම් වල සැබෑ ස්වරූපය හඳුනා ගැනීමයි. 

 <br/><br/>මේ සිංහල දෙමල  අප බෙදා වෙන්කළ භාෂාවේ බාධකය හඳුනා ගැනීමක්.</p>
        </div>
      </div>
      <!-- /text box -->
      
      <div class="span4">
        <div class="demo-text-box prl">
          <p>சிங்கள தமிழ் எழுத்துரு இடையேயான தொடர்புகள்<br/><br/>

சமாதானம் இயலாத ஒன்றல்ல. எம்மைச் சூழவுள்ள பொருட்களுக்கிடையே உள்ள வேறுபாடுகளை விடுத்து ஒற்றுமையினை அறிய முற்படுகையில் வாழ்க்கையில்  மகிழ்ச்சி கிடைக்கின்றது. தனித்துவ குழுமங்கள் வெவ்வேறு கலாசார பாரம்பரியத்தினால் கட்டி எழுப்பப்பட்டவை. வேறுபடுவது கலாசாரமே அன்றி நாம் அல்ல. இந்த இயற்கை நியதியைப் புரிந்து கொள்கின்ற பொழுது சமாதானம் இயலாத ஒன்றல்ல.

<br/><br/>இத்தளம் சிங்கள தமிழ் மொழிகளுக்கிடையேயான ஒன்றித்த அம்சங்களை இனங்காணுகின்ற ஒரு தேடல்.</p>
        </div>
      </div>
      <!-- /text box --> 
      
    </div>
    <!-- /row --> 



 <!-- alpahbet -->
    <div class="row intro_row">
     
       <div id='glyph-slider'> <a href="img01_url" target="_blank"> <img src='http://la-ulu.com/afewotherkinds/images/glyph/1.png' > </a> <a href="img01_url" target="_blank"> <img src='http://la-ulu.com/afewotherkinds/images/glyph/2.png' > </a> <a href="img01_url" target="_blank"> <img src='http://la-ulu.com/afewotherkinds/images/glyph/3.png' > </a>  </div>
    </div>
      
    <!-- /alpahbet font --> 
    
  </div>
  <!-- /row --> 



    
    <div class="row intro_row">
      <div class="span4"></div>

      <div class="span4"> 
  
<a href="http://la-ulu.com/afewotherkinds/files/other_letter_glyph_list.ai.zip" download="otherletter" class="btn btn-block btn-warning"><i class="icon-file icon-white"></i> download files</a>
        <div class="example"> <br/>
          <i>You are free:</i> to Share — to copy, distribute and transmit the work or <br/>
          to Remix — to adapt the work
          to make non-commercial use of the work <i>Under the following conditions:</i> Attribution — You must attribute this work to this site (with link)
          <p><br />
          <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/4.0/"><img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-nc-sa/4.0/80x15.png" /></a><br /><span xmlns:dct="http://purl.org/dc/terms/" property="dct:title">Other-Letter</span> by <a xmlns:cc="http://creativecommons.org/ns#" href="http://iampathum.com/" property="cc:attributionName" rel="cc:attributionURL">Pathum Egodawatta</a> is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/4.0/">Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International License</a>.<br />Based on a work at <a xmlns:dct="http://purl.org/dc/terms/" href="http://la-ulu.com/afewotherkinds/" rel="dct:source">http://la-ulu.com/afewotherkinds/</a>.<br />Permissions beyond the scope of this license may be available at <a xmlns:cc="http://creativecommons.org/ns#" href="http://la-ulu.com/afewotherkinds/" rel="cc:morePermissions">http://la-ulu.com/afewotherkinds/</a>.</p>
        </div>
        
    </div>
  
    
  </div>
  <!-- /row --> 
  

  
  <!-- about -->
  <div id= "about" class="row">
    <div class="span9">
      <div class="demo-browser-action">
        <H3>about</h3>
        <p>The ethnic conflicts in Sri Lanka surfaced in a new form as a language problem in 1950’s and eventually it led to a series of unfortunate events which included much political turmoil and a 30 year long war. It is evident that the damage has been done and in the light of peace in Sri Lanka, the ethnic tension continues to grow. 
<br/><br/>This project is not about solving the political problems in the country, but to explore the different graphical aspects of cultural boundaries between ethnicities in Sri Lanka and an attempt to dissolve these boundaries in a selected context.<br/> <br/> 


The main boundary between cultures is  the language and it happens that both sinhala and tamil languages come from the same branch of indic languages. The two ethnicities share many similar pronunciation of words as well. A deeper  look into the visual properties of the two alphabets, and their development prompts that there is a possibility of building a one set of letters to be used for both languages essentially blurring out the language barrier on a different level.</br><br/> 
  

Both the SInhala and Tamil alphabets and writing systems were simplified and changed to accommodate the idea of hybrid letters.  Basically this is a new writing system based on sinhala and tamil that could be easily learnt by the both ethnicities.The second phase of the project is using this developed writing system in an urban street which has a high tamil population density and try and make the street more familiar to a Sinhala audience.<br/> <br/> 
 </p>

      <a href="http://la-ulu.com/afewotherkinds/process"></a>
      </div>
      
    </div>
    <div class="span3">
      
        <?php get_sidebar();?>
    </div>
  </div>
  <!-- /about --> 
    <!-- NAV -->
  
  <div class="row demo-tiles">
    <div class="span3">
      <div class="tile"> <img src="images/icons/Chat@2x.png" alt="Chat@2x" class="tile-image">
        <h3 class="tile-title"></h3>
        <p></p>
        <a href="#process" class="btn btn-block slideto"><b>PROCESS</b></a> </div>
    </div>
    <div class="span3">
      <div class="tile"> <img src="images/icons/Compas@2x.png" alt="Compas@2x" class="tile-image ">
        <h3 class="tile-title"></h3>
        <p></p>
        <a href="#research" class="btn btn-block slideto"><b>RESEARCH</b></a> </div>
    </div>
    <div class="span3">
      <div class="tile"> <img src="images/icons/Pensils@2x.png" alt="Pensils@2x" class="tile-image">
        <h3 class="tile-title"></h3>
        <p></p>
        <a href="#home_discussion" class="btn btn-block slideto"><b>DISCUSSION</b></a> </div>
    </div>
    <div class="span3">
      <div class="tile tile"> <img src="images/icons/Infinity-Loop@2x.png" alt="Infinity-Loop@2x" class="tile-image">
        <h3 class="tile-title"></h3>
        <p></p>
        <a href="#home_gallery" class="btn btn-block slideto"><b>PHRASE GALLERY</b></a> </div>
    </div>
  </div>
  <!-- /Nav--> 
  <!-- Process -->
  
  <div id= "street" class="row">
    <div class="span9 homeslider">
  <img src="images/street.png"> 
</div>
    <div class="span3">
      <H3>street</h3>
        <p>Explore how ethnic divde is created in a street with graphic elements, and try to blur them out. <br/><br/><a href="http://la-ulu.com/afewotherkinds/letters/">see the project&nbsp;&rarr;</a><br/><br/><a class="slideto" href="#process">process&nbsp;&darr;</a></p>
    </div>
  </div>
  <!-- /Process --> 
  <!-- Process -->
  
  <div id= "process" class="row">
    <div class="span9 homeslider">
       <img src='http://la-ulu.com/afewotherkinds/images/proccess/1.png' >
    </div>
    <div class="span3">
      <H3>process</h3>
        <p>scrappy draft notes, sketches, screenshots and user testing photographs<br/><br/><a href="http://la-ulu.com/afewotherkinds/process">see everything&nbsp;&rarr;</a><br/><br/><a class="slideto" href="#research">research&nbsp;&darr;</a></p>
    </div>
  </div>
  <!-- /Process --> 
  
  <!-- research -->
  
  <div id= "research" class="row">
    <div class="span9 homeslider">
      <img src='http://la-ulu.com/afewotherkinds/images/proccess/4.png' >  
    </div>
    <div class="span3">
      <H3>research</h3>
      <p>documents, links, references and user research material.<br/><br/><a href="http://la-ulu.com/afewotherkinds/research">see everything&nbsp;&rarr;</a><br/><br/><a class="slideto" href="#home_gallery">galleryh&nbsp;&darr;</a></p>
   
    </div>
  </div>
  <!-- /research --> 
 <!-- gallery -->
  <div id="home_gallery" class="row">
    <div class="span9 homeslider">
       <div id="blog_sidebar">
        
      </div>
  <?php
    // Get all userinputs
    $file_path = "userInput.data";
    $fh = fopen($file_path, 'r') or die("can't open file");
    $op = '';
    
    while(!feof($fh))
      {
        $op .= '<img src="scripts/server-side-large.php?phrase=' . fgets($fh) . '">';
      }
    
    fclose($fh);
    
    echo $op;
    ?>
    </div>
    <div class="span3">
      <H3>gallery</h3>
          <p>collection of messages by users typed using "otherletter" typeface.<br/><br/><a href="http://la-ulu.com/afewotherkinds/gallery.php">see everything&nbsp;&rarr;</a><br/><br/><a class="slideto" href="#home_gallery">discussion&nbsp;&darr;</a></p>
   
    </div>
  </div>
  <!-- /gallery --> 
   <!-- discussion -->
  <div id="home_discussion" class="row">
    <div class="span9 homeslider">
       <div id="blog_sidebar">
        <?php if ( !function_exists('dynamic_sidebar')|| !dynamic_sidebar('cart-sidebar') ) : ?> <?php endif; ?>
      </div>
 
    </div>
    <div class="span3">
      <H3>discussion</h3>
<p>comments , feedback and discussion, add a comment or see what others think<br/><br/> <a href="http://la-ulu.com/afewotherkinds/discussion">see everything&nbsp;&rarr;</a></p>
   
    </div>
  </div>
  <!-- /discussion --> 
</div>
<!-- /container -->
</div>

<?php get_footer(); ?>