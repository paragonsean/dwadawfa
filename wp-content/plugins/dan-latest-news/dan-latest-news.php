<?php
 
/*
 
Plugin Name: Dan Latest News
 
Plugin URI: https://danlatestnews.com/
 
Description: Plugin to accompany tutsplus guide to creating plugins, registers a post type.
 
Version: 1.0
 
Author: WebfyMedia
 
Author URI: https://webfymedia.com/
 
License: GPLv2 or later
 
Text Domain: dannews
 
*/

/*
	@	Loading the admin menu
	*/
	function wtn_admin_menu(){
		
		add_menu_page(  
			__('Dan All News', WTN_TXT_DMN),
			__('Dan All News', WTN_TXT_DMN),
			'manage_options',
			'dan-top-news',
			array( $this, 'wtn_get_help' ),
			'dashicons-admin-site-alt',
			100 
		);
		
		add_submenu_page( 	
			'dan-top-news', 
			__('API Settings', WTN_TXT_DMN), 
			__('API Settings', WTN_TXT_DMN), 
			'manage_options', 
			'wtn-api-settings', 
			array( $this, WTN_PRFX . 'api_settings' )
		);

		add_submenu_page( 	
			'dan-top-news', 
			__('Settings', WTN_TXT_DMN), 
			__('General Settings', WTN_TXT_DMN), 
			'manage_options', 
			'wtn-settings', 
			array( $this, WTN_PRFX . 'settings' )
		);
    }

function dannews_register_post_type() {
 
    $labels = array( 
 
        'name' => __( 'All News' , 'dannews' ),
 
        'singular_name' => __( 'News' , 'dannews' ),
 
        'add_new' => __( 'New News' , 'dannews' ),
 
        'add_new_item' => __( 'Add New News' , 'dannews' ),
 
        'edit_item' => __( 'Edit News' , 'dannews' ),
 
        'new_item' => __( 'New News' , 'dannews' ),
 
        'view_item' => __( 'View News' , 'dannews' ),
 
        'search_items' => __( 'Search News' , 'dannews' ),
 
        'not_found' =>  __( 'No News Found' , 'dannews' ),
 
        'not_found_in_trash' => __( 'No News found in Trash' , 'dannews' ),
 
    );
 
    $args = array(
 
        'labels' => $labels,
 
        'has_archive' => true,
 
        'public' => true,
 
        'hierarchical' => false,
 
        'supports' => array(
 
            'title', 
 
            'editor', 
 
            'excerpt', 
 
            'custom-fields', 
 
            'thumbnail',
 
            'page-attributes'
 
        ),
 
        'rewrite'   => array( 'slug' => 'dannews' ),
 
        'show_in_rest' => true
 
    );
 
}

add_action( 'init', 'dannews_register_post_type' );

function dannews_register_taxonomy() {    

    $labels = array(
        'name' => __( 'Categories' , 'dannews' ),
        'singular_name' => __( 'Category', 'dannews' ),
        'search_items' => __( 'Search Categories' , 'dannews' ),
        'all_items' => __( 'All Categories' , 'dannews' ),
        'edit_item' => __( 'Edit Category' , 'dannews' ),
        'update_item' => __( 'Update Categories' , 'dannews' ),
        'add_new_item' => __( 'Add New Category' , 'dannews' ),
        'new_item_name' => __( 'New Category Name' , 'dannews' ),
        'menu_name' => __( 'Categories' , 'dannews' ),
    );
      
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'sort' => true,
        'args' => array( 'orderby' => 'term_order' ),
        'rewrite' => array( 'slug' => 'categories' ),
        'show_admin_column' => true,
        'show_in_rest' => true
  
    );
      
    register_taxonomy( 'dannews_category', array( 'dannews_news' ), $args);
      
}
add_action( 'init', 'dannews_register_taxonomy' );

function dan_news_styles() {
    wp_enqueue_style( 'dannews-style',  plugin_dir_url( __FILE__ ) . '/css/dannews-style.css');                      
}

add_action( 'wp_enqueue_scripts', 'dan_news_styles');