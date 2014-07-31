function ajaxupload(url,responseId,imagelist,fileId) {
	var input = document.getElementById(fileId), formdata = false;

	/*	function showUploadedItem (source) {
  		var list = document.getElementById(imagelist),
	  		li   = document.createElement("li"),
	  		img  = document.createElement("img");
  		img.src = source;
  		li.appendChild(img);
		list.appendChild(li);
	}   */

	if (window.FormData) {
  		formdata = new FormData();

	}
 		document.getElementById(responseId).innerHTML = "<div id='uploading'>Uploading...</div>"
 		var i = 0, len = input.files.length, img, reader, file;
	
		for ( ; i < len; i++ ) {
			file = input.files[i];
	
			//if (!!file.type.match(/image.*/)) {
				if ( window.FileReader ) {
					reader = new FileReader();
					reader.onloadend = function (e) { 
						//showUploadedItem(e.target.result, file.fileName);
					};
					reader.readAsDataURL(file);
				}
				if (formdata) {
					formdata.append("file[]", file);
				}
			//}	
		}

		if (formdata) {
			$.ajax({
				url: url,
				type: "POST",
				data: formdata,
				processData: false,
				contentType: false,
				success: function (res) {
					$('#uploading').remove();
					$('#'+responseId).append(res);
				}
			});
		}

}
