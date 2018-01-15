jQuery(document).ready(function( $ ) {		
	var $div; // the sdiv jquery object
	var token;
	var dialog_object;
	var dialog;
	
	//dialog-popup-script
	$(".button-dialog-container").click(function(){
		$div = $(this); // the sdiv jquery object
		token = $div.data('token');
		dialog_object = window['dialog_popup_script_' + token];
		dialog =	'<div class="dialog-overlay">' + 
			'<div class="dialog-container">' +
				'<div class="dialog-image">'+
					'<img src="' + dialog_object.image + '" alt="Image not available.">' +
				'</div>' +
				'<div class="dialog-header"> <h2>' +
					dialog_object.header +
				'</h2></div>' +
				'<div class="dialog-content">' +
					dialog_object.content +
				'</div>' +
				'<div class="dialog-footer">' +
					display_footer_info() +
				'</div>' +
			'</div>' +
		'</div>';
		console.log("This var : " + JSON.stringify(dialog_object));
		console.log("This object property : " + dialog_object.button_image );
		$("#top").append( dialog );
		$(".dialog-overlay").css("display", "flex").hide().fadeIn( "fast", function() {
			$(".dialog-container").css("display", "block").hide().slideDown("slow");
		});
	});
	
	function display_footer_info(){
		var footer_html = '<div class="dialog-footer-container">';
		var address = dialog_object.post_footer.address;
		var contact = dialog_object.post_footer.contact;
		var website = dialog_object.post_footer.website;
		if( address || contact || website ){
			if (address){
				footer_html += '<div class="dialog-footer-address">' + address + '</div>';
			}
			if (contact){
				footer_html += '<div class="dialog-footer-contact">' + contact + '</div>';
			}
			if (website){
				footer_html += '<div class="dialog-footer-website">' + website + '</div>';
			}
				footer_html += '</div>';
			return footer_html;
		}
		
		return dialog_object.post_footer.default_text;
	}
	
	$("#top").on( "click", ".dialog-overlay", function() {
		console.log("removing dialog");
		$(".dialog-overlay").fadeOut("fast", function(){
			$(".dialog-overlay").remove();
		});
	});
	
	$("#top").on("click", ".dialog-container", function(e) {
		e.stopPropagation();
	});
	
	//drag
	var isDragging = false;
	var yPos = 0;
	var isDragging = false;
	var isDown = false;
	var lastMouseYCoor = 0;
	
	$("#top").mouseup(function(){
		isDown = false;
	});
	$("#top").on("mousedown", ".dialog-overlay", function() {
		//lastMouseYCoor = event.pageY;
		isDown = true;
	})
	.on("mousemove", ".dialog-overlay", function(event) {
		if (isDown){
			//scroll up the div
			if (event.pageY > lastMouseYCoor){
				if (yPos > 0){
					yPos -= 1;
				}
			}
			//scroll down the div
			else{
				yPos += 1;
			}
			$( ".dialog-overlay" ).scrollTop( yPos );
			isDragging = true;
			lastMouseYCoor = event.pageY;
			console.log("Dragging y-coordinate: " + lastMouseYCoor);
		}
	 })
	.on("mouseup", ".dialog-overlay", function() {
		isDown = false;
	});
});