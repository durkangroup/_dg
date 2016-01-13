<?php while ( have_posts() ) : the_post(); ?>

  <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  	<header class="entry-header">
  		<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>

  		<?php if ( 'post' == get_post_type() ) : ?>
  		<div class="entry-meta">
  			<?php _dg_posted_on(); ?>
  		</div>
  		<?php endif; ?>
  	</header>

  	<div class="entry-summary">
  		<?php the_excerpt(); ?>
  	</div>

  	<footer class="entry-footer">
  		<?php _dg_entry_footer(); ?>
  	</footer>
  </article>

<?php endwhile; ?>