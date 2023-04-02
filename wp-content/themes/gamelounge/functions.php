<?php

/**
 * Include Theme styles
 *** filemtime used for prevent cache files
**/ 

function gamelounge_theme_styles(){
	wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css', array(), filemtime(get_template_directory() . '/style.css'), false);
	wp_enqueue_style( 'bootstrap', '//cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css'); 
}

add_action( 'wp_enqueue_scripts', 'gamelounge_theme_styles' );

/**
 * Include Theme scripts
 *** filemtime used for prevent cache files
**/ 

function gamelounge_theme_scripts(){
	wp_enqueue_script( 'app', get_template_directory_uri() . '/src/js/app.js', array(), filemtime(get_template_directory() . '/src/js/app.js'), true);
}

add_action( 'wp_enqueue_scripts', 'gamelounge_theme_scripts' );

/**
 * Add Theme supports
 *
**/ 

function gamelounge_theme_supports(){
	add_theme_support( 'title-tag' );  
	add_theme_support( 'html5', array('style','script') );
}

add_action( 'wp_head', 'gamelounge_theme_supports');

/**
 * Register CPT book
**/ 

function create_cpt_book() {
    register_post_type( 'book',
        array(
            'labels' => array(
                'name' => 'Books',
                'singular_name' => 'Book'
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'books'),
            'show_in_rest' => true,
            'menu_position' => 4,
  			'supports' => array('title','editor','excerpt'),
  			'register_meta_box_cb' => 'custom_meta_box'
        )
    );
}

add_action( 'init', 'create_cpt_book' );

/**
 * CPT book: Add meta box
 *** meta boxes: tagline
**/

function custom_meta_box() {
    add_meta_box(
        'tagline',
        'Tagline',
        'custom_meta_box_callback'
    );
}

/**
 * Meta boxes callback
**/

function custom_meta_box_callback( $post ) {
	// Add nonce
    wp_nonce_field( 'tagline_nonce', 'tagline_nonce' );

    // Get existing value
    $value = get_post_meta( $post->ID, '_tagline', true );

    // Print field: textarea
    echo '<textarea style="width:100%" id="tagline" name="tagline">' . esc_attr( $value ) . '</textarea>';
}

/**
 * Save meta boxes values
**/

function save_custom_meta_box_data( $post_id ) {
    // Check if nonce isset
    if ( ! isset( $_POST['tagline_nonce'] ) ) {
        return;
    }

    // Check if is valid nonce
    if ( ! wp_verify_nonce( $_POST['tagline_nonce'], 'tagline_nonce' ) ) {
        return;
    }

    // Prevent action for WP default autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check for post_type book
    if ( isset( $_POST['post_type'] ) && $_POST['post_type'] == 'book' ) {
    	// Check if user has capability to edit_post
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

    }

    // Check for specific meta box
    if ( ! isset( $_POST['tagline'] ) ) {
        return;
    }

    // Sanitize input
    $my_data = sanitize_text_field( $_POST['tagline'] );

    // Update post meta
    update_post_meta( $post_id, '_tagline', $my_data );
}

add_action( 'save_post', 'save_custom_meta_box_data' );

/**
 * WP Title filter
 *** only for single CPT book, if exist tagline meta box replace the title
**/

function tagline_filter_wp_title( $title, $sep ) {

	global $post;

	if( is_singular('book') ){
		$tagline = get_post_meta( $post->ID, '_tagline', true);
		$title = $tagline !== '' ? $tagline." ".$sep." " : $title;

	}	

	return $title;
}

add_filter( 'wp_title', 'tagline_filter_wp_title', 10, 2 );

/**
 * Pre get posts
 *** customize main query if front page adding post_type book and post, in that order
**/

function customize_query($wp_query){
	
	if(is_front_page()){
		$wp_query->set('post_type', array('book', 'post'));
		$wp_query->set('order', 'ASC');
		$wp_query->set('orderby', 'type');
	}

}

add_action( 'pre_get_posts', 'customize_query' );

/**
 * Remove filter
 *** remove the first <p> tag printed by the_excerpt()
**/

remove_filter('the_excerpt', 'wpautop');