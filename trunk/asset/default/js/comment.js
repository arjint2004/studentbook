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
			$(".replyedit"+id).load(site_url+"ticker/historydeltreply/"+id);
			$("#replyshow"+id).remove();
		}
		if(jenis=="post"){
			$("#textpost"+id).load(site_url+"ticker/historydelpost/"+id);
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
		$(".replyedit"+id).html('<form id="editreply'+id+'"><textarea rows="5" onblur="hidetextarea(this,'+id+');" post="'+id+'" onkeypress="return editreply(event,this);" name="historyreply" class="editreply" id="historyreplyedit'+id+'"></textarea></form>');
		//$("#historyreplyedit"+id).focus();
		$("#historyreplyedit"+id).focus().val(vall);	
	}
	if(jenis=="post"){
		var vall=$(".postedit"+id).html();
		$(".postedit"+id).html('<form id="editpost'+id+'"><textarea rows="5" onblur="hidetextareapost(this,'+id+');" post="'+id+'" name="historypost" onkeypress="return editpost(event,this);"  class="postreply" id="historypostedit'+id+'"></textarea></form>');
		//$("#historyreplyedit"+id).focus();
		$("#historypostedit"+id).focus().val(vall);
	}
}

function editpost(e,object){
		var id=$(object).attr('post');
		
		if (!e) e = window.event;   // resolve event instance
		if (e.keyCode == '13' && e.shiftKey){
		 
		}else if(e.keyCode == 13){
		$(object).blur();
			submiteditpost(id);
			//$('.replyedit'+id).load(site_url+"ticker/historyeditreply/"+id+"/"+$(object).val());
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
			//$('.replyedit'+id).load(site_url+"ticker/historyeditreply/"+id+"/"+$(object).val());
			return false;
		}

}

$("textarea#historyreply").live("keypress",function(event){
	  
	  if (event.keyCode == 13 && event.shiftKey) {

      }else if(event.keyCode == 13)
      {
		  $(this).blur();
          submitreply($(this).attr('post'),$(this).val());
		  return false;
      }
});
$("textarea#history").live("keypress",function(event){
	  
       if (event.keyCode == 13 && event.shiftKey) {

      }else if(event.keyCode == 13)
      {
			$(this).blur();
          submit();
		  return false;
      }

});

$("div.post input[type='submit']").live("click",function(){
$(this).attr('disabled','disabled');
submit();
return false;
});
function submiteditpost(idhistorypost){
		var formData = $("#editpost"+idhistorypost).serialize();
		$(".content-box").append("<div class=\"error-box\"></div>");
		$(".error-box").html("Sending Data").fadeIn("slow");
		//alert("myObject is " + formData.toSource());
		$.ajax({
			url		: site_url+"ticker/historyeditpost/"+idhistorypost,
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
						//$('.history').load(site_url+'index.php/ticker/history/'+idhistory);	
					//reset input value
					$('.history').load(site_url+'index.php/ticker/history/'+idhistory);
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
function submiteditreply(idhistoryreply){
		var formData = $("#editreply"+idhistoryreply).serialize();
		$(".content-box").append("<div class=\"error-box\"></div>");
		$(".error-box").html("Sending Data").fadeIn("slow");
		//alert("myObject is " + formData.toSource());
		$.ajax({
			url		: site_url+"ticker/historyeditreply/"+idhistoryreply,
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
						//$('.history').load(site_url+'index.php/ticker/history/'+idhistory);	
					//reset input value
					$('.history').load(site_url+'index.php/ticker/history/'+idhistory);
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
function submitreply(idhistoryreply,postreply){
		var formData = $("#reply"+idhistoryreply).serialize();
		$(".content-box").append("<div class=\"error-box\"></div>");
		$(".error-box").html("Sending Data").fadeIn("slow");
		//alert("myObject is " + formData.toSource());
		$.ajax({
			url		: site_url+"ticker/historysendreply/"+idhistoryreply,
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
						//$('.history').load(site_url+'index.php/ticker/history/'+idhistory);	
					//reset input value
					$('.history').load(site_url+'index.php/ticker/history/'+idhistory);
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
function submit(){
		
		var formData = $("#history").serialize();
		$(".content-box").append("<div class=\"error-box\"></div>");
		$(".error-box").html("Sending Data").fadeIn("slow");
		//alert("myObject is " + formData.toSource());
		$.ajax({
			url		: site_url+"ticker/historysend/"+idhistory,
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
						$(this).delay(500).fadeIn("slow");
						$(this).delay(3000).fadeOut("slow",function(){
							// Experimental Area //
							//autoReturn(submitName);
						});

					});*/
					
					$(".error-box").delay(1000).fadeOut("slow",function(){
						
						$(this).remove();
						$('.history').load(site_url+'index.php/ticker/history/'+idhistory);	
					});
					
					//reset input value
					//$('.history').load(site_url+'index.php/ticker/history/'+idhistory);
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
				
				
				
				
				
//auto phone number
var zChar = new Array(' ', '(', ')', '-', '.');
var maxphonelength = 13;
var phonevalue1;
var phonevalue2;
var cursorposition;

function ParseForNumber1(object){
phonevalue1 = ParseChar(object.value, zChar);
}
function ParseForNumber2(object){
phonevalue2 = ParseChar(object.value, zChar);
}

function backspacerUP(object,e) {
if(e){
e = e
} else {
e = window.event
}
if(e.which){
var keycode = e.which
} else {
var keycode = e.keyCode
}

ParseForNumber1(object)

if(keycode >= 48){
ValidatePhone(object)
}
}

function backspacerDOWN(object,e) {
if(e){
e = e
} else {
e = window.event
}
if(e.which){
var keycode = e.which
} else {
var keycode = e.keyCode
}
ParseForNumber2(object)
}

function GetCursorPosition(){

var t1 = phonevalue1;
var t2 = phonevalue2;
var bool = false
for (i=0; i<t1.length; i++)
{
if (t1.substring(i,1) != t2.substring(i,1)) {
if(!bool) {
cursorposition=i
bool=true
}
}
}
}

function ValidatePhone(object){

var p = phonevalue1

p = p.replace(/[^\d]*/gi,"")

if (p.length < 3) {
object.value=p
} else if(p.length==3){
pp=p;
d4=p.indexOf('(')
d5=p.indexOf(')')
if(d4==-1){
pp="("+pp;
}
if(d5==-1){
pp=pp+")";
}
object.value = pp;
} else if(p.length>3 && p.length < 7){
p ="(" + p;
l30=p.length;
p30=p.substring(0,4);
p30=p30+")"

p31=p.substring(4,l30);
pp=p30+p31;

object.value = pp;

} else if(p.length >= 7){
p ="(" + p;
l30=p.length;
p30=p.substring(0,4);
p30=p30+")"

p31=p.substring(4,l30);
pp=p30+p31;

l40 = pp.length;
p40 = pp.substring(0,8);
p40 = p40 + "-"

p41 = pp.substring(8,l40);
ppp = p40 + p41;

object.value = ppp.substring(0, maxphonelength);
}

GetCursorPosition()

if(cursorposition >= 0){
if (cursorposition == 0) {
cursorposition = 2
} else if (cursorposition <= 2) {
cursorposition = cursorposition + 1
} else if (cursorposition <= 5) {
cursorposition = cursorposition + 2
} else if (cursorposition == 6) {
cursorposition = cursorposition + 2
} else if (cursorposition == 7) {
cursorposition = cursorposition + 4
e1=object.value.indexOf(')')
e2=object.value.indexOf('-')
if (e1>-1 && e2>-1){
if (e2-e1 == 4) {
cursorposition = cursorposition - 1
}
}
} else if (cursorposition < 11) {
cursorposition = cursorposition + 3
} else if (cursorposition == 11) {
cursorposition = cursorposition + 1
} else if (cursorposition >= 12) {
cursorposition = cursorposition
}

var txtRange = object.createTextRange();
txtRange.moveStart( "character", cursorposition);
txtRange.moveEnd( "character", cursorposition - object.value.length);
txtRange.select();
}

}

function ParseChar(sStr, sChar)
{
if (sChar.length == null)
{
zChar = new Array(sChar);
}
else zChar = sChar;

for (i=0; i<zChar.length; i++)
{
sNewStr = "";

var iStart = 0;
var iEnd = sStr.indexOf(sChar[i]);

while (iEnd != -1)
{
sNewStr += sStr.substring(iStart, iEnd);
iStart = iEnd + 1;
iEnd = sStr.indexOf(sChar[i], iStart);
}
sNewStr += sStr.substring(sStr.lastIndexOf(sChar[i]) + 1, sStr.length);

sStr = sNewStr;
}

return sNewStr;
}
				