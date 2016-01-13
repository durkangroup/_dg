<?php get_header(); ?>

<main id="main" class="site-main" role="main">

  <header class="page-header">
    <div class="container">
      <h1 class="page-title"><?php if( is_home() && get_option( 'page_for_posts' ) ) echo get_the_title( get_option( 'page_for_posts' ) ); ?></h1>
    </div>
  </header>

  <div class="container">

  	<?php if ( have_posts() ) : ?>

  		<?php get_template_part( 'template-parts/content', get_post_format() ); ?>

  		<?php the_posts_navigation(); ?>

  	<?php else : ?>

  		<?php get_template_part( 'template-parts/content', 'none' ); ?>

  	<?php endif; ?>

  </div>
</main>

<?php // get_sidebar(); ?>

<?php get_footer(); ?>
