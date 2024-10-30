jQuery(document).ready(function() {
    // Function to handle removing a field
    jQuery(document).on('click', '.remove-field', function() {
        // alert('clicked remove');
        jQuery(this).prev('input').remove(); // Remove the input field
        jQuery(this).next('br').remove(); // Remove the <br> element
        jQuery(this).remove(); // Remove the remove button
    });

    // Function to add a new custom field
    jQuery('#add_custom_field').click(function() {
        var newField = '<input type=\"text\" name=\"custom_product_fields[]\" value=\"\">' + 
                    '<button type=\"button\" class=\"remove-field\">Remove</button><br>';
        jQuery(newField).insertBefore(this); // Insert the new field before the Add button
    });

});


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

(function($){
    $(document).ready(function(){
        $('.postbox-container p').each(function(){
            if( $(this).html().length === 0 ) {
                $(this).css('display','none');
            }
        });
    });
}(jQuery));