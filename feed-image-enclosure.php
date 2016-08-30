<?php
/*
Plugin Name: Feed Image Enclosure
Plugin URI: https://github.com/kasparsd/
Description: Add featured images as enclosures in RSS feeds
Version: 0.2
Author: Kaspars Dambis
Author URI: http://konstruktors.com
License: GPL2
*/

add_action( 'rss2_item', 'add_post_featured_image_as_rss_item_enclosure' );

function add_post_featured_image_as_rss_item_enclosure($size = 'thumbnail') {
	if ( ! has_post_thumbnail() )
		return;

	$thumbnail_size = apply_filters( 'rss_enclosure_image_size', $size );
	$thumbnail_id = get_post_thumbnail_id( get_the_ID() );
	$thumbnail = image_get_intermediate_size( $thumbnail_id, $thumbnail_size );

	if ( empty( $thumbnail ) )
		return;

	$upload_dir = wp_upload_dir();

	printf(
		'<enclosure url="%s" length="%s" type="%s" />',
		$thumbnail['url'],
		filesize( path_join( $upload_dir['basedir'], $thumbnail['path'] ) ),
		get_post_mime_type( $thumbnail_id )
	);
}