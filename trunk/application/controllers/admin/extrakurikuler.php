<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Extrakurikuler extends CI_Controller {
	 function __construct()
	 {
		parent::__construct();
		$this->load->library('auth');
		$this->auth->logged_in();
		$this->load->model('ad_extrakurikuler');
	 }
	function getpegawaiSelect($id_pegawai=null,$id_extrakurikuler){
		$guru =$this->ad_extrakurikuler->getGuru();
		$select ="";
		$select .="<select onblur='update(this)' class='jurusanaddkelas nopadmar' onchange='update(this)'  field='id_pegawai'  idjur='".$id_extrakurikuler."' name='id_pegawai'>";
		foreach($guru as $dataguru){
			if($dataguru['id']==$id_pegawai){$sel='selected';}else{$sel='';}
			$select .="<option ".$sel." value='".$dataguru['id']."'>".$dataguru['nama']."</option>";
		}
		$select .="</select>";
		
		echo $select;
	}
	function index(){
		$data['main'] 	= 'schooladmin/extrakurikuler/index';
		$data['page_title'] 	= 'Data extrakurikuler';
		$this->load->view('layout/ad_adminsekolah',$data);	 
	}
	   
    public function aktifasiExtrakurikuler()
    {
		if($_POST['aktif']==1){
			$this->db->query('UPDATE ak_extrakurikuler SET aktif=0 WHERE id='.$_POST['id'].'');		
			//$this->db->query('UPDATE ak_extrakurikuler SET aktif=1 WHERE id!='.$_POST['id'].'');		
		}
		if($_POST['aktif']==0){
			$this->db->query('UPDATE ak_extrakurikuler SET aktif=1 WHERE id='.$_POST['id'].'');		
			//$this->db->query('UPDATE ak_extrakurikuler SET aktif=0 WHERE id!='.$_POST['id'].'');		
		}
		
	}
	function adddata(){
		if(isset($_POST['addextrakurikuler'])){
			$simpan['id_sekolah']=$this->session->userdata['user_authentication']['id_sekolah'];
			$simpan['nama']=$_POST['nama'];
			$simpan['id_pegawai']=$_POST['id_pegawai'];
			$simpan['aktif']=$_POST['aktif'];
			$this->db->insert('ak_extrakurikuler',$simpan);
		}
		
		$data['guru'] =$this->ad_extrakurikuler->getGuru();
		
		$data['main'] 	= 'schooladmin/extrakurikuler/addData';
		$data['page_title'] 	= 'Tambah extrakurikuler';
		$this->load->view('layout/ad_blank',$data);
	}
	function listData(){
		$data['page_title'] 	= 'Data extrakurikuler';
		 if(isset($_POST['simpleupdate'])){
			$dataupdate=$_POST;
			$dataupdate['id']=$_POST['id_extrakurikuler'];
			unset($dataupdate['id_extrakurikuler']);
			unset($dataupdate['ajax']);
			unset($dataupdate['simpleupdate']);
			$this->db->where('id', $_POST['id_extrakurikuler']);
			$this->db->update('ak_extrakurikuler', $dataupdate);
		 }
		$data['extrakurikuler']=$this->ad_extrakurikuler->getdata($this->session->userdata['user_authentication']['id_sekolah']);
		 if ($this->input->post('ajax')) {
		   $data['main'] 	= 'schooladmin/extrakurikuler/listData'; // memilih view
		   $this->load->view('layout/ad_blank',$data); // memilih layout
		} else {
		   $data['main'] 	= 'schooladmin/extrakurikuler/listData';// memilih view
		   $this->load->view('layout/ad_adminsekolah',$data);
		} 
	}
	function daftar(){
		$data['page_title'] 	= 'Daftar extrakurikuler';
		$this->load->model('ad_akun');
		$this->load->model('ad_kelas');
		$this->load->model('ad_extrakurikuler');
		
		 if(isset($_POST['simpan'])){
		 if($_POST['isdel']==1){
			$this->db->query('DELETE FROM ak_siswa_ekstrakurikuler WHERE id_siswa_det_jenjang='.$_POST['id_siswa_det_jenjang'].' AND id_ekstrakurikuler='.$_POST['id_extrakurikuler'].'');
			$datainsert=array( 	 	 	 	 	 	 
								'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
								'id_siswa_det_jenjang'=>$_POST['id_siswa_det_jenjang'],
								'id_ekstrakurikuler'=>$_POST['id_extrakurikuler'],
								'id_semester'=>$this->session->userdata['ak_setting']['semester'],
								'ta'=>$this->session->userdata['ak_setting']['ta'],
								'aktif'=>1,
			);
			//pr($datainsert);
			$this->db->insert('ak_siswa_ekstrakurikuler', $datainsert);		 
		 }elseif($_POST['isdel']==0){
			$this->db->query('DELETE FROM ak_siswa_ekstrakurikuler WHERE id_siswa_det_jenjang='.$_POST['id_siswa_det_jenjang'].' AND id_ekstrakurikuler='.$_POST['id_extrakurikuler'].'');
		 }

		 }
		 
			$data['datasiswa']=array();
			
			if(isset($_POST['id_kelas'])){
				$cond="AND ak_det_jenjang.id_kelas=".$_POST['id_kelas']."";
				$data['kelasselected']=$_POST['id_kelas'];
				$data['extraselected']=$_POST['id_extrakurikuler'];
				$datasiswa=$this->ad_akun->getdataSiswaOrtu('0,150',12,$cond);
				$qcurrentextra=$this->ad_extrakurikuler->getdataSiswaExtra();
				$datajump=array();
				$data['datajumpcur']=array();
				foreach( $datasiswa as $datafor){
					$data['datasiswa'][$datafor['id_siswa_det_jenjang']]=$datafor;
				}
				foreach($qcurrentextra as $datacurfor){
					$data['datajumpcur'][$datacurfor['id_siswa_det_jenjang']]=$datacurfor;
				}
				//pr($datajumpcur);
				
			}else{
				$cond="";
				
			}

			
			$data['kelas']=$this->ad_kelas->getkelas($this->session->userdata['user_authentication']['id_sekolah']);
			$data['extra']=$this->ad_extrakurikuler->getData();
		
		if ($this->input->post('ajax')) {
		   $data['main'] 	= 'schooladmin/extrakurikuler/daftar'; // memilih view
		   $this->load->view('layout/ad_blank',$data); // memilih layout
		} else {
		   $data['main'] 	= 'schooladmin/extrakurikuler/daftar';// memilih view
		   $this->load->view('layout/ad_adminsekolah',$data);
		} 
	}
	function delete($id_ekstrakurikuler=null)
	 {
		$freeekstra=$this->ad_extrakurikuler->getFreeEkstrakurikuler($id_ekstrakurikuler,$this->session->userdata['user_authentication']['id_sekolah']);
		if($freeekstra==0){
			$this->db->query('DELETE FROM ak_extrakurikuler WHERE id='.$id_ekstrakurikuler.'');
		}
		echo $freeekstra;
		//return $freeekstra;
	 }
}
?>