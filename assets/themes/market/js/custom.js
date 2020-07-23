/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 * 
 */

(function($){

	"use strict";

    // this script needs to be loaded on every page where an ajax POST
    $.ajaxSetup({
        data: {
            [csrf_Name] : csrf_Hash 
        }
    });

    $(".change-theme").click(function () {
        if ($(this).attr("data-color")) {
            //set theme color
            setCookie("theme_color", $(this).attr("data-color"));
            setThemeColor();
        } else {
            //reset theme
            $(".custom-theme-color").remove();
            setCookie("theme_color", "");
        }

    });

})(jQuery);

function setThemeColor() {
    var color = getCookie("theme_color");
    if (color) {
        var href = AppHelper.assetsDirectory + "/css/color/" + color + ".css";
        $('head').append('<link id="custom-theme-color" class="custom-theme-color" rel="stylesheet" href="' + href + '" type="text/css" />');
    }
}

