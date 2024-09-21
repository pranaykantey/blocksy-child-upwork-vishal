<?php
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

function log_message($message) {
    error_log(date('[Y-m-d H:i:s] ') . $message . "\n", 3, WP_CONTENT_DIR . '/debug.log');
}

log_message("Functions.php is being loaded");

// Enqueue parent and child styles
function child_enqueue_styles() {
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('child-style', get_stylesheet_uri());
    log_message("Styles enqueued: parent-style and child-style");
}
add_action('wp_enqueue_scripts', 'child_enqueue_styles');

// Register product review template
function register_product_review_template($templates) {
    $templates['page-product-review.php'] = 'Product Review';
    log_message("Product review template registered. Templates: " . print_r($templates, true));
    return $templates;
}
add_filter('theme_post_templates', 'register_product_review_template');
add_filter('single_template', 'load_product_review_template');

function load_product_review_template($template) {
    global $post;
    $template_slug = get_page_template_slug($post->ID);
    log_message("load_product_review_template called. Template slug: $template_slug");
    if ('page-product-review.php' === $template_slug) {
        if ($theme_file = locate_template(array('page-product-review.php'))) {
            $template = $theme_file;
            log_message("Product review template loaded: $template");
        }
    }
    return $template;
}

// Add meta box for product review
function add_product_review_meta_box() {
    log_message("Attempting to add product review meta box");
    add_meta_box(
        'product_review_meta_box',
        'Product Review Details',
        'product_review_meta_box_callback',
        'post',
        'normal',
        'high'
    );
    log_message("Product review meta box added");
}
add_action('add_meta_boxes', 'add_product_review_meta_box');

function get_post_meta_with_fallback($post_id, $key, $single = true) {
    $value = get_post_meta($post_id, $key, $single);
    if ($value === '' || $value === false) {
        $value = get_post_meta($post_id, '_' . $key, $single);
    }
    return $value;
}


function product_review_meta_box_callback($post) {
    log_message("Product review meta box callback started for post ID: " . $post->ID);
    wp_nonce_field('product_review_meta_box', 'product_review_meta_box_nonce');

    $num_products = get_post_meta_with_fallback($post->ID, 'num_products', true) ?: 5;
    $intro_headline = get_post_meta_with_fallback($post->ID, 'intro_headline', true) ?: 'I tried out the top 5 men\'s facial products for beating eye bags, dark spots, and wrinkles. Here are my surprising results…';
    $intro_paragraph = get_post_meta_with_fallback($post->ID, 'intro_paragraph', true) ?: '';
    $best_product_category = get_post_meta_with_fallback($post->ID, 'best_product_category', true) ?: 'facial product for men';
    $conclusion_headline1 = get_post_meta_with_fallback($post->ID, 'conclusion_headline1', true) ?: 'Why I chose .....';
    $conclusion_para1 = get_post_meta_with_fallback($post->ID, 'conclusion_para1', true) ?: 'eb5 is my clear winner for effectiveness, affordability, and versatility.';
    $conclusion_image1 = get_post_meta_with_fallback($post->ID, 'conclusion_image1', true);
    $conclusion_para2 = get_post_meta_with_fallback($post->ID, 'conclusion_para2', true) ?: 'Affordability is another critical factor.';
    $conclusion_headline2 = get_post_meta_with_fallback($post->ID, 'conclusion_headline2', true) ?: 'How Does XYZ work';
    $conclusion_para3 = get_post_meta_with_fallback($post->ID, 'conclusion_para3', true) ?: 'The effectiveness of XYZ comes down to';
    $conclusion_image2 = get_post_meta_with_fallback($post->ID, 'conclusion_image2', true);
    $conclusion_para4 = get_post_meta_with_fallback($post->ID, 'conclusion_para4', true) ?: '';
    $cta_text = get_post_meta_with_fallback($post->ID, 'cta_text', true) ?: 'Learn More';
    $cta_link = get_post_meta_with_fallback($post->ID, 'cta_link', true) ?: 'https://eb5.com/products/face-cream-for-men';
    $sidebar_ad_image = get_post_meta_with_fallback($post->ID, 'sidebar_ad_image', true);
    $logo_url = get_post_meta_with_fallback($post->ID, 'logo_url', true) ?: 'https://vitality.guide/wp-content/uploads/sites/5/2023/04/Vitality-Guide-logo-Photoroom-768x271.jpg';
    $author_image = get_post_meta_with_fallback($post->ID, 'author_image', true) ?: 'https://vitality.guide/wp-content/uploads/sites/5/2024/07/WhatsApp-Image-2024-07-25-at-19.05.33.jpeg';
    $author_name = get_post_meta_with_fallback($post->ID, 'author_name', true) ?: 'Peter Attia';
    $site_name = get_post_meta_with_fallback($post->ID, 'site_name', true) ?: 'versus.reviews';
    $site_url = get_post_meta_with_fallback($post->ID, 'site_url', true) ?: 'https://versus.reviews/';

    // Custom product fields
    $custom_fields = get_post_meta_with_fallback($post->ID, 'custom_product_fields', true) ?: array('Effectiveness', 'Safety', 'Price');

    echo '<h3>Site Information</h3>';
    echo '<p><label for="site_name">Site Name: (site_name)</label> ';
    echo '<input type="text" id="site_name" name="site_name" value="' . esc_attr($site_name) . '" class="widefat"></p>';

    echo '<p><label for="site_url">Site URL: (site_url)</label> ';
    echo '<input type="url" id="site_url" name="site_url" value="' . esc_url($site_url) . '" class="widefat"></p>';

    echo '<h3>General Settings</h3>';
    echo '<p><label for="logo_url">Logo URL: (logo_url)</label> ';
    echo '<input type="text" id="logo_url" name="logo_url" value="' . esc_url($logo_url) . '" class="widefat"></p>';

    echo '<p><label for="author_image">Author Image URL: (author_image)</label> ';
    echo '<input type="text" id="author_image" name="author_image" value="' . esc_url($author_image) . '" class="widefat"></p>';

    echo '<p><label for="author_name">Author Name: (author_name)</label> ';
    echo '<input type="text" id="author_name" name="author_name" value="' . esc_attr($author_name) . '" class="widefat"></p>';

    echo '<p><label for="best_product_category">Best Product Category: (best_product_category)</label> ';
    echo '<input type="text" id="best_product_category" name="best_product_category" value="' . esc_attr($best_product_category) . '" class="widefat"></p>';

    echo '<h3>Sidebar Ad</h3>';
    echo '<p><label for="sidebar_ad_image">Ad Image URL: (sidebar_ad_image)</label> ';
    echo '<input type="text" id="sidebar_ad_image" name="sidebar_ad_image" value="' . esc_url($sidebar_ad_image) . '" class="sidebar-ad-image-url widefat">';
    echo '<button type="button" class="upload-sidebar-ad-button button">Upload Image</button></p>';
    echo '<div class="sidebar-ad-preview">';
    if ($sidebar_ad_image) {
        echo '<img src="' . esc_url($sidebar_ad_image) . '" class="sidebar-ad-image-preview">';
    }
    echo '</div>';

    echo '<h3>Content</h3>';
    echo '<p><label for="intro_headline">Intro Headline: (intro_headline)</label><br>';
    wp_editor($intro_headline, 'intro_headline', array('textarea_name' => 'intro_headline', 'textarea_rows' => 3));

    echo '<p><label for="intro_paragraph">Intro Paragraph: (intro_paragraph)</label><br>';
    wp_editor($intro_paragraph, 'intro_paragraph', array('textarea_name' => 'intro_paragraph', 'textarea_rows' => 10));

    echo '<p><label for="num_products">Number of Products: (num_products)</label> ';
    echo '<input type="number" id="num_products" name="num_products" value="' . esc_attr($num_products) . '" min="1" max="10"></p>';

    echo '<h3>Custom Product Fields</h3>';
    echo '<div id="custom_fields">';
    foreach ($custom_fields as $index => $field) {
        echo '<p>';
        echo '<input type="text" name="custom_product_fields[]" value="' . esc_attr($field) . '">';
        echo '<button type="button" class="remove-field">Remove</button>';
        echo '</p>';
    }
    echo '</div>';
    echo '<button type="button" id="add_custom_field">Add Custom Field</button>';

    echo '<div id="product_reviews">';
    for ($i = 1; $i <= $num_products; $i++) {
        $name = get_post_meta_with_fallback($post->ID, "product_{$i}_name", true);
        $rating = get_post_meta_with_fallback($post->ID, "product_{$i}_rating", true);
        $description = get_post_meta_with_fallback($post->ID, "product_{$i}_description", true);
        $image_url = get_post_meta_with_fallback($post->ID, "product_{$i}_image", true);

        echo '<div class="product-review" ' . ($i === 1 ? 'style="border: 2px solid #007cba; padding: 10px;"' : '') . '>';
        echo '<h3>Product ' . $i . ($i === 1 ? ' (Best Product)' : '') . '</h3>';
        echo '<p><label for="product_' . $i . '_name">Name: (product_' . $i . '_name)</label> ';
        echo '<input type="text" id="product_' . $i . '_name" name="product_' . $i . '_name" value="' . esc_attr($name) . '" class="widefat"></p>';
        echo '<p><label for="product_' . $i . '_image">Image URL: (product_' . $i . '_image)</label> ';
        echo '<input type="text" id="product_' . $i . '_image" name="product_' . $i . '_image" value="' . esc_url($image_url) . '" class="product-image-url widefat">';
        echo '<button type="button" class="upload-image-button button">Upload Image</button></p>';
        echo '<div class="image-preview">';
        if ($image_url) {
            echo '<img src="' . esc_url($image_url) . '" style="max-width:400px;">';
        }
        echo '</div>';

        foreach ($custom_fields as $field) {
            $field_key = sanitize_key($field);
            $field_value = get_post_meta_with_fallback($post->ID, "product_{$i}_{$field_key}", true);
            echo '<p><label for="product_' . $i . '_' . $field_key . '">' . esc_html($field) . ': (product_' . $i . '_' . $field_key . ')</label> ';
            echo '<input type="text" id="product_' . $i . '_' . $field_key . '" name="product_' . $i . '_' . $field_key . '" value="' . esc_attr($field_value) . '" class="widefat"></p>';
        }

        echo '<p><label for="product_' . $i . '_rating">Overall Rating: (product_' . $i . '_rating)</label> ';
        echo '<input type="text" id="product_' . $i . '_rating" name="product_' . $i . '_rating" value="' . esc_attr($rating) . '" class="widefat"></p>';
        echo '<p><label for="product_' . $i . '_description">Description: (product_' . $i . '_description)</label><br>';
        wp_editor($description, "product_{$i}_description", array('textarea_name' => "product_{$i}_description", 'textarea_rows' => 10));
        echo '</div>';
    }
    echo '</div>';

    echo '<h3>Conclusion</h3>';
    echo '<p><label for="conclusion_headline1">Conclusion Headline 1: (conclusion_headline1)</label><br>';
    wp_editor($conclusion_headline1, 'conclusion_headline1', array('textarea_name' => 'conclusion_headline1', 'textarea_rows' => 2));

    echo '<p><label for="conclusion_para1">Conclusion Paragraph 1: (conclusion_para1)</label><br>';
    wp_editor($conclusion_para1, 'conclusion_para1', array('textarea_name' => 'conclusion_para1', 'textarea_rows' => 5));

    echo '<p><label for="conclusion_image1">Conclusion Image 1: (conclusion_image1)</label> ';
    echo '<input type="text" id="conclusion_image1" name="conclusion_image1" value="' . esc_url($conclusion_image1) . '" class="conclusion-image-url widefat">';
    echo '<button type="button" class="upload-image-button button">Upload Image</button></p>';
    echo '<div class="image-preview">';
    if ($conclusion_image1) {
        echo '<img src="' . esc_url($conclusion_image1) . '" style="max-width:400px;">';
    }
    echo '</div>';

    echo '<p><label for="conclusion_para2">Conclusion Paragraph 2: (conclusion_para2)</label><br>';
    wp_editor($conclusion_para2, 'conclusion_para2', array('textarea_name' => 'conclusion_para2', 'textarea_rows' => 5));

    echo '<p><label for="conclusion_headline2">Conclusion Headline 2: (conclusion_headline2)</label><br>';
    wp_editor($conclusion_headline2, 'conclusion_headline2', array('textarea_name' => 'conclusion_headline2', 'textarea_rows' => 2));

    echo '<p><label for="conclusion_para3">Conclusion Paragraph 3: (conclusion_para3)</label><br>';
    wp_editor($conclusion_para3, 'conclusion_para3', array('textarea_name' => 'conclusion_para3', 'textarea_rows' => 5));

    echo '<p><label for="conclusion_image2">Conclusion Image 2: (conclusion_image2)</label> ';
    echo '<input type="text" id="conclusion_image2" name="conclusion_image2" value="' . esc_url($conclusion_image2) . '" class="conclusion-image-url widefat">';
    echo '<button type="button" class="upload-image-button button">Upload Image</button></p>';
    echo '<div class="image-preview">';
    if ($conclusion_image2) {
        echo '<img src="' . esc_url($conclusion_image2) . '" style="max-width:400px;">';
    }
    echo '</div>';

    echo '<p><label for="conclusion_para4">Conclusion Paragraph 4: (conclusion_para4)</label><br>';
    wp_editor($conclusion_para4, 'conclusion_para4', array('textarea_name' => 'conclusion_para4', 'textarea_rows' => 5));

    echo '<h3>CTA</h3>';
    echo '<p><label for="cta_text">CTA Text: (cta_text)</label> ';
    echo '<input type="text" id="cta_text" name="cta_text" value="' . esc_attr($cta_text) . '" class="widefat"></p>';

    echo '<p><label for="cta_link">CTA Link: (cta_link)</label> ';
    echo '<input type="url" id="cta_link" name="cta_link" value="' . esc_url($cta_link) . '" class="widefat"></p>';

    // Add word and character count display divs
    echo '<div id="word-count-display"></div>';
    echo '<div id="character-count-display"></div>';

    // Add JavaScript for dynamic product fields, image upload,
   // Add JavaScript for dynamic product fields, image upload, and custom fields
    ?>
    <script type="text/javascript">
    jQuery(document).ready(function($) {
        // Handle sidebar ad image upload
        $(document).on('click', '.upload-sidebar-ad-button', function(e) {
            e.preventDefault();
            var button = $(this);
            var customUploader = wp.media({
                title: 'Choose Ad Image',
                button: {
                    text: 'Use this image'
                },
                multiple: false
            });
            customUploader.on('select', function() {
                var attachment = customUploader.state().get('selection').first().toJSON();
                button.siblings('.sidebar-ad-image-url').val(attachment.url);
                button.siblings('.sidebar-ad-preview').html('<img src="' + attachment.url + '" class="sidebar-ad-image-preview">');
            });
            customUploader.open();
        });

        // Handle manual URL entry for sidebar ad
        $(document).on('input', '.sidebar-ad-image-url', function() {
            var url = $(this).val();
            var preview = $(this).siblings('.sidebar-ad-preview');
            if (url) {
                preview.html('<img src="' + url + '" class="sidebar-ad-image-preview">');
            } else {
                preview.empty();
            }
        });

        // Handle number of products change
        $('#num_products').on('change', function() {
            var num = $(this).val();
            var current = $('.product-review').length;
            if (num > current) {
                for (var i = current + 1; i <= num; i++) {
                    var newProduct = $('.product-review:first').clone();
                    newProduct.find('h3').text('Product ' + i + (i === 1 ? ' (Best Product)' : ''));
                    newProduct.find('input, textarea').val('').attr('name', function(index, name) {
                        return name.replace(/\d+/, i);
                    });
                    newProduct.find('.image-preview').empty();
                    $('#product_reviews').append(newProduct);

                    // Initialize new editor
                    wp.editor.initialize('product_' + i + '_description', {
                        tinymce: {
                            wpautop: true,
                            plugins : 'charmap colorpicker compat3x directionality fullscreen hr image lists media paste tabfocus textcolor wordpress wpautoresize wpdialogs wpeditimage wpemoji wpgallery wplink wptextpattern wpview',
                            toolbar1: 'formatselect bold italic bullist numlist blockquote alignleft aligncenter alignright link unlink wp_more fullscreen wp_adv',
                            toolbar2: 'strikethrough hr forecolor pastetext removeformat charmap outdent indent undo redo wp_help'
                        },
                        quicktags: true,
                        mediaButtons: true
                    });
                }
            } else if (num < current) {
                $('.product-review').slice(num).each(function() {
                    var editorId = $(this).find('.wp-editor-area').attr('id');
                    wp.editor.remove(editorId);
                }).remove();
            }
        });

        // Handle image upload
        $(document).on('click', '.upload-image-button', function(e) {
            e.preventDefault();
            var button = $(this);
            var customUploader = wp.media({
                title: 'Choose Image',
                button: {
                    text: 'Use this image'
                },
                multiple: false
            });
            customUploader.on('select', function() {
                var attachment = customUploader.state().get('selection').first().toJSON();
                button.siblings('.product-image-url, .conclusion-image-url').val(attachment.url);
                button.siblings('.image-preview').html('<img src="' + attachment.url + '" style="max-width:400px;">');
            });
            customUploader.open();
        });

        // Handle manual URL entry
        $(document).on('input', '.product-image-url, .conclusion-image-url', function() {
            var url = $(this).val();
            var preview = $(this).siblings('.image-preview');
            if (url) {
                preview.html('<img src="' + url + '" style="max-width:400px;">');
            } else {
                preview.empty();
            }
        });

        // Handle adding custom fields
        $('#add_custom_field').on('click', function() {
            var field = $('<p><input type="text" name="custom_product_fields[]" value=""><button type="button" class="remove-field">Remove</button></p>');
            $('#custom_fields').append(field);
        });

        // Handle removing custom fields
        $(document).on('click', '.remove-field', function() {
            $(this).parent().remove();
        });
    });
    </script>
    <?php

    log_message("Product review meta box callback completed for post ID: " . $post->ID);
}

function save_product_review_meta($post_id) {
    log_message("Attempting to save product review meta for post ID: " . $post_id);

    if (!isset($_POST['product_review_meta_box_nonce']) || !wp_verify_nonce($_POST['product_review_meta_box_nonce'], 'product_review_meta_box')) {
        log_message("Nonce verification failed for post ID: " . $post_id);
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        log_message("Autosave detected, skipping meta save for post ID: " . $post_id);
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        log_message("User doesn't have permission to edit post ID: " . $post_id);
        return;
    }

    $fields_to_save = array(
        'site_name', 'site_url', 'logo_url', 'author_image', 'author_name',
        'best_product_category', 'sidebar_ad_image', 'intro_headline', 'intro_paragraph',
        'num_products', 'conclusion_headline1', 'conclusion_para1', 'conclusion_image1',
        'conclusion_para2', 'conclusion_headline2', 'conclusion_para3', 'conclusion_image2',
        'conclusion_para4', 'cta_text', 'cta_link'
    );

    foreach ($fields_to_save as $field) {
        if (isset($_POST[$field])) {
            $value = $_POST[$field];
            update_post_meta($post_id, $field, $value);
            log_message("Saved $field for post ID: $post_id");
        }
    }

    // Save custom product fields
    if (isset($_POST['custom_product_fields'])) {
        $custom_fields = array_map('sanitize_text_field', $_POST['custom_product_fields']);
        update_post_meta($post_id, 'custom_product_fields', $custom_fields);
    }

    // Handle product details
    $num_products = intval($_POST['num_products']);
    for ($i = 1; $i <= $num_products; $i++) {
        $product_fields = array('name', 'image', 'rating', 'description');
        foreach ($product_fields as $field) {
            $key = "product_{$i}_{$field}";
            if (isset($_POST[$key])) {
                $value = $field === 'description' ? wp_kses_post($_POST[$key]) : sanitize_text_field($_POST[$key]);
                update_post_meta($post_id, $key, $value);
            }
        }

        // Save custom field values
        if (isset($_POST['custom_product_fields'])) {
            foreach ($_POST['custom_product_fields'] as $custom_field) {
                $field_key = sanitize_key($custom_field);
                $key = "product_{$i}_{$field_key}";
                if (isset($_POST[$key])) {
                    update_post_meta($post_id, $key, sanitize_text_field($_POST[$key]));
                }
            }
        }
    }

    log_message("Product review meta saved for post ID: " . $post_id);
}
add_action('save_post', 'save_product_review_meta');

// Debug template selection
function debug_template_selection($template) {
    log_message("debug_template_selection called");
    if (is_singular('post')) {
        $post_id = get_the_ID();
        $template_slug = get_page_template_slug($post_id);
        log_message("Post ID: $post_id, Template Slug: $template_slug, Actual template file: $template");
    } else {
        log_message("Not a singular post. Template: $template");
    }
    return $template;
}
add_filter('template_include', 'debug_template_selection', 99);

// Enqueue admin scripts
function enqueue_admin_scripts($hook) {
    global $post;

    if ($hook == 'post.php' || $hook == 'post-new.php') {
        wp_enqueue_media();
        wp_enqueue_script('product-review-admin-script', get_stylesheet_directory_uri() . '/js/product-review-admin.js', array('jquery'), '1.0', true);

        wp_localize_script('product-review-admin-script', 'productReviewAdmin', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('product_review_admin_nonce'),
        ));
        log_message("Admin scripts enqueued for post ID: " . $post->ID);
    }
}
add_action('admin_enqueue_scripts', 'enqueue_admin_scripts');

// Register custom fields for API
function register_custom_fields_for_api() {
    $custom_fields = array(
        'intro_headline', 'intro_paragraph', 'conclusion_headline1', 'conclusion_para1',
        'conclusion_image1', 'conclusion_para2', 'conclusion_headline2', 'conclusion_para3',
        'conclusion_image2', 'conclusion_para4', 'cta_text', 'cta_link', 'sidebar_ad_image',
        'logo_url', 'author_image', 'author_name', 'site_name', 'site_url', 'best_product_category',
        'num_products'
    );

    foreach ($custom_fields as $field) {
        register_rest_field('post', $field, array(
            'get_callback' => function($post_arr) use ($field) {
                return get_post_meta($post_arr['id'], $field, true);
            },
            'update_callback' => function($value, $post, $field_name) {
                return update_post_meta($post->ID, $field_name, $value);
            },
            'schema' => array(
                'type' => 'string',
                'description' => 'Custom field: ' . $field,
                'context' => array('view', 'edit')
            ),
        ));
    }

    // Register product-specific fields
    for ($i = 1; $i <= 10; $i++) {
        $product_fields = array(
            "product_{$i}_name", "product_{$i}_image", "product_{$i}_rating",
            "product_{$i}_effectiveness", "product_{$i}_safety", "product_{$i}_price",
            "product_{$i}_description"
        );
        foreach ($product_fields as $field) {
            register_rest_field('post', $field, array(
                'get_callback' => function($post_arr) use ($field) {
                    return get_post_meta($post_arr['id'], $field, true);
                },
                'update_callback' => function($value, $post, $field_name) {
                    return update_post_meta($post->ID, $field_name, $value);
                },
                'schema' => array(
                    'type' => 'string',
                    'description' => 'Custom field: ' . $field,
                    'context' => array('view', 'edit')
                ),
            ));
        }
    }
}

add_action('rest_api_init', 'register_custom_fields_for_api');

// Add custom fields to REST API response
function add_custom_fields_to_rest_api($response, $post, $request) {
    $custom_fields = get_post_custom($post->ID);
    foreach ($custom_fields as $key => $value) {
        $response->data[$key] = $value[0];
    }
    return $response;
}
add_filter('rest_prepare_post', 'add_custom_fields_to_rest_api', 10, 3);

log_message("End of functions.php file");
