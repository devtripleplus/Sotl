//Any ajax functionality that is required in any moule

/*jQuery(document).ready( function(){
	jQuery("#videoLike").click( function(){
		var user_id = jQuery('#userid').val();
		var video_id = jQuery('#videoid').val();
		$.ajax({
		  url: "/update/likes",
		  type: "POST",
		  data:{'user_id':user_id, 'video_id': video_id}
		  success: function(html){
		    $("#results").append(html);
		  }
		});
	});
});
*/

// To set the value of producer based on each review elements

  jQuery(document).ready( function(){
    jQuery(".rangeslider").click( function(){
      var writer = $("input[name=writer]").val();
      var director = $("input[name=director]").val();
      var editor = $("input[name=editor]").val();
      var cinematography = $("input[name=cinematography]").val();
      var acting = $("input[name=acting]").val();
      var producer = (parseFloat(writer) + parseFloat(director) + parseFloat(editor) +parseFloat(cinematography) + parseFloat(acting)) / 5;
      jQuery("input[name=producer],input[name=producer2]").val(Math.ceil(producer));
      jQuery(".producerValue").text(Math.ceil(producer));
    });

  });

  




