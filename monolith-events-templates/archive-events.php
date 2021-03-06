<?php
/*
 *
 * Simple Events archive view
*/
?>


<?php get_header() ?>

<?php
$today = date('Ymd');

$args = array(
	'post_type' => 'events',
	'posts_per_page' => -1,
	'order' => 'ASC',
	'orderby' => 'meta_value_num',
	'meta_key' => 'date',
	'meta_query' => array(
		array(
			 'key' => 'date',
             'value' => $today,
             'compare' => '>='
		)
	)
);

query_posts($args); ?>


<div class="wrapper-main" role="main">

	<div class="<?= CONTAINER_CLASSES; ?>">

		<? get_template_part('parts/breadcrumb'); // load breadcrumb ?>

		<div class="<?= ROW_CLASSES ?>">

			<div class="<?= MAIN_SIZE ?>">

				<header class="page-header archive-header" itemprop="name">

					<h1 class="archive-title h1">Upcoming Events</h1>

				</header>

					<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>



							<? // markup for post snippet, used in loops and queries ?>
							<article itemscope itemtype="http://schema.org/Event" <?php post_class(); ?>>

								<header class="event-title">
									<h2 class="event-headline" itemprop="name"><a href="<?= get_permalink() ?>" title="<?php the_title(); ?>" class="post-permalink" itemprop="url"><?php the_title(); ?></a></h2>
								</header>

								<section class="event-excerpt">
									<p itemprop="description"><?= get_the_excerpt(); ?></p>
								</section>

								<section class="event-detail">

									<? // See if we have dates to play with and if we do make them the correct date format ?>
									<?php if(get_field('start_date')) : ?>
										<? $start_date = DateTime::createFromFormat('Ymd', get_field('start_date')); ?>
									<?php endif; ?>
									
									<?php if(get_field('date')) : ?>
										<? $date = DateTime::createFromFormat('Ymd', get_field('date')); ?>
									<?php endif; ?>
									
									<? // if the event start and end date is the same or there is no start date just render the end date ?>
									<?php if($start_date == $date || $start_date == 0) : ?>
										<p class="event-date-detail"><?php echo $date->format('D, d F Y'); ?></p>
										
									<? // else if we have a start and end date (this is a multi day event) then render both dates ?>	
									<?php else : ?>
										<p class="event-date-detail"><?php echo $start_date->format('D, d F Y'); ?> - <?php echo $date->format('D, d F Y'); ?></p>
									<?php endif; ?>

								  	<?php if(get_field('time')) : ?>
									    <p><strong>Time</strong></p>
									    <p><?php the_field('time') ?></p>
									<? endif; ?>
								  	<?php if(get_field('venue_name')) : ?>
									    <p><strong>Venue</strong></p>
									    <p><?php the_field('venue_name') ?></p>
								    <? endif; ?>
								  	<?php if(get_field('city')) : ?>
									    <p><strong>City</strong></p>
									    <p><?php the_field('city') ?></p>
								    <? endif; ?>
								  	<?php if(get_field('country')) : ?>
									    <p><strong>Country</strong></p>
									    <p><?php the_field('country') ?></p>
								    <? endif; ?>


								</section>

								<footer class="event-footer">
									<?php get_template_part('parts/meta/readmore'); ?>
								</footer> <!-- end article footer -->

							</article>
							<hr/>


					<?php endwhile; ?>

					<? elseif ( is_search() ) : // display an error if no search results are found ?>
						<div class="alert">No results found for '<?php echo get_search_query(); ?>'</div>
					<? else : ?>
						<div class="alert">There are no posts to display.</div>
					<?php endif; ?>

					<?php get_template_part('parts/pagination') // load the pagination part ?>

			</div><!-- MAIN_SIZE -->

			<? get_template_part('parts/sidebar'); // right sidebar ?>

		</div><!-- /ROW_CLASSES -->

	</div><!-- /CONTAINER_CLASSES -->

</div><!-- /main -->

<?php get_footer() ?>