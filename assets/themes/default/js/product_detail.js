/**
 *
 * You can write your JS code for product detail page here 
 *  
 */

$(function(){
"use strict";

	$('#sellerform').submit(function(event)
	{
		//alert('aaaa');	
	});
});

	jQuery(document).ready(function($){
	    
		$(".btnrating").on('click',(function(e) {

			var value = $(this).data('attr');
			var hidd = $('.rate').val(value);
			
			var previous_value = $("#selected_rating").val();
			
			var selected_value = $(this).attr("data-attr");
			$("#selected_rating").val(selected_value);
			
			$(".selected-rating").empty();
			$(".selected-rating").html(selected_value);
			
			for (i = 1; i <= selected_value; ++i) {
			$("#rating-star-"+i).toggleClass('btn-warning');
			$("#rating-star-"+i).toggleClass('btn-default');
			}
			
			for (ix = 1; ix <= previous_value; ++ix) {
			$("#rating-star-"+ix).toggleClass('btn-warning');
			$("#rating-star-"+ix).toggleClass('btn-default');
			}
		
		}));
	
	//like and disklike product review
	$(document).on('click','.like-icon i',function(e){
		var base_url = $("#main_base_url").val();
		var element = $(this)
		if($(this).hasClass('review-not-visit'))
		{
			var ids = $(this).data('review_id');
			$.ajax({
		        url: BASE_URL+"review_like/review_insert",
		        type: "POST",
		        data:{review_id:ids},
		        success:function(result)
		        {
		        	result = JSON.parse(result);
		        	console.log(result.success);
		        	if(result.success)
		        	{
		        		$('#change-color_'+ids).removeClass('review-not-visit');
		        		$('#change-color_'+ids).addClass('review-like');
		        		 
		        		 // if(result.success.total_like > 0)
		        		element.next('.total-likes').html(result.success.total_like);
		        	}
		        	else if(result.status == 'redirect')
		        	{
		        		window.location.href = base_url+'login';
		        	}
		        	else if(result.error == 'unsuccessfull')
		        	{
		    			alert('Something happen wrong');    		
		        	}
		        },
		        error:function(e)
		        {
		        	console.log(e)
		        },        
	      	});
		}
		else
		{
			var ids = $(this).data('review_id');
			var element = $(this)
			$.ajax({
				url: BASE_URL+"review_dislike/review_delete",
				type: "POST",
				data: {review_id:ids},
				success:function(result)
				{
					result = JSON.parse(result);
					if(result.successfull)
					{
						$('#change-color_'+ids).removeClass('review-like');
		        		$('#change-color_'+ids).addClass('review-not-visit');
		        		// if(result.successfull.total_like > 0)
		        		{	
		        			element.next('.total-likes').html(result.successfull.total_like);
		        		}
					}
					else if(result.status == 'redirect')
		        	{
		        		window.location.href = base_url+'login';
		        	}
		        	else if(result.error == 'unsuccessfull')
		        	{
		    			alert('Something happen wrong');    		
		        	}
				},
				error:function(e)
				{
					console.log(e)
				},
			});
		}
	});

	//save and remove data on bell click
	$('.bellicon i').on('click',function(e){
		e.preventDefault();
		var base_url = $("#main_base_url").val();
		var variant_id = $('.alam-data').data('variant_id');
		if($(this).hasClass('text-secondary'))
		{	
			swal({
			  title: "An input!",
			  text: "Write Minimum Price For This Product:",
			  type: "input",
			  showCancelButton: true,
			  closeOnConfirm: false,
			  inputPlaceholder: "Enter Price"
			}, 
			function (input_value) {
			  if (input_value === false) return false;
			  if (input_value === "") 
			  {
			    swal.showInputError("You need to write something!");
			    return false
			  }
			  else
			  {
			  	$.ajax({
					url: BASE_URL+"alert/insert_alert_data",
					type: "POST",
					data: {minprice:input_value,variant_id:variant_id},
					success:function(result)
					{
						result = JSON.parse(result);	
						if(result.successfull == 'success')
						{
							$('#bellactive').removeClass('text-secondary');
							$('#bellactive').addClass('text-success');	
							swal("Nice!", "You wrote: " + input_value, "success");		
						}
						else if(result.incorrect == 'notnumber')
						{
							swal.showInputError("Enter only numeric value");	
						}
						else if(result.status == 'redirect')
						{
							swal.showInputError("You need to Login");
							//window.location.href = base_url+'login';
						}
					},
					error:function(e)
					{
						console.log(e)
					},
				});
			  }
			});
		}
		else
		{
			if($(this).hasClass('text-success')) 
			{
				var alarm_price = $('.alam-data').val();
				swal({
				  title: "Are you sure to remove price?",
				  text: "Your previous price is "+alarm_price,
				  type: "warning",
				  showCancelButton: true,
				  confirmButtonClass: "btn-danger",
				  confirmButtonText: "Yes, delete it!",
				  cancelButtonText: "Cancel",
				  closeOnConfirm: false,
				  closeOnCancel: false
				},
				function(isConfirm) {
				  if (isConfirm) 
				  {
				  	$.ajax({
				  		url: BASE_URL+"remove_alert/delete_alert_data",
				  		type: "POST",
				  		data: {variant_id:variant_id},
				  		success:function(result)
				  		{
				  			result = JSON.parse(result);
				  			if(result.successfull == "success")
				  			{
				  				$('#bellactive').removeClass('text-success');
				  				$('#bellactive').addClass('text-secondary');
				  				swal("Deleted!", "Your previous price has been deleted.", "success");	
				  			}
				  		},
				  		error:function(e)
				  		{
				  			console.log(e);
				  		},
				  	});
				    
				  } 
				  else 
				  {
				    swal("Cancelled", "Your previous price "+alarm_price+" is not deleted", "error");
				  }
				});
			}
		}	
	});

	// 90 daya map data start

		
		if(typeof price_date_90 !== 'undefined')
		{
			var config_90 = {
				type: 'line',
				data: {
					labels: price_date_90,
					datasets: [{
						label: 'Procut Price',
						backgroundColor: window.chartColors.red,
						borderColor: window.chartColors.red,
						data:price_data_90,
						fill: false,
					}]
				},
				options: {
					responsive: true,
					tooltips: {
						mode: 'index',
						intersect: false,
					},
					hover: {
						mode: 'nearest',
						intersect: true
					},
					scales: {
						xAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Date'
							}
						}],
						yAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Price'
							},
							ticks: {
								min: min_price_90,
								max: price_maximum_90,
								// forces step size to be 5 units
								stepSize: 500
							}
						}]
					}
				}
			};
		}
		
	//90 days map data end

	//60 days map data start
		if(typeof price_date_60 !== 'undefined') 
		{
			var config_60 = {
				type: 'line',
				data: {
					labels: price_date_60,
					datasets: [{
						label: 'Procut Price',
						backgroundColor: window.chartColors.red,
						borderColor: window.chartColors.red,
						data:price_data_60,
						fill: false,
					}]
				},
				options: {
					responsive: true,
					tooltips: {
						mode: 'index',
						intersect: false,
					},
					hover: {
						mode: 'nearest',
						intersect: true
					},
					scales: {
						xAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Date'
							}
						}],
						yAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Price'
							},
							ticks: {
								min: min_price_60,
								max: price_maximum_60,
								// forces step size to be 5 units
								stepSize: 500
							}
						}]
					}
				}

			};
		}
	// 60 days data end	
		
	//30 days map data start
		if(typeof price_date_30 !== 'undefined') 
		{
			var config_30 = {
				type: 'line',
				data: {
					labels: price_date_30,
					datasets: [{
						label: 'Procut Price',
						backgroundColor: window.chartColors.red,
						borderColor: window.chartColors.red,
						data:price_data_30,
						fill: false,
					}]
				},
				options: {
					responsive: true,
					tooltips: {
						mode: 'index',
						intersect: false,
					},
					hover: {
						mode: 'nearest',
						intersect: true
					},
					scales: {
						xAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Date'
							}
						}],
						yAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Price'
							},
							ticks: {
								min: min_price_30,
								max: price_maximum_30,
								// forces step size to be 5 units
								stepSize: 500
							}
						}]
					}
				}

			};
		}
	//30 days map data end
	window.onload = function() {

		// alert(price_date_90);
		if(typeof price_date_90 !== 'undefined' && price_date_90 != 0) 
		{ 
			var ctx_90 = document.getElementById('ninty_days').getContext('2d');
			window.myLine = new Chart(ctx_90, config_90);
		}

		if(typeof price_date_60 !== 'undefined' && price_date_60 != 0) 
		{ 
			var ctx_60 = document.getElementById('sixty_days').getContext('2d');
			window.myLine = new Chart(ctx_60, config_60);
		}
		
		if(typeof price_date_30 !== 'undefined' && price_date_30 != 0) 
		{	
			var ctx_30 = document.getElementById('thirty_days').getContext('2d');
			window.myLine = new Chart(ctx_30, config_30);
		}
	};	
	

	$(document).ready(function(){
		$('.popup-gallery').magnificPopup({
			delegate: 'a',
			type: 'image',
			tLoading: 'Loading image #%curr%...',
			mainClass: 'mfp-img-mobile',
			gallery: {
				enabled: true,
				navigateByImgClick: true,
				preload: [0,1] // Will preload 0 - before current, and 1 after the current image
			},
			image: {
				tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
				titleSrc: function(item) {
					return item.el.attr('title');
				}
			}
		});
	});

	var slider2_left = BASE_URL+'assets/images/slider2_left.png';
    var slider2_right = BASE_URL+'assets/images/slider2_right.png';
	$('.product-detail-single').slick({
        dots: false,
        infinite: true,
        speed: 300,
        slidesToShow: 1,
        slidesToScroll: 1,
        prevArrow:"<img class='a-left control-c prev slick-prev' src='"+slider2_left+"'>",
        nextArrow:"<img class='a-right control-c next slick-next' src='"+slider2_right+"'>"
    });

    //market price sorting on click
    $('.dropdown-menu a').on("click",function(){
    	var sorting_method = $(this).data('price_select');
    	var no_items = $('.grid-item').length;
    	
		var result = $('.grid-item').sort(function (a, b) {
		    var contentA = $(a).find('.table-price').data("market_price");
		    var contentB = $(b).find('.table-price').data("market_price");
		    if(sorting_method == 'high') // sorting in ascending order 
	    	{
	    		return contentB - contentA;
	    	}
	    	else // sorting in descending order
	    	{
	    		return contentA - contentB;
	    	}
	   	});
    	$('.isotope-grid').html(result);
    	$('.load-more').hide();
    });	
	
	//comments show on click show more button
	$('.show-more-comment').on('click',function(){
		$('.detail-loader').show();
		var variant_id = $('.alam-data').data('variant_id');
		var last_id = $('.last-id').val();
		$.ajax({
	        url: BASE_URL+"get_comment/get_more_comment",
	        type: "GET",
	        data:{variant_id:variant_id,last_id:last_id},
	        success:function(result)
	        {
	        	console.log(result);
	        	result = JSON.parse(result);
	        	$('.detail-loader').hide();
	        	if(result.view)
	        	{
	        		$('.more-comments').append(result.view);
	        		$('.last-id').val(result.last_id);
	        		if(result.view == 'No Comments')
	        		{
	        			$('.more-comments').html(result.no_data);
	        			$(".show-more-comment").addClass('disabled-div');
	        		}	
	        		
	        	}
	        	
	        },
	        error:function(e)
	        {
	        	console.log(e)
	        },        
      	});
	});

});