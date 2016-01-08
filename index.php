<?php get_header(); ?>

<main id="main" class="site-main container" role="main">
  <div class="row">
    <div id="content" class="col-sm-8">

    	<?php if ( have_posts() ) : ?>

    		<?php while ( have_posts() ) : the_post(); ?>

    			<?php get_template_part( 'template-parts/content', get_post_format() ); ?>

    		<?php endwhile; ?>

    		<?php the_posts_navigation(); ?>

    	<?php else : ?>

    		<?php get_template_part( 'template-parts/content', 'none' ); ?>

    	<?php endif; ?>

      <?php get_sidebar(); ?>

    </div>
  </div>
</main>

<?php // get_sidebar(); ?>

<?php get_footer(); ?>
