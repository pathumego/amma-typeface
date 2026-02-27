<?php
/**
 * Template Name: street Template
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

get_header(); ?>

 
<div class="container">






 
<div id= "about" class="row">
<div class="span3"style="position: fixed;">
<div id="page_sidebar">
  <h4>the street</h4>
   A exploration of ethnic devide in graphical elements of a street.
     <div id="blog_sidebar">
        <?php if ( !function_exists('dynamic_sidebar')|| !dynamic_sidebar('blog-sidebar') ) : ?> <?php endif; ?>
      </div>
 	</div>

  </div>
 <div class="span3">
	
  </div>



 <div class="span9">
    <div class="demo-browser-action">
    

<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
				
			<?php endwhile; // end of the loop. ?>

<?php comments_template( '', true ); ?>

       </div>  </div>
 </div>

</div>
	



</div>


	

<?php get_footer(); ?>