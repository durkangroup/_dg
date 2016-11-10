<?php get_header(); ?>

<header id="aspot" class="post-header" data-height="half">
  <div class="bg-img" style="background-image: url('<?php echo get_field('cover_image')['sizes']['article-cover']; ?>');"></div>
  <div class="inner">
    <div class="container vert-center">
      <div class="row">

        <div class="col-md-10 col-md-offset-1 col-title">
          <h1 class="post-title"><?php the_title(); ?></h1>
        </div>

      </div>
    </div>
  </div>
</header>

<main id="main" data-page="page-article">

  <?php while ( have_posts() ) : the_post(); ?>

  <article <?php post_class(); ?>>

    <cite class="by-line">
      <span>by</span> <?php the_author_meta('first_name'); ?> <?php the_author_meta('last_name'); ?> - <time class="updated" datetime="<?php get_the_time('Y-m-j') ?>"><?php echo get_the_time('M j Y') ?></time>
    </cite>

    <div class="post-content">

      <?php the_content(); ?>

    </div>

    <footer class="post-footer">
      <?php // _pc_entry_footer(); ?>
    </footer>

  </article>

  <?php endwhile; ?>

</main>

<?php // get_sidebar(); ?>

<?php get_footer(); ?>
