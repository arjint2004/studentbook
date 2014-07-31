$(function() {

	$('.post-form').submit(function() {
		var textarea  = this.getElementsByTagName('textarea')[0],
		    taWidth   = textarea.offsetWidth - 6,
				taHeight  = textarea.offsetHeight - 6,
				taTop     = textarea.offsetTop,
				taLeft    = textarea.offsetLeft,
				taText    = textarea.value,
				fpTop     = document.getElementsByClassName('post')[0].offsetTop - 3;
		
		var $hoverDiv = $('<div>').addClass('hover')
				                      .text(taText)
				                      .css({'width': taWidth,
																	  'height': taHeight,
																	  'top': taTop,
							                      'left': taLeft});
		
		var $postContent   = $('<p>').addClass('post-content')
				                         .text(taText)
				                         .css('visibility', 'hidden'),
				$postTimestamp = $('<p>').addClass('post-timestamp')
				.text('Posted on: ' + new Date().toUTCString())
				                         .css('visibility', 'hidden'),
				$post          = $('<li>').addClass('post')
				                          .append($postContent)
				                          .append($postTimestamp)
				                          .hide();
		
		textarea.value = '';
		$post.prependTo('#feed');
		$hoverDiv.appendTo('body')
			       .delay(500)
			       .animate({'top': fpTop}, 1000, 'swing')
			       .queue(function() {
						 		$postContent.css('visibility', 'visible');
							 	$hoverDiv.delay(200).stop().fadeOut();
							 	$postTimestamp.hide().css('visibility', 'visible').fadeIn();
						 });
		$post.delay(500).slideDown(1000);
	});

});