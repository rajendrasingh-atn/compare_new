(function($)
{
    "use strict";

    // this script needs to be loaded on every page where an ajax POST
    $.ajaxSetup({
        data: {
            [csrf_Name] : csrf_Hash 
        }
    });




    var btn = $('#btt-button');

    $(window).scroll(function() {
      if ($(window).scrollTop() > 300) {
        btn.addClass('show');
      } else {
        btn.removeClass('show');
      }
    });

    btn.on('click', function(e) {
      e.preventDefault();
      $('html, body').animate({scrollTop:0}, '300');
    });




$('.comapre_products_nav .nav-link').on('click',function(e)
{
// e.preventDefault();

 comapre_products_nav();

});

$(document).on('click',function()
{
    $('.comapre_products_nav .comapre_products ').slideUp();      
});



$(document).on('click','.comapre_products_nav .comapre_products a.remove_from_compare.btn.btn-link', function(e)
{ 
    e.preventDefault();
    var base_url = $("#main_base_url").val(); 
    var product_slug = $(this).data('product_slug');
    var product_category = $(this).data('product_category'); 
    
    $.ajax({

    type: 'POST',
    url: base_url+'compare-product-remove/'+product_slug+'/'+product_category,
    data: {
            product_slug: product_slug,
            product_category: product_category,
          },

    success: function (response)
    {
        if(response)
        {

            response = JSON.parse(response);
            if(response.status != 'error')
            {
                $('.product_compare').find('.compare_product_link.list_compare_link.'+product_slug).removeClass('add_to_compare'); 
                $('.product_compare').find('.compare_product_link.list_compare_link.'+product_slug+' i.fas').removeClass('fa-check');
                $('.product_compare').find('.compare_product_link.list_compare_link.'+product_slug+' i.fas').addClass('fa-plus');

                $('.comapre_products_nav .nav-link .badge-dark').text(response.compare_count);
                console.log(response.msg);
                comapre_products_nav();   
            }
            else
            {
                $('.product_compare').find('.compare_product_link.list_compare_link.'+product_slug).removeClass('add_to_compare'); 
                $('.product_compare').find('.compare_product_link.list_compare_link.'+product_slug+' i.fas').removeClass('fa-check');
                $('.product_compare').find('.compare_product_link.list_compare_link.'+product_slug+' i.fas').addClass('fa-plus');

                $('.comapre_products_nav .nav-link .badge-dark').text(response.compare_count);
                console.log(response.msg);
                comapre_products_nav();   

            }

                   
        }
        else
        {
            alert('Server Response Error');
        }

    },
    error: function(e) {
        console.log(e)
    }});



});


function comapre_products_nav()
{

    var base_url = $("#main_base_url").val();   
    $.ajax(
    {

        type: 'POST',
        url: base_url+'compare-product-nav-data',
        success: function (response)
        {
            if(response)
            {
                response = JSON.parse(response);
                $('.comapre_products_nav .comapre_products ').html(response.content);
                $('.comapre_products_nav .comapre_products ').slideDown();           
            }
            else
            {
                alert('Server Response Error');
            }

        },
        error: function(e) 
        {
            console.log(e)
        }
    });
}

$(".add_fav_product_btn").click(function(e){

    var product_id = $(this).data('product_id');   
    var base_url = $("#main_base_url").val();
    
    var element  = $(this);
    if(product_id && base_url)
    {

        $.ajax(
        {
            type: 'GET',
            url: base_url+'add-to-fav-product/'+product_id,
            success: function (response)
            {
                if(response)
                {
                    response = JSON.parse(response);
                    if(response.status=='success')
                    {
                        if(response.action=='added')
                        {
                            $(element).children('.fav_icon').removeClass('text-secondary');
                            $(element).children('.fav_icon').addClass('text-danger');
                        }
                        else
                        {
                            $(element).children('.fav_icon').removeClass('text-danger');
                            $(element).children('.fav_icon').addClass('text-secondary');
                        }
                    }
                    else
                    {
                        if(response.action=='redirect')
                        {
                           window.location.href = base_url+'login';
                        }
                        else
                        {
                           alert(response.msg);
                        }

                        
                    }       
                }
                else
                {
                    alert('Server Response Error');
                }

            },
            error: function(e) 
            {
                console.log(e)
            }
        });
    }
    else
    {
        alert('Sorry Invalid Request');
    }
});




$('.compare_product_link').on('click', function()
{

    var base_url = $("#main_base_url").val();
    var product_slug = $(this).data('product_slug');
    var product_category = $(this).data('product_category');

    if ($(this).hasClass('add_to_compare')) 
    {
      
        if(product_slug && product_category)
        {
            remove_compare_product(product_slug,product_category,$(this));
        }
        else
        {
            alert('Invalid Try'); 
        }
    }
    else
    {
        if(product_slug && product_category)
        {
            add_compare_product(product_slug,product_category,$(this));
        }
        else
        {
            alert('Invalid Try');
        }
        
    }
});

function add_compare_product(product_slug,product_category ,section)
{

    var base_url = $("#main_base_url").val();  
    $.ajax({

        type: 'POST',
        url: base_url+'compare-product/'+product_slug+'/'+product_category,
        data: {
            product_slug: product_slug,
            product_category: product_category,
          },

    success: function (response)
    {
        if(response)
        {
            response = JSON.parse(response);
            if(response.status != 'error')
            {
                // $(section).addClass('add_to_compare');
                // $(section).find('i.fas').removeClass('fa-plus');
                // $(section).find('i.fas').addClass('fa-check');

                $('.product_compare').find('.compare_product_link.list_compare_link.'+product_slug).addClass('add_to_compare'); 
                $('.product_compare').find('.compare_product_link.list_compare_link.'+product_slug+' i.fas').removeClass('fa-plus');
                $('.product_compare').find('.compare_product_link.list_compare_link.'+product_slug+' i.fas').addClass('fa-check');

                $('.comapre_products_nav .nav-link .badge-dark').text(response.compare_count);
                console.log(response.msg);
            }
            else
            {   
                $('.comapre_products_nav .nav-link .badge-dark').text(response.compare_count);
                alert(response.msg);
                location.reload();
            }

            
        }
        else
        {
            alert('Server Response Error');
        }

    },
    error: function(e) {
        console.log(e)
    }});
}


function remove_compare_product(product_slug,product_category ,section)
{

    var base_url = $("#main_base_url").val();  
    $.ajax({

    type: 'POST',

    url: base_url+'compare-product-remove/'+product_slug+'/'+product_category,
    data: {
            product_slug: product_slug,
            product_category: product_category,
          },

    success: function (response)
    {
        if(response)
        {
            response = JSON.parse(response);
            if(response.status != 'error')
            {
                $('.product_compare').find('.compare_product_link.list_compare_link.'+product_slug).removeClass('add_to_compare'); 
                $('.product_compare').find('.compare_product_link.list_compare_link.'+product_slug+' i.fas').removeClass('fa-check');
                $('.product_compare').find('.compare_product_link.list_compare_link.'+product_slug+' i.fas').addClass('fa-plus');

                $('.comapre_products_nav .nav-link .badge-dark').text(response.compare_count);
                console.log(response.msg);
            }
            else
            {
                $('.product_compare').find('.compare_product_link.list_compare_link.'+product_slug).removeClass('add_to_compare'); 
                $('.product_compare').find('.compare_product_link.list_compare_link.'+product_slug+' i.fas').removeClass('fa-check');
                $('.product_compare').find('.compare_product_link.list_compare_link.'+product_slug+' i.fas').addClass('fa-plus');

                $('.comapre_products_nav .nav-link .badge-dark').text(response.compare_count);
                alert(response.msg);
                location.reload();
            }

            
        }
        else
        {
            alert('Server Response Error');
        }

    },
    error: function(e) {
        console.log(e)
    }});
}



/**
 * Global core functions
 */
(function($)
{

    /**
     * Session language selected
     */
    $('#session-language-dropdown a').click(function(e) {
        // prevent default behavior
        if (e.preventDefault) {
            e.preventDefault();
        } else {
            e.returnValue = false;
        }

        // set up post data
        var postData = {
            language : $(this).attr('rel')
        };

        // define callback function to handle AJAX call result
        var ajaxResults = function(results) {
            if (results.success) {
                location.reload();
            } else {
                alert("{{core error session_language}}");
            }
        };

        // perform AJAX call
        executeAjax(config.baseURL + 'ajax/set_session_language', postData, ajaxResults);
    });

});

$(document).ready(function(){
    var base_url = $("#main_base_url").val();  
    var slider1_left = BASE_URL+'assets/images/slider1-left.png';
    var slider1_right = BASE_URL+'assets/images/slider1_right.png';

    var slider2_left = BASE_URL+'assets/images/slider2_left.png';
    var slider2_right = BASE_URL+'assets/images/slider2_right.png';
    
  $('.multiple-items').slick({          
      dots: true,
      infinite: true,
      speed: 300,
      slidesToShow: 1,
      adaptiveHeight: true,
      prevArrow:"<img class='a-left control-c prev slick-prev' src='"+slider1_left+"'>",
      nextArrow:"<img class='a-right control-c next slick-next' src='"+slider1_right+"'>"
   }); 
  $('.single-item').slick({
        dots: false,
        infinite: true,
        speed: 300,
        slidesToShow: 1,
        slidesToScroll: 1,
        prevArrow:"<img class='a-left control-c prev slick-prev' src='"+slider2_left+"'>",
        nextArrow:"<img class='a-right control-c next slick-next' src='"+slider2_right+"'>"
    });
  $('.tab-slide').slick({
      slidesToShow: 5,
      slidesToScroll: 1,
      autoplay: false,
      autoplaySpeed: 2000,
      prevArrow:"<img class='a-left control-c prev slick-prev' src='"+slider2_left+"'>",
      nextArrow:"<img class='a-right control-c next slick-next' src='"+slider2_right+"'>"
    });

  $('.nav-link').on('click', function () {
    setTimeout(function() {
       // alert('aaa'); 
      $('.tab-slide').slick('refresh');
    },200)
  });
  $('.slide-category').slick({
      slidesToShow: 4,
      slidesToScroll: 1,
      autoplay: false,
      autoplaySpeed: 2000,
      prevArrow:"<img class='a-left control-c prev slick-prev' src='"+slider2_left+"'>",
      nextArrow:"<img class='a-right control-c next slick-next' src='"+slider2_right+"'>"
    });
  $('.best-seller').slick({
        dots: true,
        slidesToShow: 5,
        slidesToScroll: 1,
        autoplay: false,
        autoplaySpeed: 2000,
    });
  $('.power-slide').slick({
        dots: true,
        slidesToShow: 4,
        slidesToScroll: 4,
        autoplay: false,
        autoplaySpeed: 7000,
    });

    // $('.best-selling-slide').resize();
});


})(jQuery);