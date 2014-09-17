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

function ajaxuploadnew(url,responseId,imagelist,fileId) {
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
 		//document.getElementById(responseId).innerHTML = "<div id='uploading'>Uploading...</div>"
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

		/*if (formdata) {
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
		}*/
		return formdata;
}

function filesize(IdFile,max,maxjml){
	$('#'+IdFile).bind('change', function() {
		var totsize=0;
		var maxMB=parseInt(max)/1000000;
		$.each(this.files, function( index, value ){
			//alert( index + ": " + value.size );
			totsize=totsize+parseInt(value.size);
		});
		
		if(this.files.length>maxjml){
			alert('Maximal jumlah file untuk di upload  '+maxjml+' File. Pilih kembali file dengan jumlah yang lebih sedikit dari '+maxjml+'');
			$(this).val("");
			return false;
		}
		if(totsize>max){
			alert('Ukuran file terlalu besar, Maximal jumlah ukuran file '+maxMB+'MB. Pilih kembali file dengan jumlah ukuran yang lebih kecil dari '+maxMB+'MB');
			$(this).val("");
			return false;
		}
		//alert(this.files[0].size);
	});
}