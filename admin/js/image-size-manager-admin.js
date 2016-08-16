(function ($) {
    'use strict';

    /**
     * When DOM is ready
     */
    $(function () {

        /**
         * Toggle Options display
         */
        // $('.images-size-manager-button-wrap a.button').click(function () {
        //
        //     $('.image-size-manager-options-wrap').toggleClass('display');
        // });

        /**
         * Toggle Image Size Boxes
         */
        $('.one-checkbox').click(function () {

            $(this).toggleClass('deselected');
        });


        /**
         * Click Handler for Toggle
         */


        /**
         * Create array of values when checkbox is selected.
         */
        var checked_boxes_array = [];

        $('.image-size-manager-options-wrap .one-checkbox').on('click', function () {

            var size_name = $(this).attr('id');

            //console.log($(this).attr('name'));

            //var count_val = $(this).parent().find('.size-count').val();
            var count_val = $(this).find('.size-count').val();

            if (!checked_boxes_array[count_val]) {

                checked_boxes_array[count_val] = size_name;

            } else {

                checked_boxes_array[count_val] = null;
            }


            console.log(checked_boxes_array);
        });

    });


})(jQuery);
