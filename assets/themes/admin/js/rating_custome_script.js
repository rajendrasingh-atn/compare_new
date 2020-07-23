(function($)
{
  "use strict";

  var table;

    //datatables for disapprove rating comments
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
        // "oLanguage": { },
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        "ajax": {
          "url": BASE_URL+"admin/rating/rating_list",
          "type": "POST",
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ 0,3 ], //first column / numbering column
            "orderable": false, //set not orderable
        },
        ],
 
    });

    //datatables for approve rating comments
    table = $('#approvetable').DataTable({ 
        "language": {
                        "info": table_showing+" _START_ "+table_to+" _END_ "+ table_of+ " _TOTAL_ "+ table_entries,
                        "paginate": {
                                      "previous": table_previous,
                                      "next": table_next,
                                    },
                        "sLengthMenu": table_show+" _MENU_ "+table_entries,
                        "sSearch": table_search 

                    },
        // "oLanguage": { },
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.
        "ajax": {
          "url": BASE_URL+"admin/rating/approve_rating_list",
          "type": "POST",
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ 0,3 ], //first column / numbering column
            "orderable": false, //set not orderable
        },
        ],
 
    });    

    $('body').on('click','.togle_switch',function(e){
      $.notify({
          // options
          message: 'Status updated for rating',
          target: '_blank',
        },
        {
          // settings
          element: 'body',
          placement: {
              from: "top",
            align: "right"
        },
          offset: 20,
          spacing: 10,
          z_index: 1031,
          delay: 5000,
          timer: 1000,
      });
      if($(this).prop('checked')==true)
      {
          var status = 1;
      }
      else
      {
          var status = 0; 
      }
      var ids = $(this).data('id');
      $.ajax({
        url: BASE_URL+"admin/rating/update_status",
        type: "POST",
        data:{rating_id:ids,status:status},
        success:function(){

        },
        error:function(e){

        },        
      })
    });
})(jQuery);    
