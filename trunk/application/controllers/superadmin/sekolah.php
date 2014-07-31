<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sekolah extends CI_Controller {
	 function __construct()
	 {
		  parent::__construct();
		  $this->load->library('auth');
		  $this->auth->logged_in();
	 }
	 
	public function index($start=0,$page=0) {
		$this->load->model('ad_sekolah');
		$this->load->model('ad_jenjang');
		$data['provinsi']   = $this->ad_sekolah->get_provinsi();		
		$data['jenjang']   = $this->ad_jenjang->getjenjang();		
		$data['url']   = base_url().'superadmin/sekolah/sekolahlist';		
		
		$data['page_title']   = 'DATA SEKOLAH';	
		$data['page_sub_title']   = 'PENGATURAN SEKOLAH';
		if ($this->input->post('ajax')) {
		   $data['main']	= 'superadmin/sekolah/index'; // memilih view
		   $this->load->view('layout/ad_blank',$data); // memilih layout
		} else {
		   $data['main']	= 'superadmin/sekolah/index'; // memilih view
		   $this->load->view('layout/ad_adminsekolah',$data);
		}
					
	}
	public function aktifasi() {
		$this->load->model('ad_akun');
		if($_POST['aktif']==1){
			$this->ad_akun->disableakun($_POST['id_user']);
			echo 0;
		}elseif($_POST['aktif']==0){
			$this->ad_akun->enableakun($_POST['id_user']);
			echo 1;
		}
	}
	public function aktifasifitur($id_sekolah=0,$fitur='') {
		$this->load->model('ad_sekolah');
		$fiturs=$this->ad_sekolah->getfiturbyname($id_sekolah,$fitur);
		if(empty($fiturs)){
			//insert
			//echo 'insert';
			$ins=array(
						'id_sekolah'=>$id_sekolah,
						'fitur'=>$fitur,
						'aktif'=>1
			);
			$this->db->insert('ak_fitur_sekolah',$ins);
			echo 1;
		}else{
			//update
			//echo 'update';
			if($_POST['aktif']==1){$cnd=0;}else{$cnd=1;}
			$ins=array(
						'aktif'=>$cnd
			);
			$this->db->where(array('id_sekolah'=>$id_sekolah,'fitur'=>$fitur));
			$this->db->update('ak_fitur_sekolah',$ins);
			echo $cnd;
		}
	}
	public function setsms($id_sekolah=0) {
		$this->load->model('ad_sekolah');
		
		$field=array('ask.id','ask.nama_sekolah','u.aktif','ask.sendername','ask.aktifasisendername','ask.jml_pulsa');
		$data['sekolah']=$this->ad_sekolah->getSekolahdataandUser($id_sekolah,$field);
		$data['aktifasisms_notifikasi']=$this->ad_sekolah->getfiturbyname($id_sekolah,'sms_notifikasi');
		$data['aktifasisms_blasting']=$this->ad_sekolah->getfiturbyname($id_sekolah,'sms_blasting');
		//pr($data['aktifasisms_blasting']);
		if ($this->input->post('ajax')) {
		   $data['main']	= 'superadmin/sekolah/setsms'; // memilih view
		   $this->load->view('layout/ad_blank',$data); // memilih layout
		} else {
		   $data['main']	= 'superadmin/sekolah/setsms'; // memilih view
		   $this->load->view('layout/ad_adminsekolah',$data);
		}			
	}
	public function setfitur($id_sekolah=0) {
		$this->load->model('ad_sekolah');
		
		if(isset($_POST['id_sekolah'])){
			$data['id_sekolah']=$_POST['id_sekolah'];
		}else{
			$data['id_sekolah']=$id_sekolah;
		}
		//$fiels=array('ask.id','ask.nama_sekolah','u.aktif');
		//$sekolah=$this->ad_sekolah->getSekolahdataandUser($id_sekolah,$field);
		$data['fitur']=$this->ad_sekolah->getFitur($id_sekolah);
		//pr($data['fitur']);
		if ($this->input->post('ajax')) {
		   $data['main']	= 'superadmin/sekolah/setfitur'; // memilih view
		   $this->load->view('layout/ad_blank',$data); // memilih layout
		} else {
		   $data['main']	= 'superadmin/sekolah/setfitur'; // memilih view
		   $this->load->view('layout/ad_adminsekolah',$data);
		}	
	}
	public function sekolahlist($start=0,$page=0) {
		//if($page==null || $page==0){$page=1;}
		$this->load->model('ad_sekolah');
		$this->load->helper('url');
		$this->load->library('pagination');

		$config['base_url']   = site_url('superadmin/sekolah/sekolahlist');
		
		$config['per_page']   = 25;
		//$config['uri_segment']   = 5;
		$config['cur_page']   = $start;
		$data['start'] = $start;
		$this->load->model('ad_kelas');
		//pr($_POST);
		$cond="";
			//$cond=1;
			if(isset($_POST['propinsi']) && $_POST['propinsi']!=0){
				$cond =" AND ak_sekolah.prop=".$_POST['propinsi']."";
			}
			if(isset($_POST['kabupaten']) && $_POST['kabupaten']!=0){
				$cond .=" AND ak_sekolah.kec=".$_POST['kabupaten']."";
			}
			if(isset($_POST['jenjang']) && $_POST['jenjang']!=0){
				if(isset($_POST['propinsi']) && $_POST['propinsi']==0){
					$cond .=" AND ak_sekolah.id_jenjang=".$_POST['jenjang']."";
				}else{
					$cond .=" AND ak_sekolah.id_jenjang=".$_POST['jenjang']."";
				}
			}
			//echo $cond;
			$data['datasekolah']==array();
			if(isset($_POST)){
				$data['datasekolah']=$this->ad_sekolah->getdataSekolah(''.$start.','.$config['per_page'].'',$cond);
			}
			//pr($data['datasekolah']);
			$config['total_rows'] = $this->ad_sekolah->getsekolahcountall($cond);
			

		
		
		//pr($config);
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();

		if ($this->input->post('ajax')) {
		   $data['main']	= 'superadmin/sekolah/sekolahlist'; // memilih view
		   $this->load->view('layout/ad_blank',$data); // memilih layout
		} else {
		   $data['main']	= 'superadmin/sekolah/sekolahlist'; // memilih view
		   $this->load->view('layout/ad_adminsekolah',$data);
		}
		  
	}	
	public function smssender($start=0,$page=0) {
		$this->load->model('ad_sekolah');
		$this->load->model('ad_jenjang');
		$data['provinsi']   = $this->ad_sekolah->get_provinsi();		
		$data['jenjang']   = $this->ad_jenjang->getjenjang();		
		$data['page_title']   = 'SMS';		
		$data['page_sub_title']   = 'PENGATURAN SMS UNTUK SEKOLAH';
		$data['url']   = base_url().'superadmin/sekolah/smssenderlist';		
		
		if ($this->input->post('ajax')) {
		   $data['main']	= 'superadmin/sekolah/index'; // memilih view
		   $this->load->view('layout/ad_blank',$data); // memilih layout
		} else {
		   $data['main']	= 'superadmin/sekolah/index'; // memilih view
		   $this->load->view('layout/ad_adminsekolah',$data);
		}
	}
	public function aktifasisendername() {
		if($_POST['aktif']==1){
			$this->db->query("UPDATE ak_sekolah SET aktifasisendername=0 WHERE id=".$_POST['id_sekolah']."");
			echo 0;
		}elseif($_POST['aktif']==0){
			$this->db->query("UPDATE ak_sekolah SET aktifasisendername=1 WHERE id=".$_POST['id_sekolah']."");
			echo 1;
		}
		//echo $this->db->last_query();
	}
	public function smssenderlist($start=0,$page=0) {
		//if($page==null || $page==0){$page=1;}
		$this->load->model('ad_sekolah');
		$this->load->helper('url');
		$this->load->library('pagination');

		$config['base_url']   = site_url('superadmin/sekolah/smssenderlist');
		
		$config['per_page']   = 25;
		//$config['uri_segment']   = 5;
		$config['cur_page']   = $start;
		$data['start'] = $start;
		$this->load->model('ad_kelas');
		//pr($_POST);
		$cond="";
			//$cond=1;
			if(isset($_POST['propinsi']) && $_POST['propinsi']!=0){
				$cond =" AND ak_sekolah.prop=".$_POST['propinsi']."";
			}
			if(isset($_POST['kabupaten']) && $_POST['kabupaten']!=0){
				$cond .=" AND ak_sekolah.kec=".$_POST['kabupaten']."";
			}
			if(isset($_POST['jenjang']) && $_POST['jenjang']!=0){
				if(isset($_POST['propinsi']) && $_POST['propinsi']==0){
					$cond .=" AND ak_sekolah.id_jenjang=".$_POST['jenjang']."";
				}else{
					$cond .=" AND ak_sekolah.id_jenjang=".$_POST['jenjang']."";
				}
			}
			
			//echo $cond;
			$data['datasekolah']==array();
			if(isset($_POST)){
				$data['datasekolah']=$this->ad_sekolah->getdataSekolahsms(''.$start.','.$config['per_page'].'',$cond);
			}
			$config['total_rows'] = $this->ad_sekolah->getsekolahcountall($cond);
			

		
		
		//pr($config);
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();

		if ($this->input->post('ajax')) {
		   $data['main']	= 'superadmin/sekolah/smssender'; // memilih view
		   $this->load->view('layout/ad_blank',$data); // memilih layout
		} else {
		   $data['main']	= 'superadmin/sekolah/smssender'; // memilih view
		   $this->load->view('layout/ad_adminsekolah',$data);
		}
		  
	}
	public function topupsms($id_sekolah) {
		$this->load->model('ad_sekolah');
		$field=array('ask.id','ask.jml_pulsa');
		$sekolah=$this->ad_sekolah->getSekolahdataandUser($id_sekolah,$field);
		$data['id_sekolah']=$sekolah[0]['id'];
		if(isset($_POST['topupsmslhoyo'])){
			$jml_pulsa=$sekolah[0]['jml_pulsa']+$_POST['nominal'];
			$insertyopup=array(
							'id_sekolah'=>$_POST['id_sekolah'],
							'kode_voucher'=>"".@$_POST['kode_voucher']."",
							'nominal'=>$_POST['nominal'],
							'tanggal'=>date('Y-m-d H:i:s'),
							'jml_pulsa'=>$jml_pulsa,
							'keterangan'=>$_POST['keterangan'],
			);
			$this->db->insert('ak_pulsa_topup',$insertyopup);
			$this->db->where('id',$_POST['id_sekolah']);
			$this->db->update('ak_sekolah',array('jml_pulsa'=>$jml_pulsa));
			
			echo json_encode($insertyopup);
			die();
		}
		if ($this->input->post('ajax')) {
		   $data['main']	= 'superadmin/sekolah/topupsms'; // memilih view
		   $this->load->view('layout/ad_blank',$data); // memilih layout
		} else {
		   $data['main']	= 'superadmin/sekolah/topupsms'; // memilih view
		   $this->load->view('layout/ad_adminsekolah',$data);
		}	 
	}
	
	public function delete($id_sekolah=0){
		//if(isset()){
		
		//}
		$this->load->model('ad_sekolah');
		$allcols=$this->ad_sekolah->getAllCols();
		//pr($allcols);
		foreach($allcols as $dtcols){
			//echo $dtcols['TABLE_NAME'].'<br />';
			$this->db->query('DELETE FROM '.$dtcols['TABLE_NAME'].' WHERE id_sekolah='.$id_sekolah.'');
		}
		$this->db->query('DELETE FROM ak_sekolah WHERE id='.$id_sekolah.'');
	}
	
	public function makedetgroup(){/*
		$group=array(12,13,14,15);
		foreach($group as $id_group){
		$this->db->query("
				delete from det_group WHERE id_group=".$id_group."
		   ");
		$query=$this->db->query("
				SELECT * FROM users WHERE id_group=".$id_group."
		   ");
		//echo $this->db->last_query();
	    $data= $query->result_array();
		foreach($data as $xdata){
			$detgr=array(
				'id_user'=>$xdata['id'],	
				'id_group'=>$xdata['id_group']
			);
			$this->db->insert('det_group',$detgr);
			
			echo $this->db->last_query()."<br />";
		}
		}*/
	 }
}
?>
