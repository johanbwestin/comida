<?php
// Posttypes
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
    'show_in_rest' => true,
    'description'   => 'Holds recipes and recipe specific data',
    'taxonomies' => array('ingredients'),
    'public'        => true,
    'menu_position' => 5,
    'supports'      => array( 'title', 'thumbnail', 'excerpt', 'comments' ),
    'has_archive'   => true,
  );
  register_post_type( 'recipes', $args ); 
}
add_action( 'init', 'recipe_post' );
// Ingrediens
function ingredient_post() {
  $labels = array(
    'name'               => _x( 'Ingredients', 'post type general name' ),
    'singular_name'      => _x( 'Ingredient', 'post type singular name' ),
    'add_new'            => _x( 'Add New', 'ingredient' ),
    'add_new_item'       => __( 'Add New Ingredients' ),
    'edit_item'          => __( 'Edit Ingredient' ),
    'new_item'           => __( 'New Ingredient' ),
    'all_items'          => __( 'All Ingredients' ),
    'view_item'          => __( 'View Ingredient' ),
    'search_items'       => __( 'Search Ingredients' ),
    'not_found'          => __( 'No ingredient found' ),
    'not_found_in_trash' => __( 'No ingredient found in the Trash' ), 
    'parent_item_colon'  => '',
    'menu_name'          => 'Ingredient'
  );
  $args = array(
    'labels'        => $labels,
    'show_in_rest' => true,
    'description'   => 'Holds ingredients and ingredient specific data',
    'taxonomies' => array('ingredients'),
    'public'        => true,
    'menu_position' => 5,
    'supports'      => array( 'title' ),
    'has_archive'   => true,
  );
  register_post_type( 'ingredients', $args ); 
}

add_action( 'init', 'ingredient_post' );

// Relationship
add_action( 'mb_relationships_init', function() {
  MB_Relationships_API::register( [
      'id'   => 'posts_to_pages',
      'from' => 'recipe',
      'to'   => 'ingredient',
  ] );
} );


function your_prefix_get_meta_box( $meta_boxes ) {
	$prefix = '';

	$meta_boxes[] = array(
		'id' => 'ingredient',
		'title' => esc_html__( 'Ingrediant Metabox', 'metabox-online-generator' ),
		'post_types' => array('recipes'),
		'context' => 'advanced',
		'priority' => 'default',
		'autosave' => 'false',
		'fields' => array(
			array(
				'id' => $prefix . 'ingrediant_list',
				'type' => 'text_list',
				'name' => esc_html__( 'Ingredient List', 'metabox-online-generator' ),
				'options' => array(
					'quantity' => esc_html__( 'null', 'metabox-online-generator' ),
					'unit' => esc_html__( 'null', 'metabox-online-generator' ),
					'name' => esc_html__( 'null', 'metabox-online-generator' ),
					'comment' => esc_html__( 'null', 'metabox-online-generator' ),
				),
			),
			array(
				'id' => $prefix . 'image',
				'type' => 'image_advanced',
				'name' => esc_html__( 'Image', 'metabox-online-generator' ),
				'max_file_uploads' => '1',
			),
		),
	);

	return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'your_prefix_get_meta_box' );

// Menu
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




  // //hook into the init action and call create_ingredients_nonhierarchical_taxonomy when it fires
   
  // add_action( 'init', 'create_ingredients_nonhierarchical_taxonomy', 0 );
   
  // function create_ingredients_nonhierarchical_taxonomy() {
   
  // // Labels part for the GUI
   
  //   $labels = array(
  //     'name' => _x( 'Ingredients', 'taxonomy general name' ),
  //     'singular_name' => _x( 'Ingredient', 'taxonomy singular name' ),
  //     'search_items' =>  __( 'Search Ingredients' ),
  //     'popular_items' => __( 'Popular Ingredients' ),
  //     'all_items' => __( 'All Ingredients' ),
  //     'parent_item' => null,
  //     'parent_item_colon' => null,
  //     'edit_item' => __( 'Edit Ingredient' ), 
  //     'update_item' => __( 'Update Ingredient' ),
  //     'add_new_item' => __( 'Add New Ingredient' ),
  //     'new_item_name' => __( 'New Ingredient Name' ),
  //     'separate_items_with_commas' => __( 'Separate ingredients with commas' ),
  //     'add_or_remove_items' => __( 'Add or remove ingredients' ),
  //     'choose_from_most_used' => __( 'Choose from the most used ingredients' ),
  //     'menu_name' => __( 'Ingredients' ),
  //   ); 
   
  // // Now register the non-hierarchical taxonomy like tag
   
  //   register_taxonomy('ingredients','post',array(
  //     'hierarchical' => false,
  //     'labels' => $labels,
  //     'show_ui' => true,
  //     'show_in_rest' => true,
  //     'show_admin_column' => true,
  //     'update_count_callback' => '_update_post_term_count',
  //     'query_var' => true,
  //     'rewrite' => array( 'slug' => 'ingredient' ),
  //   ));
  // }