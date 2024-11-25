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
// Register product campaign template
function register_product_campaign_template($templates)
{
    $templates['campaign-template.php'] = 'Product Campaign';
    return $templates;
}
add_filter('theme_page_templates', 'register_product_campaign_template');
add_filter('theme_post_templates', 'register_product_campaign_template');

function add_product_campaign_to_post_templates($post_templates, $wp_theme, $post, $post_type)
{
    if ('post' === $post_type) {
        $post_templates['campaign-template.php'] = 'Product campaign';
    }
    return $post_templates;
}
add_filter('theme_post_templates', 'add_product_campaign_to_post_templates', 10, 4);

// Load product campaign template
function load_product_campaign_template($template)
{
    if (is_singular() && get_page_template_slug() === 'campaign-template.php') {
        $template = locate_template('campaign-template.php');
    }
    return $template;
}
add_filter('template_include', 'load_product_campaign_template', 99);


log_message("Functions.php is being loaded");


/***************************************************
 ************ Enqueue Scripts/Styles  **************
 ***************************************************/
// Enqueue parent and child styles
function campaign_enqueue_styles()
{

    global $post;
    $template = get_page_template_slug($post->ID);
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('child-style', get_stylesheet_uri());
    if ($template == 'campaign-template.php') {
        wp_enqueue_style('product-campaign-style', get_stylesheet_directory_uri() . '/css/product-campaign.css', array(), '1.1');
    }


    // wp_enqueue_script('product-campaign-script', get_stylesheet_directory_uri() . '/js/product-campaign.js', array('jquery'), '1.1', true);

    // echo get_stylesheet_directory_uri() . '/css/product-campaign.css';

    log_message("Styles enqueued: parent-style and child-style");
}
add_action('wp_enqueue_scripts', 'campaign_enqueue_styles');



/***************************************************
 ************       Meta Boxes        **************
 ***************************************************/
// Add meta box for product campaign and campaign
function add_product_campaign_meta_box()
{
    log_message("Attempting to add product meta box");
    $post_types = array('post', 'page');
    foreach ($post_types as $post_type) {

        global $post;
        $template = get_page_template_slug($post->ID);
        if ($template == 'campaign-template.php') {
            add_meta_box(
                'product_meta_box_campaign',
                'Product Details',
                'product_meta_box_campaign_callback',
                $post_type,
                'normal',
                'high'
            );
        }
    }
    log_message("Product meta box added");
}
add_action('add_meta_boxes', 'add_product_campaign_meta_box');


function product_meta_box_campaign_callback($post)
{
    log_message("Product meta box callback started for post ID: " . $post->ID);
    $template = get_page_template_slug($post->ID);
    log_message("Template for post ID " . $post->ID . ": " . $template);

    wp_nonce_field('product_meta_box_campaign', 'product_meta_box_campaign_nonce');

    echo '<div id="product-campaign-fields" ' . ($template !== 'campaign-template.php' ? 'style="display:none;"' : '') . '>';
    log_message("Displaying product campaign fields");
    if ($template === 'campaign-template.php') {
        product_campaign_fields($post);
    }
    echo '</div>';

    log_message("Product meta box callback completed for post ID: " . $post->ID);
}

function product_campaign_fields($post)
{

    echo '<h3>Product Information</h3>';
    $num_products = get_post_meta($post->ID, 'num_products', true) ?: 5;
    field_number($post, 'num_products', 'Number of Products', 1, 10);

    for ($i = 1; $i <= $num_products; $i++) {
        echo "<h4>Product $i</h4>";
        field_text($post, "product_{$i}_name", 'Name');
        // field_text($post, "product_{$i}_brand", 'Brand');
        // field_text($post, "product_{$i}_link", 'Link');
        field_image($post, "product_{$i}_image", 'Image');
        // field_image($post, "product_{$i}_rating_image", 'Rating Image');
        // field_text($post, "product_{$i}_grade", 'Grade');
        field_editor($post, "product_{$i}_pros", 'Pros');
        // field_editor($post, "product_{$i}_cons", 'Cons');
        // field_editor($post, "product_{$i}_bottom_line", 'Bottom Line');
    }
}

/**** Review Fields  ****/

function add_product_campaign_review_meta_box()
{
    log_message("Attempting to add product meta box");
    $post_types = array('post', 'page');
    foreach ($post_types as $post_type) {

        global $post;
        $template = get_page_template_slug($post->ID);
        if ($template == 'campaign-template.php') {
            add_meta_box(
                'product_meta_box_campaign_review',
                'Review Details',
                'product_meta_box_campaign_review_callback',
                $post_type,
                'normal',
                'high'
            );
        }
    }
    log_message("Product meta box added");
}
add_action('add_meta_boxes', 'add_product_campaign_review_meta_box');

function product_meta_box_campaign_review_callback($post)
{
    log_message("Product meta box callback started for post ID: " . $post->ID);
    $template = get_page_template_slug($post->ID);
    log_message("Template for post ID " . $post->ID . ": " . $template);

    wp_nonce_field('product_meta_box_campaign', 'product_meta_box_campaign_nonce');

    echo '<div id="product-campaign-fields" ' . ($template !== 'campaign-template.php' ? 'style="display:none;"' : '') . '>';
    log_message("Displaying product campaign fields");
    if ($template === 'campaign-template.php') {
        product_campaign_review_fields($post);
    }
    echo '</div>';

    log_message("Product meta box callback completed for post ID: " . $post->ID);
}
function product_campaign_review_fields($post)
{

    echo '<h3>Review Information</h3>';
    $num_products = get_post_meta($post->ID, 'num_reviews', true) ? get_post_meta($post->ID, 'num_reviews', true) : 5;
    field_number($post, 'num_reviews', 'Number of Reviews', 1, 10);

    for ($i = 1; $i <= $num_products; $i++) {
        echo "<h4>Review $i</h4>";
        field_image($post, "review_{$i}_image", 'Image');
        field_text($post, "review_{$i}_author", 'Author');
        field_editor($post, "review_{$i}_comment", 'Comment');
    }
}
/**** Footer Fields  ****/
function add_product_campaign_footer_meta_box()
{
    log_message("Attempting to add product meta box");
    $post_types = array('post', 'page');
    foreach ($post_types as $post_type) {

        global $post;
        $template = get_page_template_slug($post->ID);
        if ($template == 'campaign-template.php') {
            add_meta_box(
                'product_meta_box_campaign_footer',
                'Footer Details',
                'product_meta_box_campaign_footer_callback',
                $post_type,
                'normal',
                'high'
            );
        }
    }
    log_message("Product meta box added");
}
add_action('add_meta_boxes', 'add_product_campaign_footer_meta_box');

function product_meta_box_campaign_footer_callback($post)
{
    log_message("Product meta box callback started for post ID: " . $post->ID);
    $template = get_page_template_slug($post->ID);
    log_message("Template for post ID " . $post->ID . ": " . $template);

    wp_nonce_field('product_meta_box_campaign', 'product_meta_box_campaign_nonce');

    echo '<div id="product-campaign-fields" ' . ($template !== 'campaign-template.php' ? 'style="display:none;"' : '') . '>';
    log_message("Displaying product campaign fields");
    if ($template === 'campaign-template.php') {
        product_campaign_footer_fields($post);
    }
    echo '</div>';

    log_message("Product meta box callback completed for post ID: " . $post->ID);
}

function product_campaign_footer_fields($post)
{
    echo '<h3>Footer Information</h3>';
    field_editor($post, "footer_text", "Footer Text");
    field_image($post, 'footer_image', "Image");
    field_text($post, "footer_button_one_text", "Button 1 Text");
    field_text($post, "footer_button_one_link", "Button 1 Link");
    field_text($post, "footer_button_two_text", "Button 2 Text");
    field_text($post, "footer_button_two_link", "Button 2 Link");
}

/**** Global Fields  ****/
function add_product_campaign_global_meta_box()
{
    log_message("Attempting to add product meta box");
    $post_types = array('post', 'page');
    foreach ($post_types as $post_type) {

        global $post;
        $template = get_page_template_slug($post->ID);
        if ($template == 'campaign-template.php') {
            add_meta_box(
                'product_meta_box_campaign_global',
                'Global Details',
                'product_meta_box_campaign_global_callback',
                $post_type,
                'normal',
                'high'
            );
        }
    }
    log_message("Product meta box added");
}
add_action('add_meta_boxes', 'add_product_campaign_global_meta_box');

function product_meta_box_campaign_global_callback($post)
{
    log_message("Product meta box callback started for post ID: " . $post->ID);
    $template = get_page_template_slug($post->ID);
    log_message("Template for post ID " . $post->ID . ": " . $template);

    wp_nonce_field('product_meta_box_campaign', 'product_meta_box_campaign_nonce');

    echo '<div id="product-campaign-fields" ' . ($template !== 'campaign-template.php' ? 'style="display:none;"' : '') . '>';
    log_message("Displaying product campaign fields");
    if ($template === 'campaign-template.php') {
        product_campaign_global_fields($post);
    }
    echo '</div>';

    log_message("Product meta box callback completed for post ID: " . $post->ID);
}

function product_campaign_global_fields($post)
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

function save_campaign_product_meta($post_id)
{
    if (!isset($_POST['product_meta_box_campaign_nonce']) || !wp_verify_nonce($_POST['product_meta_box_campaign_nonce'], 'product_meta_box_campaign')) {
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
        'author_image',
        'author_name',
        'site_name',
        'site_url',
        'num_reviews',
        'footer_text',
        'footer_image',
        'footer_button_one_text',
        'footer_button_one_link',
        'footer_button_two_text',
        'footer_button_two_link',
        'intro_headline',
        'meta_keywords',
        'meta_description',
    );



    foreach ($fields_to_save as $field) {
        if (isset($_POST[$field])) {
            $value = $_POST[$field];

            $value = wp_kses_post($value);

            $value = add_utm_to_links($value);
            update_post_meta($post_id, $field, $value);
        }
    }

    // Save custom product fields
    if (isset($_POST['custom_product_fields'])) {
        $custom_fields = array_map('sanitize_text_field', $_POST['custom_product_fields']);

        $custom_fields = add_utm_to_links($custom_fields);
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

                $value = add_utm_to_links($value);
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
                $value = add_utm_to_links($value);
                update_post_meta($post_id, $key, $value);
            }
        }
    }
}
add_action('save_post', 'save_campaign_product_meta');
