<?php
// global $post;
// Define global variables for custom fields

// $GLOBALS['common_fields'] = array(
//     'intro_headline',
//     'meta_keywords',
//     'meta_description',
// );

$GLOBALS['common_fields'] = array(
    'num_products',
    'logo_url',
    'author_image',
    'author_name',
    'site_name',
    'site_url',
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


log_message("Functions.php is being loaded");

// Enqueue parent and child styles
// function review_enqueue_styles()
// {
//     wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
//     wp_enqueue_style('child-style', get_stylesheet_uri());

//     // wp_enqueue_style('product-comparison-style', get_stylesheet_directory_uri() . '/product-comparison.css', array(), '1.1');
//     // wp_enqueue_script('product-comparison-script', get_stylesheet_directory_uri() . '/product-comparison.js', array('jquery'), '1.1', true);

//     log_message("Styles enqueued: parent-style and child-style");
// }
// add_action('wp_enqueue_scripts', 'review_enqueue_styles');


// Register product review template
// function register_product_review_template($templates)
// {
//     $templates['page-product-review.php'] = 'Product Review';
//     return $templates;
// }
// add_filter('theme_page_templates', 'register_product_review_template');
// add_filter('theme_post_templates', 'register_product_review_template');

// function add_product_review_to_post_templates($post_templates, $wp_theme, $post, $post_type)
// {
//     if ('post' === $post_type) {
//         $post_templates['page-product-review.php'] = 'Product Review';
//     }
//     return $post_templates;
// }
// add_filter('theme_post_templates', 'add_product_review_to_post_templates', 10, 4);



// // Load product review template
// function load_product_review_template($template)
// {
//     if (is_singular() && get_page_template_slug() === 'page-product-review.php') {
//         $template = locate_template('page-product-review.php');
//     }
//     return $template;
// }
// add_filter('template_include', 'load_product_review_template', 99);

// Add meta box for product review and comparison
function add_expert_review_metabox()
{
    log_message("Attempting to add product meta box");
    $post_types = array('post', 'page');
    foreach ($post_types as $post_type) {
        global $post;
        $template = get_page_template_slug($post->ID);
        if ($template == 'all-templates/expert-review-template.php') {
            add_meta_box(
                'expert_template_metabox',
                'Product Details',
                'expert_template_metabox_callback',
                $post_type,
                'normal',
                'high'
            );
        }
    }
    log_message("Product meta box added");
}

add_action('add_meta_boxes', 'add_expert_review_metabox');


// function get_post_meta_with_fallback($post_id, $key, $single = true)
// {
//     $value = get_post_meta($post_id, $key, $single);
//     if ($value === '' || $value === false) {
//         $value = get_post_meta($post_id, '_' . $key, $single);
//     }
//     return $value;
// }

function expert_template_metabox_callback($post)
{
    log_message("Product meta box callback started for post ID: " . $post->ID);
    $template = get_page_template_slug($post->ID);
    log_message("Template for post ID " . $post->ID . ": " . $template);

    wp_nonce_field('expert_review_template_metabox', 'expert_review_template_metabox_nonce');

    echo '<div id="product-expert-review-fields" ' . ($template !== 'all-templates/expert-review-template.php' ? 'style="display:none;"' : '') . '>';
    log_message("Displaying product review fields");
    if ($template === 'all-templates/expert-review-template.php') {
        product_expert_review_fields($post);
    }
    echo '</div>';

    // echo '<div id="product-comparison-fields" ' . ($template !== 'single-product-comparison.php' ? 'style="display:none;"' : '') . '>';
    // log_message("Displaying product comparison fields");
    // if ($template === 'single-product-comparison.php') {
    //     product_comparison_fields($post);
    // }
    // echo '</div>';

?>
<?php

    log_message("Product meta box callback completed for post ID: " . $post->ID);
}



function product_expert_review_fields($post)
{
    echo '<h3>Expert Details</h3>';

    echo '<h4>Site Information</h4>';
    field_text($post, 'site_name', 'Site Name', 'versus.reviews');
    field_text($post, 'site_url', 'Site URL', 'https://versus.reviews/');


    echo '<h4>General Settings</h4>';
    field_text($post, 'meta_keywords', 'Meta Keywords');
    field_textarea($post, 'meta_description', 'Meta Description');

    echo '<h4>General Settings</h4>';
    field_text($post, 'logo_url', 'Logo URL', 'https://vitality.guide/wp-content/uploads/sites/5/2023/04/Vitality-Guide-logo-Photoroom-768x271.jpg');
    field_image($post, 'author_image', 'Author Image URL', 'https://vitality.guide/wp-content/uploads/sites/5/2024/07/WhatsApp-Image-2024-07-25-at-19.05.33.jpeg');
    field_text($post, 'author_name', 'Author Name', 'Peter Attia');
    field_textarea($post, 'author_tagline', "Author Tagline", "As a strength coach and daily weightlifter, I switched from whey to beef protein due to health concerns. I tested dozens of brands, and now I'm sharing what I discovered!");
    field_text($post, 'best_product_category', 'Best Product Category', 'facial product for men');

    field_number($post, 'analyzed_count', 'Ratings analyzed', 1, 100000);
    field_number($post, 'research_hours', 'Hours researching', 1, 100000);
    field_number($post, 'brands_count', 'Brands purchased', 1, 100000);

    echo '<h4>Research Reason</h4>';
    field_text($post, 'research_reason_title', 'Research Reason Title', 'Why I Did This Research');
    field_editor($post, 'research_reason_content', 'Research Reason Content', 'Research Reason Content');
    field_gallery($post, 'research_reason_gallery', 'Research Reason Gallery');
    field_text($post, 'research_reason_caption', 'Research Reason Caption', 'Research Reason Caption');

    echo '<h4>Discount Information</h4>';
    field_text($post, 'discount_offer', 'Discount Offer', '20% Off');
    field_text($post, 'discount_code', 'Discount Code', 'FACEVG');

    echo '<h4>Sidebar Ad</h4>';
    field_image($post, 'sidebar_ad_image', 'Ad Image URL');

    echo '<h4>Content</h4>';
    field_editor($post, 'intro_headline', 'Intro Headline', 'I tried out the top 5 men\'s facial products for beating eye bags, dark spots, and wrinkles. Here are my surprising results…');
    field_editor($post, 'intro_paragraph', 'Intro Paragraph');



    field_number($post, 'num_products', 'Number of Products', 1, 10);

    echo '<div class="custom-product-fields">';
    echo '<h4>Custom Product Fields</h4>';
    echo '<div>';
    $custom_fields = get_post_meta($post->ID, 'custom_product_fields', true) ?: array('Effectiveness', 'Safety', 'Price');
    foreach ($custom_fields as $field) {
        echo '<input type="text" name="custom_product_fields[]" value="' . esc_attr($field) . '">';
        echo '<button type="button" class="remove-field">Remove</button><br>';
    }
    echo '<button type="button" id="add_custom_field">Add Custom Field</button>';
    echo '</div>';
    echo '</div>';


    $num_products = get_post_meta($post->ID, 'num_products', true) ? get_post_meta($post->ID, 'num_products', true) : 5;

    $num_products = (int) $num_products;

    for ($i = 1; $i <= $num_products; $i++) {
        echo "<h4>Product $i" . ($i === 1 ? ' (Best Product)' : '') . "</h4>";
        field_text($post, "product_{$i}_name", 'Name');
        field_image($post, "product_{$i}_image", 'Image URL');
        field_editor($post, "product_{$i}_ingredients", 'Ingredients', '', 'Enter values with , (coma)');
        field_editor($post, "product_{$i}_pros", "Pros");
        field_editor($post, "product_{$i}_cons", "Cons");



        // field_text($post, "product_{$i}_effectiveness", 'Effectiveness');
        // field_text($post, "product_{$i}_safety", 'Safety');
        // field_text($post, "product_{$i}_price", 'Price');
        //  'what_i_love', 'could_be_better',
        field_gallery($post, "product_{$i}_top_gallery", "Top Gallery");
        field_text($post, "product_{$i}_top_gallery_caption", "Top Gallery Caption");
        field_text($post, "product_{$i}_tested", "Tested");
        field_text($post, "product_{$i}_weight", "Weight");
        field_text($post, "product_{$i}_rating", 'Overall Rating');
        field_text($post, "product_{$i}_rating_ingredients", 'Ingredients Rating');
        field_text($post, "product_{$i}_rating_bioavailability", 'Bioavailability Rating');
        field_text($post, "product_{$i}_rating_taste", 'Taste Rating');
        field_text($post, "product_{$i}_rating_mixability", 'Mixability Rating');
        field_text($post, "product_{$i}_rating_digestibility", 'Digestibility Rating');




        field_editor($post, "product_{$i}_description", 'Description');
        field_text($post, "product_{$i}_flavor", 'Flavor');
        field_text($post, "product_{$i}_flavor_type", 'Flavor Type');
        field_editor($post, "product_{$i}_flavors", 'Flavours');
        field_text($post, "product_{$i}_link", 'Button Link');
        field_editor($post, "product_{$i}_bottom_line", 'Bottom Coupon Info');
        // "product_{$i}_bottom_line"
        field_text($post, "product_{$i}_reference", 'Reference');
        field_editor($post, "product_{$i}_what_i_love", 'What I Love');
        field_editor($post, "product_{$i}_could_be_better", 'Could Be Better');
        field_gallery($post, "product_{$i}_bottom_gallery", "Bottom Gallery");
        field_text($post, "product_{$i}_bottom_gallery_caption", "Bottom Gallery Caption");
        field_text($post, "product_{$i}_offer_date", "Offer Date");
        // "product_{$i}_offer_date"

        $custom_fields = get_post_meta($post->ID, 'custom_product_fields', true) ?: array('Effectiveness', 'Safety', 'Price');
        foreach ($custom_fields as $field) {
            $newFieldVal = strtolower($field);
            $newFieldVal = str_replace(' ', '_', $newFieldVal);
            field_text($post, "product_{$i}_" . $newFieldVal, $field);
        }



        // field_text($post, 'pk_product_data', 'Product Data');
    }

    echo '<h4>Conclusion</h4>';
    field_text($post, 'conclusion_headline1', 'Conclusion Headline 1', 'What Factors Matter In A Quality Beef Protein Powder According To Experts?');
    field_editor($post, 'conclusion_para1', 'Conclusion Paragraph 1', 'I consulted with registered dietitians and sport nutritionists and came up with this list of of key factors that separate premium beef protein from lower quality options:');
    field_editor($post, 'conclusion_para2', 'Conclusion Paragraph 2', '<ul>
    <li>✅ Grass fed</li>
    <li>✅ 100% lean beef</li>
    <li>✅ High quality ingredients</li>
    <li>✅ Minimal ingredients</li>
    <li>✅ Transparent labeling</li>
    <li>✅ Third party testing</li>
    <li>✅ Low Calorie</li>
    <li>✅ Taste</li>
    <li>✅ Ease of mixing</li>
    </ul>');

    field_editor($post, 'conclusion_para3', 'Conclusion Paragraph 3', 'The effectiveness of XYZ comes down to');

    field_text($post, 'conclusion_headline2', 'Conclusion Headline 2', 'How Does XYZ work');

    field_editor($post, 'conclusion_para4', 'Conclusion Paragraph 4');

    field_image($post, 'conclusion_image1', 'Conclusion Image 1');
    field_image($post, 'conclusion_image2', 'Conclusion Image 2');
    field_text($post, 'conclusion_image_overlay', 'Conclusion Image Overlay', 'Having fun testing and scoring 15 protein powders! ');
    field_text($post, 'conclusion_headline3', 'Conclusion Heading 3', 'My Pick For The Best Beef Protein Powder');

    echo '<h4>CTA</h4>';
    field_text($post, 'cta_text', 'CTA Text', 'Learn More');
    field_text($post, 'cta_link', 'CTA Link', 'https://eb5.com/products/face-cream-for-men');
}
/**** Global Fields  ****/
// function add_product_review_global_meta_box()
// {
//     log_message("Attempting to add product meta box");
//     $post_types = array('post', 'page');
//     foreach ($post_types as $post_type) {

//         global $post;
//         $template = get_page_template_slug($post->ID);
//         if ($template == 'page-product-review.php') {
//             add_meta_box(
//                 'product_meta_box_review_global',
//                 'Global Details',
//                 'product_meta_box_review_global_callback',
//                 $post_type,
//                 'normal',
//                 'high'
//             );
//         }
//     }
//     log_message("Product meta box added");
// }
// add_action('add_meta_boxes', 'add_product_review_global_meta_box');

// function product_meta_box_review_global_callback($post)
// {
//     log_message("Product meta box callback started for post ID: " . $post->ID);
//     $template = get_page_template_slug($post->ID);
//     log_message("Template for post ID " . $post->ID . ": " . $template);

//     wp_nonce_field('product_meta_box_review', 'product_meta_box_review_nonce');

//     echo '<div id="product-review-fields" ' . ($template !== 'page-product-review.php' ? 'style="display:none;"' : '') . '>';
//     log_message("Displaying product campaign fields");
//     if ($template === 'page-product-review.php') {
//         product_campaign_global_fields($post);
//     }
//     echo '</div>';

//     log_message("Product meta box callback completed for post ID: " . $post->ID);
// }

// function product_review_global_fields($post)
// {
//     echo '<h3>Global Information</h3>';
//     $count = count($GLOBALS['common_fields']);
//     $x = 0;
//     while ($x < $count) {
//         field_text($post, $GLOBALS['common_fields'][$x], $GLOBALS['common_fields'][$x]);
//         $x++;
//     }
// }

/***
 * Save metabox fields.
 */
function save_review_template_meta_boxes($post_id)
{
    if (!isset($_POST['expert_review_template_metabox_nonce']) || !wp_verify_nonce($_POST['expert_review_template_metabox_nonce'], 'expert_review_template_metabox')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // $template = get_page_template_slug($post_id);

    $fields_to_save = array(
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
        'conclusion_image_overlay',
        'conclusion_para4',
        'conclusion_headline3',
        'cta_text',
        'cta_link',
        'discount_offer',
        'discount_code',
        'num_products',
        'analyzed_count',
        'brands_count',
        'research_hours',
        'logo_url',
        'author_image',
        'author_name',
        'author_tagline',
        'site_name',
        'site_url',
        'meta_keywords',
        'meta_description',
        'research_reason_title',
        'research_reason_content',
        'research_reason_gallery',
        'research_reason_caption',

    );


    foreach ($fields_to_save as $field) {
        if (isset($_POST[$field])) {
            $value = $_POST[$field];

            $value = $value;

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
            "rating_ingredients",
            "rating_bioavailability",
            "rating_taste",
            "rating_mixability",
            "rating_digestibility",
            // 'effectiveness',
            // 'safety',
            // 'price',
            'field_one',
            'description',
            'ingredients',
            'tested',
            'weight',
            'flavor',
            'flavor_type',
            'flavors',
            'source',
            'what_i_love',
            'could_be_better',
            "top_gallery",
            "top_gallery_caption",
            "bottom_gallery",
            "bottom_gallery_caption",
            "offer_date",
            "reference",
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
add_action('save_post', 'save_review_template_meta_boxes');
