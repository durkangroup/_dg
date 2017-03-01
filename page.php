<?php get_header(); ?>

<main id="main" class="site-main" role="main">

  <header class="page-header">
    <div class="container">
      <h1 class="page-title"><?php the_title(); ?></h1>
    </div>
  </header>

  <div class="container">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'template-parts/content', 'page' ); ?>

		<?php endwhile; ?>

  </div>
</main>

<?php get_footer(); ?>
