<?php
/*
Plugin Name: Feed Image Enclosure
Plugin URI: https://github.com/kasparsd/
Description: Add featured images as enclosures in RSS feeds
Version: 0.1
Author: Kaspars Dambis
Author URI: http://konstruktors.com
License: GPL2
*/

add_action( 'rss2_item', 'add_post_featured_image_as_rss_item_enclosure' );

function add_post_featured_image_as_rss_item_enclosure() {
	global $post, $wp_query;

	if ( ! has_post_thumbnail() )
		return;

	$thumbnail_id = get_post_thumbnail_id( get_the_ID() );
	$thumbnail_size = apply_filters( 'rss_enclosure_image_size', 'thumbnail' );

	$thumbnail = image_get_intermediate_size( $thumbnail_id, $thumbnail_size );
	
	$uploads = wp_upload_dir();
	$thumbnail_full_path = $uploads['basedir'] . DIRECTORY_SEPARATOR . $thumbnail['path'];


	printf( 
		'<enclosure url="%s" length="%s" type="%s" />',
		$thumbnail['url'], 
		filesize( $thumbnail_full_path ), 
		get_post_mime_type( $thumbnail_id ) 
	);
}