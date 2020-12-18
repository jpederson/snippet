<?php

/*
Plugin Name: Snippets
Plugin URI: https://github.com/jpederson/snippets
description: Snippets of reusable html that can easily be included in pages, posts, or even templates using shortcodes.
Version: 0.0.1
Author: James Pederson
Author URI: https://jpederson.com
License: GPL2
*/


// let's create the function for the custom type
function snippet_post_type() { 
	// creating (registering) the custom type 
	register_post_type( 'snippet', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
		// let's now add all the options for this post type
		array(
			'labels' => array(
				'name' => __( 'Snippets', 'ptheme' ), /* This is the Title of the Group */
				'singular_name' => __( 'Snippet', 'ptheme' ), /* This is the individual type */
				'all_items' => __( 'All Snippets', 'ptheme' ), /* the all items menu item */
				'add_new' => __( 'Add New', 'ptheme' ), /* The add new menu item */
				'add_new_item' => __( 'Add New Snippet', 'ptheme' ), /* Add New Display Title */
				'edit' => __( 'Edit', 'ptheme' ), /* Edit Dialog */
				'edit_item' => __( 'Edit Snippets', 'ptheme' ), /* Edit Display Title */
				'new_item' => __( 'New Snippet', 'ptheme' ), /* New Display Title */
				'view_item' => __( 'View Snippet', 'ptheme' ), /* View Display Title */
				'search_items' => __( 'Search Snippets', 'ptheme' ), /* Search Custom Type Title */ 
				'not_found' =>  __( 'Nothing found in the database.', 'ptheme' ), /* This displays if there are no entries yet */ 
				'not_found_in_trash' => __( 'Nothing found in Trash', 'ptheme' ), /* This displays if there is nothing in the trash */
				'parent_item_colon' => ''
			), /* end of arrays */
			'description' => __( 'Manage Snippets.', 'ptheme' ), /* Custom Type Description */
			'public' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => true,
			'show_ui' => true,
			'query_var' => true,
			'menu_position' => 25, /* this is what order you want it to appear in on the left hand side menu */ 
			'menu_icon' => 'dashicons-media-code', /* the icon for the custom post type menu */
			'has_archive' => false, /* you can rename the slug here */
			'capability_type' => 'post',
			'hierarchical' => false,
			/* the next one is important, it tells what's enabled in the post editor */
			'supports' => array( 'title', 'editor', 'revisions' )
		) /* end of options */
	); /* end of register post type */	
}

// adding the function to the Wordpress init
add_action( 'init', 'snippet_post_type');



// function to handle the snippet shortcode
function snippet_shortcode( $atts ) {

	// if we have a slug specified
	if ( isset( $atts['slug'] ) ) {

		// let's set the args for our select
		$args = array(
		  'name'        => $atts['slug'],
		  'post_type'   => 'snippet',
		  'numberposts' => 1
		);

		// get the snippet
		$snippets = get_posts( $args );

		// check to make sure it's not empty
		if ( isset( $snippets[0] ) ) {

			// get the snippet and return the post content
			$the_snippet = $snippets[0];
			return $the_snippet->post_content;

		} else {
			return '';
		}
		
	}
}

// register the snippet shortcode
add_shortcode( 'snippet', 'snippet_shortcode' );



