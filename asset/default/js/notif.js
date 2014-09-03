jQuery(document).ready(function($){	
	
	
	function updatenotif() {
		$.ajax({
			type: "POST",
			data: 'ajax=1',
			url: $('#notifikasiasb').attr('url'),
			beforeSend: function() {
				$("#alertnotif").remove();
			},
			success: function(msg) {
			$('#notifikasiasb').html(msg);
			if(msg!=0){
				$('#notifikasiasb').before('<div id="alertnotif"></iv>');
				$('#alertnotif').css('left',$('#notifikasiasb').offset().left+'px');
				$('#alertnotif').css('bottom',$('#notifikasiasb').height()*2+'px');
				$('#alertnotif').css('width','240px');
				//$("#alertnotif").html(msg);
				$('.togglenotif').css('color','red');
					$("#alertnotif").delay(2000).html('Anda mempunyai <b>'+msg+'</b> pemberitahuan baru');
					$("#alertnotif").delay(2000).fadeOut("slow",function(){
						
						$("#alertnotif").remove();	
					});
				}else{
					$('.togglenotif').css('color','#999');
				}
				
					/*$.ajax({
						type: "POST",
						data: 'ajax=1',
						url: base_url+'akademik/notifikasi/notif',
						beforeSend: function() {
							$(this).after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
						},
						success: function(msg) {
							$("#wait").remove();	
							$("#aktifitasnotif").html(msg);
							$(".contrnt-notif").html(msg);
						}
					});*/
			}
			
		});
		setTimeout(updatenotif, 40000);
    }
    updatenotif();
	
	$('html').click(function() {
		$('.contrnt-notif').fadeOut();
	});

	$('.contrnt-notif').click(function(event){
		event.stopPropagation();
	});
	
	$('.togglenotif').click(function(){
		$(this).next('.contrnt-notif').css('height',$(window).height()/2+'px');
		//alert(($(window).height()-$(this).next('.contrnt-notif').height())/2);
		$(this).next('.contrnt-notif').css('right',($(window).width()-($('.container').width()))/2+10+'px');
		$(this).next('.contrnt-notif').css('width',$('.container').width()-10+'px');
		//$(this).next('.contrnt-notif').css('bottom',($(window).height()-$(this).next('.contrnt-notif').height())/2+'px');
		
		//loadnotif
		if( $(this).next().is(':hidden') ) {
		$.ajax({
			type: "POST",
			data: 'ajax=1',
			url: base_url+'akademik/notifikasi/notif',
			beforeSend: function() {
				$(this).after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
			},
			success: function(msg) {
				$("#wait").remove();	
				$(".contrnt-notif").html(msg);
			}
		});
		}
		$(this).next('.contrnt-notif').slideToggle();
		$(this).next('.contrnt-notif').focus();
		return false;
	});
});