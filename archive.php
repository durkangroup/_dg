<?php get_header(); ?>

<main id="main" class="site-main" role="main">

  <header class="page-header">
    <div class="container">
      <?php
        the_archive_title( '<h1 class="page-title">', '</h1>' );
        the_archive_description( '<div class="taxonomy-description">', '</div>' );
      ?>
    </div>
  </header>

  <div class="container">

		<?php if ( have_posts() ) : ?>

			<?php	get_template_part( 'template-parts/content', get_post_format() ); ?>

			<?php the_posts_navigation(); ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

  </div>
</main>

<?php // get_sidebar(); ?>

<?php get_footer(); ?>
