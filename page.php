<?php get_header(); ?>

<main id="main" class="site-main container" role="main">
  <div id="primary" class="content-area">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'template-parts/content', 'page' ); ?>

		<?php endwhile; ?>

  </div>
</main>

<?php // get_sidebar(); ?>

<?php get_footer(); ?>
