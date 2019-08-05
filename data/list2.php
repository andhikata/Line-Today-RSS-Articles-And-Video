<?php
    header('Content-Type: text/xml; charset=utf-8');
	echo '<?xml version="1.0" encoding="UTF-8" ?>';
?>
<articles>
<?php
	$args = array(
		'post_type' => 'post',
		'category_name' => 'line-video',
		'posts_per_page' => 10
	);
	$the_query = new WP_Query( $args ); $i=0;
	while ( $the_query->have_posts() ) : $the_query->the_post();

		$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
		$categories = get_the_category();
		if ( ! empty( $categories ) ) {
			$category = esc_html( $categories[0]->name );   
		}
		if($i==0) {
			echo '<UUID>post-' . get_the_id() . '</UUID>';
			echo '<time>' . get_post_time('U', true) . '000</time>';
		}
?>
	<article>
		<ID><?php echo get_the_id(); ?></ID>
		<nativeCountry>id</nativeCountry>
		<language>id</language>
		<publishCountries>
			<country>id</country>
		</publishCountries>
		<startYmdtUnix><?php echo get_post_time('U', true); ?>000</startYmdtUnix>
		<endYmdtUnix><?php echo strtotime('+30 day', get_post_time('U', true)); ?>000</endYmdtUnix>
		<title><?php the_title(); ?></title>
		<category><?php echo (!empty($category)) ? $category : get_bloginfo( 'name' ); ?></category>
		<publishTimeUnix><?php echo get_post_time('U', true); ?>000</publishTimeUnix>
		<?php echo (get_the_modified_time('U', true)) ? '<updateTimeUnix>'.get_the_modified_time('U', true).'000</updateTimeUnix>' : '' ; ?>
		<contentType>5</contentType>
		<contents>
			<video>
				<title><?php the_title(); ?></title>
				<url><?php echo do_shortcode(get_the_excerpt()); ?></url>
				<thumbnail><?php echo (!empty($feat_image)) ? $feat_image : ""; ?></thumbnail>
				</video>
						<text>
				<content><![CDATA[ <?php echo do_shortcode(wpautop(get_the_content())); ?> ]]></content>
			</text>
		</contents>
		<?php
			$post_link = get_the_permalink();
			global $post;
			$tags = wp_get_post_tags($post->ID);

			if ($tags):
		?>
		<?php
			endif; // end if
			//$post = $orig_post;
			wp_reset_query();
		?>
		<author><?php echo get_bloginfo( 'name' ); ?></author>
		<sourceUrl><?php echo $post_link; ?></sourceUrl>
	</article>
	<?php $i++; endwhile; wp_reset_postdata(); ?>
</articles>
