<?php
// CORS
// add_action('init', 'handle_preflight');
// function handle_preflight() {
//     $origin = get_http_origin();
//     if ($origin === 'http://localhost:8080') {
//         header("Access-Control-Allow-Origin: " . "http://localhost:8080");
//         header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
//         header("Access-Control-Allow-Credentials: true");
//         header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
//         if ('OPTIONS' == $_SERVER['REQUEST_METHOD']) {
//             status_header(200);
//             exit();
//         }
//     }
// }
// add_filter('rest_authentication_errors', 'rest_filter_incoming_connections');
// function rest_filter_incoming_connections($errors) {
//     $request_server = $_SERVER['REMOTE_ADDR'];
//     $origin = get_http_origin();
//     if ($origin !== 'http://localhost:8080') return new WP_Error('forbidden_access', $origin, array(
//         'status' => 403
//     ));
//     return $errors;
// }

// Default roles
// update_option('default_role','author');
// add_action('wp_rest_user_user_register', 'user_registered');
// function user_registered($user) {
//     // Do Something
// }

// Posttypes
function recipe_post()
{
  $labels = array(
    'name'               => _x('Recipes', 'post type general name'),
    'singular_name'      => _x('Recipe', 'post type singular name'),
    'add_new'            => _x('Add New', 'recipe'),
    'add_new_item'       => __('Add New Recipes'),
    'edit_item'          => __('Edit Recipe'),
    'new_item'           => __('New Recipe'),
    'all_items'          => __('All Recipes'),
    'view_item'          => __('View Recipe'),
    'search_items'       => __('Search Recipes'),
    'not_found'          => __('No recipe found'),
    'not_found_in_trash' => __('No recipe found in the Trash'),
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
    'supports'      => array('title', 'thumbnail', 'author', 'comments'),
    'has_archive'   => true,
  );
  register_post_type('recipes', $args);
}
add_action('init', 'recipe_post');
// Ingrediens
function ingredient_post()
{
  $labels = array(
    'name'               => _x('Ingredients', 'post type general name'),
    'singular_name'      => _x('Ingredient', 'post type singular name'),
    'add_new'            => _x('Add New', 'ingredient'),
    'add_new_item'       => __('Add New Ingredients'),
    'edit_item'          => __('Edit Ingredient'),
    'new_item'           => __('New Ingredient'),
    'all_items'          => __('All Ingredients'),
    'view_item'          => __('View Ingredient'),
    'search_items'       => __('Search Ingredients'),
    'not_found'          => __('No ingredient found'),
    'not_found_in_trash' => __('No ingredient found in the Trash'),
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
    'supports'      => array('title'),
    'has_archive'   => true,
  );
  register_post_type('ingredients', $args);
}

add_action('init', 'ingredient_post');

function your_prefix_get_meta_box($meta_boxes)
{
  $prefix = '';

  $meta_boxes[] = array(
    'id' => 'ingredient',
    'title' => esc_html__('Ingredient Metabox', 'metabox-online-generator'),
    'post_types' => array('recipes'),
    'context' => 'advanced',
    'priority' => 'default',
    'autosave' => 'false',
    'fields' => array(
      array(
        'id' => $prefix . 'ingredient_list',
        'type' => 'text_list',
        'name' => esc_html__('Ingredient List', 'metabox-online-generator'),
      ),
      array(
        'id' => $prefix . 'instruction_list',
        'type' => 'text_list',
        'name' => esc_html__('Lnstruction List', 'metabox-online-generator'),
      ),
      array(
        'id' => $prefix . 'description',
        'type' => 'text',
        'name' => esc_html__('Description', 'metabox-online-generator'),
        'placeholder' => esc_html__('Description', 'metabox-online-generator'),
      ),
      array(
        'id' => $prefix . 'views',
        'type' => 'number',
        'name' => esc_html__('Views', 'metabox-online-generator'),
      ),
    ),
  );

  return $meta_boxes;
}
add_filter('rwmb_meta_boxes', 'your_prefix_get_meta_box');

// Menu
register_nav_menus(
  array(
    'menu-1' => __('Primary', 'admin'),
    'footer' => __('Footer Menu', 'admin'),
    'social' => __('Social Links Menu', 'admin'),
  )
);

// create custom function to return nav menu
function custom_wp_menu()
{
  // Replace your menu name, slug or ID carefully
  return wp_get_nav_menu_items('main menu');
}

// create new endpoint route
add_action('rest_api_init', function () {
  register_rest_route('wp/v2', 'menu', array(
    'methods' => 'GET',
    'show_in_rest' => true,
    'callback' => 'custom_wp_menu',
  ));
});

// Views custom endpoint
add_action('rest_api_init', function () {
  register_rest_route('base', '/views/(?P<id>\d+)', array(
    'methods' => 'GET',
    'callback' => 'post_view_counter_function',
  ));
});
function post_view_counter_function(WP_REST_Request $request)
{
  $post_id = $request['id'];
  if (FALSE === get_post_status($post_id)) {
    return new WP_Error('error_no_post', 'Not a post id', array('status' => 404));
  } else {
    $current_views = get_post_meta($post_id, 'views', true);
    $views = $current_views + 1;
    update_post_meta($post_id, 'views', $views);
    return $views;
  }
}


















// // Search custom endpoint
// function namespace_register_search_route() {
//   register_rest_route('namespace/v1', '/search', [
//       'methods' => WP_REST_Server::READABLE,
//       'callback' => 'namespace_ajax_search',
//       'args' => namespace_get_search_args()
//   ]);
// }
// add_action( 'rest_api_init', 'namespace_register_search_route');
// /**
// * Define the arguments our endpoint receives.
// */
// function namespace_get_search_args() {
//   $args = [];
//   $args['s'] = [
//      'description' => esc_html__( 'The search term.', 'namespace' ),
//      'type'        => 'string',
//  ];
//  return $args;
// }
// /**
// * Use the request data to find the posts we
// * are looking for and prepare them for use
// * on the front end.
// */
// function namespace_ajax_search( $request ) {
//   $posts = [];
//   $results = [];
//   // check for a search term
//   if( isset($request['s'])) :
//       // get posts
//       $posts = get_posts([
//           'posts_per_page' => 5,
//           'post_type' => ['recipes'],
//           's' => $request['s'],
//       ]);
//       // set up the data I want to return
//       foreach($posts as $post):
//           $results[] = [
//               'title' => $post->post_title,
//               'link' => get_permalink( $post->ID )
//           ];
//       endforeach;
//   endif;
//   if( empty($results) ) :
//       return new WP_Error( 'front_end_ajax_search', 'No results');
//   endif;
//   return rest_ensure_response( $results );
// }







// add_action( 'rest_api_init', function () {
//   register_rest_route( 'base', '/popular/', array(
//     'methods' => 'GET',
//     'callback' => 'popular_post',
//   ));
// });
// function popular_post( WP_REST_Request $request ) {
//   // $post_id = $request['id'];
//   query_posts('meta_key=views&orderby=meta_value_num&order=DESC');
// }


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
