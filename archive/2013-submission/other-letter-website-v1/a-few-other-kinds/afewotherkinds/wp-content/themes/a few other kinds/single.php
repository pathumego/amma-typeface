<?php
/**
 * The Template for displaying all single posts.
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
  Promotional posters and type specimens.
     <div id="blog_sidebar">
        <?php if ( !function_exists('dynamic_sidebar')|| !dynamic_sidebar('blog-sidebar') ) : ?> <?php endif; ?>
      </div>
 	</div>

  </div>
 <div class="span3">
	
  </div>


 <div class="span9">
    <div class="demo-browser-action">


	
 <div class="content_slim">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', get_post_format() ); ?>

				<nav class="nav-single">
					<h3 class="assistive-text"><?php _e( '', 'twentytwelve' ); ?></h3>
					<span class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'twentytwelve' ) . '</span> %title' ); ?></span>
					<span class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'twentytwelve' ) . '</span>' ); ?></span>
				</nav><!-- .nav-single -->

				<?php comments_template( '', true ); ?>

			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->


       </div>  </div>
 </div>

</div>
	



</div>

<?php get_footer(); ?>