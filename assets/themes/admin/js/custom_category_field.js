/**
 *
 * Custom 
 * 
 */
(function($){

  "use strict";

  var table;
  $(document).ready(function() {
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
                              

          // Feature control the processing indicator.
          "processing": true, 
          // Feature control DataTables' server-side processing mode.
          "serverSide": true, 
          // Initial no order.
          "order": [], 
          "ajax": {
            "url": BASE_URL+"admin/customfield/customcategory_list",
            "type": "POST",
          },
          // Set column definition initialisation properties.
          "columnDefs": [
          { 
            // first column / numbering column
            "targets": [ 0,2,4 ], 
            // set not orderable
            "orderable": false, 
          },
        ],
   
      });

  });

  // icon picker jquery
  $('#target').on('change', function(e) {
      $('#iconfield').val(e.icon);
  });

  // sweetalert delete confirm
  $('body').on('click','.cat_delete',function(e){
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



})(jQuery);



