<?php
/* The main template file */

get_header(); ?>

      <div class="blog-header">
        <h1 class="blog-title"><?php bloginfo( 'name' ); ?></h1>
        <p class="lead blog-description"><?php bloginfo( 'description' ); ?></p>
      </div>

      <div class="row">

        <div class="col-sm-8 blog-main">
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<div class="blog-post">
						<h2 class="blog-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<p class="blog-post-meta"><?php the_time( 'F d, Y' ); ?> by <a href="<?php the_author_link(); ?>"><?php the_author(); ?></a></p>
						<?php the_excerpt(); ?>
					</div><!-- /.blog-post -->
				<?php endwhile; ?>
				<?php else :
				
			endif; ?>

        </div><!-- /.blog-main -->
		
		<?php get_sidebar(); ?>
		
      </div><!-- /.row -->

<?php get_footer(); ?>