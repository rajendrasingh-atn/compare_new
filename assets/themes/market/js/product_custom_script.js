(function($)
{
"use strict";



//select2 tool jquery 
$(document).ready(function() {
    $('.select_dropdown').select2();
});


$('#selectcategory').on('change',function(e){

    var cat_id = $(this).val();
    if(cat_id == '')
    {
        $('.customfield_div').slideUp();
        return false;
    }

    // alert(cat_id);
    $('.customfield_div').slideDown();
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: BASE_URL+'market/product/get_custom_field_by_category/'+cat_id,
        data:{categoryId:cat_id},

        success: function (response){
            
            if(response)
            {
                $("#table_id tbody").html("");
                $(".Category_Field_data").html("");

                $(response.customHtml).each(function(key, value) {
                    $(".Category_Field_data").append(value);

                })
            }
            else
            {
                alert('error');
            }
            
        },
        error: function(e){

        },  
    });
});

$(document).on('click','.edit_product_varient', function(product){
        
    var product_id = $(this).data('product_id');
    var product_varient_id = $(this).data('product_varient_id');
    if(product_id == '' || product_varient_id =='' || isNaN(product_id) == true || isNaN(product_varient_id) == true )
    {
        return false;
    }

    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: BASE_URL+'market/product/product_varient/'+product_id+'/'+product_varient_id,
        data:{
                product_id:product_id,
                product_varient_id:product_varient_id,
            },

        success: function (response){
            
            if(response)
            {
            
            console.log(response);

            $("#model_box_content").html("");
            $("#model_box_content").append(response.data);
            $('#model_box_content').modal('show');

            }
            else
            {
                alert('error');
            }
            
        },
        error: function(e)
        {
            console.log(e);
             alert('exception');
        },  
    });
});


Dropzone.autoDiscover = false;
$(function() {

    var myDropzone = $("#imageupload").dropzone({ 
        url: BASE_URL+"market/product/productuploadfile",
        maxFilesize: 5,
        maxFiles: 5,
        renameFile: function(file) {
            var dt = new Date()
            var time = dt.getTime()
            return time+convertToSlug(file.name)
        },
        addRemoveLinks: true,
        dictResponseError: 'Server not Configured',
        acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg",
        timeout: 50000,

        removedfile: function(file) 
        {
            var name = file.upload.filename;

            $.ajax({

                type: 'POST',
                url: BASE_URL+'market/product/productdel_file',
                data: {filename: name },
            
                success: function (data){
                    if(data){
                        data = JSON.parse(data);
                        console.log("File has been successfully removed!!"+data);
                        $('.product_image_block :input[value="'+data+'"]').remove();
                    }
                    else
                    {
                        alert('error');
                    }
                    

                },
                error: function(e) {
                    console.log(e)
                }})
                var fileRef
                return (fileRef = file.previewElement) != null ? 
                fileRef.parentNode.removeChild(file.previewElement) : void 0
        },
   
        success: function(file, response) 
        {
            response = JSON.parse(response);
            if(response.name){
                if ( $("product_image_input").length ) {                    
                $(".product_image_block").last().after('<input type="hidden" name="product_image[]" class="form-control product_image_input" value="'+response.name+'">');
                }
                else{                    
                $(".product_image_block").append('<input type="hidden" name="product_image[]" class="form-control product_image_input" value="'+response.name+'">');
                }
            }
            else
            {
                alert('error'); 
            }

        },

        error: function(file, response)
        {
           return false;
        },

        init:function() {

            var self = this
            // config
            self.options.addRemoveLinks = true
            self.options.dictRemoveFile = "Delete"
            //New file added
            self.on("addedfile", function (file) {
                console.log('new file added ', file)
            })
            // Send file starts
            self.on("sending", function (file, xhr, formData) {
                formData.append([csrf_Name], csrf_Hash) 
                console.log('upload started', file)
                $('.meter').show()
            })

            // File upload Progress
            self.on("totaluploadprogress", function (progress) {
                console.log("progress ", progress)
                $('.roller').width(progress + '%')
            })

            self.on("queuecomplete", function (progress) {
                $('.meter').delay(999).slideUp(999)
            })

            // On removing file
            self.on("removedfile", function (file) {
                console.log(file)
            })

            self.on("maxfilesexceeded", function(file){
                // alert("No more files please!")
                alert("No more files please !" );
                this.removeFile(file)
            })
        }
    })
})



function convertToSlug(Text)
{
    return Text
        .toLowerCase()
        .replace(/ /g,'-')
}


var table;

var csrfName = $('#csrf_hash').val();
var csrf_token = $('#csrf_token').val();

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
            "url": BASE_URL+"market/product/product_list",
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

});

$('.remove_img_btn').on('click',function(e)
{   
    e.preventDefault();

    var imgName = $(this).data('uploadimg');
    var id = $(this).data('id');

    $.ajax({
        url:BASE_URL+"market/product/updatedDelete",
        type:"POST",
        data:{filename:imgName,id:id},
        success: function (response){ 
            response = JSON.parse(response);

            var product_img = $("#product_images").val();
            if(product_img.indexOf(response.name+',') != -1)
            {
                
                var setimgValue = product_img.replace(response.name+',','');
            }
            else if(product_img.indexOf(','+response.name) != -1)
            {
                var setimgValue = product_img.replace(','+response.name,'');
            }
            else
            {
                var setimgValue = product_img.replace(response.name,'');
            }   

            $("#product_images").val('');
            $("#product_images").val(setimgValue);

        },
        error: function(e){
            
        },  
    }); 
    $(this).parents('.editImage').remove();
});

//product and variant delete with sweetalert
$('body').on('click','.common_delete',function(e){
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


$(".popup").on("click", function() {
   $('#imagepreview').attr('src', $(this).attr('src')); 
   $('#imagemodal').modal('show'); 
});

$(".delete_product_image").on("click", function(e) {
    e.preventDefault();

    var variant_id = $(this).data('variant_id');
    var product_image_name = $(this).data('image_name');

    if(variant_id && product_image_name)
    {

       $(this).closest('.col-1').remove();

    $.ajax({
        dataType : "json",
        type : 'post',
        data: {
                variant_id: variant_id,
                product_image_name: product_image_name,
              },
        url: BASE_URL+'market/product/delete_varient_image',
        success: function(response){
            if(response)
            {
                 console.log(response);
            }
            else
            {
               console.log(response);
            }

          },
          error: function (jqXHR, status, err) {
            console.log(jqXHR);
          }
    });
    

    }
    else
    {
        return false;
    }

});


$(document).ready(function() {

    $('.market_product_status').click(function(e)
    {
        var parent_div = $(this).closest('.market_data');

        if($(this).prop('checked') == true)
        {
            $(parent_div).find('.base_price').removeAttr("disabled");
            $(parent_div).find('.sale_price').removeAttr("disabled");
            $(parent_div).find('.affiliate_marketing_url').removeAttr("disabled");
        }
        else
        {
            $(parent_div).find('.base_price').attr("disabled","disabled");
            $(parent_div).find('.sale_price').attr("disabled","disabled");
            $(parent_div).find('.affiliate_marketing_url').attr("disabled","disabled");
        }

    });
});


})(jQuery);