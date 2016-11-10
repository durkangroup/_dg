<?php get_header(); ?>

<main id="main" class="site-main" role="main">

  <header class="page-header">
    <div class="container">
      <h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', '_pc' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
    </div>
  </header>

  <div class="container">

		<?php if ( have_posts() ) : ?>

			<?php get_template_part( 'template-parts/content', 'search' ); ?>

			<?php the_posts_navigation(); ?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

  </div>
</main>

<?php // get_sidebar(); ?>

<?php get_footer(); ?>
