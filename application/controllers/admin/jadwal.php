<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jadwal extends CI_Controller {
    function __construct()
    {
      parent::__construct();
	  $this->load->library('auth');
	  $this->auth->logged_in();
    }
   
    public function index()
    {
		$this->load->model('ad_kelas');
	    $data['kelas'] 	=$this->ad_kelas->getkelas($this->session->userdata['user_authentication']['id_sekolah']);
		$_SESSION['userdata']=$this->session->userdata;
		$_SESSION['session_id']=$this->session->userdata['session_id'];
		//pr($data['kelas']);
		$data['ak_setting'] 	= $this->session->userdata['ak_setting'];
		$data['session_id'] 	= $this->session->userdata['session_id'];
        $data['main'] 	= 'schooladmin/jadwal/index';
		$data['page_title'] 	= 'Jadwal Pelajaran';
		$this->load->view('layout/ad_fullwidth',$data);
    }
	function getPelajaranByIdKelas($id_kelas=null){
		if($id_kelas==null){$id_kelas=$_POST['id_kelas'];}
		$this->load->model('ad_pelajaran');
		$this->load->model('ad_kelas');
		
		$kelas=$this->ad_kelas->getkelasById($this->session->userdata['user_authentication']['id_sekolah'],$id_kelas);
		
		$mapel=$this->ad_pelajaran->getdatabySemesterJenjangJurusanKelas($this->session->userdata['ak_setting']['semester'],$kelas[0]['kelas'],$kelas[0]['id_jurusan']);
		//if(isset($_POST)){
		$mapelselected=$this->ad_pelajaran->getSelectedPelajaran();
		//}
		//pr($mapelselected);
		echo "<option value=''>Pilih Pelajaran</option>";
		foreach($mapel as $selectpel){
			if(@$_POST['id_pelajaran']==$selectpel['id']){ $slctd='selected class="selected"';}else{ $slctd=''; }
			if(@$mapelselected[0]['id']==$selectpel['id']){ $slctd='selected class="selected"';}else{ $slctd=''; }
			echo "<option ".$slctd." value='".$selectpel['id']."'>".$selectpel['nama']."</option>";
		}

		die();
	}
    public function getKelas($id_kelas=null)
    {
       $this->load->model('ad_kelas');
	   $kelas=$this->ad_kelas->getkelas($this->session->userdata['user_authentication']['id_sekolah']);
	   $select ="<option value='".$kelas[0]['id']."'>Pilih Kelas</option>";
	   foreach($kelas as $datakelas){
			if($id_kelas==$datakelas['id']){
				$slct="selected";
			}else{
				$slct="";
			}
			$select .="<option ".$slct." value='".$datakelas['id']."'>".$datakelas['kelas'].$datakelas['nama']."</option>";
	   }
	   echo $select;
	   die();
    }
    
	function getPengajar($id_pelajaran=null){
		if(isset($_POST)){
		$waktu=explode(" ",@$_POST['waktu']);
		$id_pelajaran=@$_POST['id_pelajaran'];
		if($id_pelajaran=='' || isset($_POST['id_kelas']) ){
			$pelselected=$this->db->query('SELECT am.id_pegawai, am.id_pelajaran FROM ak_jadwal aj JOIN ak_mengajar am ON aj.id_mengajar=am.id WHERE aj.id_kelas="'.@$_POST['id_kelas'].'" AND StartTime="'.$_POST['start'].'" AND EndTime="'.$_POST['end'].'" ');	
			$dataselected=$pelselected->result_array();
			if($dataselected[0]['id_pelajaran']!=''){
			$id_pelajaran=$dataselected[0]['id_pelajaran'];			
			}
			$id_pegawai=$dataselected[0]['id_pegawai'];
		}
		//pr($id_pelajaran);
		//pr($id_pegawai);
		switch($waktu[0]){
			case"(Senin)":
				$tgl='2013-02-11';
			break;
			case"(Selasa)":
				$tgl='2013-02-12';
			break;
			case"(Rabu)":
				$tgl='2013-02-13';
			
			break;
			case"(Kamis)":
				$tgl='2013-02-14';
			break;
			case"(Jumat)":
				$tgl='2013-02-15';
			break;
			case"(Sabtu)":
				$tgl='2013-02-16';
			break;
			case"(Minggu)":
				$tgl='2013-02-17';
			break;
			
		}
		//echo $tgl;
		$wstart="".@$tgl." ".@$waktu[1]."";
		$wend="".@$tgl." ".str_replace("  ","",@$waktu[4])."";
		$guru=$this->db->query('SELECT ap.nama, ap.id as id_pegawai, am.id FROM ak_mengajar am JOIN ak_pegawai ap ON am.id_pegawai=ap.id WHERE am.id_pegawai NOT IN(SELECT am.id_pegawai FROM ak_jadwal aj JOIN ak_mengajar am ON aj.id_mengajar=am.id WHERE aj.StartTime="'.$wstart.'" AND aj.StartTime="'.$wend.'  ") AND am.id_pelajaran="'.$id_pelajaran.'" AND am.id_kelas="'.@$_POST['id_kelas'].'"');
		//echo $this->db->last_query();
		
		echo "<option  value=''>Pilih Guru</option>";
		foreach($guru->result_array() as $dataguru){
			if(isset($id_pegawai) && $id_pegawai==$dataguru['id_pegawai']){$slctd='selected';}else{$slctd='';}
			echo "<option ".$slctd."  value='".$dataguru['id']."'>".$dataguru['nama']."</option>";
		}
		}
		
		die();
	}
	
	function getPelajaran($semester=null,$kelas=null,$jurusan=null){
		if(isset($_POST['kelas'])){
			$semester=@$_POST['semester'];
			$kelas=@$_POST['kelas'];
			$jurusan=@$_POST['id_jurusan'];
			$pelajaran=@$_POST['id_pelajaran'];
		}
		$this->load->model('ad_pelajaran');
		$mapel=$this->ad_pelajaran->getdatabySemesterJenjangJurusanKelas($semester,$kelas,$jurusan);

		echo "<option value=''>Pilih Pelajaran</option>";
		foreach($mapel as $selectpel){
			if(@$_POST['id_pelajaran']==$selectpel['id']){ $slctd='selected';}else{ $slctd=''; }
			echo "<option ".$slctd." value='".$selectpel['id']."'>".$selectpel['nama']."</option>";
		}

		die();
	}
    
}
?>