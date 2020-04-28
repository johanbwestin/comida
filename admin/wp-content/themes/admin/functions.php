<?php
function recipe_post() {
  $labels = array(
    'name'               => _x( 'Recipes', 'post type general name' ),
    'singular_name'      => _x( 'Recipe', 'post type singular name' ),
    'add_new'            => _x( 'Add New', 'recipe' ),
    'add_new_item'       => __( 'Add New Recipes' ),
    'edit_item'          => __( 'Edit Recipe' ),
    'new_item'           => __( 'New Recipe' ),
    'all_items'          => __( 'All Recipes' ),
    'view_item'          => __( 'View Recipe' ),
    'search_items'       => __( 'Search Recipes' ),
    'not_found'          => __( 'No recipe found' ),
    'not_found_in_trash' => __( 'No recipe found in the Trash' ), 
    'parent_item_colon'  => '',
    'menu_name'          => 'Recipe'
  );
  $args = array(
    'labels'        => $labels,
    'description'   => 'Holds recipes and recipe specific data',
    'public'        => true,
    'menu_position' => 5,
    'supports'      => array( 'title', 'thumbnail', 'excerpt', 'comments' ),
    'has_archive'   => true,
  );
  register_post_type( 'recipes', $args ); 
}
add_action( 'init', 'recipe_post' );

register_nav_menus(
  array(
    'menu-1' => __( 'Primary', 'admin' ),
    'footer' => __( 'Footer Menu', 'admin' ),
    'social' => __( 'Social Links Menu', 'admin' ),
  )
);

// create custom function to return nav menu
function custom_wp_menu() {
  // Replace your menu name, slug or ID carefully
  return wp_get_nav_menu_items('main menu');
}

// create new endpoint route
add_action( 'rest_api_init', function () {
  register_rest_route( 'wp/v2', 'menu', array(
      'methods' => 'GET',
      'show_in_rest' => true,
      'callback' => 'custom_wp_menu',
  ) );
} );