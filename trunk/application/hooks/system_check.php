<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class System_Check 
{
   function checkOtority()
   {
		/*$dirControllers=array('/','admin/','akademik/');
		foreach($dirControllers as $dirc){
			$controller[$dirc]=$this->getControllersAndmethod($dirc);
		}*/
		
		$CI = & get_instance();
		$CI->load->library('session');
		//echo('<pre>');
		//print_r($CI->router->class);
		//print_r($CI->router->method);
		//print_r($CI->session->userdata);
        //echo('</pre>');
		//pr($CI->session->userdata['user_authentication']);
		$url=$CI->router->class."/".$CI->router->method;
		//echo $url."<br>";
		//echo serialize(array('pegawai/index'));die();
		//pr($CI->router);
		if(isset($CI->session->userdata['user_authentication']) && $CI->session->userdata['user_authentication']['otoritas']!=''){
			switch($CI->session->userdata['user_authentication']['otoritas']){
				case 'guru':
					//pr(unserialize($CI->session->userdata['user_authentication']['auth']));
					//echo '<br />'.$url;
					//die();
					
					//if(in_array($url,unserialize($CI->session->userdata['user_authentication']['auth']))){
					
					//}else{
						//redirect('authentication/logout');
					//}
				break;
				
				case 'siswa':
					
				break;
				
				default:
				
				break;
			}
		}
		
   }
   
   
   public function getControllersAndmethod($dirc)
    {
		//$dirc=$dirc.'/';
        $controllers    = array();

        $dir            = APPPATH.'/controllers/'.$dirc;
        $files          = scandir($dir);

        $controller_files = array_filter($files, function($filename) {
            return (substr(strrchr($filename, '.'), 1)=='php') ? true : false;
        });
		//pr($controller_files);
        foreach ($controller_files as $filename)
        { 
            require_once('./application/controllers/'.$dirc.$filename);

            $classname = ucfirst(substr($filename, 0, strrpos($filename, '.')));
			//echo $classname."<br />";
           // if($classname!='Login'){
			$controller = new $classname();
			//pr($controller);
            $methods = get_class_methods($controller);

            foreach ($methods as $method)
            {
                array_push($methods,$method);
            }

            $controller_info = array(
                'filename' => $filename,
                'class_name' => $classname,
                'methods'  => $methods
            );
            array_push($controllers,$controller_info);
			//}
        }
		
		return $controllers;

        //pr($controllers);

    }

}
 
?>