<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Controllers extends CI_Controller {

    function __construct()
    {
        parent::__construct();
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
	
	function index(){
		$dirControllers=array('/','admin/','akademik/');
		foreach($dirControllers as $dirc){
			$controller[$dirc]=$this->getControllersAndmethod($dirc);
		}
		pr($controller);
	}
}
/* End of file controllers.php */
/* Location: ./application/controllers/controllers.php */