<?php

$GLOBALS['global_color_scheme_template'] = array(
    'primary_color',
    'secondary_color',
    'tertiary_color',
    'marked_bg_color',
    'button_bg',
    'button_two_bg',
    'button_color',
    'button_two_color',
    'link_color',
    'footer_bg',
    'footer_color',
);

function add_utm_to_links_by_api($content)
{
    // Add UTM parameters
    $current_domain = parse_url(home_url(), PHP_URL_HOST);
    // Define UTM parameters
    $utm = '?utm_source=' . $current_domain . '&utm_medium=referral&utm_campaign=blog_link';

    // Use a regex to find all <a> tags with href attributes
    $content = preg_replace_callback(
        '/<a\s+([^>]*href=["\'])([^"\']+)/i',
        function ($matches) use ($utm) {
            $url = $matches[2];
            // Append UTM only if it doesn't already have query parameters
            if (strpos($url, '?') === false) {
                $url .= $utm;
            }
            return '<a ' . $matches[1] . $url;
        },
        $content
    );

    return $content;
}

// Register custom fields for API
function register_custom_fields_for_api()
{

    global $post;

    $common_fields = array(
        'num_products',
        'logo_url',
        'author_image',
        'author_name',
        'author_tagline',
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
        'best_product_category',
        'discount_offer',
        'discount_code',
        'meta_keywords',
        'meta_description',
        'custom_product_fields',
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
        'considerations_image',
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

    $product_campaign_fields = array(
        'num_reviews',
        'footer_text',
        'footer_image',
        'footer_button_one_text',
        'footer_button_one_link',
        'footer_button_two_text',
        'footer_button_two_link',
    );

    $product_simple_with_sidebar = array(
        'sidebar_ad_image_link',
        'footer_image_link',
        'footer_ad_image',
        'footer_ad_image_link',
        'footer_text_link',
    );

    $expert_review_template_fields = array(
        'conclusion_headline3',
        'conclusion_image_overlay',
        'analyzed_count',
        'brands_count',
        'research_hours',
        'research_reason_title',
        'research_reason_content',
        'research_reason_gallery',
        'research_reason_caption',
    );

    // $global_color_fields = array(
    //     'primary_color',
    //     'secondary_color',
    //     'tertiary_color',
    //     'marked_bg_color',
    //     'button_color',
    // );

    $global_color_fields = $GLOBALS['global_color_scheme_template'];

    $all_fields = array_merge($common_fields, $product_review_fields, $product_comparison_fields, $product_campaign_fields, $product_simple_with_sidebar, $global_color_fields, $expert_review_template_fields);

    // Add product-specific fields
    for ($i = 1; $i <= 25; $i++) {
        $product_fields = array(
            "product_{$i}_name",
            "product_{$i}_price",
            "product_{$i}_description",
            "product_{$i}_flavors",
            "product_{$i}_flavor_type",
            "product_{$i}_flavor_reviewed",
            "product_{$i}_brand",
            "product_{$i}_source",
            "product_{$i}_ingredients",
            "product_{$i}_tested",
            "product_{$i}_quantity",
            "product_{$i}_weight",
            "product_{$i}_link",
            "product_{$i}_reference",
            "product_{$i}_image",
            "product_{$i}_rating_image",
            "product_{$i}_grade",
            "product_{$i}_pros",
            "product_{$i}_cons",
            "product_{$i}_bottom_line",
            "product_{$i}_rating",
            "product_{$i}_rating_ingredients",
            "product_{$i}_rating_bioavailability",
            "product_{$i}_rating_taste",
            "product_{$i}_rating_mixability",
            "product_{$i}_rating_digestibility",
            "product_{$i}_effectiveness",
            "product_{$i}_safety",
            "product_{$i}_flavor",
            "product_{$i}_type",
            "product_{$i}_what_i_love",
            "product_{$i}_could_be_better",
            "product_{$i}_top_gallery",
            "product_{$i}_top_gallery_caption",
            "product_{$i}_bottom_gallery",
            "product_{$i}_bottom_gallery_caption",
            "product_{$i}_offer_date",

            "review_{$i}_author",
            "review_{$i}_image",
            "review_{$i}_comment",
            "review_{$i}_author_designation",
        );

        $custom_fieldss = get_post_meta($post->ID, 'custom_product_fields', true) ?: array('Effectiveness', 'Safety', 'Price');
        foreach ($custom_fieldss as $fieldd) {
            $newFieldVal = strtolower($fieldd);
            $newFieldVal = str_replace(' ', '_', $newFieldVal);
            $product_fields[]   = "product_{$i}_" . $newFieldVal;
        }


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
                    $value = add_utm_to_links_by_api($value);
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


// global $post;
// $custom_fieldss = get_post_meta($post->ID, 'custom_product_fields', true) ?: array('Effectiveness', 'Safety', 'Price');
// foreach ($custom_fieldss as $fieldd) {
//     $newFieldVal = strtolower($fieldd);
//     $newFieldVal = str_replace(' ', '_', $newFieldVal);
//     $product_fields[]   = $newFieldVal;
// }
// var_dump($custom_fieldss);
