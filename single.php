<?php get_header(); ?>

<main id="main" class="site-main" role="main">

  <header class="page-header">
    <div class="container">
      <h1 class="page-title"><?php echo get_the_title( get_option( 'page_for_posts' )); ?></h1>
    </div>
  </header>

  <div class="container">

  	<?php while ( have_posts() ) : the_post(); ?>

  		<?php get_template_part( 'template-parts/content', 'single' ); ?>

  		<?php if ( comments_open() || get_comments_number() ) : comments_template(); endif; ?>

      <?php // the_post_navigation(); ?>

  	<?php endwhile; ?>

  </div>
</main>

<?php // get_sidebar(); ?>

<?php get_footer(); ?>
