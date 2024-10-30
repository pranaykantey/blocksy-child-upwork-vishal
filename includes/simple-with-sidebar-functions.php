<?php
// global $post;
// Define global variables for custom fields
$GLOBALS['common_fields'] = array(
    'intro_headline',
    'meta_keywords',
    'meta_description'
);


/***************************************************
 *************** Register Template *****************
 ***************************************************/
// Register product simple_sidebar template
function register_sinple_sidebar_template($templates)
{
    $templates['simple-with-sidebar.php'] = 'Simple Sidebar';
    return $templates;
}
add_filter('theme_page_templates', 'register_sinple_sidebar_template');
add_filter('theme_post_templates', 'register_sinple_sidebar_template');

function add_simple_sidebar_to_post_templates($post_templates, $wp_theme, $post, $post_type)
{
    if ('post' === $post_type) {
        $post_templates['simple-with-sidebar.php'] = 'Simple Sidebar';
    }
    return $post_templates;
}
add_filter('theme_post_templates', 'add_simple_sidebar_to_post_templates', 10, 4);

// Load product simple_sidebar template
function load_product_simple_sidebar_template($template)
{
    if (is_singular() && get_page_template_slug() === 'simple-with-sidebar.php') {
        $template = locate_template('simple-with-sidebar.php');
    }
    return $template;
}
add_filter('template_include', 'load_product_simple_sidebar_template', 99);


log_message("Functions.php is being loaded");


/***************************************************
 ************ Enqueue Scripts/Styles  **************
 ***************************************************/
// Enqueue parent and child styles
function simple_sidebar_enqueue_styles()
{
    global $post;
    $template = get_page_template_slug($post->ID);
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('child-style', get_stylesheet_uri());
    if ($template == 'simple-with-sidebar.php') {
        wp_enqueue_style('product-simple_sidebar-style', get_stylesheet_directory_uri() . '/css/simple-with-sidebar.css', array(), '1.1');
    }

    // wp_enqueue_script('product-simple_sidebar-script', get_stylesheet_directory_uri() . '/js/product-simple_sidebar.js', array('jquery'), '1.1', true);

    // echo get_stylesheet_directory_uri() . '/css/product-simple_sidebar.css';

    log_message("Styles enqueued: parent-style and child-style");
}
add_action('wp_enqueue_scripts', 'simple_sidebar_enqueue_styles');



/***************************************************
 ************       Meta Boxes        **************
 ***************************************************/
// Add meta box for product simple_sidebar and simple_sidebar
function add_product_simple_sidebar_meta_box()
{
    log_message("Attempting to add product meta box");
    $post_types = array('post', 'page');
    foreach ($post_types as $post_type) {

        global $post;
        $template = get_page_template_slug($post->ID);
        if ($template == 'simple-with-sidebar.php') {
            add_meta_box(
                'product_meta_box_simple_sidebar',
                'Product Details',
                'product_meta_box_simple_sidebar_callback',
                $post_type,
                'normal',
                'high'
            );
        }
    }
    log_message("Product meta box added");
}
add_action('add_meta_boxes', 'add_product_simple_sidebar_meta_box');


function product_meta_box_simple_sidebar_callback($post)
{
    log_message("Product meta box callback started for post ID: " . $post->ID);
    $template = get_page_template_slug($post->ID);
    log_message("Template for post ID " . $post->ID . ": " . $template);

    wp_nonce_field('product_meta_box_simple_sidebar', 'product_meta_box_simple_sidebar_nonce');

    echo '<div id="product-simple_sidebar-fields" ' . ($template !== 'simple-with-sidebar.php' ? 'style="display:none;"' : '') . '>';
    log_message("Displaying product simple_sidebar fields");
    if ($template === 'simple-with-sidebar.php') {
        product_simple_with_sidebar_fields($post);
    }
    echo '</div>';

    log_message("Product meta box callback completed for post ID: " . $post->ID);
}

function product_simple_with_sidebar_fields($post)
{
    echo '<h3> Subtitle </h3>';
    field_editor($post, 'subtitle', 'Subtitle');
    echo '<h3> Author Info </h3>';
    field_text($post, 'author_name', 'Author Name');
    field_image($post, 'author_image', 'Author Image');

    echo '<h3>Product Information</h3>';
    $num_products = get_post_meta($post->ID, 'num_products', true) ?: 5;
    field_number($post, 'num_products', 'Number of Products', 1, 10);
    for ($i = 1; $i <= $num_products; $i++) {
        echo '<div class="product-item-repeater-box">';
        echo "<h4>Product $i</h4>";
        field_text($post, "product_{$i}_name", 'Name');
        // field_text($post, "product_{$i}_brand", 'Brand');
        // field_text($post, "product_{$i}_link", 'Link');
        field_image($post, "product_{$i}_image", 'Image');
        // field_image($post, "product_{$i}_rating_image", 'Rating Image');
        // field_text($post, "product_{$i}_grade", 'Grade');
        field_editor($post, "product_{$i}_pros", 'Pros');
        field_editor($post, "product_{$i}_cons", 'Cons');
        // field_editor($post, "product_{$i}_bottom_line", 'Bottom Line');
        echo '</div>';
    }
}

/**** Review Fields  ****/

function add_product_simple_sidebar_review_meta_box()
{
    log_message("Attempting to add product meta box");
    $post_types = array('post', 'page');
    foreach ($post_types as $post_type) {

        global $post;
        $template = get_page_template_slug($post->ID);
        if ($template == 'simple-with-sidebar.php') {
            add_meta_box(
                'product_meta_box_simple_sidebar_review',
                'Sidebar & Footer',
                'product_meta_box_simple_sidebar_review_callback',
                $post_type,
                'normal',
                'high'
            );
        }
    }
    log_message("Product meta box added");
}
add_action('add_meta_boxes', 'add_product_simple_sidebar_review_meta_box');

function product_meta_box_simple_sidebar_review_callback($post)
{
    log_message("Product meta box callback started for post ID: " . $post->ID);
    $template = get_page_template_slug($post->ID);
    log_message("Template for post ID " . $post->ID . ": " . $template);

    wp_nonce_field('product_meta_box_simple_sidebar', 'product_meta_box_simple_sidebar_nonce');

    echo '<div id="product-simple_sidebar-fields" ' . ($template !== 'simple-with-sidebar.php' ? 'style="display:none;"' : '') . '>';
    log_message("Displaying product simple_sidebar fields");
    if ($template === 'simple-with-sidebar.php') {
        product_simple_sidebar_review_fields($post);
    }
    echo '</div>';

    log_message("Product meta box callback completed for post ID: " . $post->ID);
}
function product_simple_sidebar_review_fields($post)
{

    // 'considerations_title',
    // 'considerations_image',
    // 'considerations_content',
    echo '<h3>Sidebar and Footer</h3>';
    field_editor($post, 'considerations_title', 'Final Thought');
    field_image($post, 'considerations_image', 'Final Thought Image');
    field_editor($post, 'considerations_content', 'Final Thought Content');
    field_image($post, 'sidebar_ad_image', 'Sidebar Image');
    field_text($post, 'sidebar_ad_image_link', 'Sidebar Ad Link');
    field_image($post, 'footer_image', 'Footer Image');
    field_text($post, 'footer_image_link', 'Footer Image Link');
    field_editor($post, 'footer_text', 'Footer Text');
    field_text($post, 'footer_text_link', 'Footer Text Link');
    field_image($post, 'footer_ad_image', 'Footer Ad Image');
    field_text($post, 'footer_ad_image_link', 'Footer Ad Link');
    field_text($post, 'footer_button_one_text', 'Footer Button One Text');
    field_text($post, 'footer_button_one_link', 'Footer Button One Link');
    field_text($post, 'footer_button_two_text', 'Footer Button Two Text');
    field_text($post, 'footer_button_two_link', 'Footer Button Two Link');
}
/**** Footer Fields  ****/
// function add_product_simple_sidebar_footer_meta_box()
// {
//     log_message("Attempting to add product meta box");
//     $post_types = array('post', 'page');
//     foreach ($post_types as $post_type) {

//         global $post;
//         $template = get_page_template_slug($post->ID);
//         if ($template == 'simple-with-sidebar.php') {
//             add_meta_box(
//                 'product_meta_box_simple_sidebar_footer',
//                 'Footer Details',
//                 'product_meta_box_simple_sidebar_footer_callback',
//                 $post_type,
//                 'normal',
//                 'high'
//             );
//         }
//     }
//     log_message("Product meta box added");
// }
// add_action('add_meta_boxes', 'add_product_simple_sidebar_footer_meta_box');

// function product_meta_box_simple_sidebar_footer_callback($post)
// {
//     log_message("Product meta box callback started for post ID: " . $post->ID);
//     $template = get_page_template_slug($post->ID);
//     log_message("Template for post ID " . $post->ID . ": " . $template);

//     wp_nonce_field('product_meta_box_simple_sidebar', 'product_meta_box_simple_sidebar_nonce');

//     echo '<div id="product-simple_sidebar-fields" ' . ($template !== 'simple-with-sidebar.php' ? 'style="display:none;"' : '') . '>';
//     log_message("Displaying product simple_sidebar fields");
//     if ($template === 'simple-with-sidebar.php') {
//         product_simple_sidebar_footer_fields($post);
//     }
//     echo '</div>';

//     log_message("Product meta box callback completed for post ID: " . $post->ID);
// }

// function product_simple_sidebar_footer_fields($post)
// {
//     echo '<h3>Footer Information</h3>';
//     field_editor($post, "footer_text", "Footer Text");
//     field_image($post, 'footer_image', "Image");
//     field_text($post, "footer_button_one_text", "Button 1 Text");
//     field_text($post, "footer_button_one_link", "Button 1 Link");
//     field_text($post, "footer_button_two_text", "Button 2 Text");
//     field_text($post, "footer_button_two_link", "Button 2 Link");
// }

/**** Global Fields  ****/
function add_product_simple_sidebar_global_meta_box()
{
    log_message("Attempting to add product meta box");
    $post_types = array('post', 'page');
    foreach ($post_types as $post_type) {

        global $post;
        $template = get_page_template_slug($post->ID);
        if ($template == 'simple-with-sidebar.php') {
            add_meta_box(
                'product_meta_box_simple_sidebar_global',
                'Global Details',
                'product_meta_box_simple_sidebar_global_callback',
                $post_type,
                'normal',
                'high'
            );
        }
    }
    log_message("Product meta box added");
}
add_action('add_meta_boxes', 'add_product_simple_sidebar_global_meta_box');

function product_meta_box_simple_sidebar_global_callback($post)
{
    log_message("Product meta box callback started for post ID: " . $post->ID);
    $template = get_page_template_slug($post->ID);
    log_message("Template for post ID " . $post->ID . ": " . $template);

    wp_nonce_field('product_meta_box_simple_sidebar', 'product_meta_box_simple_sidebar_nonce');

    echo '<div id="product-simple_sidebar-fields" ' . ($template !== 'simple-with-sidebar.php' ? 'style="display:none;"' : '') . '>';
    log_message("Displaying product simple_sidebar fields");
    if ($template === 'simple-with-sidebar.php') {
        product_simple_sidebar_global_fields($post);
    }
    echo '</div>';

    log_message("Product meta box callback completed for post ID: " . $post->ID);
}

function product_simple_sidebar_global_fields($post)
{
    echo '<h3>Global Information</h3>';
    $count = count($GLOBALS['common_fields']);
    $x = 0;
    while ($x < $count) {
        field_text($post, $GLOBALS['common_fields'][$x], $GLOBALS['common_fields'][$x]);
        $x++;
    }
}

/***************************************************
 ************   Saving Meta Boxes     **************
 ***************************************************/

function save_simple_sidebar_product_meta($post_id)
{
    if (!isset($_POST['product_meta_box_simple_sidebar_nonce']) || !wp_verify_nonce($_POST['product_meta_box_simple_sidebar_nonce'], 'product_meta_box_simple_sidebar')) {
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
        'num_products',
        'logo_url',
        'subtitle',
        'author_image',
        'author_name',
        'sidebar_ad_image',
        'sidebar_ad_image_link',
        'site_name',
        'site_url',
        'num_reviews',
        'footer_text',
        'footer_text_link',
        'footer_image',
        'footer_image_link',
        'footer_ad_image',
        'footer_ad_image_link',
        'footer_button_one_text',
        'footer_button_one_link',
        'footer_button_two_text',
        'footer_button_two_link',
        'considerations_title',
        'considerations_image',
        'considerations_content',
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

    for ($i = 1; $i <= $num_products; $i++) {
        $product_fields = array(
            'name',
            'image',
            'pros',
            'cons',
        );


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


    // Save product-review fields
    $num_reviews = get_post_meta($post_id, 'num_reviews', true) ? get_post_meta($post_id, 'num_reviews', true) : 5;
    $num_reviews = (int) $num_reviews;

    for ($i = 1; $i <= $num_reviews; $i++) {
        $product_fields = array(
            'author',
            'image',
            'comment',
        );

        foreach ($product_fields as $field) {
            $key = "review_{$i}_{$field}";
            if (isset($_POST[$key])) {
                // $value = in_array($field, array('pros', 'cons', 'bottom_line', 'description', 'link'))
                //     ? wp_kses_post($_POST[$key])
                //     : sanitize_text_field($_POST[$key]);
                $value = $_POST[$key];
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
add_action('save_post', 'save_simple_sidebar_product_meta');
