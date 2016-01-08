<?php get_header(); ?>

<main id="main" class="site-main container" role="main">
  <div id="primary" class="content-area row">

    <div id="content" class="col-lg-8 col-lg-offset-2 col-sm-10 col-sm-offset-1">

  		<?php if ( have_posts() ) : ?>

  			<header class="page-header">
  				<?php
  					the_archive_title( '<h1 class="page-title">', '</h1>' );
  					the_archive_description( '<div class="taxonomy-description">', '</div>' );
  				?>
  			</header>

  			<?php while ( have_posts() ) : the_post(); ?>

  				<?php	get_template_part( 'template-parts/content', get_post_format() ); ?>

  			<?php endwhile; ?>

  			<?php the_posts_navigation(); ?>

  		<?php else : ?>

  			<?php get_template_part( 'template-parts/content', 'none' ); ?>

  		<?php endif; ?>

    </div>

  </div>
</main>

<?php // get_sidebar(); ?>

<?php get_footer(); ?>
