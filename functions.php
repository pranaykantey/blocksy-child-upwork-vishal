<?php
if (!defined('ABSPATH')) {
    die('Direct access forbidden.');
}

// Enable WordPress debug logging
if (!defined('WP_DEBUG_LOG')) {
    define('WP_DEBUG_LOG', true);
}

function log_message($message) {
    error_log(date('[Y-m-d H:i:s] ') . $message . "\n", 3, WP_CONTENT_DIR . '/debug.log');
}

// Enqueue parent and child styles
function child_enqueue_styles() {


    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('child-style', get_stylesheet_uri());
    
    wp_enqueue_style('product-comparison-style', get_stylesheet_directory_uri() . '/product-comparison.css', array(), '1.1');
    wp_enqueue_script('product-comparison-script', get_stylesheet_directory_uri() . '/product-comparison.js', array('jquery'), '1.1', true);

    log_message("Styles enqueued: parent-style and child-style");
}
add_action('wp_enqueue_scripts', 'child_enqueue_styles');

// Enqueue product comparison styles
function enqueue_product_comparison_styles() {
    if (is_singular('post') && has_post_format('product-comparison')) {
        wp_enqueue_style('product-comparison-style', get_stylesheet_directory_uri() . '/product-comparison.css', array(), filemtime(get_stylesheet_directory() . '/product-comparison.css'));
        log_message("Product comparison styles enqueued for post ID: " . get_the_ID());
    }
}
add_action('wp_enqueue_scripts', 'enqueue_product_comparison_styles');

// Register product comparison template
function register_product_comparison_template($templates) {
    $templates['single-product-comparison.php'] = 'Product Comparison';
    log_message("Product comparison template registered");
    return $templates;
}
add_filter('theme_post_templates', 'register_product_comparison_template');

add_action('admin_menu', 'enable_custom_fields_metabox');
function enable_custom_fields_metabox() {
    add_meta_box('postcustom', 'Custom Fields', 'post_custom_meta_box', 'post', 'normal', 'high');
}

// Set template for product comparison posts
function set_product_comparison_template($template) {
    if (is_singular('post') && has_post_format('product-comparison')) {
        $new_template = locate_template(array('single-product-comparison.php'));
        if (!empty($new_template)) {
            log_message("Product comparison template set for post ID: " . get_the_ID());
            return $new_template;
        } else {
            log_message("Product comparison template not found for post ID: " . get_the_ID());
        }
    }
    return $template;
}
add_filter('single_template', 'set_product_comparison_template');

/* function register_custom_fields() {
    $custom_fields = array(
        'disclosure_top', 'Featured_Image', 'subtitle', 'benefits_nav_text',
        'ingredients_nav_text', 'top_5_nav_text', 'disclosure', 'benefits_title',
        'benefits_subtitle', 'benefits_content', 'usage_title', 'usage_content',
        'ingredients_to_look_for_title', 'ingredients_to_look_for_content',
        'ingredients_to_avoid_title', 'ingredients_to_avoid_content',
        'considerations_title', 'considerations_content', 'top_products_title',
	'num_products', 'results_disclaimer', 'citations_title', 'citations',
	'back_to_top_text', 'primary_color', 'secondary_color', 'tertiary_color'
    );

    foreach ($custom_fields as $field) {
        register_post_meta('post', $field, array(
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
        ));
        
       
    }
        // Register product-specific custom fields
    $product_fields = array(
        'name', 'brand', 'link', 'image', 'image_width', 'rating_image',
        'rating', 'grade', 'pros', 'cons', 'bottom_line'
    );

    for ($i = 1; $i <= 5; $i++) {
        foreach ($product_fields as $field) {
            register_post_meta('post', "product_{$i}_{$field}", array(
                'show_in_rest' => true,
                'single' => true,
                'type' => 'string',
            ));
        }
    }
}
add_action('init', 'register_custom_fields'); */

function handle_custom_fields($post_id, $post, $update) {
    if ($post->post_type !== 'post') {
        return;
    }
	error_log("Handling custom fields for post ID: $post_id");

    log_message("Handling custom fields for post ID: $post_id");

    // Get the raw POST data
    $raw_data = file_get_contents('php://input');
    log_message("Raw POST data: " . $raw_data);
    $data = json_decode($raw_data, true);
	log_message("Decoded data: " . print_r($data, true));


    if (isset($data['meta']) && is_array($data['meta'])) {
        foreach ($data['meta'] as $key => $value) {
            update_post_meta($post_id, $key, wp_kses_post($value));
            log_message("Updated custom field '$key' for post ID: $post_id");

            // Handle featured image
            if ($key === 'featured_image' && !empty($value)) {
                $image_id = upload_image_from_url($value, $post_id);
                if ($image_id) {
                    set_post_thumbnail($post_id, $image_id);
                    log_message("Set featured image for post ID: $post_id");
                }
            }
        }
    } else {
        log_message("No meta data found in POST for post ID: $post_id");
    }
	$all_meta = get_post_meta($post_id);
    log_message("All post meta after update: " . print_r($all_meta, true));

    // Set post format to 'product-comparison'
    set_post_format($post_id, 'product-comparison');
    log_message("Set post format to 'product-comparison' for post ID: $post_id");

    // Set template to 'single-product-comparison.php'
    update_post_meta($post_id, '_wp_page_template', 'single-product-comparison.php');
    log_message("Set template to 'single-product-comparison.php' for post ID: $post_id");
}
add_action('rest_api_inserted_post', 'handle_custom_fields', 10, 3);
 

function upload_image_from_url($image_url, $post_id) {
    require_once(ABSPATH . 'wp-admin/includes/media.php');
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/image.php');

    // Download file to temp dir
    $tmp = download_url($image_url);

    if (is_wp_error($tmp)) {
        log_message("Error downloading image: " . $tmp->get_error_message());
        return false;
    }

    $file_array = array(
        'name' => basename($image_url),
        'tmp_name' => $tmp
    );

    // Do the validation and storage stuff
    $id = media_handle_sideload($file_array, $post_id);

    // If error storing permanently, unlink
    if (is_wp_error($id)) {
        @unlink($file_array['tmp_name']);
        log_message("Error storing image: " . $id->get_error_message());
        return false;
    }

    return $id;
}
// Add product comparison format
function add_product_comparison_format() {
    add_theme_support('post-formats', array('product-comparison'));
    log_message("Product comparison post format added");
    require_once('inc/metabox-fields.php');
    require_once('inc/products-metabox-fields.php');
    require_once('inc/sidebar-metabox.php');
}
add_action('after_setup_theme', 'add_product_comparison_format');



//function display_all_post_meta() {
//   global $post;
//    $post_meta = get_post_meta($post->ID);
//    echo '<div style="background-color: #f0f0f0; padding: 15px; margin-top: 20px;">';
//    echo '<h3>All Post Meta:</h3>';
//    echo '<pre>' . print_r($post_meta, true) . '</pre>';
//    echo '</div>';
//}
//add_action('edit_form_after_title', 'display_all_post_meta');

// Helper function to get custom field with fallback
function get_custom_field($field, $fallback = '') {
    $value = get_post_meta(get_the_ID(), $field, true);
    log_message("Retrieved custom field '$field' for post ID: " . get_the_ID());
    return !empty($value) ? $value : $fallback;
}

// Log when a product comparison post is loaded
function log_product_comparison_post_load() {
    if (is_singular('post') && has_post_format('product-comparison')) {
        $post_id = get_the_ID();
        $template = get_page_template_slug($post_id);
        log_message("Product comparison post loaded - ID: {$post_id}, Template: {$template}");
    }
}
add_action('wp', 'log_product_comparison_post_load');
