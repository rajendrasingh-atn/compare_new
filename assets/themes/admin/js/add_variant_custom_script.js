(function($) {
    "use strict";


    Dropzone.autoDiscover = false;
    


        var myDropzone = $("#imageupload").dropzone({
            url: BASE_URL + "admin/product/productuploadfile",
            maxFilesize: 5,
            maxFiles: 5,
            renameFile: function(file) {
                var dt = new Date()
                var time = dt.getTime()
                return time + convertToSlug(file.name)
            },
            addRemoveLinks: true,
            dictResponseError: 'Server not Configured',
            acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg",
            timeout: 50000,

            removedfile: function(file) {
                var name = file.upload.filename;

                $.ajax({

                    type: 'POST',
                    url: BASE_URL + 'admin/product/productdel_file',
                    data: {
                        filename: name
                    },

                    success: function(data) {
                        if (data) {
                            data = JSON.parse(data);
                            console.log("File has been successfully removed!!" + data);
                            $('.product_image_block :input[value="' + data + '"]').remove();
                        } else {
                            alert('error');
                        }

                    },
                    error: function(e) {
                        console.log(e)
                    }
                })
                var fileRef
                return (fileRef = file.previewElement) != null ?
                    fileRef.parentNode.removeChild(file.previewElement) : void 0
            },

            success: function(file, response) {
                response = JSON.parse(response);
                if (response.name) {
                    if ($("product_image_input").length) {
                        $(".product_image_block").last().after('<input type="hidden" name="product_image[]" class="form-control product_image_input" value="' + response.name + '">');
                    } else {
                        $(".product_image_block").append('<input type="hidden" name="product_image[]" class="form-control product_image_input" value="' + response.name + '">');
                    }
                } else {
                    alert('error');
                }

            },

            error: function(file, response) {
                alert('FV');
                return false;
            },

            init: function() {

                var self = this
                // config
                self.options.addRemoveLinks = true
                self.options.dictRemoveFile = "Delete"
                // New file added
                self.on("addedfile", function(file) {
                    console.log('new file added ', file)
                })
                // Send file starts
                self.on("sending", function(file, xhr, formData) {
                    formData.append([csrf_Name], csrf_Hash)
                    console.log('upload started', file)
                    $('.meter').show()
                })

                // File upload Progress
                self.on("totaluploadprogress", function(progress) {
                    console.log("progress ", progress)
                    $('.roller').width(progress + '%')
                })

                self.on("queuecomplete", function(progress) {
                    $('.meter').delay(999).slideUp(999)
                })

                // On removing file
                self.on("removedfile", function(file) {
                    console.log(file)
                })

                self.on("maxfilesexceeded", function(file) {
                    // alert("No more files please!")
                    alert("No more files please !");
                    this.removeFile(file)
                })
            }
        })

    function convertToSlug(Text) {
        return Text
            .toLowerCase()
            .replace(/ /g, '-')
    }

    var table;

    
        var productid = $('#productid').val();
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
                "url": BASE_URL + "admin/product/product_variant_list",
                "type": "POST",
            },

            //Set column definition initialisation properties.
            "columnDefs": [{
                "targets": [0, 2, 4], //first column / numbering column
                "orderable": false, //set not orderable
            }, ],

        });

        // $('#image_upload').ssi_uploader({url: 'uploadfile', dropZone: false});
    $('.select_dropdown').select2();


    $('.remove_img_btn').on('click', function(e) {
        e.preventDefault();

        var imgName = $(this).data('uploadimg');
        var id = $(this).data('id');
        
        $.ajax({
            url: BASE_URL + "admin/product/updatedDelete",
            type: "POST",
            data: {
                filename: imgName,
                id: id
            },
            success: function(response) {
                response = JSON.parse(response);
                var product_img = $("#product_images").val();
                if (product_img.indexOf(response.name + ',') != -1) {

                    var setimgValue = product_img.replace(response.name + ',', '');
                } else if (product_img.indexOf(',' + response.name) != -1) {
                    var setimgValue = product_img.replace(',' + response.name, '');
                } else {
                    var setimgValue = product_img.replace(response.name, '');
                }

                $("#product_images").val('');
                $("#product_images").val(setimgValue);

            },
            error: function(e) {

            },
        });
        $(this).parents('.editImage').remove();
    });

    //product and variant delete with sweetalert
    $('body').on('click', '.common_delete', function(e) {
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
            function(isConfirm) {
                if (isConfirm == true) {
                    window.location.href = link;
                }
            });
    });

    $(".popup").on("click", function() {
        $('#imagepreview').attr('src', $(this).attr('src'));
        $('#imagemodal').modal('show');
    });

    $(".delete_product_image").on("click", function(e) {
        e.preventDefault();

        var variant_id = $(this).data('variant_id');
        var product_image_name = $(this).data('image_name');

        if (variant_id && product_image_name) {

            $(this).closest('.col-1').remove();

            $.ajax({
                dataType: "json",
                type: 'post',
                data: {
                    variant_id: variant_id,
                    product_image_name: product_image_name,
                },
                url: BASE_URL + 'admin/product/delete_varient_image',
                success: function(response) {
                    if (response) {
                        console.log(response);
                    } else {
                        console.log(response);
                    }

                },
                error: function(jqXHR, status, err) {
                    console.log(jqXHR);
                }
            });


        } else {
            return false;
        }

    });
});

$(document).ready(function() {
    $('.market_product_status').click(function(e) {
        var parent_div = $(this).closest('.market_data');

        if ($(this).prop('checked') == true) {
            $(parent_div).find('.base_price').removeAttr("disabled");
            $(parent_div).find('.sale_price').removeAttr("disabled");
            $(parent_div).find('.affiliate_marketing_url').removeAttr("disabled");
        } else {
            $(parent_div).find('.base_price').attr("disabled", "disabled");
            $(parent_div).find('.sale_price').attr("disabled", "disabled");
            $(parent_div).find('.affiliate_marketing_url').attr("disabled", "disabled");
        }
    });

    // //addition market add
    // $('.marketicon').click(function(e){
    //     var tabledata = '<tr class="addition-row"><td scope="row"><input type="text" class="form-control" name="additionalmarketname[]" id="marketname" value="" /></td>';
    //         tabledata += '<td scope="row"><input type="number" class="form-control" name="additionalbaseprice[]" id="additionbaseprice" value="" /></td>';
    //         tabledata += '<td scope="row"><input type="number" class="form-control" name="additionalsaleprice[]" id="additionsaleprice" value="" /></td>';
    //         tabledata += '<td scope="row"><input type="text" class="form-control" name="additionalaffiliateurl[]" id="affiliatemarketurl" value="" /></td>';
    //         tabledata += '<td scope="row"><div class="remove btn btn-danger removebtn py-2"> Remove <i class=" px-2 fa fa-times" aria-hidden="true"></i> </div></td></tr>';            
    //     $('.table').append(tabledata);
    // });

    // //addition market remove
    // $(document).on("click",".removebtn",function(){
        
    //     $(this).parents('.addition-row').remove();
    // });
    $('.marketicon').click(function(e){
        var $tr    = $(this).closest('.market_data');
        var $clone = $tr.clone();
        $clone.find('input[type=text]').val('');
        $clone.find('input[type=number]').val('');
        $clone.find('.marketfield').val('');
        $clone.find('.addbtn').remove().end();
        $clone.append("<td scope='row'><div class='remove btn btn-danger removebtn py-2'>Remove<i class='px-2 fa fa-times' aria-hidden='true'></i></div></td>").end();
        // $(".table tr.market_data").append("<td></td>").end();
        $tr.after($clone); 


    });

    //market remove
    $(document).on("click",".removebtn",function()
    {
        $(this).parents('.market_data').remove();
    });
});
