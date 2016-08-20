(function ($) {
    'use strict';

    /**
     * When DOM is ready
     */
    $(function () {

        /**
         * Toggle Image Size Boxes
         */
        $('.one-checkbox').click(function () {

            $(this).toggleClass('deselected');
        });

        /**
         * Deselect All Checkboxes
         */

        $('.description-text a.deselect-all-images').click(function () {

            $('.one-checkbox').addClass('deselected');
        });

        $('.description-text a.select-all-images').click(function () {

            $('.one-checkbox').removeClass('deselected');
        });


        /**
         * Create array of values when checkbox is selected.
         */
        var checked_boxes_array = [];

        $('.image-size-manager-options-wrap .one-checkbox').on('click', function () {

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

            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: formdata,
                contentType: false,
                processData: false,
                success: function (data, textStatus, XMLHttpRequest) {
                    /**
                     * Log the returned data
                     */
                    console.log(data);

                    /**
                     * Use data to modify value of hidden field
                     */
                    //$('input#field_id').val(data);

                },
                error: function (MLHttpRequest, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });

            console.log(checked_boxes_array);
        });

    });


})(jQuery);
