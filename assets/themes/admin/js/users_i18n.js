(function($) { 
    // more code using $ as alias to jQuery

	"use strict";

    /**
     * Delete a user
     */
    $(".btn-delete-user").on("click", function() {
        window.location.href = BASE_URL+"/admin/users/delete/" + $(this).attr('data-id');
    });

	$(".popup").on("click", function() {
	   $('#imagepreview').attr('src', $(this).attr('src')); 
	   $('#imagemodal').modal('show'); 
	});

})(jQuery);
