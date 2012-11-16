/**
 * CodePeople Post Map 
 * Version: 1.0.1
 * Author: CodePeople
 * Plugin URI: http://wordpress.dwbooster.com
*/

(function ($) {
	window['_get_latlng'] = function (){
		var g  			= new google.maps.Geocoder(),
			a 			= $('#cpm_point_address').val(),
			longitude 	= $('#cpm_point_longitude').val(),
			latitude 	= $('#cpm_point_latitude').val(),
			language	= $('#cpm_map_language').val(),
			request		= {};
		
		// Remove unnecessary spaces characters
		longitude = longitude.replace(/^\s+/, '').replace(/\s+$/, '');
		latitude  = latitude.replace(/^\s+/, '').replace(/\s+$/, '');
		a = a.replace(/^\s+/, '').replace(/\s+$/, '');
		
		if(longitude.length && latitude.length){
			request['location'] = new google.maps.LatLng(latitude, longitude);
		}else if(a.length){
			request['address'] = a.replace(/[\n\r]/g, '');
		}else{
			return false;
		}	
		
		g.geocode(request, function(result, status){
			if(status && status == "OK"){
				// Update fields
				var address   = result[0]['formatted_address'],
					latitude  = result[0]['geometry']['location'].lat(),
					longitude = result[0]['geometry']['location'].lng();
				
				if(address && latitude && longitude){
					$('#cpm_point_address').val(address);
					$('#cpm_point_longitude').val(longitude);
					$('#cpm_point_latitude').val(latitude);
				}
			}else{
				alert('The point is not located');
			}
			
		});
	};		
	
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
				send_to_editor('[codepeople-post-map]');
			}
		});
	});
	
	// Show/Hide the information related to the map 
	window['display_map_form'] = function (){
		$('#map_data').slideToggle();
	};
	
	// Check the point or address existence
	window['checking_point'] = function (){
		var language = 'en';
		
		if(typeof google != 'undefined' && google.maps){
			_get_latlng();
		}else{
			$('<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false'+((language) ? '&language='+language: '')+'&callback=_get_latlng"></script>').appendTo('body');
		}
	};
})(jQuery);