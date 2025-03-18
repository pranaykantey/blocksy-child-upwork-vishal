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
        if (template === 'all-templates/page-product-review.php') {
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


// jQuery(document).ready(function($) {
//     $('.upload-image-button').on('click', function(e) {
//         e.preventDefault();
//         var button = $(this);
//         var field = button.data('field');
//         var customUploader = wp.media({
//             title: 'Choose Image',
//             button: {
//                 text: 'Use this image'
//             },
//             multiple: false
//         }).on('select', function() {
//             var attachment = customUploader.state().get('selection').first().toJSON();
//             $('#' + field).val(attachment.url);
//             button.siblings('.preview-image').attr('src', attachment.url).show();
//         }).open();
//     });
// });

jQuery(document).ready(function ($) {
    let mediaUploader;

    $('.upload-image-button').on('click', function (e) {
        e.preventDefault();

        let button = $(this);
        let field = $('#' + button.data('field'));
        let preview = field.siblings('.preview-image');
        let removeButton = field.siblings('.remove-image-button');

        // If the media frame already exists, reopen it
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }

        // Create a new media frame
        mediaUploader = wp.media({
            title: 'Choose an Image',
            library: { type: 'image' },
            multiple: false,
            button: { text: 'Use this image' }
        });

        // When an image is selected, update the input field and preview
        mediaUploader.on('select', function () {
            let attachment = mediaUploader.state().get('selection').first().toJSON();
            field.val(attachment.url);
            preview.attr('src', attachment.url).show();
            removeButton.show();
        });

        mediaUploader.open();
    });

    // Remove Image
    $('.remove-image-button').on('click', function (e) {
        e.preventDefault();

        let button = $(this);
        let field = $('#' + button.data('field'));
        let preview = field.siblings('.preview-image');

        field.val(''); // Clear the input field
        preview.attr('src', '').hide(); // Hide the preview
        button.hide(); // Hide the remove button
    });
});

// gallery uploader
jQuery(document).ready(function ($) {
    let galleryFrame;

    $('.gallery-upload-button').on('click', function (e) {
        e.preventDefault();

        let button = $(this);
        let field = $('#' + button.data('field'));
        let previewContainer = $('#gallery-preview-' + button.data('field'));
        let selectedImages = field.val() ? field.val().split(',') : [];

        // If media frame exists, reopen it
        if (galleryFrame) {
            galleryFrame.open();
            return;
        }

        // Create a new media frame
        galleryFrame = wp.media({
            title: 'Select Images',
            library: { type: 'image' },
            multiple: true,
            button: { text: 'Add to Gallery' }
        });

        // When images are selected, update the gallery
        galleryFrame.on('select', function () {
            let selection = galleryFrame.state().get('selection');

            selection.each(function (attachment) {
                let imgId = attachment.id;
                let imgUrl = attachment.attributes.url;

                if (!selectedImages.includes(imgId.toString())) {
                    selectedImages.push(imgUrl);

                    // Append new image preview
                    previewContainer.append(`
                        <div class="gallery-item" data-id="${imgId}" style="display:inline-block; position:relative; margin:5px;">
                            <img src="${imgUrl}" style="width:100px;">
                            <button type="button" class="remove-gallery-image" data-id="${imgId}" style="position:absolute; top:0; right:0; background:red; color:white; border:none; cursor:pointer;">X</button>
                        </div>
                    `);
                }
            });

            // Update hidden input field
            field.val(selectedImages.join(','));
        });

        galleryFrame.open();
    });

    // Remove Image from Gallery
    $(document).on('click', '.remove-gallery-image', function () {
        let button = $(this);
        let imgId = button.data('id');
        let field = button.closest('.custom-meta-box-field').find('textarea');
        let previewContainer = button.closest('.gallery-preview');

        // Remove from selected images array
        let selectedImages = field.val().split(',').filter(id => id !== imgId.toString());
        field.val(selectedImages.join(','));

        // Remove image preview
        button.parent().remove();
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