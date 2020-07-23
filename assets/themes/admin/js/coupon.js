(function($)
{
"use strict";


var table;
var csrfName = $('#csrf_hash').val();
var csrf_token = $('#csrf_token').val();

//datatables
table = $('#table').DataTable({ 
    
        "language": {
                        "info": table_showing+" _START_ "+table_to+" _END_ "+ table_of+ " _TOTAL_ "+ table_entries,
                        "paginate": {
                                      "previous": table_previous,
                                      "next": table_next,
                                    },
                        "sLengthMenu": table_show+" _MENU_ "+table_entries,
                        "sSearch": table_search 

                    },


    "processing": true, //Feature control the processing indicator.
    "serverSide": true, //Feature control DataTables' server-side processing mode.
    "order": [],
    "ajax": {
        "url": BASE_URL+"admin/coupon/coupon_list",
        "type": "POST",
    },

    //Set column definition initialisation properties.
    "columnDefs": [
    { 
        "targets": [ 0, 3 ], //first column / numbering column
        "orderable": false, //set not orderable
    },
    ],

});


//select2 tool jquery 
$(document).ready(function() {
    $('.select_dropdown').select2();

});

            $(function () {
                $('.datetimepicker').datetimepicker({
                  format: 'YYYY-MM-DD HH:mm:ss',
                });
            });

$(".popup").on("click", function() 
{
   $('#imagepreview').attr('src', $(this).attr('src')); 
   $('#imagemodal').modal('show'); 
});

//product and variant delete with sweetalert
$('body').on('click','.common_delete',function(e)
{
    var link = $(this).attr("href");

   e.preventDefault(false);
   swal({
        title: are_you_sure,
        text: permanently_deleted,
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: yes_delere_it,
    },
    function(isConfirm){
        if(isConfirm==true){
            window.location.href=link;        
        }
    });
});


$(document).ready(function() {
    // $('.coupon_code_box').hide();
    $(".is_coupon").click(function() {
        var checkBoxes = $(".is_coupon");
        if (checkBoxes.is(':checked')) 
        {
            $('.coupon_code_box').slideDown();
        }
        else
        {
            $('.coupon_code_box').slideUp();
        }
    });                 
});


})(jQuery);