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

function product_meta_box_sidebar_color_callback($post)
{
    log_message("Product meta box sidebar callback started for post ID: " . $post->ID);
    $template = get_page_template_slug($post->ID);
    log_message("Template for post ID " . $post->ID . ": " . $template);

    echo '<div id="product-comparison-fields-sidebar">';
    log_message("Displaying product comparison sidebar fields");
    product_comparison_sidebar_color_fields($post);
    echo '</div>';
}
function product_comparison_sidebar_color_fields($post)
{
    echo '<h3>Color Scheme</h3>';
    $fields_list = $GLOBALS['global_color_scheme_template'];

    $i = 0;
    while ($i < count($fields_list)) {
        $val = $fields_list[$i];
        $val = str_replace('_', ' ', $val);
        $val = ucfirst($val);
        field_color($post, $fields_list[$i], $val);
        $i++;
    }
    // field_color($post, 'primary_color', 'Primary Color');
    // field_color($post, 'secondary_color', 'Secondary Color');
    // field_color($post, 'tertiary_color', 'Tertiary Color');
    // field_color($post, 'marked_bg_color', 'Marked Color');
    // field_color($post, 'button_color', 'Button Color');
    // field_color($post, 'link_color', 'Link Color');
}


// 'primary_color',
// 'secondary_color',
// 'tertiary_color',
// 'marked_bg_color',
// 'button_color',

function save_global_color_product_meta($post_id)
{

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }


    $fields_to_save = $GLOBALS['global_color_scheme_template'];


    foreach ($fields_to_save as $field) {
        if (isset($_POST[$field])) {
            $value = $_POST[$field];

            $value = wp_kses_post($value);

            update_post_meta($post_id, $field, $value);
        }
    }
}
add_action('save_post', 'save_global_color_product_meta');


// Enqueue admin scripts
function enqueue_admin_scripts($hook)
{
    global $post;

    if ($hook == 'post.php' || $hook == 'post-new.php') {
        wp_enqueue_media();
        wp_enqueue_script('wp-color-picker');
        wp_enqueue_style('wp-color-picker');

        wp_enqueue_style('admin_custom_style_template', get_stylesheet_directory_uri() . '/css/admin-custom.css');

        wp_enqueue_script('product-admin-script', get_stylesheet_directory_uri() . '/js/product-admin.js', array('jquery', 'wp-color-picker'), '1.0', true);

        wp_enqueue_script('admin-custom', get_stylesheet_directory_uri() . '/js/admin-custom.js', array('jquery'), '1.0', true);

        wp_localize_script('product-admin-script', 'productAdmin', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('product_admin_nonce'),
        ));

        // Add inline script for image upload functionality
        $image_upload_script = "
        ";
        wp_add_inline_script('product-admin-script', $image_upload_script);

        log_message("Admin scripts enqueued for post ID: " . $post->ID);
    }
}
add_action('admin_enqueue_scripts', 'enqueue_admin_scripts');

function bct_template_enqueue_global()
{
    wp_enqueue_style('admin_custom_style_template', get_stylesheet_directory_uri() . '/css/main.css');
}

add_action('wp_enqueue_scripts', 'bct_template_enqueue_global');


/************************************
 *******     Applying CSS     *******
 ************************************/
function bct_global_apply_css_to_footer()
{
    global $post;
    $post_id = $post->ID;
?>
    <style>
        /**********************************************
            Primary Color
        **********************************************/

        <?php if (get_post_meta($post_id, 'primary_color', true)) : ?>.lp .right-panel h2 {
            background-image: linear-gradient(to bottom, <?php echo get_post_meta($post_id, 'primary_color', true); ?> 10%, <?php echo get_post_meta($post_id, 'primary_color', true); ?> 92%) !important;
        }

        .lp .nav-bar a:nth-child(2),
        .lp .colored-table.blue h3 {
            background-color: <?php echo get_post_meta($post_id, 'primary_color', true); ?> !important;
        }

        .product-review-article h3,
        .product-review-article h2,
        .post-template-campaign-template .repeater-title,
        .post-template-simple-with-sidebar .heading-2 {
            color: <?php echo get_post_meta($post_id, 'primary_color', true); ?> !important;
        }

        <?php endif; ?>
        /**********************************************
            ./ End Primary Color
        **********************************************/

        /**********************************************
            Secondary Color
        **********************************************/
        <?php if (get_post_meta($post_id, 'secondary_color', true)) : ?>.lp .colored-table.green h3 {
            background-color: <?php echo get_post_meta($post_id, 'secondary_color', true); ?> !important;
        }

        .product-review-article .has-background,
        .post-template-campaign-template .review-item {
            background-color: <?php echo get_post_meta($post_id, 'secondary_color', true); ?> !important;
        }

        <?php endif; ?>
        /**********************************************
            ./ End Secondary Color
        **********************************************/

        /**********************************************
            Tertiary Color
        **********************************************/
        <?php if (get_post_meta($post_id, 'tertiary_color', true)) : ?>.lp .colored-table.red h3 {
            background-color: <?php echo get_post_meta($post_id, 'tertiary_color', true); ?> !important;
        }

        .post-template-campaign-template .review-comment {
            background-color: <?php echo get_post_meta($post_id, 'tertiary_color', true); ?> !important;
        }

        <?php endif; ?>
        /**********************************************
            ./ End Tertiary Color
        **********************************************/

        /**********************************************
            Button Color
        **********************************************/
        /* button bg  */
        <?php if (get_post_meta($post_id, 'button_bg', true)) : ?>.lp .right a:last-of-type {
            background-color: <?php echo get_post_meta($post_id, 'button_bg', true); ?> !important;
        }

        .nav-bar a {
            display: flex !important;
            justify-content: center;
            align-items: center;
            color: <?php echo get_post_meta($post_id, 'button_bg', true); ?> !important;
        }

        .post-template-campaign-template .row.buttons .button-one {
            background-color: <?php echo get_post_meta($post_id, 'button_bg', true); ?> !important;
        }

        .site .site-inner .content-area .site-main .wp-block-buttons .wp-block-button a.wp-block-button__link {
            background-color: <?php echo get_post_meta($post_id, 'button_bg', true); ?> !important;
        }

        <?php endif; ?>

        /* button color  */
        <?php if (get_post_meta($post_id, 'button_color', true)) : ?>.nav-bar a,
        .post-template-campaign-template .row.buttons .button-one,
        .site .site-inner .content-area .site-main .wp-block-buttons .wp-block-button a.wp-block-button__link {
            color: <?php echo get_post_meta($post_id, 'button_color', true); ?> !important;
        }

        <?php endif; ?>

        /* Button two bg  */
        <?php if (get_post_meta($post_id, 'button_two_bg', true)) : ?>.post-template-campaign-template .row.buttons .button-two {
            background-color: <?php echo get_post_meta($post_id, 'button_two_bg', true); ?> !important;
        }

        <?php endif; ?><?php if (get_post_meta($post_id, 'button_two_color', true)) : ?>.post-template-campaign-template .row.buttons .button-two {
            color: <?php echo get_post_meta($post_id, 'button_two_color', true); ?> !important;
        }

        <?php endif; ?>
        /**********************************************
            ./ End Button Color
        **********************************************/

        /**********************************************
            Link Color
        **********************************************/
        <?php if (get_post_meta($post_id, 'link_color', true)) : ?>.product-review-article a {
            color: <?php echo get_post_meta($post_id, 'link_color', true); ?> !important;
        }

        <?php endif; ?>
        /**********************************************
            ./ End Link Color
        **********************************************/

        /**********************************************
            Mark Color
        **********************************************/
        <?php if (get_post_meta($post_id, 'marked_bg_color', true)) : ?>mark {
            background-color: <?php echo get_post_meta($post_id, 'marked_bg_color', true); ?> !important;
        }

        <?php endif; ?>
        /**********************************************
            ./ End Mark Color
        **********************************************/


        /**********************************************
            Footer Color
        **********************************************/
        <?php if (get_post_meta($post_id, 'footer_bg', true)) : ?>.template-footer {
            background-color: <?php echo get_post_meta($post_id, 'footer_bg', true); ?> !important;
        }

        <?php endif; ?><?php if (get_post_meta($post_id, 'footer_color', true)) : ?>.template-footer * {
            color: <?php echo get_post_meta($post_id, 'footer_color', true); ?> !important;
        }

        <?php endif; ?>
        /**********************************************
            ./ End Footer Color
        **********************************************/

        /* template-footer */
    </style>
<?php
}
add_action('wp_footer', 'bct_global_apply_css_to_footer');
