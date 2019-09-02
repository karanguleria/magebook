//wp_enqueue_script( 'ajax-scripts', url-to-your-file/plugin-ajax.js', __FILE__ ) , array( '$' ), '1.0.0', true );

(function($) {
$(document).ready(function(){
    //alert(11);
$('#mySelect').on( 'change' , function(){
    //alert(1);
    var newValue = $(this).val();
    //alert(newValue);
    //var ajaxurl ='https://gp24.ro/wp-admin/admin-ajax.php';
    var ajaxurl ='https://gp24.ro/wp-content/themes/magbook/event.php';
    $.ajax({
        type: 'POST',
        url: ajaxurl, // use ajax_params.ajax_url if using in plugin
        dataType: 'json',
        data: {
            //action: 'crunchify_widget_events_listing_shortcode',
            //action: 'https://gp24.ro/wp-content/themes/magbook/event.php',
            newValue: newValue
        },
        success: function(response) {
            console.log(response);
            //alert('success');
        },
        error: function(errorThrown){
            console.log(errorThrown);
           // alert('Failed');
        }    
      })
    })
   })
});

/**/

