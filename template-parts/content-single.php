<article <?php post_class('col-sm-8'); ?>>

  <header class="entry-header">
    <h1 class="entry-title"><?php the_title(); ?></h1>
    <div class="entry-meta">
      <time class="updated" datetime="<?php get_the_time('Y-m-j') ?>"><?php echo get_the_time('M. j Y') ?></time>
      <cite class="by-line"><span>by</span> <?php the_author_posts_link(); ?></cite>
    </div>
  </header>

  <?php if ( has_post_thumbnail() ) : ?>
  <figure class="entry-featured">
    <picture>
      <a href="<?php the_permalink(); ?>">
        <?php the_post_thumbnail('post-featured-lg'); ?>
      </a>
    </picture>
  </figure>
  <?php endif; ?>

  <div class="entry-content">
    <?php the_content(); ?>
  </div>

	<footer class="entry-footer" role="contentinfo">
		<?php _dg_entry_footer(); ?>
	</footer>

</article>
