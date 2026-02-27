<?php
/**
 * Template Name: Process Template
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

<div id="about" class="row">

 <div class="span3"style="position: fixed;">
<div id="page_sidebar">
   Explore the development of the "otherkind" typeface.
     
 <div id="blog_sidebar">
        <?php if ( !function_exists('dynamic_sidebar')|| !dynamic_sidebar('blog-sidebar') ) : ?> <?php endif; ?>
      </div>
  </div>
</div>
 <div class="span3">
   
  </div>


  <div class="span9">
    <div class="demo-browser-action">
    

<?php if(have_posts()) : ?>
<?php while(have_posts()) : the_post(); ?>
<br><br>
<div class="content_slim">
  <ul>
    <?php
        $args = array( 'numberposts' => 20);
        $lastposts = get_posts( $args );
        foreach($lastposts as $post) : setup_postdata($post); ?>
    <div class='story'>
      <h3>
        <?php the_title(); ?>
        </h3>
      <?php the_content(); ?>
    </div>
    <?php endforeach; ?>
  </ul>
  <?php edit_post_link(__('[Edit this page]'), '<br />', ''); ?>
</div>
<?php endwhile; ?>
<?php else : ?>



       </div>
  </div>

 
</div>
<!-- /download area -->





<h1>
  <?php _e("Sorry, but you are looking for something that isn&#8217;t here."); ?>
</h1>
<?php endif; ?>
</div></div></div>
<!-- #primary -->

<?php get_footer(); ?>