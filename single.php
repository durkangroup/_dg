<?php get_header(); ?>

<main id="main" class="site-main container" role="main">
  <div class="row">

  	<?php while ( have_posts() ) : the_post(); ?>

  		<?php get_template_part( 'template-parts/content', 'single' ); ?>

  		<?php if ( comments_open() || get_comments_number() ) : comments_template(); endif; ?>

      <?php // the_post_navigation(); ?>

  	<?php endwhile; ?>

    <?php get_sidebar(); ?>

  </div>
</main>

<?php get_footer(); ?>
