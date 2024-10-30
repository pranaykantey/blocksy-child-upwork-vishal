<?php
// Helper functions for field generation
function field_text($post, $key, $label, $default_value = '')
{
    $value = get_post_meta($post->ID, $key, true);
    if (empty($value)) {
        $value = $default_value;
    }
    echo "<p class='custom-meta-box-field'><label for='$key'><strong>$label</strong> ($key)</label><br>";
    echo "<input type='text' id='$key' name='$key' value='" . esc_attr($value) . "' class='widefat'></p>";
}

function field_textarea($post, $key, $label, $default_value = '')
{
    $value = get_post_meta($post->ID, $key, true);
    if (empty($value)) {
        $value = $default_value;
    }
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
    echo "<div class='editor-field-custom custom-meta-box-field'><label for='$key'><strong>$label</strong> ($key)</label><br>";
    wp_editor($value, $key, array('textarea_name' => $key, 'textarea_rows' => 5));
    echo "</div>";
}

function field_image($post, $key, $label, $default_value = '')
{
    $value = get_post_meta($post->ID, $key, true);
    if (empty($value)) {
        $value = $default_value;
    }
    echo "<p class='custom-meta-box-field'><label for='$key'><strong>$label</strong> ($key)</label><br>";
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
    if( !$value ) {
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

function hasHeadingTag($string) {
    // Regular expression to match any heading tag from <h1> to <h6>
    $pattern = '/<h[1-6]\b[^>]*>(.*?)<\/h[1-6]>/i';
    
    // Check if there is a match in the string
    return preg_match($pattern, $string) === 1;
}
