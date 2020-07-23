(function($) {
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
                             


            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.
            "ajax": {
                "url": BASE_URL + "admin/customfield/customfield_list",
                "type": "POST",
            },

            //Set column definition initialisation properties.
            "columnDefs": [{
                "targets": [0, 3], //first column / numbering column
                "orderable": false, //set not orderable
            }, ],

        });

    });

    // add more button for option add and remove
    $(function() {
        $('#add').on('click', function(e) {
            e.preventDefault();
            $('<div/>').addClass('new-text-div')
                .html($('<input type="text" name="custom_options[]" value="">').addClass('form-control addmore'))
                .append($('<button class="remove btn btn-danger removebtn py-2"> Remove <i class=" px-2 fa fa-times" aria-hidden="true"></i> </button>'))
                .insertAfter($('[class="new-text-div"]').last());
        });
        $(document).on('click', 'button.remove', function(e) {
            e.preventDefault();
            $(this).closest('div.new-text-div').remove();
        });
    });


    //delete by sweetalert jquery
    $('body').on('click', '.customfield_delete', function(e) {
        var link = $(this).attr("href");
        //console.log(link);
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
            function(isConfirm) {
                if (isConfirm == true) {
                    window.location.href = link;
                }
            });
    });

    //remove option on edit work
    $('.removeoption').on('click', function() {
        $(this).closest('.optionparent').remove();
    });

    //select2 tool jquery 
    $(document).ready(function() {
        $('.select_dropdown').select2();
    });

    $(document).ready(function() {
        $('.custom_group').trigger("change");
    });

    $('.custom_group').on('change', function(group) {
        var custom_group = $(this).val();

        if (custom_group == '') {
            $('.add_option').slideUp();
            $('.length_limit').slideUp();

        } else if (custom_group == 1 || custom_group == 2) {
            $('.add_option').slideUp();
            $('.length_limit').slideDown();

        } else if (custom_group == 3 || custom_group == 4 || custom_group == 5) {
            $('.add_option').slideDown();
            $('.length_limit').slideUp();

        }

    });
})(jQuery);