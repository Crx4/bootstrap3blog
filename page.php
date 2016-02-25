<?php get_header(); ?>
      <div class="row">
		<div class="blog-header">
			<h1 class="blog-title"><?php the_title(); ?></h1>
			<p class="lead blog-description"><?php the_time( 'F d, Y' ); ?></p>
		</div>
        <div class="col-lg-12 blog-main">
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<div class="blog-post">
						<?php the_content(); ?>
					</div><!-- /.blog-post -->
				<?php endwhile; ?>
					<nav>
						<ul class="pager">
						  <li><?php previous_post_link( '%link', 'Previous' ); ?></li>
						  <li><?php next_post_link( '%link', 'Next' ); ?></li>
						</ul>
					</nav>
				<?php else :
			endif; ?>
        </div><!-- /.blog-main -->		
      </div><!-- /.row -->
<?php get_footer(); ?>