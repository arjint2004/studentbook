<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Application Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/general/controllers.html
 */
class CI_Controller {

	private static $instance;
	/**
	 * Constructor
	 */
	public function __construct()
	{
		error_reporting(0); 
        ini_set('display_errors', 0);
		self::$instance =& $this;
		
		// Assign all the class objects that were instantiated by the
		// bootstrap file (CodeIgniter.php) to local class variables
		// so that CI can run as one big super object.
		foreach (is_loaded() as $var => $class)
		{
			$this->$var =& load_class($class);
		}

		$this->load =& load_class('Loader', 'core');

		$this->load->initialize();
		
		log_message('debug', "Controller Class Initialized");
		//$this->output->enable_profiler(TRUE);
	}

	public static function &get_instance()
	{
		return self::$instance;
	}
	
	
	function set_layout(){print_r($this->session->userdata('logged_in'));
	   if($this->session->userdata('logged_in'))
	   {
		 //$session_data = $this->session->userdata('logged_in');
		 //$data['username'] = $session_data['username'];
		 // $this->load->view('home_view', $data);
		 //$this->add_view("main", "homepage", $data); // put the "homepage" view in the "main" content area, passing in the $data array if wanted
		 //$this->add_content("username", $session_data['username']); // pass in the standard text content
		 $result=$this->session->userdata('logged_in');
		 
			 switch($result['otoritas']){
				case "superadmin":
					return 'ad_superadmin';
				break;
				case "admin sekolah":
					return 'ad_adminsekolah';
				break;
				case "siswa":
					return 'ad_detail';
				break;
				case "guru":
					return 'ad_detail';
				break;
				case "ortu":
					return 'ad_detail';
				break;
				default:
					return 'ad_default';
				break;
			}
	   }
	   else
	   {
		 //If no session, redirect to login page
		 //redirect('homepage', 'refresh');
		 return 'ad_default'; // render the page with the layout and the content
	   }
	}


	function add_view($content_area, $view, $data = array()){
		if($content_area!='page_title'){
			$this->add_content("page_title", 'Studentbook'); // pass in the standard text content
		}
		
		$this->add_content($content_area, $this->load->view($view, $data, TRUE));
	}
 
	function add_content($content_area, $content){
		$this->content_areas[$content_area] = $content;
	}
 

	function render($layout ="ad_default"){
		
		if($layout !="blank"){
		$layout=$this->set_layout();
		$this->load->view('layout/header', $this->content_areas);
		$this->load->view('layout/'.$layout, $this->content_areas);
		//$this->load->view('layout/footer', $this->content_areas);		
		}else{
		//$this->load->view('layout/blank', $this->content_areas);
		}
	}
}
// END Controller class

/* End of file Controller.php */
/* Location: ./system/core/Controller.php */