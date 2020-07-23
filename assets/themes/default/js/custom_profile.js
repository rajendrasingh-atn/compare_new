//delete user alert variant
$('.text-success').on('click',function(e){
	e.preventDefault();
	var variant_id = $(this).data('variant_id');
	var base_url = $("#main_base_url").val();
	var redirect_page = base_url+'profile?tab=alert';
	swal({
	  title: "Are you sure to remove alert ?",
	  //text: "Your previous price is ",
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
	  		url: BASE_URL+"remove_alarm/remove_user_alarm",
	  		type: "POST",
	  		data: {variant_id:variant_id},
	  		success:function(result)
	  		{
	  			result = JSON.parse(result);
	  			if(result.successfull == "success")
	  			{
	  				window.location.href = redirect_page;
	  				swal("Deleted!", "Your alert price has been deleted.", "success");	
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
	    swal("Cancelled", "Your alert is not deleted", "error");
	  }
	});
});

//click on view more button update status in user_alarm table
$('.set-status').on('click',function(e){
	var status = $(this).data('status');
	var  variant_id = $(this).data('variant_id');
	if(status == 1)
	{
		$.ajax({
			url: BASE_URL+"status_change/update_user_alarm_status",
			type: "POST",
			data:{variant_id:variant_id},
			success:function(result)
			{
				result = JSON.parse(result);
				if(result.successfull == "success")
				{
					$('#status_value_'+variant_id).removeClass('status-color');
					$('#status_value_'+variant_id).addClass('bg-white');
				}
			},
			error:function(e)
			{
				console.log(e);
			},
		});
	}
});

//click on buy now button update status in user_alarm table
$('.change-status').on('click',function(e){

	var status = $(this).data('status');
	var  variant_id = $(this).data('variant_id');
	if(status == 1)
	{
		$.ajax({
			url: BASE_URL+"status_change/update_user_alarm_status",
			type: "POST",
			data:{variant_id:variant_id},
			success:function(result)
			{
				result = JSON.parse(result);
				if(result.successfull == "success")
				{
					$('#status_value_'+variant_id).removeClass('status-color');
					$('#status_value_'+variant_id).addClass('bg-white');
				}
			},
			error:function(e)
			{
				console.log(e);
			},
		});
	}
});