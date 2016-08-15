<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package ReadMore
 */

if ( ! function_exists( 'readmore_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function readmore_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = $time_string;

	$byline = sprintf(
		esc_html_x( 'By %s', 'post author', 'readmore' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on"><i class="fa fa-clock-o"></i> ' . $posted_on . '</span><span class="byline"><i class="fa fa-user"></i> ' . $byline . '</span>';

	if ( ! is_single() && ! post_password_required()
		&& comments_open() && get_comments_number() ) {

		echo '<span class="comments-link"><i class="fa fa-comments-o"></i> ';
		comments_popup_link('');
		echo '</span>';
	}

}
endif;

if ( ! function_exists( 'readmore_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function readmore_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'readmore' ) );
		if ( $categories_list && readmore_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'readmore' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'readmore' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'readmore' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}
}
endif;

if ( ! function_exists( 'readmore_categorized_blog' ) ) :
/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function readmore_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'readmore_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'readmore_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so readmore_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so readmore_categorized_blog should return false.
		return false;
	}
}
endif;

if ( ! function_exists( 'readmore_category_transient_flusher' ) ) :
/**
 * Flush out the transients used in readmore_categorized_blog.
 */
function readmore_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'readmore_categories' );
}
endif;
add_action( 'edit_category', 'readmore_category_transient_flusher' );
add_action( 'save_post',     'readmore_category_transient_flusher' );

if ( ! function_exists( 'readmore_flexslider' ) ) :
/**
 * Outputs a slider for post attachments
 * @param  WP_Post $post
 * @param  string $size
 */
function readmore_flexslider() {

	if ( is_page()) :
		$attachment_parent = $post->ID;
	else :
		$attachment_parent = get_the_ID();
	endif;

	if($images = get_posts(array(
		'post_parent'    => $attachment_parent,
		'post_type'      => 'attachment',
		'numberposts'    => -1, // show all
		'post_status'    => null,
		'post_mime_type' => 'image',
                'orderby'        => 'menu_order',
                'order'           => 'ASC',
	))) { ?>

		<div class="flexslider">

			<ul class="slides">

				<?php foreach($images as $image) {
					$attimg = wp_get_attachment_image($image->ID,'post-image'); ?>

					<li>
						<?php echo $attimg; ?>
						<?php if ( !empty($image->post_excerpt)) : ?>
							<div class="media-caption-container">
								<p class="media-caption"><?php echo $image->post_excerpt ?></p>
							</div>
						<?php endif; ?>
					</li>

				<?php }; ?>

			</ul>

		</div><?php

	}
}
endif;
