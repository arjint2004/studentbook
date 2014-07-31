<?php
class MY_Controller extends CI_Controller {
 
	private $content_areas;
	var $theme='default';
	function __construct(){
		parent::__construct();
		
	}
	
	function set_layout(){
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
					return 'superadmin';
				break;
				case "admin sekolah":
					return 'adminsekolah';
				break;
				case "siswa":
					return 'detail';
				break;
				case "guru":
					return 'detail';
				break;
				case "ortu":
					return 'detail';
				break;
				default:
					return 'default';
				break;
			}
	   }
	   else
	   {
		 //If no session, redirect to login page
		 //redirect('homepage', 'refresh');
		 return 'default'; // render the page with the layout and the content
	   }
	}

	function set_theme($theme='default'){
		$this->theme=$theme;
	}
	function add_view($content_area, $view, $data = array()){
		if($content_area!='page_title'){
			$this->add_content("page_title", 'Studentbook'); // pass in the standard text content
		}
		
		$this->add_content($content_area, $this->load->view($this->theme."/".$view, $data, TRUE));
	}
 
	function add_content($content_area, $content){
		$this->content_areas[$content_area] = $content;
	}
 

	function render($layout ="default"){
		
		if($layout !="blank"){
		$layout=$this->set_layout();
		$this->load->view($this->theme.'/layouts/header', $this->content_areas);
		$this->load->view($this->theme.'/layouts/'.$layout, $this->content_areas);
		$this->load->view($this->theme.'/layouts/footer', $this->content_areas);		
		}else{
		$this->load->view($this->theme.'/layouts/blank', $this->content_areas);
		}
	}
 
}
?>