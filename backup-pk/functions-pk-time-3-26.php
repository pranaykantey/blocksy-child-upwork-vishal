<?php
if (!defined('ABSPATH')) {
    die('Direct access forbidden.');
}

// Enable WordPress debug logging
if (!defined('WP_DEBUG_LOG')) {
    define('WP_DEBUG_LOG', true);
}

function log_message($message)
{
    error_log(date('[Y-m-d H:i:s] ') . $message . "\n", 3, WP_CONTENT_DIR . '/debug.log');
}

// Enqueue parent and child styles
function child_enqueue_styles()
{
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('child-style', get_stylesheet_uri());

    wp_enqueue_style('fontawesome_pk', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css', [], '1.0.0');
    // wp_enqueue_style('product-comparison-style', get_stylesheet_directory_uri() . '/product-comparison.css', array(), '1.1');
    // wp_enqueue_script('product-comparison-script', get_stylesheet_directory_uri() . '/product-comparison.js', array('jquery'), '1.1', true);

    log_message("Styles enqueued: parent-style and child-style");
}
// add_action('wp_enqueue_scripts', 'child_enqueue_styles');
add_action('wp_enqueue_scripts', 'child_enqueue_styles');

// Enqueue product comparison styles
function enqueue_product_comparison_styles()
{
    if (is_singular('post') && has_post_format('product-comparison')) {
        wp_enqueue_style('product-comparison-post', get_stylesheet_directory_uri() . '/product-comparison.css', array(), filemtime(get_stylesheet_directory() . '/product-comparison.css'));
        wp_enqueue_script('product-comparison-script', get_stylesheet_directory_uri() . '/product-comparison.js', array('jquery'), '1.1', true);

        log_message("Product comparison styles enqueued for post ID: " . get_the_ID());
    }
}
add_action('wp_enqueue_scripts', 'enqueue_product_comparison_styles');

// Register product comparison template
function register_product_comparison_template($templates)
{
    $templates['single-product-comparison.php'] = 'Product Comparison';
    log_message("Product comparison template registered");
    return $templates;
}
add_filter('theme_post_templates', 'register_product_comparison_template');

// Set template for product comparison posts
function set_product_comparison_template($template)
{
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

function handle_custom_fields($post_id, $post, $update)
{
    if ($post->post_type !== 'post') {
        return;
    }
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

function upload_image_from_url($image_url, $post_id)
{
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
function add_product_comparison_format()
{
    add_theme_support('post-formats', array('product-comparison'));
    log_message("Product comparison post format added");
}
add_action('after_setup_theme', 'add_product_comparison_format');

// Helper function to get custom field with fallback
function get_custom_field($field, $fallback = '')
{
    $value = get_post_meta(get_the_ID(), $field, true);
    log_message("Retrieved custom field '$field' for post ID: " . get_the_ID());
    return !empty($value) ? $value : $fallback;
}

// Log when a product comparison post is loaded
function log_product_comparison_post_load()
{
    if (is_singular('post') && has_post_format('product-comparison')) {
        $post_id = get_the_ID();
        $template = get_page_template_slug($post_id);
        log_message("Product comparison post loaded - ID: {$post_id}, Template: {$template}");
    }
}
add_action('wp', 'log_product_comparison_post_load');

// Enqueue custom admin assets
function enqueue_custom_admin_assets($hook)
{
    if ('post.php' != $hook && 'post-new.php' != $hook) {
        return;
    }
    wp_enqueue_media();
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker');
    wp_enqueue_style('custom-admin-css', get_stylesheet_directory_uri() . '/custom-admin.css');
    wp_enqueue_script('custom-admin-js', get_stylesheet_directory_uri() . '/custom-admin.js', array('jquery', 'wp-color-picker'), null, true);
}
add_action('admin_enqueue_scripts', 'enqueue_custom_admin_assets');

// Add custom meta boxes
function custom_meta_boxes()
{
    add_meta_box('custom_main_fields', 'Main Custom Fields', 'custom_main_fields_callback', 'post', 'normal', 'high');
    add_meta_box('custom_product_fields', 'Product Information', 'custom_product_fields_callback', 'post', 'normal', 'high');
    add_meta_box('custom_sidebar_fields', 'Sidebar Information', 'custom_sidebar_fields_callback', 'post', 'side', 'default');
    add_meta_box('custom_color_fields', 'Color Scheme', 'custom_color_fields_callback', 'post', 'side', 'default');
}
add_action('add_meta_boxes', 'custom_meta_boxes');


function custom_main_fields_callback($post)
{
    wp_nonce_field('custom_main_fields_nonce', 'custom_main_fields_nonce');

    $fields = array(
        'disclosure_top' => array('label' => 'Disclosure Top', 'type' => 'text'),
        'subtitle' => array('label' => 'Subtitle', 'type' => 'text'),
        'benefits_nav_text' => array('label' => 'Benefits Nav Text', 'type' => 'text'),
        'ingredients_nav_text' => array('label' => 'Ingredients Nav Text', 'type' => 'text'),
        'top_5_nav_text' => array('label' => 'Top 5 Nav Text', 'type' => 'text'),
        'disclosure' => array('label' => 'Disclosure', 'type' => 'text'),
        'effect_image' => array('label' => 'The Effect Image', 'type' => 'image'),
        'benefits_title' => array('label' => 'Benefits Title', 'type' => 'text'),
        'benefits_content' => array('label' => 'Benefits Content', 'type' => 'editor'),
        'usage_title' => array('label' => 'Usage Title', 'type' => 'text'),
        'usage_content' => array('label' => 'Usage Content', 'type' => 'editor'),
        'ingredients_to_look_for_title' => array('label' => 'Ingredients to Look For Title', 'type' => 'text'),
        'ingredients_to_look_for_content' => array('label' => 'Ingredients to Look For Content', 'type' => 'editor'),
        'ingredients_to_avoid_title' => array('label' => 'Ingredients to Avoid Title', 'type' => 'text'),
        'ingredients_to_avoid_content' => array('label' => 'Ingredients to Avoid Content', 'type' => 'editor'),
        'considerations_title' => array('label' => 'Considerations Title', 'type' => 'text'),
        'considerations_content' => array('label' => 'Considerations Content', 'type' => 'editor'),
        'top_products_title' => array('label' => 'Top Products Title', 'type' => 'text'),
        'citations_title' => array('label' => 'Citations Title', 'type' => 'text'),
        'citations' => array('label' => 'Citations', 'type' => 'editor'),
        'back_to_top_text' => array('label' => 'Back to Top Text', 'type' => 'text'),
    );

    render_custom_fields($post, $fields);
}

function custom_product_fields_callback($post)
{
    wp_nonce_field('custom_product_fields_nonce', 'custom_product_fields_nonce');

    $num_products = get_post_meta($post->ID, 'num_products', true) ?: 5;
    echo '<p><label for="num_products">Number of Products: </label>';
    echo '<input type="number" id="num_products" name="num_products" value="' . esc_attr($num_products) . '" min="1" max="10"></p>';

    for ($i = 1; $i <= $num_products; $i++) {
        $fields = array(
            "product_{$i}_name" => array('label' => "Product $i Name", 'type' => 'text'),
            "product_{$i}_brand" => array('label' => "Product $i Brand", 'type' => 'text'),
            "product_{$i}_link" => array('label' => "Product $i Link", 'type' => 'url'),
            "product_{$i}_image" => array('label' => "Product $i Image", 'type' => 'image'),
            "product_{$i}_rating_image" => array('label' => "Product $i Rating Image", 'type' => 'image'),
            "product_{$i}_grade" => array('label' => "Product $i Grade", 'type' => 'text'),
            "product_{$i}_pros" => array('label' => "Product $i Pros", 'type' => 'editor'),
            "product_{$i}_cons" => array('label' => "Product $i Cons", 'type' => 'editor'),
            "product_{$i}_bottom_line" => array('label' => "Product $i Bottom Line", 'type' => 'editor'),
        );

        echo "<h3>Product $i</h3>";
        render_custom_fields($post, $fields);
    }
}

function custom_sidebar_fields_callback($post)
{
    wp_nonce_field('custom_sidebar_fields_nonce', 'custom_sidebar_fields_nonce');

    $fields = array(
        'sidebar_1_title' => array('label' => 'Sidebar 1 Title', 'type' => 'text'),
        'sidebar_1_subtitle' => array('label' => 'Sidebar 1 Subtitle', 'type' => 'text'),
        'sidebar_1_image_1' => array('label' => 'Sidebar 1 Image 1', 'type' => 'image'),
        'sidebar_1_image_2' => array('label' => 'Sidebar 1 Image 2', 'type' => 'image'),
        'sidebar_2_title' => array('label' => 'Sidebar 2 Title', 'type' => 'text'),
        'sidebar_2_subtitle' => array('label' => 'Sidebar 2 Subtitle', 'type' => 'text'),
        'sidebar_2_link_title_top5' => array('label' => 'Sidebar 2 Link Title Top 5', 'type' => 'text'),
    );

    $icon_fields = array(
        'sidebar_2_icon_1'  => array('label' => 'sidebar 2 icon 1', 'type'   => 'select', 'options' => [
            'active'    => 'Active',
            'inactive'  => 'Inactive',
        ]),
        'sidebar_2_icon_2'  => array('label' => 'sidebar 2 icon 2', 'type'   => 'select', 'options' => [
            'active'    => 'Active',
            'inactive'  => 'Inactive',
        ]),
        'sidebar_2_icon_3'  => array('label' => 'sidebar 2 icon 3', 'type'   => 'select', 'options' => [
            'active'    => 'Active',
            'inactive'  => 'Inactive',
        ]),
        'sidebar_2_icon_4'  => array('label' => 'sidebar 2 icon 4', 'type'   => 'select', 'options' => [
            'active'    => 'Active',
            'inactive'  => 'Inactive',
        ]),
        'sidebar_2_icon_5'  => array('label' => 'sidebar 2 icon 5', 'type'   => 'select', 'options' => [
            'active'    => 'Active',
            'inactive'  => 'Inactive',
        ]),
        'sidebar_2_icon_6'  => array('label' => 'sidebar 2 icon 6', 'type'   => 'select', 'options' => [
            'active'    => 'Active',
            'inactive'  => 'Inactive',
        ]),
    );

    render_custom_fields($post, $fields);
    render_custom_fields($post, $icon_fields);

    echo '<p><strong>Automatically filled fields:</strong></p>';
    echo '<p>Sidebar 2 Link Title 1: ' . esc_html(get_post_meta($post->ID, 'benefits_title', true)) . '</p>';
    echo '<p>Sidebar 2 Link Title 2: ' . esc_html(get_post_meta($post->ID, 'usage_title', true)) . '</p>';
    echo '<p>Sidebar 2 Link Title 3: ' . esc_html(get_post_meta($post->ID, 'ingredients_to_avoid_title', true)) . '</p>';
}

function custom_color_fields_callback($post)
{
    wp_nonce_field('custom_color_fields_nonce', 'custom_color_fields_nonce');

    $fields = array(
        'primary_color' => array('label' => 'Primary Color', 'type' => 'color'),
        'secondary_color' => array('label' => 'Secondary Color', 'type' => 'color'),
        'tertiary_color' => array('label' => 'Tertiary Color', 'type' => 'color'),
    );

    render_custom_fields($post, $fields);
}

function render_custom_fields($post, $fields)
{
    foreach ($fields as $key => $field) {
        $value = get_post_meta($post->ID, $key, true);
        echo "<div class='custom-field'>";
        echo "<label for='$key'>{$field['label']} <small>($key)</small></label>";

        switch ($field['type']) {
            case 'text':
            case 'url':
                echo "<input type='{$field['type']}' id='$key' name='$key' value='" . esc_attr($value) . "' style='width: 100%;'>";
                break;
            case 'editor':
                wp_editor($value, $key, array('textarea_name' => $key, 'textarea_rows' => 5));
                break;
            case 'image':
                echo "<input type='text' id='$key' name='$key' value='" . esc_attr($value) . "' style='width: 80%;'>";
                echo "<button type='button' class='upload-image-button button' data-field='$key'>Choose Image</button>";
                echo "<div class='image-preview'>";
                if ($value) {
                    echo "<img style='max-width: 100%;' src='" . esc_url($value) . "' alt='Preview'>";
                }
                echo "</div>";
                break;
            case 'color':
                echo "<input type='text' id='$key' name='$key' value='" . esc_attr($value) . "' class='color-picker'>";
                break;
            case 'select':
                echo "<select id='$key' name='$key'>";
                foreach ($field['options'] as $option_value => $option_label) {
                    echo "<option value='$option_value' " . selected($value, $option_value, false) . ">$option_label</option>";
                }
                echo "</select>";
                break;
        }
        echo "</div>";
    }
}


function save_custom_fields($post_id)
{
    $nonces = array(
        'custom_main_fields_nonce',
        'custom_product_fields_nonce',
        'custom_sidebar_fields_nonce',
        'custom_color_fields_nonce'
    );

    foreach ($nonces as $nonce) {
        if (!isset($_POST[$nonce]) || !wp_verify_nonce($_POST[$nonce], $nonce)) {
            return;
        }
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Get all existing custom fields
    $existing_fields = array_keys(get_post_custom($post_id));

    // Define all possible custom fields
    $all_possible_fields = array(
        'disclosure_top',
        'subtitle',
        'benefits_nav_text',
        'ingredients_nav_text',
        'top_5_nav_text',
        'disclosure',
        'effect_image',
        'benefits_title',
        'benefits_content',
        'usage_title',
        'usage_content',
        'ingredients_to_look_for_title',
        'ingredients_to_look_for_content',
        'ingredients_to_avoid_title',
        'ingredients_to_avoid_content',
        'considerations_title',
        'considerations_content',
        'top_products_title',
        'citations_title',
        'citations',
        'back_to_top_text',
        'num_products',
        'sidebar_1_title',
        'sidebar_1_subtitle',
        'sidebar_1_image_1',
        'sidebar_1_image_2',
        'sidebar_2_title',
        'sidebar_2_subtitle',
        'sidebar_2_link_title_top5',
        'primary_color',
        'secondary_color',
        'tertiary_color',
        'sidebar_2_icon_1',
        'sidebar_2_icon_2',
        'sidebar_2_icon_3',
        'sidebar_2_icon_4',
        'sidebar_2_icon_5',

    );

    // Add product-specific fields
    $num_products = isset($_POST['num_products']) ? intval($_POST['num_products']) : 5;
    for ($i = 1; $i <= $num_products; $i++) {
        $all_possible_fields = array_merge($all_possible_fields, array(
            "product_{$i}_name",
            "product_{$i}_brand",
            "product_{$i}_link",
            "product_{$i}_image",
            "product_{$i}_rating_image",
            "product_{$i}_grade",
            "product_{$i}_pros",
            "product_{$i}_cons",
            "product_{$i}_bottom_line"
        ));
    }

    // Combine existing and possible fields
    $fields_to_save = array_unique(array_merge($existing_fields, $all_possible_fields));

    foreach ($fields_to_save as $field) {
        if (isset($_POST[$field])) {
            $value = $_POST[$field];
            if ($field === 'citations') {
                // Allow more HTML tags for citations, including ol and li
                $allowed_html = array(
                    'a' => array(
                        'href' => array(),
                        'title' => array(),
                        'target' => array()
                    ),
                    'ol' => array(),
                    'li' => array(),
                    'p' => array(),
                    'br' => array(),
                    'strong' => array(),
                    'em' => array()
                );
                $value = wp_kses($value, $allowed_html);
            } elseif (strpos($field, '_content') !== false || strpos($field, '_pros') !== false || strpos($field, '_cons') !== false || strpos($field, '_bottom_line') !== false) {
                $value = wp_kses_post($value);
            } elseif (strpos($field, '_image') !== false || (strpos($field, '_link') !== false && $field !== 'sidebar_2_link_title_top5')) {
                $value = esc_url_raw($value);
            } else {
                $value = sanitize_text_field($value);
            }
            update_post_meta($post_id, $field, $value);
            log_message("Updated field '$field' with value: $value");
        }
    }
}

add_action('save_post', 'save_custom_fields');

function resize_image_url($url, $max_width, $max_height)
{
    $upload_dir = wp_upload_dir();
    $image_data = file_get_contents($url);
    $filename = basename($url);

    if (wp_mkdir_p($upload_dir['path'])) {
        $file = $upload_dir['path'] . '/' . $filename;
    } else {
        $file = $upload_dir['basedir'] . '/' . $filename;
    }

    file_put_contents($file, $image_data);

    $wp_filetype = wp_check_filetype($filename, null);
    $attachment = array(
        'post_mime_type' => $wp_filetype['type'],
        'post_title' => sanitize_file_name($filename),
        'post_content' => '',
        'post_status' => 'inherit'
    );

    $attach_id = wp_insert_attachment($attachment, $file);
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    $attach_data = wp_generate_attachment_metadata($attach_id, $file);
    wp_update_attachment_metadata($attach_id, $attach_data);

    $image = wp_get_image_editor($file);
    if (!is_wp_error($image)) {
        $image->resize($max_width, $max_height, false);
        $image->save($file);
    }

    return wp_get_attachment_url($attach_id);
}

// Remove default custom fields metabox
function remove_custom_fields_metabox()
{
    remove_meta_box('postcustom', 'post', 'normal');
}
add_action('admin_menu', 'remove_custom_fields_metabox');

function save_custom_all_fields($post_id)
{
    if (!isset($_POST['custom_all_fields_nonce']) || !wp_verify_nonce($_POST['custom_all_fields_nonce'], 'custom_all_fields_nonce')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $fields = array_keys(get_post_custom($post_id));

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            $value = $_POST[$field];
            if (strpos($field, '_content') !== false || strpos($field, '_pros') !== false || strpos($field, '_cons') !== false || strpos($field, '_bottom_line') !== false) {
                $value = wp_kses_post($value);
            } elseif (strpos($field, '_image') !== false || strpos($field, '_link') !== false) {
                $value = esc_url_raw($value);
            } else {
                $value = sanitize_text_field($value);
            }
            update_post_meta($post_id, $field, $value);
        }
    }
}
add_action('save_post', 'save_custom_all_fields');

function register_custom_fields_to_rest_api()
{
    $custom_fields = [
        'disclosure_top',
        'subtitle',
        'benefits_nav_text',
        'ingredients_nav_text',
        'top_5_nav_text',
        'disclosure',
        'effect_image',
        'benefits_title',
        'benefits_content',
        'usage_title',
        'usage_content',
        'ingredients_to_look_for_title',
        'ingredients_to_look_for_content',
        'ingredients_to_avoid_title',
        'ingredients_to_avoid_content',
        'considerations_title',
        'considerations_content',
        'top_products_title',
        'citations_title',
        'citations',
        'back_to_top_text',
        'num_products',
        'sidebar_1_title',
        'sidebar_1_subtitle',
        'sidebar_1_image_1',
        'sidebar_1_image_2',
        'sidebar_2_title',
        'sidebar_2_subtitle',
        'sidebar_2_link_title_top5',
        'primary_color',
        'secondary_color',
        'tertiary_color'
    ];

    // Add product-specific fields
    for ($i = 1; $i <= 10; $i++) {
        $custom_fields = array_merge($custom_fields, [
            "product_{$i}_name",
            "product_{$i}_brand",
            "product_{$i}_link",
            "product_{$i}_image",
            "product_{$i}_rating_image",
            "product_{$i}_grade",
            "product_{$i}_pros",
            "product_{$i}_cons",
            "product_{$i}_bottom_line"
        ]);
    }

    foreach ($custom_fields as $field) {
        register_rest_field('post', $field, array(
            'get_callback' => function ($post_arr) use ($field) {
                return get_post_meta($post_arr['id'], $field, true);
            },
            'update_callback' => function ($value, $post, $field_name) {
                return update_post_meta($post->ID, $field_name, $value);
            },
            'schema' => null,
        ));
    }
}
add_action('rest_api_init', 'register_custom_fields_to_rest_api');
