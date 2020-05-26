<?php
// Allow cors for frontend application. This is for later use
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

// Custom posttype for Recipes
add_action('init', 'recipe_post');
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

// Meta box custom fields
add_filter('rwmb_meta_boxes', 'your_prefix_get_meta_box');

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

// Menu
register_nav_menus(
  array(
    'menu-1' => __('Primary', 'admin'),
    'footer' => __('Footer Menu', 'admin'),
    'social' => __('Social Links Menu', 'admin'),
  )
);

// Menu custom endpoint
add_action('rest_api_init', function () {
  register_rest_route('wp/v2', 'menu', array(
    'methods' => 'GET',
    'show_in_rest' => true,
    'callback' => 'custom_wp_menu',
  ));
});

// Menu callbackfunction, returns nav menu
function custom_wp_menu()
{
  // menu name
  return wp_get_nav_menu_items('main menu');
}

// Views custom endpoint
add_action('rest_api_init', function () {
  register_rest_route('base', '/views/(?P<id>\d+)', array(
    'methods' => 'GET',
    'callback' => 'post_view_counter_function',
  ));
});

// View counter callback function
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
