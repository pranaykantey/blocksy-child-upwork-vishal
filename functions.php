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

/************************************************************
 ************* Register product review template *************
 ************************************************************/
function register_product_review_template($templates)
{
    $templates['all-templates/page-product-review.php'] = 'Product Review';
    return $templates;
}
add_filter('theme_page_templates', 'register_product_review_template');
add_filter('theme_post_templates', 'register_product_review_template');

function add_product_review_to_post_templates($post_templates, $wp_theme, $post, $post_type)
{
    if ('post' === $post_type) {
        $post_templates['all-templates/page-product-review.php'] = 'Product Review';
    }
    return $post_templates;
}
add_filter('theme_post_templates', 'add_product_review_to_post_templates', 10, 4);

// Load product review template
function load_product_review_template($template)
{
    if (is_singular() && get_page_template_slug() === 'all-templates/page-product-review.php') {
        $template = locate_template('all-templates/page-product-review.php');
    }
    return $template;
}
add_filter('template_include', 'load_product_review_template', 99);

/************************************************************
 ********** ./ End Register product review template *********
 ************************************************************/

/************************************************************
 ************* Register Expert review template *************
 ************************************************************/
add_action('init', function() {
    $template_path = locate_template('all-templates/expert-review-template.php');
    error_log('Template Path: ' . ($template_path ?: 'NOT FOUND'));
});

/**
 * Register the template for pages.
 */
function register_expert_review_template($templates) {
    $templates['all-templates/expert-review-template.php'] = 'Expert Review';
    return $templates;
}
add_filter('theme_page_templates', 'register_expert_review_template'); // For pages

/**
 * Add template support for posts (manually handling since WP lacks a native post filter).
 */
function add_expert_review_template_to_posts($templates) {
    $templates['all-templates/expert-review-template.php'] = 'Expert Review';
    return $templates;
}
add_filter('theme_post_templates', 'add_expert_review_template_to_posts'); // Reusing page filter for posts

/**
 * Force loading the custom template for posts & pages.
 */
function load_expert_review_template($template) {
    global $post;
    
    if (!$post) {
        return $template;
    }

    // Get the assigned template for both pages & posts
    $template_slug = get_post_meta($post->ID, '_wp_page_template', true);

    if ($template_slug === 'all-templates/expert-review-template.php') {
        $custom_template = locate_template('all-templates/expert-review-template.php');
        if (!empty($custom_template)) {
            return $custom_template;
        }
    }

    return $template;
}
add_filter('template_include', 'load_expert_review_template', 99);


/************************************************************
 ********** ./ End Register expert review template *********
 ************************************************************/



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

function add_footer_script_code()
{

    global $post;
    $template = get_page_template_slug($post->ID);
    if (
        $template == 'campaign-template.php' ||
        $template == 'all-templates/page-product-review.php' ||
        $template == 'all-templates/expert-review-template.php' ||
        $template == 'single-product-comparison.php' ||
        $template == 'simple-with-sidebar.php'
    ) :
        ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const links = document.querySelectorAll('a');
                const utm = '?utm_source=<?php echo parse_url(home_url(), PHP_URL_HOST); ?>&utm_medium=referral&utm_campaign=blog_link';

                links.forEach(link => {
                    const href = link.getAttribute('href');
                    if (href && !href.includes('?')) {
                        link.setAttribute('href', href + utm);
                    }
                });
            });
        </script>
<?php
    endif;
}
add_action('wp_footer', 'add_footer_script_code');


// including template required functions 
// template helper 
if (file_exists(__DIR__ . '/includes/helper-functions.php')) {
    require_once('includes/helper-functions.php');
}
// api functions.
if (file_exists(__DIR__ . '/includes/save-by-api-functions.php')) {
    require_once('includes/save-by-api-functions.php');
}
// common functions.
if (file_exists(__DIR__ . '/includes/common-functions.php')) {
    require_once('includes/common-functions.php');
}

// review template functions.
if (file_exists(__DIR__ . '/includes/expert-review-functions.php')) {
    require_once('includes/expert-review-functions.php');
}
// review template functions.
if (file_exists(__DIR__ . '/includes/review-functions.php')) {
    require_once('includes/review-functions.php');
}
// comparison template functions.
if (file_exists(__DIR__ . '/includes/comparison-functions.php')) {
    require_once('includes/comparison-functions.php');
}
// campaign template functions.
if (file_exists(__DIR__ . '/includes/campaign-template-functions.php')) {
    require_once('includes/campaign-template-functions.php');
}
// campaign template functions.
if (file_exists(__DIR__ . '/includes/simple-with-sidebar-functions.php')) {
    require_once('includes/simple-with-sidebar-functions.php');
}

// echo __DIR__ . 'includes/comparison-functions.php';



// $template = get_page_template_slug($post->ID)
// global $post;
// var_dump(get_page_template_slug($post->ID));

// var_dump(get_the_ID());

// require review functions php file 
// if (is_singular() && get_page_template_slug() === 'page-product-review.php') {
// }
// // require review functions php file 
// if (is_singular() && get_page_template_slug() === 'single-product-comparison.php') {
// }
