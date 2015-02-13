<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Artikel extends MY_Controller {
	function __construct() {
        	parent::__construct();
			$this->load->model("artikel_model", "martikel");
        }

    function indeks(){
    	$data['artikel'] = $this->martikel->get_all_artikel();
		$data['page_title'] = 'StudentBooks';
		$this->load->view('layout/homepage/artikel_indeks',$data);
    }   

	function view($id_artikel = null){
		$artikel 			= $this->martikel->get_artikel_by_id($id_artikel);	
		$data['artikel'] 	= $artikel;
		$id_kategori 		= $artikel->id_kategori;
		$data['art_kat'] 	= $this->martikel->get_artikel_by_idkat($id_kategori);
		
		$data['page_title'] = 'StudentBooks';
		$this->load->view('layout/homepage/artikel',$data); 
	}
}