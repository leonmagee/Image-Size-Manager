/**
 * For upload.php admin page - upload box loads when 'Add New' button is clicked
 * @todo currently I'm adding a click handler to the 'Add New' button to trigger the JS on this page, this is a bad way to do it, instead I need to find the event that fires when this frame loads and use that instead.
 */
(function ($) {
    'use strict';

    /**
     * When DOM is ready
     */
    $(function () {

        /**
         * Wrap everything in click handler for 'add new' button - this should only be enqueued
         * for the uploads.php page...
         */
        var image_size_manager_visible = false;
        $('#wp-media-grid .page-title-action').click(function () {

            if (!image_size_manager_visible) {

                $('.image-size-manager-options-wrap').show();
                /**
                 * Move UI above media upload area for uploads.php
                 */
                $('.image-size-manager-options-wrap').insertBefore('.uploader-inline');

                /**
                 * Get current user ID
                 */
                var ism_user_id = $('input#ism-current-user-id').val();

                /**
                 * Deselect All Checkboxes
                 */
                $('.description-text a.deselect-all-images').click(function () {
                    /**
                     * Show spinner icon
                     */
                    var spinner_icon = $('.description-text i.fa.deselect');
                    spinner_icon.css({'opacity': '1'});

                    var formdata = new FormData();


                    /**
                     * Get all checkbox names
                     */

                    var box_id_array = [];

                    $('.image-size-manager-options-wrap .one-checkbox').each(function () {

                        box_id_array.push($(this).attr('id'));
                    });

                    formdata.append("image_size_deselect_all", 'click');

                    formdata.append("action", "ism_custom_ajax_hook");

                    formdata.append("ism_user_id", ism_user_id);

                    formdata.append("box_id_array", box_id_array);

                    $.ajax({
                        type: 'POST',
                        url: ajaxurl,
                        data: formdata,
                        contentType: false,
                        processData: false,
                        success: function (data, textStatus, XMLHttpRequest) {

                            /**
                             * Change icons and add 'deselected' class to all buttons
                             */
                            $('.image-size-manager-options-wrap .one-checkbox i.fa').removeClass('fa-check-square-o').addClass('fa-square-o');

                            $('.one-checkbox').addClass('deselected');
                            spinner_icon.css({'opacity': '0'});

                            /**
                             * Log the returned data
                             */
                            console.log(data);
                        },
                        error: function (MLHttpRequest, textStatus, errorThrown) {
                            alert(errorThrown);
                        }
                    });
                });

                /**
                 * Select All Checkboxes
                 */
                $('.description-text a.select-all-images').click(function () {
                    /**
                     * Show spinner icon
                     */
                    var spinner_icon = $('.description-text i.fa.select');
                    spinner_icon.css({'opacity': '1'});

                    var formdata = new FormData();

                    formdata.append("image_size_select_all", 'click');

                    formdata.append("action", "ism_custom_ajax_hook");

                    formdata.append("ism_user_id", ism_user_id);

                    $.ajax({
                        type: 'POST',
                        url: ajaxurl,
                        data: formdata,
                        contentType: false,
                        processData: false,
                        success: function (data, textStatus, XMLHttpRequest) {

                            /**
                             * Change icons and add 'deselected' class to all buttons
                             */
                            $('.image-size-manager-options-wrap .one-checkbox i.fa').removeClass('fa-square-o').addClass('fa-check-square-o');

                            $('.one-checkbox').removeClass('deselected');
                            spinner_icon.css({'opacity': '0'});

                            /**
                             * Log the returned data
                             */
                            console.log(data);
                        },
                        error: function (MLHttpRequest, textStatus, errorThrown) {
                            alert(errorThrown);
                        }
                    });

                });

                /**
                 * Create array of values when checkbox is selected.
                 * Trigger AJAX when image size is clicked
                 */
                var checked_boxes_array = [];

                $('.image-size-manager-options-wrap .one-checkbox').on('click', function () {

                    var checkbox_element = $(this);
                    var icon_element = checkbox_element.find('i.fa');

                    if (icon_element.hasClass('fa-check-square-o')) {
                        icon_element.removeClass('fa-check-square-o adding').addClass('fa-refresh fa-spin removing');
                    }

                    if (icon_element.hasClass('fa-square-o')) {

                        icon_element.removeClass('fa-square-o removing').addClass('fa-refresh fa-spin adding');
                    }

                    var size_name = $(this).attr('id');

                    var count_val = $(this).find('.size-count').val();

                    if (!checked_boxes_array[count_val]) {

                        checked_boxes_array[count_val] = size_name;

                    } else {

                        checked_boxes_array[count_val] = null;
                    }

                    var formdata = new FormData();

                    formdata.append("checked_boxes_array", checked_boxes_array);

                    formdata.append("image_size_click_happened", 'click');

                    formdata.append("action", "ism_custom_ajax_hook");

                    formdata.append("ism_user_id", ism_user_id);

                    $.ajax({
                        type: 'POST',
                        url: ajaxurl,
                        data: formdata,
                        contentType: false,
                        processData: false,
                        success: function (data, textStatus, XMLHttpRequest) {

                            if (icon_element.hasClass('removing')) {
                                icon_element.removeClass('fa-refresh fa-spin').addClass('fa-square-o');
                            }

                            if (icon_element.hasClass('adding')) {
                                icon_element.removeClass('fa-refresh fa-spin').addClass('fa-check-square-o');
                            }

                            checkbox_element.toggleClass('deselected');
                            /**
                             * Log the returned data
                             */
                            console.log(data);
                        },
                        error: function (MLHttpRequest, textStatus, errorThrown) {
                            alert(errorThrown);
                        }
                    });
                    console.log(checked_boxes_array);
                });

                image_size_manager_visible = true;

            } else {

                $('.image-size-manager-options-wrap').hide();
                image_size_manager_visible = false;
            }


        });


    });


})(jQuery);
