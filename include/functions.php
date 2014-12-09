<?php 
/**
 * CodePeople Post Map 
 * Version: 1.0.1
 * Author: CodePeople
 * Plugin URI: http://wordpress.dwbooster.com
*/

class CPM {
	//---------- VARIABLES ----------
	
	var $lang_array; // List of supported languages
	var $points = array(); // List of points to set on map
	var $points_str = ''; // List of points as javascript code
	var $map_id; // ID of map
    var $limit=0; // The number of pins allowed in map zero = unlimited
    var $defaultpost=''; // The post ID for centring the map, and display by default the infowindow
	var $extended = array();
	var $multiple = false;
	
	//---------- CONSTRUCTOR ----------
	
	function __construct(){
		$this->map_id = "cpm_".wp_generate_password(6, false);
		$this->lang_array = array(
							"ar"=>__("ARABIC","codepeople-post-map"),
							"eu"=>__("BASQUE","codepeople-post-map"),
							"bg"=>__("BULGARIAN","codepeople-post-map"),
							"bn"=>__("BENGALI","codepeople-post-map"),
							"ca"=>__("CATALAN","codepeople-post-map"),
							"cs"=>__("CZECH","codepeople-post-map"),
							"da"=>__("DANISH","codepeople-post-map"),
							"de"=>__("GERMAN","codepeople-post-map"),
							"el"=>__("GREEK","codepeople-post-map"),
							"en"=>__("ENGLISH","codepeople-post-map"),
							"en-AU"=>__("ENGLISH (AUSTRALIAN)","codepeople-post-map"),
							"en-GB"=>__("ENGLISH (GREAT BRITAIN)","codepeople-post-map"),
							"es"=>__("SPANISH","codepeople-post-map"),
							"eu"=>__("BASQUE","codepeople-post-map"),
							"fa"=>__("FARSI","codepeople-post-map"),
							"fi"=>__("FINNISH","codepeople-post-map"),
							"fil"=>__("FILIPINO","codepeople-post-map"),
							"fr"=>__("FRENCH","codepeople-post-map"),
							"gl"=>__("GALICIAN","codepeople-post-map"),
							"gu"=>__("GUJARATI","codepeople-post-map"),
							"hi"=>__("HINDI","codepeople-post-map"),
							"hr"=>__("CROATIAN","codepeople-post-map"),
							"hu"=>__("HUNGARIAN","codepeople-post-map"),
							"id"=>__("INDONESIAN","codepeople-post-map"),
							"it"=>__("ITALIAN","codepeople-post-map"),
							"iw"=>__("HEBREW","codepeople-post-map"),
							"ja"=>__("JAPANESE","codepeople-post-map"),
							"kn"=>__("KANNADA","codepeople-post-map"),
							"ko"=>__("KOREAN","codepeople-post-map"),
							"lt"=>__("LITHUANIAN","codepeople-post-map"),
							"lv"=>__("LATVIAN","codepeople-post-map"),
							"ml"=>__("MALAYALAM","codepeople-post-map"),
							"mr"=>__("MARATHI","codepeople-post-map"),
							"nl"=>__("DUTCH","codepeople-post-map"),
							"no"=>__("NORWEGIAN","codepeople-post-map"),
							"or"=>__("ORIYA","codepeople-post-map"),
							"pl"=>__("POLISH","codepeople-post-map"),
							"pt"=>__("PORTUGUESE","codepeople-post-map"),
							"pt-BR"=>__("PORTUGUESE (BRAZIL)","codepeople-post-map"),
							"pt-PT"=>__("PORTUGUESE (PORTUGAL)","codepeople-post-map"),
							"ro"=>__("ROMANIAN","codepeople-post-map"),
							"ru"=>__("RUSSIAN","codepeople-post-map"),
							"sk"=>__("SLOVAK","codepeople-post-map"),
							"sl"=>__("SLOVENIAN","codepeople-post-map"),
							"sr"=>__("SERBIAN","codepeople-post-map"),
							"sv"=>__("SWEDISH","codepeople-post-map"),
							"tl"=>__("TAGALOG","codepeople-post-map"),
							"ta"=>__("TAMIL","codepeople-post-map"),
							"te"=>__("TELUGU","codepeople-post-map"),
							"th"=>__("THAI","codepeople-post-map"),
							"tr"=>__("TURKISH","codepeople-post-map"),
							"uk"=>__("UKRAINIAN","codepeople-post-map"),
							"vi"=>__("VIETNAMESE","codepeople-post-map"),
							"zh-CN"=>__("CHINESE (SIMPLIFIED)","codepeople-post-map"),
							"zh-TW"=>__("CHINESE (TRADITIONAL)","codepeople-post-map")
                                                
        ); 
	} // End __construct
	
	//---------- CREATE MAP ----------
	
	/**
	 * Save a map object in database
	 * called by the action save_post
	 */
	function save_map($post_id){
		// authentication checks

		// make sure data came from our meta box
		if (!isset($_POST['cpm_map_noncename']) || !wp_verify_nonce($_POST['cpm_map_noncename'],__FILE__)) return $post_id;

		// check user permissions
		if (isset($_POST['post_type'] ) && $_POST['post_type'] == 'page'){
			if (!current_user_can('edit_page', $post_id)) return $post_id;
		}
		else{
			if (!current_user_can('edit_post', $post_id)) return $post_id;
		}

		// authentication passed, save data
		$default_icon = ( !empty( $_POST['default_icon'] ) ) ? $_POST['default_icon'] : $this->get_configuration_option('default_icon');
        
		delete_post_meta($post_id,'cpm_point');
		delete_post_meta($post_id,'cpm_map');
		
        $new_cpm_point = $_POST['cpm_point'];
		$new_cpm_map = $_POST['cpm_map'];
		$new_cpm_point['icon'] = str_replace( CPM_PLUGIN_URL, '', $default_icon );

        // Set the map's config
        $new_cpm_map['single'] = (isset($new_cpm_map['single'])) ? true : false;
        if($new_cpm_map['single']){
            $new_cpm_point['address'] = esc_attr($new_cpm_point['address']);
            $new_cpm_point['name'] = esc_attr($new_cpm_point['name']);
            $new_cpm_point['description'] = esc_attr($new_cpm_point['description']);
            
            
            $new_cpm_map['zoompancontrol'] 	= ($new_cpm_map['zoompancontrol'] == true);
            $new_cpm_map['mousewheel'] 		= ($new_cpm_map['mousewheel'] == true);
            $new_cpm_map['typecontrol'] 	= ($new_cpm_map['typecontrol'] == true);
            $new_cpm_map['streetviewcontrol'] 	= ($new_cpm_map['streetviewcontrol'] == true);
            $new_cpm_map['dynamic_zoom'] 	= (isset($new_cpm_map['dynamic_zoom']) && $new_cpm_map['dynamic_zoom']) ? true : false;
            $new_cpm_map['show_default'] 	= (isset($new_cpm_map['show_default']) && $new_cpm_map['show_default']) ? true : false;
            $new_cpm_map['show_window'] 	= (isset($new_cpm_map['show_window']) && $new_cpm_map['show_window']) ? true : false;
            
            add_post_meta($post_id,'cpm_map',$new_cpm_map,TRUE);
        } 
            
		// The address is required, if address is empty the couple: latitude, longitude must be defined
		if(!(empty($new_cpm_point['address']) || empty($new_cpm_point['latitude']) || empty($new_cpm_point['longitude']))){
			add_post_meta($post_id,'cpm_point',$new_cpm_point,TRUE);
		}
		
	} // End save_map
	
	//---------- OPTIONS FOR CODEPEOPLE POST MAP ----------
	/**
	 * Get default configuration options
	 */
	function _default_configuration(){
		return array(
							'zoom' => '10',
							'dynamic_zoom' => false,
							'width' => '450',
							'height' => '450',
							'margin' => '10',
							'align' => 'center',									
							'language' => 'en',
							'icons' => array(),
							'default_icon' => CPM_PLUGIN_URL.'/images/icons/marker.png',
							'type' => 'ROADMAP',
							'points' => 3,
							'display' => 'map',
							'mousewheel' => true,
							'zoompancontrol' => true,
							'typecontrol' => true,
							'streetviewcontrol' => true,
							'highlight'	=> true,
							'highlight_class' => 'cpm_highlight',
							'show_window' => true,
                            'show_default' => true,
							'windowhtml' => "<div class='cpm-infowindow'>
                                                <div class='cpm-content'>
                                                    <a title='%link%' href='%link%'>%thumbnail%</a>
                                                    <a class='title' href='%link%'>%title%</a>
                                                    <div class='address'>%address%</div>
                                                    <div class='description'>%description%</div>
                                                </div>
                                                <div style='clear:both;'></div>
                                            </div>"
							);
	} // End _default_configuration
	
	/**
	 * Set default system and maps configuration
	 */
	function set_default_configuration($default = false){
		$cpm_default = $this->_default_configuration();
							
    	$options = get_option('cpm_config');
		if ($default || $options === false) {
			update_option('cpm_config', $cpm_default);
			$options = $cpm_default;
		}
		return $options;
	} // End set_default_configuration
	
	/**
	 * Get a part of option variable or the complete array
	 */
	function get_configuration_option($option = null){
	
		$options = get_option('cpm_config');
		$default = $this->_default_configuration();
		
		if(!isset($options)){
			$options = $default;
		}
		
		if(isset($option)){
            return (isset($options[$option])) ? $options[$option] : ((isset($default[$option])) ? $default[$option] : null);
		}else{
			return $options;
		}	
		
	} // End get_configuration_option
	
	//---------- METADATA FORM METHODS ----------
	
	/**
	 * Private method to deploy the list of languages
	 */
	function _deploy_languages($options){
		print '<select name="cpm_map[language]" id="cpm_map_language">';
		foreach($this->lang_array as $key=>$value)
			print '<option value="'.$key.'" '.((isset($options['language']) && $options['language'] == $key) ? 'selected' : '').'>'.$value.'</option>';
		print '</select>';	
	} // End _deploy_languages
	
	/**
	 * Private method to get the list of icons
	 */
	function _deploy_icons($options = null){ 
		$icon_path = CPM_PLUGIN_URL.'/images/icons/';
		$icon_dir = CPM_PLUGIN_DIR.'/images/icons/';	

		$icons_array = array();

		$default_icon = (isset($options) && isset($options['icon'])) ? $options['icon'] : $this->get_configuration_option('default_icon');
		if( strpos($default_icon, 'http') !== 0 ) $default_icon = CPM_PLUGIN_URL.$default_icon;
		
		if ($handle = opendir($icon_dir)) {
			
			while (false !== ($file = readdir($handle))) {
		
				$file_type = wp_check_filetype($file);
				$file_ext = $file_type['ext'];
				if ($file != "." && $file != ".." && ($file_ext == 'gif' || $file_ext == 'jpg' || $file_ext == 'png') ) {
					array_push($icons_array,$icon_path.$file);
				}
			}
		}
		?>
			<div class="cpm_label">
				<?php _e("Select the marker by clicking on the images", "codepeople-post-map"); ?> 
			</div>    	   
			<div id="cpm_icon_cont">
				<input type="hidden" name="default_icon" value="<?php echo $default_icon ?>" id="default_icon" />			
				<?php foreach ($icons_array as $icon){ ?>
				  <div class="cpm_icon <?php if ($default_icon == $icon) echo "cpm_selected" ?>">
				  <img src="<?php echo $icon ?>" /> 
				  </div>
				<?php } ?>
			</div> 
			<div id="icon_credit">
				<span><?php _e("Powered by","codepeople-post-map"); ?></span>
				<a href="http://mapicons.nicolasmollet.com" target="_blank">
					<img src="<?php echo CPM_PLUGIN_URL ?>/images/miclogo-88x31.gif" />
				</a>
			 </div>
             <div class="clear"></div>
             <span class="cpm_more_info_hndl  cpm_blink_me" style="margin-left: 10px;"><a href="javascript:void(0);" onclick="cpm_display_more_info( this );">[ + more information]</a></span>
             <div class="cpm_more_info">
                <p>To use your own markers icons, you only should to upload the icons images to the following location:</p>
                <p>/wp-content/plugins/codepeople-post-map/images/icons</p>
                <p>and then select the icon's image from the list</p>
                <a href="javascript:void(0)" onclick="cpm_hide_more_info( this );">[ + less information]</a>
             </div>
		<?php
	} // End _deploy_icons
	
	/**
	 * Private method to insert the map form
	 */
	function _deploy_map_form($options = NULL, $single = false){
		?>
		<h2><?php _e('Maps Configuration', 'codepeople-post-map'); ?></h2>
		<p  style="border:1px solid #E6DB55;margin-bottom:10px;padding:5px;background-color: #FFFFE0;">
		<?php _e('For any issues with the map, go to our <a href="http://wordpress.dwbooster.com/contact-us" target="_blank">contact page</a> and leave us a message.'); ?><br/><br />
		<?php _e('If you want test the premium version of CP Google Maps go to the following links:<br/> <a href="http://demos.net-factor.com/cp-google-maps/wp-login.php" target="_blank">Administration area: Click to access the administration area demo</a><br/> <a href="http://demos.net-factor.com/cp-google-maps/" target="_blank">Public page: Click to access the CP Google Maps</a>'); ?>
		</p>
		<table class="form-table">
			<?php
                if($single){
            ?>    
                    <tr valign="top">
                        <th scope="row"><label for="cpm_map_single"><?php _e('Use particular settings for this map:', 'codepeople-post-map')?></label></th>
                        <td>
                            <input type="checkbox" name="cpm_map[single]" id="cpm_map_single" <?php echo ((isset($options['single'])) ? 'CHECKED' : '');?> />
                        </td>
                    </tr>
            <?php        
                }
            ?>
			<tr valign="top">
				<th scope="row"><label for="cpm_map_zoom"><?php _e('Map zoom:', 'codepeople-post-map')?></label></th>
				<td>
					<input type="text" size="4" name="cpm_map[zoom]" id="cpm_map_zoom" value="<?php echo ((isset($options['zoom'])) ? $options['zoom'] : '');?>" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="cpm_map_dynamic_zoom"><?php _e('Dynamic zoom:', 'codepeople-post-map')?></label></th>
				<td>
					<input type="checkbox" name="cpm_map[dynamic_zoom]" id="cpm_map_dynamic_zoom" <?php echo ( ( isset($options['dynamic_zoom'] ) && $options['dynamic_zoom'] ) ? 'CHECKED' : '' ); ?> /> <?php _e( 'Allows to adjust the zoom dynamically to display all points on map', 'codepeople-post-map' ); ?>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="cpm_map_width"><?php _e('Map width:', 'codepeople-post-map')?></label></th>
				<td>
					<input type="text" size="4" name="cpm_map[width]" id="cpm_map_width" value="<?php echo ((isset($options['width'])) ? $options['width'] : '');?>" />
                    <span class="cpm_more_info_hndl cpm_blink_me" style="margin-left: 10px;"><a href="javascript:void(0);" onclick="cpm_display_more_info( this );">[ + more information]</a></span>
                    <div class="cpm_more_info">
                        <p>To insert the map in a responsive design (in a responsive design, the map's width should be adjusted with the page width):</p>
                        <p>the value of map's width should be defined as a percentage of container's width, for example, type the value: <strong>100%</strong></p>
                        <a href="javascript:void(0)" onclick="cpm_hide_more_info( this );">[ + less information]</a>
                    </div>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="cpm_map_height"><?php _e('Map height:', 'codepeople-post-map')?></label></th>
				<td>
					<input type="text" size="4" name="cpm_map[height]" id="cpm_map_height" value="<?php echo ((isset($options['height'])) ? $options['height'] : '');?>" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="cpm_map_margin"><?php _e('Map margin:', 'codepeople-post-map')?></label></th>
				<td>
					<input type="text" size="4" name="cpm_map[margin]" id="cpm_map_margin" value="<?php echo ((isset($options['height'])) ? $options['margin'] : '');?>" />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="cpm_map_align"><?php _e('Map align:', 'codepeople-post-map')?></label></th>
				<td>
					<select id="cpm_map_align" name="cpm_map[align]">
						<option value="left" <?php echo((isset($options['align']) && $options['align'] == 'left') ? 'selected': ''); ?>><?php _e('left'); ?></option>
						<option value="center" <?php echo((isset($options['align']) && $options['align'] == 'center') ? 'selected': ''); ?>><?php _e('center'); ?></option>
						<option value="right" <?php echo((isset($options['align']) && $options['align'] == 'right') ? 'selected': ''); ?>><?php _e('right'); ?></option>
					</select>	
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="cpm_map_type"><?php _e('Map type:', 'codepeople-post-map'); ?></label></th>
				<td>
					<select name="cpm_map[type]" id="cpm_map_type" >
						<option value="ROADMAP" <?php echo ((isset($options['type']) && $options['type']=='ROADMAP') ? 'selected' : '');?>><?php _e('ROADMAP - Displays a normal street map', 'codepeople-post-map');?></option>
						<option value="SATELLITE" <?php echo ((isset($options['type']) && $options['type']=='SATELLITE') ? 'selected' : '');?>><?php _e('SATELLITE - Displays satellite images', 'codepeople-post-map');?></option>
						<option value="TERRAIN" <?php echo ((isset($options['type']) && $options['type']=='TERRAIN') ? 'selected' : '');?>><?php _e('TERRAIN - Displays maps with physical features such as terrain and vegetation', 'codepeople-post-map');?></option>
						<option value="HYBRID" <?php echo ((isset($options['type']) && $options['type']=='HYBRID') ? 'selected' : '');?>><?php _e('HYBRID - Displays a transparent layer of major streets on satellite images', 'codepeople-post-map');?></option>
					</select>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="cpm_map_language"><?php _e('Map language:', 'codepeople-post-map');?></th>
				<td><?php $this->_deploy_languages($options); ?></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="cpm_map_display"><?php _e('Display map in post/page:', 'codepeople-post-map'); ?></label></th>
				<td>
					<select name="cpm_map[display]" id="cpm_map_display" >
						<option value="icon" <?php echo ((isset($options['display']) && $options['display']=='icon') ? 'selected' : '');?>><?php _e('as icon', 'codepeople-post-map'); ?></option>
						<option value="map" <?php echo ((isset($options['display']) && $options['display']=='map') ? 'selected' : '');?>><?php _e('as full map', 'codepeople-post-map'); ?></option>
					</select>
				</td>
			</tr>
            
            <tr valign="top">
				<th scope="row"><label for="cpm_show_window"><?php _e('Show info bubbles:', 'codepeople-post-map');?></th>
				<td>
                    <input type="checkbox" id="cpm_show_window" name="cpm_map[show_window]" value="true" <?php echo ((isset($options['show_window']) && $options['show_window']) ? 'checked' : '');?>><span> <?php _e( 'Display the bubbles associated to the points', 'codepeople-post-map');?></span>
                </td>
			</tr>
            
            <tr valign="top">
				<th scope="row"><label for="cpm_show_default"><?php _e('Display a bubble by default:', 'codepeople-post-map');?></th>
				<td>
                    <input type="checkbox" id="cpm_show_default" name="cpm_map[show_default]" value="true" <?php echo ((isset($options['show_default']) && $options['show_default']) ? 'checked' : '');?>><span> <?php _e( 'Display a bubble opened by default', 'codepeople-post-map' ); ?></span>
                </td>
			</tr>
<?php
			if( !$single ){
?>            
				<tr valign="top">
					<th scope="row"><label for="cpm_get_direction"  style="color:#CCCCCC;"><?php _e('Display the get directions link:', 'codepeople-post-map');?></th>
					<td>
						<input type="checkbox" disabled><span> <?php _e( 'Display a link at  bottom of infowindow to get directions', 'codepeople-post-map' ); ?></span><br />
						<span style="color:#FF0000;">The feature is available only for the commercial version of plugin. <a href="http://wordpress.dwbooster.com/content-tools/codepeople-post-map#download">Click Here</a></span>
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row"><label for="cpm_map_link"  style="color:#CCCCCC;"><?php _e('Display a link to Google Maps:', 'codepeople-post-map');?></th>
					<td>
						<input type="checkbox" disabled><span> <?php _e( 'Display a link at  bottom of infowindow to display on Google Maps', 'codepeople-post-map' ); ?></span><br />
						<span style="color:#FF0000;">The feature is available only for the commercial version of plugin. <a href="http://wordpress.dwbooster.com/content-tools/codepeople-post-map#download">Click Here</a></span>
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row"><label for="cpm_street_view_link" style="color:#CCCCCC;"><?php _e('Display a link to street view:', 'codepeople-post-map');?></th>
					<td>
						<input type="checkbox" disabled /><span> <?php _e( 'Display a link at bottom of infowindow to load the corresponding street view', 'codepeople-post-map' ); ?></span><br />
						<span style="color:#FF0000;">The feature is available only for the commercial version of plugin. <a href="http://wordpress.dwbooster.com/content-tools/codepeople-post-map#download">Click Here</a></span>
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row"><label for="cpm_show_default" style="color:#CCCCCC;"><?php _e('Display the Panoramio layer:', 'codepeople-post-map');?></th>
					<td>
						<input type="checkbox" disabled /><span> <?php _e( 'Display a layer with photos published in Panoramio', 'codepeople-post-map' ); ?></span><br />
						<span style="color:#FF0000;">The feature is available only for the commercial version of plugin. <a href="http://wordpress.dwbooster.com/content-tools/codepeople-post-map#download">Click Here</a></span>
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row"><label for="cpm_MarkerClusterer" style="color:#CCCCCC;"><?php _e('Display a bundle of points in the same area, like a cluster:', 'codepeople-post-map');?></th>
					<td>
						<input type="checkbox" disabled /><span> <?php _e( 'Displays the number of points in the cluster', 'codepeople-post-map' ); ?></span><br />
						<span style="color:#FF0000;">The feature is available only for the commercial version of plugin. <a href="http://wordpress.dwbooster.com/content-tools/codepeople-post-map#download">Click Here</a></span>
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row"><label for="cpm_your_location" style="color:#CCCCCC;"><?php _e('Display the user\'s location:', 'codepeople-post-map');?></th>
					<td>
						<input type="checkbox" disabled /><span> <?php _e( "Display an icon with the user's location on map", 'codepeople-post-map' ); ?> </span><br />
						<span style="color:#FF0000;">The feature is available only for the commercial version of plugin. <a href="http://wordpress.dwbooster.com/content-tools/codepeople-post-map#download">Click Here</a></span>
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row"><label for="cpm_your_location_title" style="color:#CCCCCC;"><?php _e('Title of user\'s location:', 'codepeople-post-map');?></th>
					<td>
						<input type="text" disabled value="You are here" /><span> <?php _e('Title of user\'s location', 'codepeople-post-map');?></span><br />
						<span style="color:#FF0000;">The feature is available only for the commercial version of plugin. <a href="http://wordpress.dwbooster.com/content-tools/codepeople-post-map#download">Click Here</a></span>
					</td>
				</tr>
<?php
			}
?>            
            <tr valign="top">
				<th scope="row"><label for="cpm_map_route" style="color:#CCCCCC;"><?php _e('Display route:', 'codepeople-post-map');?></th>
				<td>
                    <input type="checkbox" DISABLED><span> <?php _e( 'Draws the route between the points in the same post', 'codepeople-post-map'); ?></span><br />
                    <span style="color:#FF0000;">The route between points is available only for the commercial version of plugin. <a href="http://wordpress.dwbooster.com/content-tools/codepeople-post-map#download">Click Here</a></span>
                </td>
			</tr>
            
            <tr valign="top">
				<th scope="row"><label for="cpm_travel_mode" style="color:#CCCCCC;"><?php _e('Travel mode:', 'codepeople-post-map');?></th>
				<td>
                    <select disabled>
                        <option value="DRIVING">Driving</option>
                    </select>
                </td>
            </tr>
			
            
			<tr valign="top">
				<th scope="row"><label for="wpGoogleMaps_description"><?php _e('Options', 'codepeople-post-map'); ?>:</label></th>
				<td>
					<input type="checkbox" name="cpm_map[streetviewcontrol]" id="cpm_map_streetviewcontrol" value="true" <?php echo ((isset($options['streetviewcontrol']) && $options['streetviewcontrol']) ? 'checked' : '');?> />
					<label for="cpm_map_streetviewcontrol"><?php _e('Display the street view control', 'codepeople-post-map'); ?></label><br />
					<input type="checkbox" name="cpm_map[mousewheel]" id="cpm_map_mousewheel" value="true" <?php echo ((isset($options['mousewheel']) && $options['mousewheel']) ? 'checked' : '');?> />
					<label for="cpm_map_mousewheel"><?php _e('Enable mouse wheel zoom', 'codepeople-post-map'); ?></label><br />
					<input type="checkbox" name="cpm_map[zoompancontrol]" id="cpm_map_zoompancontrol" value="true" <?php echo ((isset($options['zoompancontrol']) && $options['zoompancontrol']) ? 'checked' : '');?> />
					<label for="cpm_map_zoompancontrol"><?php _e('Enable zoom/pan controls', 'codepeople-post-map'); ?></label><br />
					<input type="checkbox" name="cpm_map[typecontrol]" id="cpm_map_typecontrol" value="true" <?php echo ((isset($options['typecontrol']) && $options['typecontrol']) ? 'checked' : '');?> />
					<label for="cpm_map_typecontrol"> <?php _e('Enable map type controls (Map, Satellite, or Hybrid)', 'codepeople-post-map'); ?> </label><br />
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="cpm_map_points"><?php _e('Enter the number of posts to display on the post/page map', 'codepeople-post-map'); ?>:</th>
				<td><input type="text" name="cpm_map[points]" id="cpm_map_points" value="<?php echo ((isset($options['points'])) ? $options['points'] : '');?>" /></td>
			</tr>
			<tr>
				<th scope="row"><label for="cpm_map_stylized" style="color:#CCCCCC;"><?php _e('Allow stylize the maps:', 'codepeople-post-map')?></label></th>
				<td valign="top">
					<input type="checkbox" DISABLED />
				</td>
			</tr>
			<tr>
				<th></th>
				<td>
					<span>
					<?php
						_e( 'If you want change the maps\' styles, be sure to know how to create a JSON structure with the map\'s styles', 'codepeople-post-map')
					?>
					</span><br />
					<textarea rows="10" cols="80" DISABLED READONLY ></textarea><br />
					 <span style="color:#FF0000;">This feature is available only in commercial version of plugin. <a href="http://wordpress.dwbooster.com/content-tools/codepeople-post-map#download">Click Here</a></span>
				</td>
			</tr>
            <tr>
				<th scope="row"><label for="cpm_map_legend" style="color:#CCCCCC;"><?php _e('Display the map\'s legend:', 'codepeople-post-map')?></label></th>
				<td valign="top">
					<input type="checkbox" disabled readonly /> <span style="color:#FF0000;">This feature is available only in commercial version of plugin. <a href="http://wordpress.dwbooster.com/content-tools/codepeople-post-map#download">Click Here</a></span>
				</td>
			</tr>
            <tr>
				<th scope="row"><label for="cpm_map_legend_taxonomy" style="color:#CCCCCC;"><?php _e('Select the taxonomy to display on legend:', 'codepeople-post-map')?></label></th>
				<td valign="top">
                    <select disabled readonly>
                        <option value=""><?php _e( 'Select a taxonomy', 'codepeople-post-map' ); ?></option>
                    </select>
                </td>
			</tr>
			<tr>
				<th scope="row"><label for="cpm_map_legend_title" style="color:#CCCCCC;"><?php _e('Enter a title for legend:', 'codepeople-post-map')?></label></th>
				<td valign="top">
					<input type="text" disabled readonly />
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="cpm_map_legend_class" style="color:#CCCCCC;"><?php _e('Enter a classname to be applied to the legend:', 'codepeople-post-map')?></label></th>
				<td valign="top">
					<input type="text" disabled readonly />
				</td>
			</tr>
			
		</table>
	<?php
	} // End _deploy_map_form
	
	/**
	 * Private method to print Maps form
	 */
	function _print_form($options){
		global $post;
		$default_configuration = $this->_default_configuration();
		
		// create a custom nonce for submit verification later
		echo '<input type="hidden" name="cpm_map_noncename" value="' . wp_create_nonce(__FILE__) . '" />';
	?>
		<script>
			var cpm_default_marker = "<?php echo $default_configuration['default_icon']; ?>";
			var cpm_point = {};
			
			<?php 
			if(!empty($options['address']) || (!empty($options['latitude']) && !empty($options['longitude']))){ 
				if(!empty($options['address'])) echo 'cpm_point["address"]="'.$options['address'].'";';
				if(!empty($options['latitude']) && !empty($options['longitude'])){
					echo 'cpm_point["latitude"]="'.$options['latitude'].'";';
					echo 'cpm_point["longitude"]="'.$options['longitude'].'";';
				}
				
			} else {
				echo 'cpm_point["address"]="Statue of Liberty, Statue of Liberty National Monument, Statue Of Liberty, New York, NY 10004, USA";'; 
				echo 'cpm_point["latitude"]="40.689848";';
				echo 'cpm_point["longitude"]="-74.044869";';
			} 
			?>
			
		</script>
		<p  style="font-weight:bold;"><?php _e('For more information go to the <a href="http://wordpress.dwbooster.com/content-tools/codepeople-post-map" target="_blank">CodePeople Post Map</a> plugin page'); ?></p>
		<p  style="border:1px solid #E6DB55;margin-bottom:10px;padding:5px;background-color: #FFFFE0;"><?php _e('For any issues with the map, go to our <a href="http://wordpress.dwbooster.com/contact-us" target="_blank">contact page</a> and leave us a message.'); ?></p>
        <p>
            <?php _e( 'To insert a map in the post follow the steps below', 'codepeople-post-map');?>:
        </p>
        <ol>
            <li><?php _e( 'Enter the point\'s information (the latitude and longitude are required, but are obtained pressing the "verify" button after type the address', 'codepeople-post-map' );?></li>
            <li><?php _e('Insert the shortcode in the post\'s content pressing the "insert the map tag" button', 'codepeople-post-map');?></li>
            <li><?php _e('If you want to use specific settings just for this map, press the "Show/Hide Map\'s Options" button, and modifies the settings for this map', 'codepeople-post-map'); ?></li>
            <li><?php _e( 'Don\'t forget to press the "Update" button for save the post and map data', 'codepeople-post-map');?></li>
        </ol>
		<div style="border:1px solid #CCC;margin-bottom:10px;min-height:60px;">
			<h3><?php _e('Map points'); ?></h3>
			<div id="points_container" style="padding:10px;">
			<?php _e('Multiple points in the same Post/Page are available only in the <a href="http://wordpress.dwbooster.com/content-tools/codepeople-post-map#download" target="_blank">advanced version</a>.'); ?>
			</div>
		</div>
		<div class="point_form" style="border:1px solid #CCC;">
			<h3><?php _e('Map point description'); ?></h3>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="cpm_name"><?php _e('Location name:', 'codepeople-post-map')?></label></th>
					<td>
						<input type="text" size="40" style="width:95%;" name="cpm_point[name]" id="cpm_point_name" value="<?php echo ((isset($options['name'])) ? $options['name'] : '');?>" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="cpm_point_description"><?php _e('Location description:', 'codepeople-post-map')?></label></th>
					<td>
						<input type="text" size="40" style="width:95%;" name="cpm_point[description]" id="cpm_point_description" value="<?php echo ((isset($options['description'])) ? $options['description'] : '');?>" />
                        <br />
                        <em>It is possible to insert a link to another page in the infowindow associated to the point. Type the link tag to the other page in the point description box, similar to: <span style="white-space:nowrap;"><strong>&lt;a href="http://wordpress.dwbooster.com" &gt;CLICK HERE &lt;/a&gt;</strong></span></em>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
                        <?php _e("Select an images to attach to the point: ","codepeople-post-map"); ?>
					</th>
                    <td>
                        <input type="text" name="cpm_point[thumbnail]" value="<?php if(isset($options["thumbnail"])){ echo $options["thumbnail"];} ?>" id="cpm_point_thumbnail" />
                        <input class="button" type="button" value="Upload Images" onclick="cpm_thumbnail_selection(this);" />
                    </td>	
				</tr>
				<tr valign="top">
					<td colspan="2">
						<table>
							<tr valign="top">
								<td>
                                    <span style="font-weight:bold;">Address, latitude and longitude are required fields.</span>
									<table>
										<tr valign="top">
											<th scope="row"><label for="cpm_point_address"><?php _e('Address:', 'codepeople-post-map')?></label></th>
											<td  width="100%">
												<input type="text" style="width:100%;" name="cpm_point[address]" id="cpm_point_address" value="<?php echo ((isset($options['address'])) ? $options['address'] : '');?>" />
											</td>
										</tr>	
										<tr valign="top">
											<th scope="row"><label for="cpm_point_latitude"><?php _e('Latitude:', 'codepeople-post-map')?></label></th>
											<td>
												<input type="text" style="width:100%;" name="cpm_point[latitude]" id="cpm_point_latitude" value="<?php echo ((isset($options['latitude'])) ? $options['latitude'] : '');?>" />
											</td>
										</tr>
										<tr valign="top">
											<th scope="row"><label for="cpm_point_longitude"><?php _e('Longitude:', 'codepeople-post-map')?></label></th>
											<td>
												<input type="text" style="width:100%;" name="cpm_point[longitude]" id="cpm_point_longitude" value="<?php echo ((isset($options['longitude'])) ? $options['longitude'] : '');?>" />
											</td>
										</tr>
										<tr valign="top">
											<th scope="row" style="text-align:right;"><p class="submit"><input type="button" name="cpm_point_verify" id="cpm_point_verify" value="<?php _e('Verify', 'codepeople-post-map'); ?>" onclick="cpm_checking_point(this);" /></p></th>
											<td>
												<label for="cpm_point_verify"><?php _e('Verify this latitude and longitude using Geocoding. This could overwrite the point address.', 'codepeople-post-map')?><span style="color:#FF0000">(<?php _e('Required: Press the button "verify" after complete the address.', 'codepeople-post-map'); ?>)</span></label>
											</td>
										</tr>
									</table>
								</td>
								<td width="50%">
									<div id="cpm_map_container" class="cpm_map_container" style="height:250px; border:1px dotted #CCC;">
									</div>
								</td>
							</tr>
						</table>	
					</td>
				</tr>
				<tr valign="top">
					<td colspan="2">
						<?php $this->_deploy_icons($options); ?>
					</td>	
				</tr>
			</table>
		</div>
		<div style="border:1px solid #CCC; padding:10px; margin:10px 0;">
			<p>
			<?php
			_e( 'To insert this map in a post/page, press the <strong>"insert the map tag"</strong> button and save the post/page modifications.', 'codepeople-post-map' );
			?>
			</p>
			<div style="border:1px solid #CCC; padding:10px; padding:5px;">
				<p style="color:#CCC;">
				<input type="checkbox" DISABLED />
				<?php
				_e( 'Do you want display a <strong>shape</strong> on map?', 'codepeople-post-map' );
				?>
				<br /><span style="color:#FF0000;">The feature is available only for the commercial version of plugin. <a href="http://wordpress.dwbooster.com/content-tools/codepeople-post-map#download" target="_blank">Click Here</a></span>
				</p>
			</div>	
			<table class="form-table">
				<tr valign="top">
					<td scope="row" valign="top" style="vertical-align:top;width:350px;">
						<label><?php _e('If you want to display the map in page / post:', 'codepeople-post-map')?></label><br />
						<input type="button" class="button-primary" name="cpm_map_shortcode" id="cpm_map_shortcode" value="<?php _e('Insert the map tag', 'codepeople-post-map'); ?>" style="height:40px; padding-left:30px; padding-right:30px; font-size:1.5em;" /><br />
						<span class="cpm_more_info_hndl cpm_blink_me" style="margin-left: 10px;"><a href="javascript:void(0);" onclick="cpm_display_more_info( this );">[ + more information]</a></span>
						<div class="cpm_more_info">
							<p>It is possible to use attributes in the shortcode, like: width, height, zoom and the other maps attributes:</p>
							<p><strong>[codepeople-post-map width="450" height="500"]</strong></p>
							<p>The premium version of plugin allows to use a special attribute "cat" (referent to category), to display all points created in a category:</p>
							<p><strong>[codepeople-post-map cat="35"]</strong><br/>Note: the number 35 correspond to the ID of category.</p>
							<p>or all points on website, using as category ID the value "-1"</p>
							<p><strong>[codepeople-post-map cat="-1"]</strong></p>
							<p>The special attribute "tag", allow to display all points that belong to the posts with a specific tag assigned, for example "mytag":</p>
							<p><strong>[codepeople-post-map tag="mytag"]</strong></p>
							<br />
							<a href="javascript:void(0)" onclick="cpm_hide_more_info( this );">[ + less information]</a>
						</div>
					</td>
					<td valign="top" style="vertical-align:top;">
						<label style="color:#CCC;"><?php _e('To display the points that belong to any category','codepeople-post-map');?>:</label><br />
						<select size="2" multiple="multiple" style="height:48px;width:100%;" disabled>
							<option value="-1">All points on website</option>
						<?php
							$categories = get_categories();
							foreach( $categories as $category )
							{
								print '<option value="'.$category->term_id.'">'.$category->name.'</option>';
							}
							
						?>
						</select>
						<br /><span style="color:#FF0000;">The feature is available only for the commercial version of plugin. <a href="http://wordpress.dwbooster.com/content-tools/codepeople-post-map#download" target="_blank">Click Here</a></span>
					</td>
				</tr>
			</table>	
		</div>	
		<div id="map_data">
			<?php $this->_deploy_map_form($options, true); ?>
		</div>	
        <p>&nbsp;</p>
		<?php
	} // End _print_form
	
	/**
	 * Form for maps insertion and update
	 */
	function insert_form(){
		global $post, $wpdb;
	
		$cpm_point = get_post_meta($post->ID, 'cpm_point', TRUE);
		$cpm_map = get_post_meta($post->ID, 'cpm_map', TRUE);
		$general_options = $this->get_configuration_option();
		$options = array_merge((array)$general_options, (array)$cpm_point, (array)$cpm_map);
		$options['post_id'] = $post->ID;
		$this->_print_form($options);
	} // End insert_form
	
	//---------- LOADING RESOURCES ----------
	
	/*
	 * Load the required scripts and styles for ADMIN section of website
	 */
	function load_admin_resources(){
		wp_enqueue_style(
			'admin_cpm_style',
			CPM_PLUGIN_URL.'/styles/cpm-admin-styles.css'
		);
		
		wp_enqueue_script(
			'admin_cpm_script',
			CPM_PLUGIN_URL.'/js/cpm.admin.js',
			array('jquery'),
            null,
            true
		);
	} // End load_admin_resources
	
	/**
	 * Load script and style files required for display google maps on public website
	 */
	function load_resources() {
        global $cpm_resources_loaded;
        if( !is_admin() && empty( $cpm_resources_loaded ) )
        {
            $cpm_resources_loaded = true;
            
            if( !wp_script_is( 'jquery' ) )
            {
                print "<script src='".($_SERVER['SERVER_PORT'] == 443 ? "https" : "http")."://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js'></script>";
            }
            
            print "<link rel='stylesheet' id='cpm_style-css'  href='".CPM_PLUGIN_URL.'/styles/cpm-styles.css'."' type='text/css' media='all' />";
            print "<script src='".CPM_PLUGIN_URL.'/js/cpm.js'."'></script>";
        }
	} // End load_resources
	
	function load_header_resources(){
		echo '<style>.cpm-map img{ max-width: none !important;box-shadow:none !important;}</style>';
	} // End load_header_resources
	
	/**
	 * Print the settings page for entering the general setting's data of maps
	 */
	function settings_page(){
		// Check if post exists and save the configuraton options
		if (isset($_POST['cpm_map_noncename']) && wp_verify_nonce($_POST['cpm_map_noncename'],__FILE__)){
			$options = $_POST['cpm_map'];
            $options['windowhtml'] = $this->get_configuration_option('windowhtml');
			update_option('cpm_config', $options);
			echo '<div class="updated"><p><strong>'.__("Settings Updated").'</strong></div>';
		}else{
			$options = $this->get_configuration_option();
		}
		
	?>
		<div class="wrap">
			<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
	<?php	
		$this->_deploy_map_form($options);
	?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row" style="color:#CCCCCC;"><label for="cpm_map_exif_information"><?php _e('Generate points dynamically from geolocation information included on images, when images are uploaded to WordPress:', 'codepeople-post-map')?></label></th>
				<td>
					<input type="checkbox" DISABLED />
                    <?php _e('The geolocation information is added to the images from your mobiles or cameras, if they have associated GPS devices', 'codepeople-post-map');?>
					<br />
                    <span style="color:#FF0000;">The free version of CodePeople Post Map allows only one map by webpage. <a href="http://wordpress.dwbooster.com/content-tools/codepeople-post-map#download">Click Here</a></span>
				</td>
			</tr>
			
            <tr valign="top">
				<th scope="row" style="color:#CCCCCC;"><label for="cpm_map_geolocation_information"><?php _e('Generate points dynamically from geolocation information included on posts:', 'codepeople-post-map')?></label></th>
				<td>
					<input type="checkbox" DISABLED />
                    <?php _e('The geolocation information is added to the post from WordPress app in your mobile', 'codepeople-post-map');?>
					<br />
                    <span style="color:#FF0000;">The free version of CodePeople Post Map allows only one map by webpage. <a href="http://wordpress.dwbooster.com/content-tools/codepeople-post-map#download">Click Here</a></span>
				</td>
			</tr>
			
            <tr valign="top">
				<th scope="row"><label for="cpm_map_search"  style="color:#CCCCCC;"><?php _e('Use points information in search results:', 'codepeople-post-map')?></label></th>
				<td>
					<input type="checkbox" name="cpm_map[search]" id="cpm_map_search" value="true" disabled /> <span style="color:#FF0000;">The search in the maps data is available only in commercial version of plugin. <a href="http://wordpress.dwbooster.com/content-tools/codepeople-post-map#download">Click Here</a></span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="cpm_map_highlight" style="color:#CCCCCC;"><?php _e('Highlight post when mouse move over related point on map:', 'codepeople-post-map')?></label></th>
				<td>
					<input type="checkbox" name="cpm_map[highlight]" id="cpm_map_highlight" value="true" disabled /> <span style="color:#FF0000;">The post highlight is available only in commercial version of plugin. <a href="http://wordpress.dwbooster.com/content-tools/codepeople-post-map#download">Click Here</a></span>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="cpm_map_highlight_class" style="color:#CCCCCC;"><?php _e('Highlight class:', 'codepeople-post-map')?></label></th>
				<td>
					<input type="input" name="cpm_map[highlight_class]" id="cpm_map_highlight_class" disabled /><span style="color:#FF0000;">The highlight class is available only in commercial version of plugin. <a href="http://wordpress.dwbooster.com/content-tools/codepeople-post-map#download">Click Here</a></span>
				</td>
			</tr>
            <tr valign="top">
				<th scope="row"><label for="cpm_map_post_type" style="color:#CCCCCC;"><?php _e('Allow to associate a map to the post types:', 'codepeople-post-map')?></label></th>
				<td valign="top">
                <?php
                    $post_types = get_post_types(array('public' => true), 'names');
                ?>
                    <select multiple size="3" DISABLED >
                <?php   
                        foreach($post_types as $post_type){
                            print '<option value="'.$post_type.'" >'.$post_type.'</option>';
                        }
                ?>    
                    </select>
                <?php
                    _e('Posts and Pages are selected by default', 'codepeople-post-map');
                ?>
                <br />    
                <span style="color:#FF0000;">Associate the maps to custom post types is available only in commercial version of plugin. <a href="http://wordpress.dwbooster.com/content-tools/codepeople-post-map#download">Click Here</a></span>
				</td>
			</tr>
		</table>
        <table cellpadding="10" cellspacing="10" width="500px">
            <tr valign="top">
                <td align="center" width="30%">
                    <a href="http://wordpress.dwbooster.com/content-tools/codepeople-post-map" target="_blank">
                    <img src="<?php echo(CPM_PLUGIN_URL.'/images/routes.jpg'); ?>" width="100px" height="100px" class="cpm_thumbnail_admin" style="border:1px solid #AAA;" />
                    </a>
                    <br />Draws Routes
                </td>
                <td align="center">
                    <a href="http://wordpress.dwbooster.com/content-tools/codepeople-post-map" target="_blank">
                    <img src="<?php echo(CPM_PLUGIN_URL.'/images/custom_post_type.jpg'); ?>" width="100px" height="100px" class="cpm_thumbnail_admin" style="border:1px solid #AAA;" />
                    </a>
                    <br />Associate maps to custom post types
                </td>
                <td align="center" width="30%">
                    <a href="http://wordpress.dwbooster.com/content-tools/codepeople-post-map" target="_blank">
                    <img src="<?php echo(CPM_PLUGIN_URL.'/images/multiple.jpg'); ?>" width="100px" height="100px" class="cpm_thumbnail_admin" style="border:1px solid #AAA;" />
                    </a>
                    <br/>Display a map for each post in pages with multiple posts
                </td>
            </tr>
        </table>
        <script>
            jQuery(function(){
                jQuery('.cpm_thumbnail_admin').mouseover(function(){jQuery(this).width(300).height(300);}).mouseout(function(){jQuery(this).width(100).height(100);});
            });
        </script>
		<p  style="font-weight:bold;"><?php _e('For more information go to the <a href="http://wordpress.dwbooster.com/content-tools/codepeople-post-map" target="_blank">CodePeople Post Map</a> plugin page'); ?></p>
		<div class="submit"><input type="submit" class="button-primary" value="<?php _e('Update Settings', 'codepeople-post-map');?>" /></div>
		<?php 
			// create a custom nonce for submit verification later
			echo '<input type="hidden" name="cpm_map_noncename" value="' . wp_create_nonce(__FILE__) . '" />'; 
		?>
		</form>
		</div>
	<?php
	} // End settings_page
	
	//---------- SHORTCODE METHODS ----------
	
	/*
	 * Populate the attribute points
	 */
	function populate_points($post_id){
		if( is_admin() ) return;
		
        $point = get_post_meta($post_id, 'cpm_point', TRUE);
		if(!empty($point)){
			$point['post_id'] = $post_id;
			if(!in_array($point, $this->points)){
                $this->points[] = $point;
            }	
		}	
	} // End populate_points
	
	/*
	 * Generates the javascript code of map points, only called from webpage of multiples posts
	 */
	function print_points(){
        global $id;
        
		$limit = abs($this->limit);
        
        $str = '';
        $current_post = '';
        $count_posts = 0;
        $count_points = 0;
        
        foreach($this->points as $point){
            if(!empty($limit)){
                if($current_post != $point['post_id']){
                    $current_post = $point['post_id'];
                    $count_posts++;
                    if( $count_posts > $limit) break;
                    if( !empty($this->defaultpost) && $this->defaultpost == $current_post )
                    {
                        $point[ 'default' ] = 1;
                        $this->defaultpost = '';
                    }
                }
            }    
            
            $str .=  $this->_set_map_point($point, $count_points);
            $count_points++;
        }
        if(strlen($str))
        {
            $str = "<script>if(typeof cpm_global != 'undefined' && typeof cpm_global['".$this->map_id."'] != 'undefined' && typeof cpm_global['".$this->map_id."']['markers'] != 'undefined'){ ".$str." }</script>";
        }
        
        $this->points = array();
        print $str;
	} // End print_points
	
	/**
	 * Replace each [codepeople-post-map] shortcode by the map
	 */
	function replace_shortcode($atts){
		global $post, $id, $cpm_objs, $cpm_in_loop;
        
        // Load the plugin resources
        $this->load_resources();
        
        $cpm_obj = new CPM;
        $cpm_objs[] = $cpm_obj;
        
		if(is_array($atts)) $cpm_obj->extended = $atts;
        
        if( !empty( $atts[ 'defaultpost' ] ) )  $cpm_obj->defaultpost = str_replace( ' ', '', $atts[ 'defaultpost' ] );
		
        if( isset($id) && ( is_singular() || !empty( $cpm_in_loop ) ) ){
            $cpm_map = get_post_meta($id, 'cpm_map', TRUE);
        }
        
        if(empty($cpm_map)){
            $cpm_map = $cpm_obj->get_configuration_option();
        }
		
        if(!empty($cpm_map['points'])){
            $cpm_obj->limit = $cpm_map['points'];
        }
        
        if( !empty( $atts[ 'points' ] ) )
        {
            $atts[ 'points' ] = trim( $atts[ 'points' ] );
            if( is_numeric( $atts[ 'points' ] ) && $atts[ 'points' ] > 0 ) $cpm_obj->limit = $atts[ 'points' ];
        }
        
		if( isset($id) && ( is_singular() || !empty( $cpm_in_loop ) ) ){ // For maps in a post or page
			// Set the actual post only to avoid duplicates
			$posts = array( $id );
			
			$query_arg = array( 
                'meta_key' => 'cpm_point', 
                'post_status' => 'publish', 
                'orderby' => 'post_date', 
                'order' => 'DESC', 
                'cache_results' => false,
                'fields' => 'ids',
                'post__not_in' => array( $id )
            );
			if( !empty($cpm_obj->limit) ){
				$query_arg[ 'numberposts' ] = $cpm_obj->limit - 1;
			}
			
			// Get POSTs in the same category
			$categories = get_the_category();
			$categories_ids = array();
			foreach($categories as $category){
				array_push( $categories_ids, $category->term_id);
			}
			
			if( !empty( $categories_ids ) ){
				$query_arg[ 'category' ] = implode( ',', $categories_ids );
			}
			
			$posts = array_merge( $posts, get_posts( $query_arg ) );
			
			foreach( $posts as $_post){
				$cpm_obj->populate_points($_post, true);
			}	
		    	
		}else{
            $cpm_obj->multiple = true;
        }
        
        $output  = $cpm_obj->_set_map_tag($cpm_map);
		$output .= $cpm_obj->_set_map_config($cpm_map);
			
        $output .= "<noscript>
                        codepeople-post-map require JavaScript
                    </noscript>
                    ";	
			
        if( !empty( $atts['print'] ) ){
            print $output;
            $cpm_obj->print_points();
            return '';
        }
        
        return $output;    
    } // End replace_shortcode
	
	/*
	 * Generates the DIV tag where the map will be loaded
	 */
	function _set_map_tag($atts){
		$atts = array_merge($atts, $this->extended);
        extract($atts);				
		$output ='<div id="'.$this->map_id.'" class="cpm-map" style="display:none; width:'.$width.(( strpos($width, '%') !== false ) ? '' : 'px').'; height:'.$height.(( strpos($height, '%') !== false ) ? '' : 'px').'; ';
		switch ($align) {
			case "left" :		  
				$output .= 'float:left; margin:'.$margin.'px;"';
			break;
			case "right" :		  
				$output .= 'float:right; margin:'.$margin.'px;"';
			break;
			case "center" :		  
				$output .= 'clear:both; overflow:hidden; margin:'.$margin.'px auto;"';
			break;
			default:
				$output .= 'clear:both; overflow:hidden; margin:'.$margin.'px auto;"';
			break;		  	  
		}
		$output .= "></div>";
		return $output;
	} // End _set_map_tag
	
	/*
	 * Generates the javascript tag with map configuration
	 */
	function _set_map_config($atts){
        $atts = array_merge($atts, $this->extended);
		
		extract($atts);
		$default_language = $this->get_configuration_option('language');
		$output  = "<script type=\"text/javascript\">\n";
	
		if(isset($language)) 
			$output  .= 'var cpm_language = {"lng":"'.$language.'"};';
		elseif(isset($default_language))	
			$output  .= 'var cpm_language = {"lng":"'.$default_language.'"};';
	
		$output .= "var cpm_global = cpm_global || {};\n";
		$output .= "cpm_global['$this->map_id'] = {}; \n";
		$output .= "cpm_global['$this->map_id']['zoom'] = $zoom;\n";
		$output .= "cpm_global['$this->map_id']['dynamic_zoom'] = ".((isset($dynamic_zoom) && $dynamic_zoom) ? 'true' : 'false').";\n";
		$output .= "cpm_global['$this->map_id']['markers'] = new Array();\n";
		$output .= "cpm_global['$this->map_id']['display'] = '$display';\n"; 
		$output .= "cpm_global['$this->map_id']['highlight_class'] = '".$this->get_configuration_option('highlight_class')."';\n"; 
		  
		$highlight = $this->get_configuration_option('highlight');
		$output .= "cpm_global['$this->map_id']['highlight'] = ".(($highlight && !is_singular()) ? 'true' : 'false').";\n"; 
		$output .= "cpm_global['$this->map_id']['type'] = '$type';\n";	
        $output .= "cpm_global['$this->map_id']['show_window'] = ".((isset($show_window) && $show_window) ? 'true' : 'false').";\n";
		$output .= "cpm_global['$this->map_id']['show_default'] = ".((isset($show_default) && $show_default) ? 'true' : 'false').";\n";
        
		  
		// Define controls
		$output .= "cpm_global['$this->map_id']['mousewheel'] = ".((isset($mousewheel) && $mousewheel) ? 'true' : 'false').";\n";	  
		$output .= "cpm_global['$this->map_id']['zoompancontrol'] = ".((isset($zoompancontrol) && $zoompancontrol) ? 'true' : 'false').";\n";	  
		$output .= "cpm_global['$this->map_id']['typecontrol'] = ".((isset($typecontrol) && $typecontrol) ? 'true' : 'false').";\n";	  
		$output .= "cpm_global['$this->map_id']['streetviewcontrol'] = ".((isset($streetviewcontrol) && $streetviewcontrol) ? 'true' : 'false').";\n";	  
		$output .= "</script>";
		
		return $output;
	} // End _set_map_config
	
	/*
	 * Generates the javascript code of map points
	 */
	function _set_map_point($point, $index){
		$icon = (!empty($point['icon'])) ? $point['icon'] : $this->get_configuration_option('default_icon');
		if( strpos( $icon, 'http' ) !== 0 ) $icon = CPM_PLUGIN_URL.$icon;
		
        $obj = new stdClass;
        $obj->address = str_replace(array('&quot;', '&lt;', '&gt;', '&#039;', '&amp;'), array('\"', '<', '>', "'", '&'), $point['address']);
        $obj->lat = $point['latitude'];
        $obj->lng = $point['longitude'];
        $obj->info = str_replace(array('&quot;', '&lt;', '&gt;', '&#039;', '&amp;'), array('\"', '<', '>', "'", '&'), $this->_get_windowhtml($point));
        $obj->icon = $icon;
        $obj->post = $point['post_id'];
        $obj->default = ( !empty( $point[ 'default' ] ) ) ? true : false;
		return 'cpm_global["'.$this->map_id.'"]["markers"]['.$index.'] = '.json_encode( $obj ).';';
    } // End _set_map_point
	
    function _get_img_id($url){
        global $wpdb;
        $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM " . $wpdb->prefix . "posts" . " WHERE guid='%s';", $url )); 
        return $attachment[0];
    } // End get_img_id
    
	/**
	 * Get the html info associated to point marker
	 */
 	function _get_windowhtml(&$point) {
    
		$windowhtml = "";
		$windowhtml_frame = $this->get_configuration_option('windowhtml');	
		
		$point_title = (!empty($point['name'])) ? $point['name'] : get_the_title($point['post_id']);
		$point_link = (!empty($point['post_id'])) ? get_permalink($point['post_id']) : '';
		
		$point_thumbnail = "";
        
        if (isset($point['thumbnail']) && $point['thumbnail'] != "") {
            $point_img_url = $point['thumbnail'];
            if(preg_match("/attachment_id=(\d+)/i", $point['thumbnail'], $matches)){
            	$thumb = wp_get_attachment_image_src($matches[1], 'thumbnail');
				if(is_array($thumb))$point_thumbnail = $thumb[0];
			}else{
                $point_thumbnail = $point['thumbnail'];
			}
            if($point_thumbnail != "")
                $point_img_url = $point_thumbnail;
		}
		
		$point_description = ($point['description'] != "") ? $point['description'] : $this->_get_excerpt($point['post_id']);
		$point_address = $point['address'];

		if(isset($point_img_url)) {
			$point_img = "<img src='".$point_img_url."' style='margin:8px 0 0 8px !important; width:90px; height:90px' align='right' />";
			$html_width = "310px";
		} else {
			$point_img = "";
			$html_width = "auto";
		}				
					
		$find = array("%title%","%link%","%thumbnail%", "%excerpt%","%description%","%address%","%width%","\r\n","\f","\v","\t","\r","\n","\\","\"");
		$replace  = array($point_title,$point_link,$point_img,"",$point_description,$point_address,$html_width,"","","","","","","","'");
		
		$windowhtml = str_replace( $find, $replace, $windowhtml_frame);
					
		return $windowhtml;
	} // End _get_windowhtml
	
	/**
	 * Get the excerpt from content
	 */
	function _get_excerpt($post_id) { // Fakes an excerpt if needed

		$content_post = get_post($post_id);
		$content = $content_post->post_content;

		if ( '' != $content ) {
			return wp_trim_words( strip_shortcodes( $content ), 10 );
        }
		return $content;
	} // End _get_excerpt
	
	/*
		Set a link to contact page
	*/
	function customizationLink($links) { 
		$settings_link = '<a href="http://wordpress.dwbooster.com/contact-us" target="_blank">'.__('Request custom changes').'</a>'; 
		array_unshift($links, $settings_link); 
		return $links; 
	} // End customizationLink
} // End CPM class
?>