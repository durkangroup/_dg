<div class="page-content">
	<?php the_content(); ?>
	<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', '_dg' ),
			'after'  => '</div>',
		) );
	?>
</div>

<footer class="page-footer">
</footer>