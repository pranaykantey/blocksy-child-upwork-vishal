<?php

// Define global variables for custom fields
$GLOBALS['common_fields'] = array(
    'num_products',
    'logo_url',
    'author_image',
    'author_name',
    'site_name',
    'site_url'
);

$GLOBALS['product_review_fields'] = array(
    'intro_headline',
    'intro_paragraph',
    'conclusion_headline1',
    'conclusion_para1',
    'conclusion_image1',
    'conclusion_para2',
    'conclusion_headline2',
    'conclusion_para3',
    'conclusion_image2',
    'conclusion_para4',
    'cta_text',
    'cta_link',
    'sidebar_ad_image',
    'best_product_category'
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


// Add a new function to handle Open Graph tags
function vitality_guide_conditional_open_graph_tags()
{
    // Check if we're not using the page-product-review.php template
    if (!is_page_template('page-product-review.php')) {
        global $post;
        if (is_singular()) {
            $post_id = $post->ID;
            $intro_headline = get_post_meta($post_id, 'intro_headline', true) ?: get_the_title();
            $author_name = get_post_meta($post_id, 'author_name', true) ?: get_the_author_meta('display_name');
            $site_name = get_post_meta($post_id, 'site_name', true) ?: get_bloginfo('name');
            $site_url = get_post_meta($post_id, 'site_url', true) ?: home_url();
?>
            <meta property="og:title" content="<?php echo esc_attr(get_the_title()); ?>" />
            <meta property="og:description" content="<?php echo esc_attr($intro_headline); ?>" />
            <meta property="og:url" content="<?php echo esc_url(get_permalink()); ?>" />
            <meta property="og:type" content="article" />
            <meta property="og:site_name" content="<?php echo esc_attr($site_name); ?>" />
            <meta property="og:image" content="<?php echo esc_url(get_the_post_thumbnail_url($post_id, 'large')); ?>" />
            <meta property="article:author" content="<?php echo esc_attr($author_name); ?>" />
            <meta property="article:published_time" content="<?php echo esc_attr(get_the_date('c')); ?>" />
            <meta property="og:article:author:name" content="<?php echo esc_attr($author_name); ?>" />
            <meta property="og:article:reading_time" content="6 minutes" />
            <meta property="og:site:url" content="<?php echo esc_url($site_url); ?>" />
    <?php
        }
    }
}

// Add the new function to the wp_head action
add_action('wp_head', 'vitality_guide_conditional_open_graph_tags');

// Remove any existing add_open_graph_tags action, if it exists
remove_action('wp_head', 'add_open_graph_tags');

if (!defined('ABSPATH')) {
    die('Direct access forbidden.');
}

// Enable WordPress debug logging
if (!defined('WP_DEBUG')) {
    define('WP_DEBUG', true);
}
if (!defined('WP_DEBUG_LOG')) {
    define('WP_DEBUG_LOG', true);
}
if (!defined('WP_DEBUG_DISPLAY')) {
    define('WP_DEBUG_DISPLAY', false);
}


function log_message($message)
{
    error_log(date('[Y-m-d H:i:s] ') . $message . "\n", 3, WP_CONTENT_DIR . '/debug.log');
}

log_message("Functions.php is being loaded");

// Enqueue parent and child styles
function child_enqueue_styles()
{
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('child-style', get_stylesheet_uri());

    wp_enqueue_style('product-comparison-style', get_stylesheet_directory_uri() . '/product-comparison.css', array(), '1.1');
    wp_enqueue_script('product-comparison-script', get_stylesheet_directory_uri() . '/product-comparison.js', array('jquery'), '1.1', true);

    log_message("Styles enqueued: parent-style and child-style");
}
add_action('wp_enqueue_scripts', 'child_enqueue_styles');

// Register product review template
function register_product_review_template($templates)
{
    $templates['page-product-review.php'] = 'Product Review';
    return $templates;
}
add_filter('theme_page_templates', 'register_product_review_template');
add_filter('theme_post_templates', 'register_product_review_template');

function add_product_review_to_post_templates($post_templates, $wp_theme, $post, $post_type)
{
    if ('post' === $post_type) {
        $post_templates['page-product-review.php'] = 'Product Review';
    }
    return $post_templates;
}
add_filter('theme_post_templates', 'add_product_review_to_post_templates', 10, 4);


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
    if (is_singular('post') && get_page_template_slug() === 'single-product-comparison.php') {
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

// Load product review template
function load_product_review_template($template)
{
    if (is_singular() && get_page_template_slug() === 'page-product-review.php') {
        $template = locate_template('page-product-review.php');
    }
    return $template;
}
add_filter('template_include', 'load_product_review_template', 99);

// Add meta box for product review and comparison
function add_product_meta_box()
{
    log_message("Attempting to add product meta box");
    $post_types = array('post', 'page');
    foreach ($post_types as $post_type) {
        add_meta_box(
            'product_meta_box',
            'Product Details',
            'product_meta_box_callback',
            $post_type,
            'normal',
            'high'
        );
    }
    log_message("Product meta box added");
}
add_action('add_meta_boxes', 'add_product_meta_box');


function get_post_meta_with_fallback($post_id, $key, $single = true)
{
    $value = get_post_meta($post_id, $key, $single);
    if ($value === '' || $value === false) {
        $value = get_post_meta($post_id, '_' . $key, $single);
    }
    return $value;
}

function product_meta_box_callback($post)
{
    log_message("Product meta box callback started for post ID: " . $post->ID);
    $template = get_page_template_slug($post->ID);
    log_message("Template for post ID " . $post->ID . ": " . $template);

    wp_nonce_field('product_meta_box', 'product_meta_box_nonce');

    echo '<div id="product-review-fields" ' . ($template !== 'page-product-review.php' ? 'style="display:none;"' : '') . '>';
    log_message("Displaying product review fields");
    product_review_fields($post);
    echo '</div>';

    echo '<div id="product-comparison-fields" ' . ($template !== 'single-product-comparison.php' ? 'style="display:none;"' : '') . '>';
    log_message("Displaying product comparison fields");
    product_comparison_fields($post);
    echo '</div>';

    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            function toggleFields() {
                var template = $('#page_template').val();
                if (template === 'page-product-review.php') {
                    $('#product-review-fields').show();
                    $('#product-comparison-fields').hide();
                    $('#product_meta_box_sidebar').hide();
                    $('#product_meta_box').show();
                } else if (template === 'single-product-comparison.php') {
                    $('#product-review-fields').hide();
                    $('#product-comparison-fields').show();
                    $('#product_meta_box_sidebar').show();
                    $('#product_meta_box').show();
                } else {
                    $('#product-review-fields').hide();
                    $('#product-comparison-fields').hide();
                    $('#product_meta_box_sidebar').hide();
                    $('#product_meta_box').hide();
                }
            }

            $('#page_template').on('change', toggleFields);
            toggleFields(); // Run on page load
        });
    </script>
<?php

    log_message("Product meta box callback completed for post ID: " . $post->ID);
}


function add_product_meta_box_sidebar_color()
{
    log_message("Attempting to add product meta box");
    $post_types = array('post', 'page');
    foreach ($post_types as $post_type) {
        add_meta_box(
            'product_meta_box_sidebar_color',
            'Colors Selection',
            'product_meta_box_sidebar_color_callback',
            $post_type,
            'side',
            'low'
        );
    }
    log_message("Product meta box added");
}
add_action('add_meta_boxes', 'add_product_meta_box_sidebar_color');

function product_meta_box_sidebar_color_callback($post) {
    log_message("Product meta box sidebar callback started for post ID: " . $post->ID);
    $template = get_page_template_slug($post->ID);
    log_message("Template for post ID " . $post->ID . ": " . $template);

    echo '<div id="product-comparison-fields-sidebar">';
    log_message("Displaying product comparison sidebar fields");
    product_comparison_sidebar_color_fields($post);
    echo '</div>';
}
function product_comparison_sidebar_color_fields($post) {
    echo '<h3>Color Scheme</h3>';
    field_color($post, 'primary_color', 'Primary Color');
    field_color($post, 'secondary_color', 'Secondary Color');
    field_color($post, 'tertiary_color', 'Tertiary Color');
    field_color($post, 'marked_bg_color', 'Marked Color');
    field_color($post, 'button_color', 'Button Color');
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

?>
    <!-- <script type="text/javascript">
        jQuery(document).ready(function($) {
            function toggleFields() {
                var template = $('#page_template').val();
                if (template === 'page-product-review.php') {
                    // $('#product-review-fields').show();
                    $('#product_meta_box_sidebar').hide();
                } else if (template === 'single-product-comparison.php') {
                    // $('#product-review-fields').hide();
                    $('#product_meta_box_sidebar').show();
                } else {
                    $('#product_meta_box_sidebar').hide();
                }
            }

            $('#page_template').on('change', toggleFields);
            toggleFields(); // Run on page load
        });
    </script> -->
<?php
    log_message("Product meta box sidebar callback completed for post ID: " . $post->ID);
}

function product_review_fields($post)
{
    echo '<h3>Product Review Details</h3>';

    echo '<h4>Site Information</h4>';
    field_text($post, 'site_name', 'Site Name');
    field_text($post, 'site_url', 'Site URL');

    echo '<h4>General Settings</h4>';
    field_text($post, 'logo_url', 'Logo URL');
    field_image($post, 'author_image', 'Author Image URL');
    field_text($post, 'author_name', 'Author Name');
    field_text($post, 'best_product_category', 'Best Product Category');

    echo '<h4>Sidebar Ad</h4>';
    field_image($post, 'sidebar_ad_image', 'Ad Image URL');

    echo '<h4>Content</h4>';
    field_editor($post, 'intro_headline', 'Intro Headline');
    field_editor($post, 'intro_paragraph', 'Intro Paragraph');
    field_number($post, 'num_products', 'Number of Products', 1, 10);

    echo '<h4>Custom Product Fields</h4>';
    $custom_fields = get_post_meta($post->ID, 'custom_product_fields', true) ?: array('Effectiveness', 'Safety', 'Price');
    foreach ($custom_fields as $field) {
        echo '<input type="text" name="custom_product_fields[]" value="' . esc_attr($field) . '">';
        echo '<button type="button" class="remove-field">Remove</button><br>';
    }
    echo '<button type="button" id="add_custom_field">Add Custom Field</button>';

    $num_products = get_post_meta($post->ID, 'num_products', true) ?: 5;
    for ($i = 1; $i <= $num_products; $i++) {
        echo "<h4>Product $i" . ($i === 1 ? ' (Best Product)' : '') . "</h4>";
        field_text($post, "product_{$i}_name", 'Name');
        field_image($post, "product_{$i}_image", 'Image URL');
        field_text($post, "product_{$i}_effectiveness", 'Effectiveness');
        field_text($post, "product_{$i}_safety", 'Safety');
        field_text($post, "product_{$i}_price", 'Price');
        field_text($post, "product_{$i}_rating", 'Overall Rating');
        field_editor($post, "product_{$i}_description", 'Description');
    }

    echo '<h4>Conclusion</h4>';
    field_editor($post, 'conclusion_headline1', 'Conclusion Headline 1');
    field_editor($post, 'conclusion_para1', 'Conclusion Paragraph 1');
    field_image($post, 'conclusion_image1', 'Conclusion Image 1');
    field_editor($post, 'conclusion_para2', 'Conclusion Paragraph 2');
    field_editor($post, 'conclusion_headline2', 'Conclusion Headline 2');
    field_editor($post, 'conclusion_para3', 'Conclusion Paragraph 3');
    field_image($post, 'conclusion_image2', 'Conclusion Image 2');
    field_editor($post, 'conclusion_para4', 'Conclusion Paragraph 4');

    echo '<h4>CTA</h4>';
    field_text($post, 'cta_text', 'CTA Text');
    field_text($post, 'cta_link', 'CTA Link');
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
    }


    // button_color
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

// Helper functions for field generation
function field_text($post, $key, $label)
{
    $value = get_post_meta($post->ID, $key, true);
    echo "<p><label for='$key'><strong>$label</strong> ($key)</label><br>";
    echo "<input type='text' id='$key' name='$key' value='" . esc_attr($value) . "' class='widefat'></p>";
}

function field_select($post, $key, $label, $options)
{
    // Retrieve the current value of the custom field
    $value = get_post_meta($post->ID, $key, true);

    // Output the label and select field
    echo "<p><label for='$key'><strong>$label</strong> ($key)</label><br>";
    echo "<select id='$key' name='$key' class='widefat'>";

    // Loop through each option and output it as a select option
    foreach ($options as $option_value => $option_label) {
        echo "<option value='" . esc_attr($option_value) . "' " . selected($value, $option_value, false) . ">" . esc_html($option_label) . "</option>";
    }

    echo "</select></p>";
}


function field_editor($post, $key, $label)
{
    $value = get_post_meta($post->ID, $key, true);
    echo "<p><label for='$key'><strong>$label</strong> ($key)</label><br>";
    wp_editor($value, $key, array('textarea_name' => $key, 'textarea_rows' => 5));
    echo "</p>";
}

function field_image($post, $key, $label)
{
    $value = get_post_meta($post->ID, $key, true);
    echo "<p><label for='$key'><strong>$label</strong> ($key)</label><br>";
    echo "<input type='text' id='$key' name='$key' value='" . esc_attr($value) . "' class='widefat'>";
    echo "<button type='button' class='upload-image-button button' data-field='$key'>Choose Image</button>";
    if ($value) {
        echo "<img src='" . esc_url($value) . "' class='preview-image' style='max-width: 200px; max-height: 200px;'>";
    }
    echo "</p>";
}

function field_number($post, $key, $label, $min, $max)
{
    $value = get_post_meta($post->ID, $key, true);
    echo "<p><label for='$key'><strong>$label</strong> ($key)</label><br>";
    echo "<input type='number' id='$key' name='$key' value='" . esc_attr($value) . "' min='$min' max='$max'></p>";
}

function field_color($post, $key, $label)
{
    $value = get_post_meta($post->ID, $key, true);
    echo "<p><label for='$key'><strong>$label</strong> ($key)</label><br>";
    echo "<input type='text' id='$key' name='$key' value='" . esc_attr($value) . "' class='color-field'></p>";
}

function output_fields($post, $fields)
{
    foreach ($fields as $key => $label) {
        $value = get_post_meta($post->ID, $key, true);
        echo "<p><label for='$key'><strong>$label</strong> ($key)</label><br>";
        if (strpos($key, 'content') !== false || strpos($key, 'paragraph') !== false || in_array($key, ['product_1_pros', 'product_1_cons', 'product_1_bottom_line'])) {
            wp_editor($value, $key, array('textarea_name' => $key, 'textarea_rows' => 5));
        } elseif (strpos($key, 'image') !== false || strpos($key, 'url') !== false) {
            echo "<input type='text' id='$key' name='$key' value='" . esc_attr($value) . "' class='widefat'>";
            echo "<button type='button' class='upload-image-button button' data-field='$key'>Choose Image</button>";
            if ($value) {
                echo "<img src='" . esc_url($value) . "' class='preview-image' style='max-width: 200px; max-height: 200px;'>";
            }
        } elseif (strpos($key, 'color') !== false) {
            echo "<input type='text' id='$key' name='$key' value='" . esc_attr($value) . "' class='color-field'>";
        } else {
            echo "<input type='text' id='$key' name='$key' value='" . esc_attr($value) . "' class='widefat'>";
        }
        echo "</p>";
    }
}


function save_product_meta($post_id)
{
    if (!isset($_POST['product_meta_box_nonce']) || !wp_verify_nonce($_POST['product_meta_box_nonce'], 'product_meta_box')) {
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
        'site_name',
        'site_url',

        // Product Review fields
        'best_product_category',
        'sidebar_ad_image',
        'intro_headline',
        'intro_paragraph',
        'conclusion_headline1',
        'conclusion_para1',
        'conclusion_image1',
        'conclusion_para2',
        'conclusion_headline2',
        'conclusion_para3',
        'conclusion_image2',
        'conclusion_para4',
        'cta_text',
        'cta_link',

        // Product Comparison fields
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
        // Sidebar Fields.
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
        'marked_bg_color',
        'button_color',
        'sidebar_2_icon_1',
        'sidebar_2_icon_2',
        'sidebar_2_icon_3',
        'sidebar_2_icon_4',
        'sidebar_2_icon_5',
        'sidebar_2_icon_6',
    );

    foreach ($fields_to_save as $field) {
        if (isset($_POST[$field])) {
            $value = $_POST[$field];
            if (strpos($field, 'content') !== false || strpos($field, 'paragraph') !== false || $field === 'citations') {
                $value = wp_kses_post($value);
            } else {
                $value = sanitize_text_field($value);
            }
            update_post_meta($post_id, $field, $value);
        }
    }

    // Save custom product fields
    if (isset($_POST['custom_product_fields'])) {
        $custom_fields = array_map('sanitize_text_field', $_POST['custom_product_fields']);
        update_post_meta($post_id, 'custom_product_fields', $custom_fields);
    }

    // Save product-specific fields
    $num_products = intval($_POST['num_products']);
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
            'effectiveness',
            'safety',
            'price',
            'description'
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

                update_post_meta($post_id, $key, $value);
            }
        }
    }
}
add_action('save_post', 'save_product_meta');

function save_product_review_meta($post_id)
{
    $fields = array(
        'intro_headline',
        'intro_paragraph',
        'conclusion_headline1',
        'conclusion_para1',
        'conclusion_image1',
        'conclusion_para2',
        'conclusion_headline2',
        'conclusion_para3',
        'conclusion_image2',
        'conclusion_para4',
        'cta_text',
        'cta_link',
        'sidebar_ad_image',
        'best_product_category'
    );

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            $value = in_array($field, array('intro_paragraph', 'conclusion_para1', 'conclusion_para2', 'conclusion_para3', 'conclusion_para4'))
                ? wp_kses_post($_POST[$field])
                : sanitize_text_field($_POST[$field]);
            update_post_meta($post_id, $field, $value);
        }
    }
}

function save_product_comparison_meta($post_id)
{
    $fields = array(
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
        'sidebar_2_icon_6'
    );

    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            $value = in_array($field, array('benefits_content', 'usage_content', 'ingredients_to_look_for_content', 'ingredients_to_avoid_content', 'considerations_content', 'citations'))
                ? wp_kses_post($_POST[$field])
                : sanitize_text_field($_POST[$field]);
            update_post_meta($post_id, $field, $value);
        }
    }
}

// Enqueue admin scripts
function enqueue_admin_scripts($hook)
{
    global $post;

    if ($hook == 'post.php' || $hook == 'post-new.php') {
        wp_enqueue_media();
        wp_enqueue_script('wp-color-picker');
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('product-admin-script', get_stylesheet_directory_uri() . '/js/product-admin.js', array('jquery', 'wp-color-picker'), '1.0', true);

        wp_localize_script('product-admin-script', 'productAdmin', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('product_admin_nonce'),
        ));

        // Add inline script for image upload functionality
        $image_upload_script = "
            jQuery(document).ready(function($) {
                $('.upload-image-button').on('click', function(e) {
                    e.preventDefault();
                    var button = $(this);
                    var field = button.data('field');
                    var customUploader = wp.media({
                        title: 'Choose Image',
                        button: {
                            text: 'Use this image'
                        },
                        multiple: false
                    }).on('select', function() {
                        var attachment = customUploader.state().get('selection').first().toJSON();
                        $('#' + field).val(attachment.url);
                        button.siblings('.preview-image').attr('src', attachment.url).show();
                    }).open();
                });
            });
            // code by pk.
            jQuery('.color-field').wpColorPicker();
        ";
        wp_add_inline_script('product-admin-script', $image_upload_script);

        log_message("Admin scripts enqueued for post ID: " . $post->ID);
    }
}
add_action('admin_enqueue_scripts', 'enqueue_admin_scripts');

// Register custom fields for API
function register_custom_fields_for_api()
{
    $common_fields = array(
        'num_products',
        'logo_url',
        'author_image',
        'author_name',
        'site_name',
        'site_url'
    );

    $product_review_fields = array(
        'intro_headline',
        'intro_paragraph',
        'conclusion_headline1',
        'conclusion_para1',
        'conclusion_image1',
        'conclusion_para2',
        'conclusion_headline2',
        'conclusion_para3',
        'conclusion_image2',
        'conclusion_para4',
        'cta_text',
        'cta_link',
        'sidebar_ad_image',
        'best_product_category'
    );

    $product_comparison_fields = array(
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
        'sidebar_2_icon_6'
    );

    $all_fields = array_merge($common_fields, $product_review_fields, $product_comparison_fields);

    // Add product-specific fields
    for ($i = 1; $i <= 10; $i++) {
        $product_fields = array(
            "product_{$i}_name",
            "product_{$i}_brand",
            "product_{$i}_link",
            "product_{$i}_image",
            "product_{$i}_rating_image",
            "product_{$i}_grade",
            "product_{$i}_pros",
            "product_{$i}_cons",
            "product_{$i}_bottom_line",
            "product_{$i}_rating",
            "product_{$i}_effectiveness",
            "product_{$i}_safety",
            "product_{$i}_price",
            "product_{$i}_description"
        );
        $all_fields = array_merge($all_fields, $product_fields);
    }

    foreach ($all_fields as $field) {
        register_rest_field(
            'post',
            $field,
            array(
                'get_callback'    => function ($post_arr) use ($field) {
                    $template = get_page_template_slug($post_arr['id']);
                    if (($template === 'page-product-review.php' && in_array($field, $GLOBALS['product_review_fields'])) ||
                        ($template === 'single-product-comparison.php' && in_array($field, $GLOBALS['product_comparison_fields'])) ||
                        in_array($field, $GLOBALS['common_fields']) ||
                        strpos($field, 'product_') === 0
                    ) {
                        return get_post_meta($post_arr['id'], $field, true);
                    }
                    return null;
                },
                'update_callback' => function ($value, $post, $field_name) {
                    return update_post_meta($post->ID, $field_name, $value);
                },
                'schema'          => array(
                    'type'        => 'string',
                    'description' => 'Custom field: ' . $field,
                    'context'     => array('view', 'edit')
                ),
            )
        );
    }
}
add_action('rest_api_init', 'register_custom_fields_for_api');

// Add custom fields to REST API response
function add_custom_fields_to_rest_api($response, $post, $request)
{
    $custom_fields = get_post_custom($post->ID);
    foreach ($custom_fields as $key => $value) {
        $response->data[$key] = $value[0];
    }
    return $response;
}
add_filter('rest_prepare_post', 'add_custom_fields_to_rest_api', 10, 3);



// Debug template selection
function debug_template_selection($template)
{
    $post_id = get_the_ID();
    $template_slug = get_page_template_slug($post_id);
    $post_type = get_post_type($post_id);
    log_message("Template selection - Post ID: $post_id, Post Type: $post_type, Template Slug: $template_slug, Actual template file: $template");
    return $template;
}
add_filter('template_include', 'debug_template_selection', 99);

// Remove default custom fields metabox
function remove_custom_fields_metabox()
{
    remove_meta_box('postcustom', 'post', 'normal');
}
add_action('admin_menu', 'remove_custom_fields_metabox');

function debug_post_template($post_id)
{
    $template = get_page_template_slug($post_id);
    $post_type = get_post_type($post_id);
    $meta = get_post_meta($post_id);

    log_message("Debug for post ID: $post_id");
    log_message("Post Type: $post_type");
    log_message("Template: $template");
    log_message("Meta: " . print_r($meta, true));
}

add_action('save_post', 'debug_post_template');
add_action('wp_insert_post', 'debug_post_template');

add_action('save_post', 'debug_post_saving', 10, 3);
function debug_post_saving($post_id, $post, $update)
{
    error_log("Attempting to save post ID: $post_id");
    error_log("Post data: " . print_r($post, true));
    error_log("Is update: " . ($update ? 'yes' : 'no'));
}
log_message("End of functions.php file");
