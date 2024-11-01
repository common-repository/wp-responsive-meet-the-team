<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action( 'wp_ajax_wprm_jcrop_image', 'wprm_jcrop_image' );
add_action( 'wp_ajax_nopriv_wprm_jcrop_image', 'wprm_jcrop_image' );
function wprm_jcrop_image(){

   $html .='<input type="hidden" id="x" name="x" />
            <input type="hidden" id="y" name="y" />
            <input type="hidden" id="w" name="w" />
            <input type="hidden" id="h" name="h" />
            <input type="hidden" id="att_id" name="att_id" />
            <input type="button" id="crop_submit" value="Crop Image" class="btn btn-large btn-inverse" />';
   
    $html .="<script>jQuery(function(){
            jQuery('#cropbox').Jcrop({
            aspectRatio: 1,
            onSelect: updateCoords
            });});
            function updateCoords(c)
            {
            jQuery('#x').val(c.x); jQuery('#y').val(c.y); jQuery('#w').val(c.w); jQuery('#h').val(c.h);
            att_id = jQuery('.simplePanelImagePreview').next().val();
            jQuery('#att_id').val(att_id);
            };
            function checkCoords()
            {
            if (parseInt(jQuery('#w').val())) return true;
            alert('Please select a crop region then press submit.');
            return false;
            };</script>";

    $html .="<script>
    		jQuery('#crop_submit').on('click',function(){
    		
    		x =jQuery('#x').val();
    		y =jQuery('#y').val();
    		w =jQuery('#w').val();
    		h =jQuery('#h').val();
    		att_id =jQuery('#att_id').val();
    		
    		var data = {
      		action: 'wprm_jcrop_image_save',
			x:x,
			y:y,
			w:w,
			h:h,
			att_id:att_id
      		};
 
    		jQuery.ajax({url: 'admin-ajax.php',data, success: function(result){
        	  var res = jQuery.parseJSON(result);
        	  jQuery('.simplePanelImagePreview').next().val(res.attach_id);  
        	  jQuery('.simplePanelImagePreview').next().next().val(res.attach_url);  
    		  jQuery('.simplePanelImagePreview img').attr('src',res.attach_url);	
    		  jQuery('.simplePanelImagePreview img').css('display','block');	
    		  jQuery('.simplePanelImagePreview img').css('visibility','visible');
    		  jQuery('.simplePanelImagePreview img').css('width','auto');
    		  jQuery('.simplePanelImagePreview img').css('height','auto');
    		  jQuery('.desc-field').html('');
    		  jQuery('.jcrop-holder').remove();
    		  jQuery('#team_circle').removeClass('simplePanelimageUpload');
    		  }});
  			});</script>";        

    echo $html;    
    die();
}        
add_action( 'wp_ajax_wprm_jcrop_image_save', 'wprm_jcrop_image_save' );
add_action( 'wp_ajax_nopriv_wprm_jcrop_image_save', 'wprm_jcrop_image_save' );

function wprm_jcrop_image_save(){

	$uploaddir = wp_upload_dir();

	
	$orginal_path = get_attached_file($_REQUEST['att_id']); // Full path
	$src = $orginal_path;

	$wp_filetype = wp_check_filetype(basename($src), null );
	
	
	if($wp_filetype['ext']=='jpg' || $wp_filetype['ext']=='jpeg'):	
	$targ_w = $targ_h = 210;
	$jpeg_quality = 90;
	$img_r = imagecreatefromjpeg($src);
	$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );
	imagecopyresampled($dst_r,$img_r,0,0,$_REQUEST['x'],$_REQUEST['y'],
	$targ_w,$targ_h,$_REQUEST['w'],$_REQUEST['h']);
	$filename= time().'-cropped.jpeg';
	$uploadfile =  $uploaddir['path'] . '/' . $filename;
  	imagejpeg($dst_r,$uploadfile,$jpeg_quality);
  	endif;
	
  	if($wp_filetype['ext']=='png'):	

  	$targ_w = $targ_h = 210;
	$jpeg_quality = 9;
	$img_r = imagecreatefrompng($src);
	imagealphablending($img_r, false);
    $dst_r = ImageCreateTrueColor( $targ_w, $targ_h );
	imagealphablending($dst_r, false);
    imagecopyresampled($dst_r,$img_r,0,0,$_REQUEST['x'],$_REQUEST['y'],
	$targ_w,$targ_h,$_REQUEST['w'],$_REQUEST['h']);
	$black = imagecolorallocate($dst_r,0,0,0);
    imagecolortransparent($dst_r, $black);
    $filename= time().'-cropped.png';
	$uploadfile =  $uploaddir['path'] . '/' . $filename;
  	imagealphablending($dst_r,false);
    imagesavealpha($dst_r,true);
    imagepng($dst_r,$uploadfile,$jpeg_quality);
	
	endif;

	$attachment = array(
	'post_mime_type' => $wp_filetype['type'],
	'post_title' => preg_replace('/.[^.]+$/', '', $filename),
	'post_content' => '',
	'post_status' => 'inherit',
	'menu_order' => $_i + 1000
	);
	
	 $attach_id = wp_insert_attachment( $attachment,$uploadfile );
	 $fullsizepath = get_attached_file( $attach_id );
	 $metadata = wp_generate_attachment_metadata( $attach_id,$fullsizepath );
	 wp_update_attachment_metadata( $attach_id,$metadata );

	 if ( is_wp_error( $metadata ) )
	echo 'Images not upoaded Correctly Please try Again.';
	 if ( empty( $metadata ) )
	 echo 'Unknown failure reason.';

	$data['attach_id']=$attach_id;
	 
	 $data['attach_url']=wp_get_attachment_url($attach_id);
	 
	 echo json_encode($data);
	 exit;

}