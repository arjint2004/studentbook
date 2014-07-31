$(document).ready(function(){

	$.validator.addMethod("notEqual", function(value, element, param) {
	  return this.optional(element) || value != param;
	}, "Please choose a value!");

	
	$(".sendmail").each(function(){
		$container = $(this).next("div.error-container");
		//Validate Starts
		$(this).validate({
		  	onfocusout: function(element) {	$(element).valid();	},
			errorContainer: $container,
			rules:{
		      name:{required:true,minlength:3,notEqual:'Your Name'},
		  	  email:{required:true,email:true,notEqual:'Your Email'},
			  subject:{notEqual:'Subject'},
			  message:{notEqual:'Your Message'}
			  
			  /*,message:{required:true,minlength:10}*/
			}
		});//Validate End
		
		//Submit Starts		   
		$(this).submit(function(e){
			$frm = $(this);
			$name = $frm.find('*[name=name]').val();
			$email = $frm.find('*[name=email]').val();
			$subject = $frm.find('*[name=subject]').val();
			$message = $frm.find('*[name=message]').val();
			
			if($frm.find('*[name=name]').is('.valid') && $frm.find('*[name=email]').is('.valid')) {
				var action = $frm.attr('action');
				$frm.find('*[name=submit]').attr('disabled', 'disabled').after('');

				$frm.prev(".ajax_message").slideUp(750, function () {
					$ajax_container = $(this);
					$ajax_container.hide();
					
					$.post(action, {
						name: $name,
						email: $email,
						subject: $subject,
						message: $message
						}, function (data) {
							$ajax_container.html(data);
							$ajax_container.slideDown('slow');
							$frm.find('*[name=submit]').attr('disabled', '');
							if (data.match('success') != null) $frm.slideUp('slow');
						});
					});
			}
		e.preventDefault();	
		});//Submit End
		
	});
});