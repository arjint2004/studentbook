<script>

//var idcomment=<?=$id?>;
function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
function hidetextarea(object,id){
	//$(object).remove();
	//$(".replyedit"+id).html($(object).val());
}
function hidetextareapost(object,id){
	//$(object).remove();
	//$(".postedit"+id).html($(object).val());
}
function del(jenis,id){
	var answer = confirm("Are you sure?")
	if (answer){
		if(jenis=="reply"){
			$(".replyedit"+id).load("<?=base_url()?>akademik/comment/commentdeltreply/"+id);
			$("#replyshow"+id).remove();
		}
		if(jenis=="post"){
			$("#textpost"+id).load("<?=base_url()?>akademik/comment/commentdelpost/"+id);
			$("#textpost"+id).remove();
		}		
	}
	else{
		return false;
	}

}
function edit(jenis,id){
	if(jenis=="reply"){
		var vall=$(".replyedit"+id).html();
		$(".replyedit"+id).html('<form id="editreply'+id+'"><textarea rows="5" onblur="hidetextarea(this,'+id+');" post="'+id+'" onkeypress="return editreply(event,this);" name="commentreply" class="editreply" id="commentreplyedit'+id+'"></textarea></form>');
		//$("#commentreplyedit"+id).focus();
		$("#commentreplyedit"+id).focus().val(vall);	
	}
	if(jenis=="post"){
		var vall=$(".postedit"+id).html();
		$(".postedit"+id).html('<form id="editpost'+id+'"><textarea rows="5" onblur="hidetextareapost(this,'+id+');" post="'+id+'" name="commentpost" onkeypress="return editpost(event,this);"  class="postreply" id="commentpostedit'+id+'"></textarea></form>');
		//$("#commentreplyedit"+id).focus();
		$("#commentpostedit"+id).focus().val(vall);
	}
}

function editpost(e,object){
		var id=$(object).attr('post');
		
		if (!e) e = window.event;   // resolve event instance
		if (e.keyCode == '13' && e.shiftKey){
		 
		}else if(e.keyCode == 13){
		$(object).blur();
			submiteditpost(id);
			//$('.replyedit'+id).load("<?=base_url()?>akademik/comment/commenteditreply/"+id+"/"+$(object).val());
			return false;
		}

}
function editreply(e,object){
	var id=$(object).attr('post');
	
		if (!e) e = window.event;   // resolve event instance
		if (e.keyCode == '13' && e.shiftKey){
		 
		}else if(e.keyCode == 13){
		$(object).blur();
			submiteditreply(id);
			//$('.replyedit'+id).load("<?=base_url()?>akademik/comment/commenteditreply/"+id+"/"+$(object).val());
			return false;
		}

}

$("textarea.commentreply").live("keypress",function(event){
	  
	  if (event.keyCode == 13 && event.shiftKey) {

      }else if(event.keyCode == 13)
      {
          submitreply($(this).attr('post'),$(this).val(),$(this));
		 
		  $(this).blur();
		  return false;
      }
});
$("textarea.comment").live("keypress",function(event){
	  
      if (event.keyCode == 13 && event.shiftKey) {

      }else if(event.keyCode == 13)
      {
          submit($(this));
		  $(this).blur();
		  return false;
      }

});

$("div.post input[type='submit']").live("click",function(){
$(this).attr('disabled','disabled');
submit();
return false;
});
function submiteditpost(idcommentpost){
		var formData = $("#editpost"+idcommentpost).serialize();
		$(".content-box").append("<div class=\"error-box\"></div>");
		$(".error-box").html("Sending Data").fadeIn("slow");
		//alert("myObject is " + formData.toSource());
		$.ajax({
			url		: "<?=base_url()?>akademik/comment/commenteditpost/"+idcommentpost,
			type	: "post",
			data	: formData,
			dataType: "json",
			timeout	: 5000,
			error	: function(){
				$(".error-box").delay(1000).html('Sending Data Failed');
				$(".error-box").delay(1000).fadeOut("slow",function(){
					//$(this).remove();
				});
				
			},
			success	: function(returnData){
				
				if(returnData.status){
					//alert("myObject is " + returnData.message.toSource());
					//$(".error-box").delay(1000).html(returnData.message);
						//$('.comment').load('<?=base_url()?>akademik/comment/index/'+$('input#idcommentar').val());	
					//reset input value
					$('.comment').load('<?=base_url()?>akademik/comment/index/'+$('input#idcommentar').val()+'/first/'+$('input#jensget').val());
				}else{
					$(".error-box").delay(1000).html(returnData.message);
					$(".error-box").delay(1000).fadeOut("slow",function(){
						//$(this).remove();
						
					});
					
				}
			}
		});
		
		return false;
}
function submiteditreply(idcommentreply){
		var formData = $("#editreply"+idcommentreply).serialize();
		$(".content-box").append("<div class=\"error-box\"></div>");
		$(".error-box").html("Sending Data").fadeIn("slow");
		//alert("myObject is " + formData.toSource());
		$.ajax({
			url		: "<?=base_url()?>akademik/comment/commenteditreply/"+idcommentreply,
			type	: "post",
			data	: formData,
			dataType: "json",
			timeout	: 5000,
			error	: function(){
				$(".error-box").delay(1000).html('Sending Data Failed');
				$(".error-box").delay(1000).fadeOut("slow",function(){
					$(this).remove();
				});
				
			},
			success	: function(returnData){
				
				if(returnData.status){
					//alert("myObject is " + returnData.message.toSource());
					//$(".error-box").delay(1000).html(returnData.message);
						//$('.comment').load('<?=base_url()?>akademik/comment/index/'+$('input#idcommentar').val());	
					//reset input value
					$('.comment').load('<?=base_url()?>akademik/comment/index/'+$('input#idcommentar').val()+'/first/'+$('input#jensget').val());
				}else{
					$(".error-box").delay(1000).html(returnData.message);
					$(".error-box").delay(1000).fadeOut("slow",function(){
						$(this).remove();
						
					});
					
				}
			}
		});
		
		return false;
}
function submitreply(idcommentreply,postreply,obj){
		var formData = $("#reply"+idcommentreply).serialize();
		$(".content-box").append("<div class=\"error-box\"></div>");
		$(".error-box").html("Sending Data").fadeIn("slow");
		//alert("myObject is " + formData.toSource());
		$.ajax({
			url		: "<?=base_url()?>akademik/comment/commentsendreply/"+idcommentreply,
			type	: "post",
			data	: formData,
			dataType: "json",
			timeout	: 5000,
			error	: function(){
				$(".error-box").delay(1000).html('Sending Data Failed');
				$(".error-box").delay(1000).fadeOut("slow",function(){
					$(this).remove();
				});
				
			},
			success	: function(returnData){
				
				if(returnData.status){
					//alert("myObject is " + returnData.message.toSource());
					//$(".error-box").delay(1000).html(returnData.message);
						//$('.comment').load('<?=base_url()?>akademik/comment/index/'+$('input#idcommentar').val());	
					//reset input value
					//$('.comment').load('<?=base_url()?>akademik/comment/index/'+$('input#idcommentar').val()+'/first/'+$('input#jensget').val());
					var obload=$(obj).parent('form').parent('div').parent('div').parent('div').parent('div').parent('div');
					$(obload).load('<?=base_url()?>akademik/comment/index/'+$(obj).next('input').next('input').val()+'/first/'+$(obj).next('input').val());
				}else{
					$(".error-box").delay(1000).html(returnData.message);
					$(".error-box").delay(1000).fadeOut("slow",function(){
						$(this).remove();
						
					});
					
				}
			}
		});
		
		return false;
}
function submit(obj){
		
		var formData = $(obj).parent('form').serialize();
		$(".content-box").append("<div class=\"error-box\"></div>");
		$(".error-box").html("Sending Data").fadeIn("slow");
		//alert("myObject is " + formData.toSource());
		$.ajax({
			url		: "<?=base_url()?>akademik/comment/commentsend/"+$(obj).next('input').next('input').val(),
			type	: "post",
			data	: formData,
			dataType: "json",
			timeout	: 5000,
			error	: function(){
				$(".error-box").delay(1000).html('Sending Data Failed');
				$(".error-box").delay(1000).fadeOut("slow",function(){
					$(this).remove();
				});
				
			},
			success	: function(returnData){
				
				if(returnData.status){
					//alert("myObject is " + returnData.message.toSource());
					$(".error-box").delay(1000).html(returnData.message);
					
					/*$('.mebox').fadeOut("slow",0,function(){
						var info = "<div class=\"note-wrapper\"><p>Your Information <br />Successfully Submited</p>";
						//info = info+"<span>click <a href=\"#\" id=\"return\" class=\""+submitName+"\">here</a> ";
						//info = info+"to add more information</span></div>";
						info = info+"<span>Thanks for submiting your data</span></div> ";
						
						$(this).empty();
						$(this).append(info);
						$(this).delay(1000).fadeIn("slow");
						$(this).delay(3000).fadeOut("slow",function(){
							// Experimental Area //
							//autoReturn(submitName);
						});

					});*/
					
					$(".error-box").delay(1000).fadeOut("slow",function(){
						$(this).remove();
						var obload=$(obj).parent('form').parent('div').parent('div').parent('div');
						$(obload).load('<?=base_url()?>akademik/comment/index/'+$(obj).next('input').next('input').val()+'/first/'+$(obj).next('input').val());
					});
					
					//reset input value
					//$('.comment').load('<?=base_url()?>akademik/comment/index/'+$('input#idcommentar').val());
				}else{
					$(".error-box").delay(1000).html(returnData.message);
					$(".error-box").delay(1000).fadeOut("slow",function(){
						$(this).remove();
						
					});
					
				}
			}
		});
		
		return false;
}


function formatCurrency(num) {
	var str=num;
	var duaakhir=str.substring(str.length-2,str.length);
	var depan=str.substring(0,str.length-2);

	return depan+'.'+duaakhir;

	
}

function formatCurrency2(num) {
	num = num.toString().replace(/\$|\,/g, '');
	if (isNaN(num)) num = "0";
	sign = (num == (num = Math.abs(num)));
	num = Math.floor(num * 100 + 0.50000000001);
	cents = num % 100;
	num = Math.floor(num / 100).toString();
	if (cents < 10) cents = "0" + cents;
	for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
	num = num.substring(0, num.length - (4 * i + 3)) + ',' + num.substring(num.length - (4 * i + 3));
	return (((sign) ? '' : '-') + '' + num + '.' + cents);
}

				function readURL(input) {
					var id=$(input).attr('id');
					
				   var reader = new FileReader();
							reader.readAsDataURL(input.files[0]);
							reader.onload = function (e) {
								$('div.'+$(input).attr('id')).html('');
								$('div.'+$(input).attr('id')).html('<img id="img'+$(input).attr('id')+'" src="'+e.target.result+'" alt="your image" />');
							}	
				}

</script>			