<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class penghubungortutk extends CI_Controller
    {
		public function __construct()
        {
            parent::__construct();
            $this->load->library('session');
            $this->load->library('auth');
            $this->auth->user_logged_in();
        }
		
        public function index()
        {		
		
		}
		
        public function addcontent()
        {
			if(isset($_POST['semester'])){
				$semester=$_POST['semester'];
			}else{
				$semester=$this->session->userdata['ak_setting']['semester'];
			}
			//echo $semester;
			$this->load->model('ad_penghubungortutk');
			if(isset($_POST['program'])){
			$content=$this->ad_penghubungortutk->getdataByIdSekolah($this->session->userdata['user_authentication']['id_sekolah'],'perkembangan_tk',$semester);
				if(empty($content)){
					$datain=array( 'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
								   'content'=>serialize($_POST['program']),
								   'semester'=>$semester,
								   'type'=>'perkembangan_tk'
								);
					$this->db->insert('ak_penghubung_tk_cont',$datain);
				}else{
					$datain=array( 'content'=>serialize($_POST['program']),
								   'type'=>'perkembangan_tk'
								   );
					$this->db->where('id',$content[0]['id']);				
					$this->db->update('ak_penghubung_tk_cont',$datain);
				}
			}
			//echo $this->db->last_query();
			$content=$this->ad_penghubungortutk->getdataByIdSekolah($this->session->userdata['user_authentication']['id_sekolah'],'perkembangan_tk',$semester);
			$content[0]['contarr']=unserialize($content[0]['content']);
			//pr($content);
			$data['semester']=$this->db->query("SELECT * FROM ak_semester WHERE id_sekolah=".$this->session->userdata['user_authentication']['id_sekolah']."")->result_array();
			
			$data['semester_id']=$semester;
			$data['content']=$content;
			$data['action']="admin/penghubungortutk/addcontent";
			$data['titlefield']='PROGRAM PENGEMBANGAN';
			$data['titlefield2']='Aspek Penilaian';
            $data['main']= 'schooladmin/penghubungortutk/addcontent';
            $this->load->view('layout/ad_adminsekolah',$data);
		}
        public function addcontentmenu()
        {
			$this->load->model('ad_penghubungortutk');
			if(isset($_POST['program'])){
			$content=$this->ad_penghubungortutk->getdataByIdSekolah($this->session->userdata['user_authentication']['id_sekolah'],'menu_makan');
				if(empty($content)){
					$datain=array( 'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
								   'content'=>serialize($_POST['program']),
								   'type'=>'menu_makan'
								  
								);
					$this->db->insert('ak_penghubung_tk_cont',$datain);
				}else{
					$datain=array( 'content'=>serialize($_POST['program']),
								   'type'=>'menu_makan'
								   );
					$this->db->where('id',$content[0]['id']);				
					$this->db->update('ak_penghubung_tk_cont',$datain);
				}
			}
			//echo $this->db->last_query();
			$content=$this->ad_penghubungortutk->getdataByIdSekolah($this->session->userdata['user_authentication']['id_sekolah'],'menu_makan');
			$content[0]['contarr']=unserialize($content[0]['content']);
			//pr($content);
			$data['content']=$content;
            $data['main']= 'schooladmin/penghubungortutk/addcontentmenu';
            $this->load->view('layout/ad_adminsekolah',$data);
		}
        public function addcontenttpa()
        {
			if(isset($_POST['semester'])){
				$semester=$_POST['semester'];
			}else{
				$semester=$this->session->userdata['ak_setting']['semester'];
			}
			$this->load->model('ad_penghubungortutk');
			if(isset($_POST['program'])){
			$content=$this->ad_penghubungortutk->getdataByIdSekolah($this->session->userdata['user_authentication']['id_sekolah'],'perkembangan_tpa',$semester);
				if(empty($content)){
					$datain=array( 'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
								   'content'=>serialize($_POST['program']),
								   'type'=>'perkembangan_tpa'
								  
								);
					$this->db->insert('ak_penghubung_tk_cont',$datain);
				}else{
					$datain=array( 'content'=>serialize($_POST['program']),
								   'type'=>'perkembangan_tpa'
								   );
					$this->db->where('id',$content[0]['id']);				
					$this->db->update('ak_penghubung_tk_cont',$datain);
				}
			}
			//echo $this->db->last_query();
			$content=$this->ad_penghubungortutk->getdataByIdSekolah($this->session->userdata['user_authentication']['id_sekolah'],'perkembangan_tpa',$semester);
			$content[0]['contarr']=unserialize($content[0]['content']);
			//pr($content);
			$data['content']=$content;
			$data['action']="admin/penghubungortutk/addcontenttpa";
            $data['main']= 'schooladmin/penghubungortutk/addcontent';
            $this->load->view('layout/ad_adminsekolah',$data);
		}
		
    }
?>