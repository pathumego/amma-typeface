
Base color
<?php $controls->color('theme_color'); ?> (format #RRGGBB)
<br><br>
Banner/Title
<?php $controls->wp_editor('theme_banner'); ?>
<div class="hints">
    Create a content with an image (500 pixel wide) that will be your newsletter banner and that will replace the 
    title with your blog name.
</div>
<br>
<?php $controls->checkbox('theme_posts', 'Add latest posts'); ?>
<br>
<?php $controls->checkbox('theme_thumbnails', 'Add post thumbnails'); ?>
<br>
<?php $controls->checkbox('theme_excerpts', 'Add post excerpts'); ?>
<br><br>
Categories
<?php $controls->categories_group('theme_categories'); ?>
<br><br>
Tags
<?php $controls->text('theme_tags', 30); ?> (comma separated)
<br><br>
Max posts
<?php $controls->text('theme_max_posts', 5); ?>   
<br><br>
Post types to include
<br> 
<?php $controls->post_types('theme_post_types'); ?>
<div class="hints">Leave all uncheck for a default behavior.</div>
