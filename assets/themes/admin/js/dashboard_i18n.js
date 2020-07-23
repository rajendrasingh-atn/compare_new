(function($)
{
"use strict";

$(document).ready(function() {
	

    // Jsi18n demonstration
    $('#jsi18n-sample').click(function(e) {
        if (e.preventDefault) { e.preventDefault(); } else { e.returnValue = false; }
        alert("{{admin dashboard jsi18n-sample}}");
    });

});


$("#graph_month").on('change', function(change) 
{
	var new_product_view_month = [];
	var new_product_visits_array = [];
	var new_total_visits = 10;
	var graph_month = $(this).val();
	if(graph_month)
	{
	    $.ajax({

		    type: 'POST',
		    url: BASE_URL+'admin/dashboard/get_month_product_view',
		    data: {
		            graph_month: graph_month,
		          },

		    success: function (response)
		    {
		        if(response)
		        {

		            response = JSON.parse(response);
		            if(response.status != 'error')
		            {
		               new_product_view_month = response.product_view_month;
		               new_product_visits_array = response.product_visits_array;
		               new_total_visits = response.total_visits;
		               canvas_graph_load(new_product_view_month, new_product_visits_array, new_total_visits);
		            }
		            else
		            {
		            	alert(response.msg);
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
	else
	{
		alert('Invalid Request');
	}
});

	window.onload = function() 
	{
	     canvas_graph_load(product_view_month, product_visits_array, total_visits);
	     //alert(product_view_month);
	};



    function canvas_graph_load(view_month, product_visits, total_visit)
	{
		var config = 
	    {
	         type: 'line',
	         data: 
	         {
	            labels: view_month,
	            datasets: [{
	               label: 'Products Visits',
	               backgroundColor: window.chartColors.red,
	               borderColor: window.chartColors.red,
	               pointRadius: 6,
	               data: product_visits,
	               fill: false,
	            }]
	         },
	         options: {
	            responsive: true,
	            title: {
	               display: true,
	               text: 'Line Chart'
	            },

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
	                     labelString: 'Product Visit Date'
	                  }
	               }],
	               yAxes: [{
	                  display: true,
	                  scaleLabel: {
	                     display: true,
	                     labelString: 'Number Of Time Visit Products'
	                  },
	                  ticks: {
	                     min: 0,
	                     max: total_visit,

	                     // forces step size to be 5 units
	                     stepSize: 5
	                  }
	               }]
	            }
	         }
	    };

	    var ctx = document.getElementById('canvassss').getContext('2d');
     	
     	window.myLine = new Chart(ctx, config);
	}



})(jQuery);

