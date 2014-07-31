<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Ak_file {
    function upload($dir='upload/akademik/',$tableTosave,$datasave,$filesname='file',$key) {
        if(move_uploaded_file( $_FILES[$filesname]["tmp_name"][$key], $dir . $name)){
			return true;
		}else{
			return false;
		}
    }
	function send_download($dir,$filename){
		$file_path = $dir.$filename;
		$file_size=@filesize($file_path);
		header("Content-Type: application/x-zip-compressed");
		header("Content-disposition: attachment; filename=$filename");
		header("Content-Length: $file_size");
		readfile($file_path);
		exit;
	} 
}

