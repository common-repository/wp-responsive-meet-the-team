jQuery(function($){
 
jQuery('#setting_heading_font_size').parent().prepend('<div id="slider-range"></div>');
jQuery('#setting_Subheading_font_size').parent().prepend('<div id="slider-range2"></div>');
jQuery('#setting_paragraph_font_size').parent().prepend('<div id="slider-range3"></div>');
  jQuery('#team_circle').removeClass('simplePanelimageUpload');
  // Set all variables to be used in scope
  var frame,
      metaBox = jQuery('#team_circle') // Your meta box id here
      imgContainer = jQuery('.simplePanelImagePreview'), // Your meta box id here
      imgIdInput = jQuery('.simplePanelImagePreview').next(), // Your meta box id here
      imgUrlInput = jQuery('.simplePanelImagePreview').next().next() // Your meta box id here
      ;
  
  // ADD IMAGE LINK
  metaBox.on( 'click', function( event ){
    
    event.preventDefault();
    
   
    // Create a new media frame
    frame = wp.media({
      title: 'Select or Upload Media For Crop',
      button: {
        text: 'Use this media'
      },
      multiple: false  // Set to true to allow multiple files to be selected
    });

   
    // When an image is selected in the media frame...
    frame.on( 'select', function() {
      
      // Get media attachment details from the frame state
      var attachment = frame.state().get('selection').first().toJSON();
      
      // Send the attachment URL to our custom image input field.
      imgContainer.html( '<img src="'+attachment.url+'" alt="" style="max-width:100%;" id="cropbox"/>' );

      // Send the attachment id to our hidden input
      imgIdInput.val( attachment.id );
      imgUrlInput.val( attachment.url );

      // Hide the add image link
     var data = {
      action: 'jcrop_image',
      };
 
    jQuery.ajax({url: 'admin-ajax.php',data, success: function(result){
        jQuery(".desc-field").html(result);
    }});

     //addImgLink.addClass( 'hidden' );
    });

    // Finally, open the modal on click
    frame.open();
  });

  jQuery(document).ready(function(){

    jQuery('.dp-close,.dp-overly').click(function(){
     jQuery('.dp-light-box,.dp-overly').slideUp();
    })


  jQuery('.dp-layout-boxed > div').each(function(){
jQuery(this).children('.dp-item-boxed').click(function(){
  jQuery(this).nextAll().slideDown();
})
  })



  })  

jQuery('#setting_post_type').change(function(){
 if(jQuery(this).is(':checked'))
 jQuery('.form-table tr:nth-child(3)').css('display','table-row');
else
  jQuery('.form-table tr:nth-child(3)').css('display','none');
});
if(jQuery('#setting_post_type').is(':checked'))
 jQuery('.form-table tr:nth-child(3)').css('display','table-row');
});

