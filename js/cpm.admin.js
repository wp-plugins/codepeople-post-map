/**
 * CodePeople Post Map 
 * Version: 1.0.1
 * Author: CodePeople
 * Plugin URI: http://wordpress.dwbooster.com
*/

(function ($) {
	$(function(){
		// Actions for icons
		$(".cpm_icon").click(function(){
			var  i = $(this);
			$('.cpm_icon.cpm_selected').removeClass('cpm_selected');
			i.addClass('cpm_selected');
			$('#default_icon').val($('img', i).attr('src'));
		}).mouseover(function(){
			$(this).css({"border":"solid #BBBBBB 1px"})
		}).mouseout(function(){
			$(this).css({"border":"solid #F9F9F9 1px"})
		});
		
		// Actions for thumbnail selection
		$(".cpm_thumb").click(function(){
			var e = $(this);
			$("#cpm_point_thumbnail").attr("value", $('img', e).attr('src'));
			$(".cpm_thumb_selected").removeClass("cpm_thumb_selected");
			e.addClass("cpm_thumb_selected");
		});
		
		// Action for insert shortcode 
		$('#cpm_map_shortcode').click(function(){
			if(send_to_editor){
				send_to_editor('[codepepople-post-map]');
			}
		});
	});
	
	// Show/Hide the information related to the map 
	window['display_map_form'] = function (){
		$('#map_data').slideToggle();
	};
	
	// Check the point or address existence
	window['checking_point'] = function (){
		var address 	= $('#cpm_point_address').val(),
			longitude 	= $('#cpm_point_longitude').val(),
			latitude 	= $('#cpm_point_latitude').val(),
			language	= $('#cpm_map_language').val(),
			query,
			type;
		
		// Remove unnecessary spaces characters
		longitude = longitude.replace(/^\s+/, '').replace(/\s+$/, '');
		latitude  = latitude.replace(/^\s+/, '').replace(/\s+$/, '');
		address   = address.replace(/^\s+/, '').replace(/\s+$/, '');
		
		if(longitude.length && latitude.length){
			query = latitude+','+longitude;
			type = 'latlng';
		}else if(address.length){
			type = 'address';
			query = address.replace(/[\n\r]/g, '').replace(/\s/g, '+');
		}else{
			return false;
		}	
		
		var api_url = "http://maps.googleapis.com/maps/api/geocode/json?"+type+"="+escape(query)+"&sensor=false&language="+language+"&callback=?";
		$.ajax({url:'/wp-content/plugins/codepeople-post-map/include/get.php', dataType:'json', success:function(data){
			var flag = false;
			if(data.status && data.status == 'OK'){
				var address   = data["results"]["0"]["formatted_address"],
					latitude  = data["results"]["0"]["geometry"]["location"]["lat"],
					longitude = data["results"]["0"]["geometry"]["location"]["lng"];
				
				if(address && latitude && longitude){
					$('#cpm_point_address').val(address);
					$('#cpm_point_longitude').val(longitude);
					$('#cpm_point_latitude').val(latitude);
					
					flag = true;
				}
			}
			
			if(!flag){
				alert('The point is not located');
			}
		}, data:{filter:api_url}});
	};
})(jQuery);