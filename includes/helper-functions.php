<?php

function add_utm_to_links($content)
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
// Helper functions for field generation
function field_text($post, $key, $label, $default_value = '', $description = '')
{
    $value = get_post_meta($post->ID, $key, true);
    if (empty($value)) {
        $value = $default_value;
    }
    $value = add_utm_to_links($value);
    echo "<p class='custom-meta-box-field'><label for='$key'><strong>$label</strong> ($key)</label><br><small>$description</small>";
    echo "<input type='text' id='$key' name='$key' value='" . esc_attr($value) . "' class='widefat'></p>";
}

function field_textarea($post, $key, $label, $default_value = '')
{
    $value = get_post_meta($post->ID, $key, true);
    if (empty($value)) {
        $value = $default_value;
    }
    $value = add_utm_to_links($value);
    echo "<p class='custom-meta-box-field'><label for='$key'><strong>$label</strong> ($key)</label><br>";
    echo "<textarea type='text' id='$key' name='$key'  class='widefat'>" . esc_attr($value) . "</textarea></p>";
}
function field_select($post, $key, $label, $options)
{
    // Retrieve the current value of the custom field
    $value = get_post_meta($post->ID, $key, true);

    // Output the label and select field
    echo "<p class='custom-meta-box-field'><label for='$key'><strong>$label</strong> ($key)</label><br>";
    echo "<select id='$key' name='$key' class='widefat'>";

    // Loop through each option and output it as a select option
    foreach ($options as $option_value => $option_label) {
        echo "<option value='" . esc_attr($option_value) . "' " . selected($value, $option_value, false) . ">" . esc_html($option_label) . "</option>";
    }

    echo "</select></p>";
}


function field_editor($post, $key, $label, $default_value = '')
{
    $value = get_post_meta($post->ID, $key, true);
    if (empty($value)) {
        $value = $default_value;
    }

    $value = add_utm_to_links($value);

    echo "<div class='editor-field-custom custom-meta-box-field'><label for='$key'><strong>$label</strong> ($key)</label><br>";
    wp_editor($value, $key, array('textarea_name' => $key, 'textarea_rows' => 5));
    echo "</div>";
}

// function field_image($post, $key, $label, $default_value = '')
// {
//     $value = get_post_meta($post->ID, $key, true);
//     if (empty($value)) {
//         $value = $default_value;
//     }
//     echo "<p class='custom-meta-box-field'><label for='$key'><strong>$label</strong> ($key)</label><br>";
//     echo "<input type='text' id='$key' name='$key' value='" . esc_attr($value) . "' class='widefat'>";
//     echo "<button type='button' class='upload-image-button button' data-field='$key'>Choose Image</button>";
//     if ($value) {
//         echo "<img src='" . esc_url($value) . "' class='preview-image' style='max-width: 200px; max-height: 200px;'>";
//     }
//     echo "</p>";
// }

function field_image($post, $key, $label, $default_value = '')
{
    $value = get_post_meta($post->ID, $key, true);
    if (empty($value)) {
        $value = $default_value;
    }
?>
    <p class='custom-meta-box-field'>
        <label for="<?php echo esc_attr($key); ?>"><strong><?php echo esc_html($label); ?></strong> (<?php echo esc_html($key); ?>)</label><br>
        <input type="text" id="<?php echo esc_attr($key); ?>" name="<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($value); ?>" class="widefat">
        <button type="button" class="upload-image-button button" data-field="<?php echo esc_attr($key); ?>">Choose Image</button>
        <button type="button" class="remove-image-button button" data-field="<?php echo esc_attr($key); ?>" style="display: <?php echo $value ? 'inline-block' : 'none'; ?>;">Remove Image</button>
        <?php if ($value) : ?>
            <img src="<?php echo esc_url($value); ?>" class="preview-image" style="max-width: 200px; max-height: 200px; display: block; margin-top: 10px;">
        <?php else : ?>
            <img src="" class="preview-image" style="max-width: 200px; max-height: 200px; display: none; margin-top: 10px;">
        <?php endif; ?>
    </p>
<?php
}


function field_gallery($post, $key, $label)
{
    $value = get_post_meta($post->ID, $key, true);
    $image_ids = !empty($value) ? explode(',', $value) : [];
    $image_urls = [];
    foreach ($image_ids as $image_id) {
        // $img_url = wp_get_attachment_url($image_id);
        $image_urls[] = $image_id;
    }
?>
    <div class="custom-meta-box-field">
        <div class='custom-meta-box-field-child'>
            <label for="<?php echo esc_attr($key); ?>"><strong><?php echo esc_html($label); ?></strong> (<?php echo esc_html($key); ?>)</label><br>
            <button type="button" class="button gallery-upload-button" data-field="<?php echo esc_attr($key); ?>">Select Images</button>
            <br>
            <textarea class="widefat" id="<?php echo esc_attr($key); ?>" name="<?php echo esc_attr($key); ?>"><?php echo implode(',', $image_urls); ?></textarea>
        </div>
        <div id="gallery-preview-<?php echo esc_attr($key); ?>" class="gallery-preview">
            <?php foreach ($image_ids as $image_id) : ?>
                <?php $img_url = $image_id; ?>
                <div class="gallery-item" data-id="<?php echo $img_url; ?>" style="display:inline-block; position:relative; margin:5px;">
                    <img src="<?php echo esc_url($img_url); ?>" style="width:100px;">
                    <button type="button" class="remove-gallery-image" data-id="<?php echo $img_url; ?>" style="position:absolute; top:0; right:0; background:red; color:white; border:none; cursor:pointer;">X</button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php
}



function field_number($post, $key, $label, $min, $max)
{
    $value = get_post_meta($post->ID, $key, true);
    if (!$value) {
        $value = 5;
    }
    echo "<p class='custom-meta-box-field'><label for='$key'><strong>$label</strong> ($key)</label><br>";
    echo "<input type='number' id='$key' name='$key' value='" . esc_attr($value) . "' min='$min' max='$max'></p>";
}

function field_color($post, $key, $label)
{
    $value = get_post_meta($post->ID, $key, true);
    echo "<p class='custom-meta-box-field'><label for='$key'><strong>$label</strong> ($key)</label><br>";
    echo "<input type='text' id='$key' name='$key' value='" . esc_attr($value) . "' class='color-field'></p>";
}

function output_fields($post, $fields)
{
    foreach ($fields as $key => $label) {
        $value = get_post_meta($post->ID, $key, true);
        echo "<p class='custom-meta-box-field'><label for='$key'><strong>$label</strong> ($key)</label><br>";
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

function hasHeadingTag($string)
{
    // Regular expression to match any heading tag from <h1> to <h6>
    $pattern = '/<h[1-6]\b[^>]*>(.*?)<\/h[1-6]>/i';

    // Check if there is a match in the string
    return preg_match($pattern, $string) === 1;
}
