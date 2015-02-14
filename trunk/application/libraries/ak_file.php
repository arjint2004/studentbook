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
		redirect(base_url($dir.$filename));
		/*$file_path = $dir.$filename;
		$file_size=@filesize($file_path);
		header("Content-Type: application/x-zip-compressed");
		header("Content-disposition: attachment; filename=$filename");
		header("Content-Length: $file_size");
		readfile($file_path);*/
		exit;
	} 
	function dirToArray($dir) {
	  
	   $result = array();

	   $cdir = @scandir($dir);
	   if(!empty($cdir)){
	   foreach ($cdir as $key => $value)
	   {
		  if (!in_array($value,array(".","..")))
		  {
			 if (is_dir($dir . DIRECTORY_SEPARATOR . $value))
			 {
				$result[$value] = $this->dirToArray($dir . DIRECTORY_SEPARATOR . $value);
			 }
			 else
			 {
				$result[] = $value;
			 }
		  }
	   }
	   }
	  
	   return $result;
	} 
}

