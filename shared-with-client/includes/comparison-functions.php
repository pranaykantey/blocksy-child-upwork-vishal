<?php
// global $post;
// Define global variables for custom fields
$GLOBALS['common_fields'] = array(
    'logo_url',
    'author_image',
    'author_name',
    'site_name',
    'site_url',
    'intro_headline',
    'meta_keywords',
    'meta_description',
);

$GLOBALS['product_comparison_fields'] = array(
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
    'back_to_top_text'
);


log_message("Functions.php is being loaded");

// Enqueue parent and child styles
function comparison_enqueue_styles()
{

    global $post;
    $template = get_page_template_slug($post->ID);
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('child-style', get_stylesheet_uri());
    if ($template == 'single-product-comparison.php') {
        wp_enqueue_style('product-comparison-style', get_stylesheet_directory_uri() . '/product-comparison.css', array(), '1.1');
        wp_enqueue_script('product-comparison-script', get_stylesheet_directory_uri() . '/product-comparison.js', array('jquery'), '1.1', true);
    }

    log_message("Styles enqueued: parent-style and child-style");
}
add_action('wp_enqueue_scripts', 'comparison_enqueue_styles');



// Register product comparison template
// function register_product_comparison_template($templates)
// {
//     $templates['single-product-comparison.php'] = 'Product Comparison';
//     log_message("Product comparison template registered");
//     return $templates;
// }
// add_filter('theme_post_templates', 'register_product_comparison_template');

// // Set template for product comparison posts
// function set_product_comparison_template($template)
// {
//     if (is_singular('post') && get_page_template_slug() === 'single-product-comparison.php') {
//         $new_template = locate_template(array('single-product-comparison.php'));
//         if (!empty($new_template)) {
//             log_message("Product comparison template set for post ID: " . get_the_ID());
//             return $new_template;
//         } else {
//             log_message("Product comparison template not found for post ID: " . get_the_ID());
//         }
//     }
//     return $template;
// }
// add_filter('single_template', 'set_product_comparison_template');

// Add meta box for product review and comparison
function add_product_comparison_meta_box()
{
    log_message("Attempting to add product meta box");
    $post_types = array('post', 'page');
    foreach ($post_types as $post_type) {

        global $post;
        $template = get_page_template_slug($post->ID);
        if ($template == 'single-product-comparison.php') {
            add_meta_box(
                'product_meta_box',
                'Product Details',
                'product_meta_box_comparison_callback',
                $post_type,
                'normal',
                'high'
            );
        }
    }
    log_message("Product meta box added");
}
add_action('add_meta_boxes', 'add_product_comparison_meta_box');



// function get_post_meta_with_fallback($post_id, $key, $single = true)
// {
//     $value = get_post_meta($post_id, $key, $single);
//     if ($value === '' || $value === false) {
//         $value = get_post_meta($post_id, '_' . $key, $single);
//     }
//     return $value;
// }

function product_meta_box_comparison_callback($post)
{
    log_message("Product meta box callback started for post ID: " . $post->ID);
    $template = get_page_template_slug($post->ID);
    log_message("Template for post ID " . $post->ID . ": " . $template);

    wp_nonce_field('product_meta_box_comparison', 'product_meta_box_comparison_nonce');

    echo '<div id="product-comparison-fields" ' . ($template !== 'single-product-comparison.php' ? 'style="display:none;"' : '') . '>';
    log_message("Displaying product comparison fields");
    if ($template === 'single-product-comparison.php') {
        product_comparison_fields($post);
    }
    echo '</div>';

    log_message("Product meta box callback completed for post ID: " . $post->ID);
}



function product_comparison_fields($post)
{
    echo '<h3>Main Custom Fields</h3>';
    field_text($post, 'disclosure_top', 'Disclosure Top');
    field_text($post, 'subtitle', 'Subtitle');
    field_text($post, 'benefits_nav_text', 'Benefits Nav Text');
    field_text($post, 'ingredients_nav_text', 'Ingredients Nav Text');
    field_text($post, 'top_5_nav_text', 'Top 5 Nav Text');
    field_text($post, 'disclosure', 'Disclosure');
    field_image($post, 'effect_image', 'The Effect Image');
    field_text($post, 'benefits_title', 'Benefits Title');
    field_editor($post, 'benefits_content', 'Benefits Content');
    field_text($post, 'usage_title', 'Usage Title');
    field_editor($post, 'usage_content', 'Usage Content');
    field_text($post, 'ingredients_to_look_for_title', 'Ingredients to Look For Title');
    field_editor($post, 'ingredients_to_look_for_content', 'Ingredients to Look For Content');
    field_text($post, 'ingredients_to_avoid_title', 'Ingredients to Avoid Title');
    field_editor($post, 'ingredients_to_avoid_content', 'Ingredients to Avoid Content');
    field_text($post, 'considerations_title', 'Considerations Title');
    field_editor($post, 'considerations_content', 'Considerations Content');
    field_text($post, 'top_products_title', 'Top Products Title');
    field_text($post, 'citations_title', 'Citations Title');
    field_editor($post, 'citations', 'Citations');
    field_text($post, 'back_to_top_text', 'Back to Top Text');



    echo '<h3>Product Information</h3>';
    $num_products = get_post_meta($post->ID, 'num_products', true) ?: 5;
    field_number($post, 'num_products', 'Number of Products', 1, 10);

    for ($i = 1; $i <= $num_products; $i++) {

        echo '<div class="product-item-repeater-box">';
        echo "<h4>Product $i</h4>";
        field_text($post, "product_{$i}_name", 'Name');
        field_text($post, "product_{$i}_brand", 'Brand');
        field_text($post, "product_{$i}_link", 'Link');
        field_image($post, "product_{$i}_image", 'Image');
        field_image($post, "product_{$i}_rating_image", 'Rating Image');
        field_text($post, "product_{$i}_grade", 'Grade');
        field_editor($post, "product_{$i}_pros", 'Pros');
        field_editor($post, "product_{$i}_cons", 'Cons');
        field_editor($post, "product_{$i}_bottom_line", 'Bottom Line');
        echo '</div>';
    }


    // button_color
}


function add_product_meta_box_sidebar()
{
    log_message("Attempting to add product meta box");
    $post_types = array('post', 'page');
    foreach ($post_types as $post_type) {
        add_meta_box(
            'product_meta_box_sidebar',
            'Sidebar Details',
            'product_meta_box_sidebar_callback',
            $post_type,
            'side',
            'low'
        );
    }
    log_message("Product meta box added");
}
add_action('add_meta_boxes', 'add_product_meta_box_sidebar');


function product_meta_box_sidebar_callback($post)
{

    log_message("Product meta box sidebar callback started for post ID: " . $post->ID);
    $template = get_page_template_slug($post->ID);
    log_message("Template for post ID " . $post->ID . ": " . $template);

    echo '<div id="product-comparison-fields-sidebar">';
    log_message("Displaying product comparison sidebar fields");
    product_comparison_sidebar_fields($post);
    echo '</div>';

    log_message("Product meta box sidebar callback completed for post ID: " . $post->ID);
}

function product_comparison_sidebar_fields($post)
{
    echo '<h3>Sidebar One Information</h3>';
    field_text($post, 'sidebar_1_title', 'Sidebar 1 Title');
    field_text($post, 'sidebar_1_subtitle', 'Sidebar 1 Subtitle');
    field_image($post, 'sidebar_1_image_1', 'Sidebar 1 Image 1');
    field_image($post, 'sidebar_1_image_2', 'Sidebar 1 Image 2');
    field_text($post, 'sidebar_2_title', 'Sidebar 2 Title');
    field_text($post, 'sidebar_2_subtitle', 'Sidebar 2 Subtitle');
    field_text($post, 'sidebar_2_link_title_top5', 'Sidebar 2 Link Title Top 5');
    echo '<h3> Sidebar Two Information </h3>';

    field_select($post, 'sidebar_2_icon_1', 'Sidebar 2 Icon 1', [
        'active'    => 'Active',
        'inactive'  => 'Inactive',
    ]);
    field_select($post, 'sidebar_2_icon_2', 'Sidebar 2 Icon 2', [
        'active'    => 'Active',
        'inactive'  => 'Inactive',
    ]);
    field_select($post, 'sidebar_2_icon_3', 'Sidebar 2 Icon 3', [
        'active'    => 'Active',
        'inactive'  => 'Inactive',
    ]);
    field_select($post, 'sidebar_2_icon_4', 'Sidebar 2 Icon 4', [
        'active'    => 'Active',
        'inactive'  => 'Inactive',
    ]);
    field_select($post, 'sidebar_2_icon_5', 'Sidebar 2 Icon 5', [
        'active'    => 'Active',
        'inactive'  => 'Inactive',
    ]);
    field_select($post, 'sidebar_2_icon_6', 'Sidebar 2 Icon 6', [
        'active'    => 'Active',
        'inactive'  => 'Inactive',
    ]);
}

/**** Global Fields  ****/
function add_product_comparison_global_meta_box()
{
    log_message("Attempting to add product meta box");
    $post_types = array('post', 'page');
    foreach ($post_types as $post_type) {

        global $post;
        $template = get_page_template_slug($post->ID);
        if ($template == 'single-product-comparison.php') {
            add_meta_box(
                'product_meta_box_comparison_global',
                'Global Details',
                'product_meta_box_comparison_global_callback',
                $post_type,
                'normal',
                'high'
            );
        }
    }
    log_message("Product meta box added");
}
add_action('add_meta_boxes', 'add_product_comparison_global_meta_box');

function product_meta_box_comparison_global_callback($post)
{
    log_message("Product meta box callback started for post ID: " . $post->ID);
    $template = get_page_template_slug($post->ID);
    log_message("Template for post ID " . $post->ID . ": " . $template);

    wp_nonce_field('product_meta_box_comparison', 'product_meta_box_comparison_nonce');

    echo '<div id="product-comparison-fields" ' . ($template !== 'single-product-comparison.php' ? 'style="display:none;"' : '') . '>';
    log_message("Displaying product campaign fields");
    if ($template === 'single-product-comparison.php') {
        product_comparison_global_fields($post);
    }
    echo '</div>';

    log_message("Product meta box callback completed for post ID: " . $post->ID);
}

function product_comparison_global_fields($post)
{
    echo '<h3>Global Information</h3>';
    $count = count($GLOBALS['common_fields']);
    $x = 0;
    while ($x < $count) {
        field_text($post, $GLOBALS['common_fields'][$x], $GLOBALS['common_fields'][$x]);
        $x++;
    }
}

/**
 * saving metabox fields values.
 *
 * @param   [type]  $post_id  [$post_id description]
 *
 * @return  [type]            [return description]
 */
function save_product_meta($post_id)
{
    if (!isset($_POST['product_meta_box_comparison_nonce']) || !wp_verify_nonce($_POST['product_meta_box_comparison_nonce'], 'product_meta_box_comparison')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $template = get_page_template_slug($post_id);

    $fields_to_save = array(
        // Common fields
        'num_products',
        'logo_url',
        'author_image',
        'author_name',
        // comparison fields 
        'site_name',
        'site_url',
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
        'sidebar_1_title',
        'sidebar_1_image_1',
        'sidebar_1_image_2',
        'sidebar_1_subtitle',
        'sidebar_2_title',
        'sidebar_2_subtitle',
        'sidebar_2_icon_1',
        'sidebar_2_icon_2',
        'sidebar_2_icon_3',
        'sidebar_2_icon_4',
        'sidebar_2_icon_5',
        'sidebar_2_icon_6',
        'intro_headline',
        'meta_keywords',
        'meta_description',

    );


    foreach ($fields_to_save as $field) {
        if (isset($_POST[$field])) {
            $value = $_POST[$field];

            $value = wp_kses_post($value);

            update_post_meta($post_id, $field, $value);
        }
    }

    // Save custom product fields
    if (isset($_POST['custom_product_fields'])) {
        $custom_fields = array_map('sanitize_text_field', $_POST['custom_product_fields']);
        update_post_meta($post_id, 'custom_product_fields', $custom_fields);
    }

    // Save product-specific fields

    $num_products = get_post_meta($post_id, 'num_products', true) ? get_post_meta($post_id, 'num_products', true) : 5;
    $num_products = (int) $num_products;
    // $num_products = intval($_POST['num_products']);

    for ($i = 1; $i <= $num_products; $i++) {
        $product_fields = array(
            'name',
            'brand',
            'link',
            'image',
            'rating_image',
            'grade',
            'pros',
            'cons',
            'bottom_line',
            'rating',
            // 'effectiveness',
            // 'safety',
            // 'price',
            'field_one',
            'description'
        );

        $custom_fieldss = get_post_meta($post_id, 'custom_product_fields', true) ?: array('Effectiveness', 'Safety', 'Price');

        foreach ($custom_fieldss as $fieldd) {
            $newFieldVal = strtolower($fieldd);
            $newFieldVal = str_replace(' ', '_', $newFieldVal);
            $product_fields[]   = $newFieldVal;
        }

        // var_dump($product_fields);

        foreach ($product_fields as $field) {
            $key = "product_{$i}_{$field}";
            if (isset($_POST[$key])) {
                $value = in_array($field, array('pros', 'cons', 'bottom_line', 'description', 'link'))
                    ? wp_kses_post($_POST[$key])
                    : sanitize_text_field($_POST[$key]);

                // Special handling for the link field
                if ($field === 'link') {
                    $value = esc_url_raw($_POST[$key]);
                }

                // var_dump($value);

                update_post_meta($post_id, $key, $value);
            }
        }
    }
}
add_action('save_post', 'save_product_meta');


// function save_product_comparison_meta($post_id)
// {
//     $fields = array(
//         'disclosure_top',
//         'subtitle',
//         'benefits_nav_text',
//         'ingredients_nav_text',
//         'top_5_nav_text',
//         'disclosure',
//         'effect_image',
//         'benefits_title',
//         'benefits_content',
//         'usage_title',
//         'usage_content',
//         'ingredients_to_look_for_title',
//         'ingredients_to_look_for_content',
//         'ingredients_to_avoid_title',
//         'ingredients_to_avoid_content',
//         'considerations_title',
//         'considerations_content',
//         'top_products_title',
//         'citations_title',
//         'citations',
//         'back_to_top_text',
//         'sidebar_1_title',
//         'sidebar_1_image_1',
//         'sidebar_1_image_2',
//         'sidebar_1_subtitle',
//         'sidebar_2_title',
//         'sidebar_2_subtitle',
//         'sidebar_2_icon_1',
//         'sidebar_2_icon_2',
//         'sidebar_2_icon_3',
//         'sidebar_2_icon_4',
//         'sidebar_2_icon_5',
//         'sidebar_2_icon_6'
//     );

//     foreach ($fields as $field) {
//         if (isset($_POST[$field])) {
//             $value = in_array($field, array('benefits_content', 'usage_content', 'ingredients_to_look_for_content', 'ingredients_to_avoid_content', 'considerations_content', 'citations'))
//                 ? wp_kses_post($_POST[$field])
//                 : sanitize_text_field($_POST[$field]);
//             update_post_meta($post_id, $field, $value);
//         }
//     }
// }
