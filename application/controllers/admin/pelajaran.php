<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pelajaran extends CI_Controller {
	 function __construct()
	 {
		parent::__construct();
		$this->load->library('auth');
		$this->auth->logged_in();
		$this->load->model('ad_pelajaran');
	 }
	function index(){

		$data['page_title'] 	= 'Data Pelajaran';
		if ($this->input->post('ajax')) {
		   $data['main'] 	= 'schooladmin/pelajaran/index'; // memilih view
		   $this->load->view('layout/ad_blank',$data); // memilih layout
		} else {
		   $data['main'] 	= 'schooladmin/pelajaran/index';// memilih view
		   $this->load->view('layout/ad_adminsekolah',$data);
		} 
	}
	function delete($id_pelajaran=null){
		$freepelajaran=$this->ad_pelajaran->getFreePelajaran($id_pelajaran,$this->session->userdata['user_authentication']['id_sekolah']);
		if($freepelajaran==0){
			$this->db->query('DELETE FROM ak_pelajaran WHERE id='.$id_pelajaran.'');
		}
		echo $freepelajaran;
	}
	function deletehard($id_pelajaran=null){
		$allcolsq=$this->db->query("
								SELECT DISTINCT TABLE_NAME
								FROM INFORMATION_SCHEMA.COLUMNS
								WHERE COLUMN_NAME
								IN (
								'id_pelajaran'
								)
								AND TABLE_SCHEMA = 'studentbook'
								");
		$allcols=$allcolsq->result_array();
		pr($allcols);
		foreach($allcols as $dtcols){
			//pr($dtcols);
			$this->db->query('DELETE FROM '.$dtcols['TABLE_NAME'].' WHERE id_pelajaran='.$id_pelajaran.'');
			pr($this->db->last_query());
		}
		$this->db->query('DELETE FROM ak_pelajaran WHERE  id='.$id_pelajaran.'');
		
		echo 0;
	}
	function editdata($id=0){
		$this->load->model('ad_jurusan');
		$this->load->model('ad_kelas');
		$this->load->model('ad_setting');
		$data['semester'] 	=  $this->ad_setting->getSemester($this->session->userdata['user_authentication']['id_sekolah']);
		if(isset($_POST['addpelajaran'])){
			$datamapel=array(
						'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
						'id_jurusan'=>$_POST['id_jurusan'],
						'nama'=>$_POST['nama'],
						'alias'=>$_POST['alias'],
						'kelompok'=>$_POST['kelompok'],
						'semester'=>$_POST['semester'],
						'kelas'=>$_POST['jenjang']
			);
			
			$this->db->where('id', $_POST['id']);
			$this->db->update('ak_pelajaran',$datamapel);
			//die();
		}
		$datajenjang=$this->ad_kelas->thisjenjang($this->session->userdata['user_authentication']['id']);
		$jur=$this->ad_jurusan->getdata($this->session->userdata['user_authentication']['id_sekolah']);
		
		$data['pelajaran'] 	=  $this->ad_pelajaran->getdataById($id);
		$data['grade'] 	=  unserialize($datajenjang[0]['grade']);
		$data['jurusan'] 	= $jur;
		$data['main'] 	= 'schooladmin/pelajaran/editData';
		$data['page_title'] 	= 'Tambah Pelajaran';
		$this->load->view('layout/ad_blank',$data);
	}
	function adddatasub(){
	
		$this->load->model('ad_jurusan');
		$this->load->model('ad_pelajaran');
		$this->load->model('ad_kelas');
		$this->load->model('ad_setting');
		if(isset($_POST['addpelajaran'])){
			$expmapel=explode(",",$_POST['nama']);
			$expmapelalias=explode(",",$_POST['alias']);
			//pr($expmapelalias);
			//pr($expmapel);die();
			foreach($expmapel as $kyexp=> $namapel){
				$datamapel=array(
							'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
							'id_jurusan'=>$_POST['id_jurusan'],
							'nama'=>$namapel,
							'alias'=>$expmapelalias[$kyexp],
							'kelompok'=>$_POST['kelompok'],
							'semester'=>$_POST['semester'],
							'kelas'=>$_POST['jenjang']
				);
				if(isset($_POST['id_parent'])){
					$datamapel['id_parent']=$_POST['id_parent'];
					$this->db->where('id',$_POST['id_parent']);
					$this->db->update('ak_pelajaran',array('havechild'=>1));
				}
				$this->db->insert('ak_pelajaran',$datamapel);
			}
			//die();
		}
		
			$datapelajaran=$this->ad_pelajaran->getdataByIdSekolah($this->session->userdata['user_authentication']['id_sekolah']);		

			if(!empty($datapelajaran) && isset($_POST['set_pelajaran'])){
				$this->db->where('id_sekolah',$this->session->userdata['user_authentication']['id_sekolah']);
				$this->db->update('ak_step_registrasi',array('set_tahun_ajaran'=>1,'set_semester'=>1,'set_jurusan'=>1,'set_kelas'=>1,'set_pelajaran'=>1,'finish'=>1));
			
				$this->load->model('ad_setting');
				$cekcompletereg=$this->ad_setting->getDataStepRegistrasi($this->session->userdata['user_authentication']['id_sekolah']);
				//pr($cekcompletereg);	
				if($cekcompletereg[0]['set_tahun_ajaran']==1 && $cekcompletereg[0]['set_semester']==1 && $cekcompletereg[0]['set_kelas']==1 && $cekcompletereg[0]['set_jurusan']==1 && $cekcompletereg[0]['set_pelajaran']==1 && $cekcompletereg[0]['finish']==1 ){
					//echo "<script>window.location = '".base_url()."admin/schooladmin';</script>";
					//die();
				}
			}
		$datajenjang=$this->ad_kelas->thisjenjang($this->session->userdata['user_authentication']['id']);
		$jur=$this->ad_jurusan->getdata($this->session->userdata['user_authentication']['id_sekolah']);
		
		$data['semester'] 	=  $this->ad_setting->getSemester($this->session->userdata['user_authentication']['id_sekolah']);
		$data['grade'] 	=  unserialize($datajenjang[0]['grade']);
		$data['jenjang'] 	= $datajenjang;
		$data['jurusan'] 	= $jur;
		$data['page_title'] 	= 'Tambah Pelajaran';
		if(isset($_POST['jenjang']) && isset($_POST['jurusan']) && isset($_POST['semester'])){
			$data['pelajaran'] 	=  $this->ad_pelajaran->getdataById($_POST['id_pelajaran']);
			$data['selected']=$_POST;
			$data['page_title'] 	= 'Tambah Sub Pelajaran '.$data['pelajaran'][0]['nama'].'';
			$data['addjenis'] 	= 'sub';
		}
		$data['main'] 	= 'schooladmin/pelajaran/addDataSub';
		$this->load->view('layout/ad_blank',$data);
	}
	function adddata(){
	
		$this->load->model('ad_jurusan');
		$this->load->model('ad_pelajaran');
		$this->load->model('ad_kelas');
		$this->load->model('ad_setting');
		if(isset($_POST['addpelajaran'])){
			$expmapel=explode(",",$_POST['nama']);
			$expmapelalias=explode(",",$_POST['alias']);
			//pr($expmapelalias);
			//pr($expmapel);die();
			
			foreach($_POST['semester'] as $id_semester){
				foreach($_POST['jenjang'] as $jenjang){
					foreach($expmapel as $kyexp=> $namapel){
						$datamapel=array(
									'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
									'id_jurusan'=>$_POST['id_jurusan'],
									'nama'=>$namapel,
									'alias'=>$expmapelalias[$kyexp],
									'kelompok'=>$_POST['kelompok'],
									'semester'=>$id_semester,
									'kelas'=>$jenjang
						);
						if(isset($_POST['id_parent'])){
							$datamapel['id_parent']=$_POST['id_parent'];
							$this->db->where('id',$_POST['id_parent']);
							$this->db->update('ak_pelajaran',array('havechild'=>1));
						}
						$this->db->insert('ak_pelajaran',$datamapel);
					}	
				}	
			}	
			
			//die();
		}
			$datapelajaran=$this->ad_pelajaran->getdataByIdSekolah($this->session->userdata['user_authentication']['id_sekolah']);
			
			if(!empty($datapelajaran) && isset($_POST['set_pelajaran'])){
				$this->db->where('id_sekolah',$this->session->userdata['user_authentication']['id_sekolah']);
				$this->db->update('ak_step_registrasi',array('set_tahun_ajaran'=>1,'set_semester'=>1,'set_jurusan'=>1,'set_kelas'=>1,'set_pelajaran'=>1,'finish'=>1));
			
				$this->load->model('ad_setting');
				$cekcompletereg=$this->ad_setting->getDataStepRegistrasi($this->session->userdata['user_authentication']['id_sekolah']);
				//pr($cekcompletereg);	
				if($cekcompletereg[0]['set_tahun_ajaran']==1 && $cekcompletereg[0]['set_semester']==1 && $cekcompletereg[0]['set_kelas']==1 && $cekcompletereg[0]['set_jurusan']==1 && $cekcompletereg[0]['set_pelajaran']==1 && $cekcompletereg[0]['finish']==1 ){
					//echo "<script>window.location = '".base_url()."admin/schooladmin';</script>";
					//die();
				}
			}
			
		$datajenjang=$this->ad_kelas->thisjenjang($this->session->userdata['user_authentication']['id']);
		$jur=$this->ad_jurusan->getdata($this->session->userdata['user_authentication']['id_sekolah']);
		
		$data['semester'] 	=  $this->ad_setting->getSemester($this->session->userdata['user_authentication']['id_sekolah']);
		$data['grade'] 	=  unserialize($datajenjang[0]['grade']);
		$data['jenjang'] 	= $datajenjang;
		$data['jurusan'] 	= $jur;
		$data['page_title'] 	= 'Tambah Pelajaran';
		if(isset($_POST['jenjang']) && isset($_POST['jurusan']) && isset($_POST['semester'])){
			$data['pelajaran'] 	=  $this->ad_pelajaran->getdataById($_POST['id_pelajaran']);
			$data['selected']=$_POST;
			$data['page_title'] 	= 'Tambah Sub Pelajaran '.$data['pelajaran'][0]['nama'].'';
			$data['addjenis'] 	= 'sub';
		}
		$data['main'] 	= 'schooladmin/pelajaran/addData';
		$this->load->view('layout/ad_blank',$data);
	}
	
	function listDataSub($id_pelajaran=0){
	
		$this->load->model('ad_pelajaran');
		
		
		//get data pelajaran
		$param['id_sekolah']=$this->session->userdata['user_authentication']['id_sekolah'];
		$param['id_parent']=$id_pelajaran;
		
		if(@$_POST['jenjang']!='' ){
			$param['jenjang']=$_POST['jenjang'];
		}
		if(@$_POST['jenjang']!='' && @$_POST['id_jurusan']!=''){
			$param['id_jurusan']=$_POST['id_jurusan'];
		}
		if(@$_POST['jenjang']!='' && @$_POST['id_jurusan']!='' && @$_POST['semester']!='' ){
			$param['semester']=$_POST['semester'];
		}

		if($id_pelajaran!=0){
			$data['pelajaran'] 	=  $this->ad_pelajaran->getdataadminsub($param);
		}
		
		$data['sub'] 	= true;
		$data['page_title'] 	= 'Data Sub Pelajaran';
		 if ($this->input->post('ajax')) {
		   $data['main'] 	= 'schooladmin/pelajaran/listDataSub'; // memilih view
		   $this->load->view('layout/ad_blank',$data); // memilih layout
		} else {
		   $data['main'] 	= 'schooladmin/pelajaran/listDataSub';// memilih view
		   $this->load->view('layout/ad_adminsekolah',$data);
		} 	
	}
	function listData(){
	
		$this->load->model('ad_jurusan');
		$this->load->model('ad_kelas');
		$this->load->model('ad_pelajaran');
		$this->load->model('ad_setting');
		
		
		//get data pelajaran
		$param['id_sekolah']=$this->session->userdata['user_authentication']['id_sekolah'];
		
		if(@$_POST['jenjang']!='' ){
			$param['jenjang']=$_POST['jenjang'];
		}
		if(@$_POST['jenjang']!='' && @$_POST['id_jurusan']!=''){
			$param['id_jurusan']=$_POST['id_jurusan'];
		}
		if(@$_POST['jenjang']!='' && @$_POST['id_jurusan']!='' && @$_POST['semester']!='' ){
			$param['semester']=$_POST['semester'];
		}
		
		$datajenjang=$this->ad_kelas->thisjenjang($this->session->userdata['user_authentication']['id']);
		$jur=$this->ad_jurusan->getdata($this->session->userdata['user_authentication']['id_sekolah']);
		
		$data['grade'] 	=  unserialize($datajenjang[0]['grade']);
		$data['jurusan'] 	= $jur;
		$data['semester'] 	=  $this->ad_setting->getSemester($this->session->userdata['user_authentication']['id_sekolah']);
		if(isset($_POST['jenjang']) && isset($_POST['semester'])){
			$data['pelajaran'] 	=  $this->ad_pelajaran->getdataadmin($param);
		}else{
			$param['semester']=$this->session->userdata['ak_setting']['semester'];
			$param['id_jurusan']=$jur[0]['id'];
			$param['jenjang']=$data['grade'][0];
			$data['pelajaran'] 	=  $this->ad_pelajaran->getdataadmin($param);
			$data['param']=$param;
		}
		
		$data['page_title'] 	= 'Data Pelajaran';
		 if ($this->input->post('ajax')) {
		   $data['main'] 	= 'schooladmin/pelajaran/listData'; // memilih view
		   $this->load->view('layout/ad_blank',$data); // memilih layout
		} else {
		   $data['main'] 	= 'schooladmin/pelajaran/listData';// memilih view
		   $this->load->view('layout/ad_adminsekolah',$data);
		} 
	}
	public function getMapelByKelasAndPegawai($id_kelas=null,$id_mapel=null,$nopilih=0,$id_pengguna=0)
    {
       $this->load->model('ad_pelajaran');
       $this->load->model('ad_kelas');
	   $jurusankelasnya=$this->ad_kelas->getkelasById($this->session->userdata['user_authentication']['id_sekolah'],$id_kelas);
		// pr($jurusankelasnya);die();
	   $mapel=$this->ad_pelajaran->getdatabySemesterJenjangJurusanKelasPegawaimengajar($this->session->userdata['ak_setting']['semester'],$jurusankelasnya[0]['kelas'],$jurusankelasnya[0]['id_jurusan'],$id_kelas,$id_pengguna);
	   //pr($mapel);
	   $select ='';
	    if($nopilih==0){
			$select ="<option value='0'>Pilih Pelajaran</option>";
		}
	   foreach($mapel as $datamapel){
			if($id_mapel==$datamapel['id']){
				$slct="selected";
			}else{
				$slct="";
			}
			/*if($datamapel['havechild']==1){
				$mapelchild=$this->ad_pelajaran->getdataChild($datamapel['id']);
				foreach($mapelchild as $datamapelchild){
					if($id_mapel==$datamapelchild['id']){
						$slct="selected";
					}else{
						$slct="";
					}
					$select .="<option ".@$slct." alias='".$datamapelchild['alias']."' value='".$datamapelchild['id']."'>".$datamapelchild['nama']."</option>";
				}
			}else{*/
				$select .="<option ".@$slct." alias='".$datamapel['alias']."' value='".$datamapel['id']."'>".$datamapel['nama']."</option>";
			//}
	   }
	   echo $select;
	   die();
    }
	
	public function getKelasByPelajaranAndPegawai($id_pelajaran=0,$id_kelas=0)
    {
       $this->load->model('ad_kelas');
	   $kelas=$this->ad_kelas->getKelasByPelajaranMengajar($id_pelajaran,$this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['ak_setting']['semester'],$this->session->userdata['user_authentication']['id_pengguna']);
		//echo $this->db->last_query();
	   $select ='';
	   $select ="<option value='0'>Pilih Kelas</option>";
	   foreach($kelas as $datakelas){
			if($id_kelas==$datakelas['id']){
				$slct="selected";
			}else{
				$slct="";
			}
			$select .="<option ".@$slct." id_mengajar='".$datakelas['id_mengajar']."' value='".$datakelas['id']."'>".$datakelas['kelas'].$datakelas['nama']."</option>";
	   }
	   echo $select;
	   die();
    }
	
	public function getMapelByKelas($id_kelas=null,$id_mapel=null)
    {
       $this->load->model('ad_pelajaran');
       $this->load->model('ad_kelas');
	   $jurusankelasnya=$this->ad_kelas->getkelasById($this->session->userdata['user_authentication']['id_sekolah'],$id_kelas);
		// pr($jurusankelasnya);die();
	   $mapel=$this->ad_pelajaran->getdatabySemesterJenjangJurusanKelas($this->session->userdata['ak_setting']['semester'],$jurusankelasnya[0]['kelas'],$jurusankelasnya[0]['id_jurusan']);
	   $select ='';
	   $select ="<option value='0'>Pilih Pelajaran</option>";
	   foreach($mapel as $datamapel){
			if($id_mapel==$datamapel['id']){
				$slct="selected";
			}else{
				$slct="";
			}
			$select .="<option ".@$slct." value='".$datamapel['id']."'>".$datamapel['nama']."</option>";
	   }
	   echo $select;
	   die();
    }
	function getjurusanByjenjang($jenjangkelas=null){ 
		$this->load->model('ad_jurusan');
		$jur=$this->ad_jurusan->getdata($this->session->userdata['user_authentication']['id_sekolah']);
			if($jenjangkelas>10){
				unset($jur[0]);
				foreach($jur as $datajur){
					echo '<option value="'.$datajur['id'].'">'.$datajur['nama'].'</option>';
				}
			}elseif($jenjangkelas==null){
				unset($jur[0]);
				foreach($jur as $datajur){
					echo '<option value="'.$datajur['id'].'">'.$datajur['nama'].'</option>';
				}
			}else{
				echo '<option value="'.$jur[0]['id'].'">'.$jur[0]['nama'].'</option>';
			}
	}
	
	
	function copyMapelSemester(){ 
		//get id_semester 
		$id_sm=$this->db->query('SELECT * FROM ak_semester WHERE id_sekolah=? ORDER BY nama ASC',array($this->session->userdata['user_authentication']['id_sekolah']))->result_array();
		
		//ambil data pelajaran semester1
		$mapel=$this->db->query('SELECT ap.* FROM ak_pelajaran ap JOIN ak_semester asm ON ap.semester=asm.id WHERE ap.id_sekolah=? AND ap.semester=?',array($this->session->userdata['user_authentication']['id_sekolah'],$id_sm[0]['id']))->result_array();
		echo $this->db->last_query();
		//pr($mapel);
		$ii=0;
		foreach($mapel as $mapelsm1){
			//echo $ii++."<br>";
			//cek exist data mapel
			$c_mpl=$this->db->query('SELECT COUNT(*) as c FROM ak_pelajaran WHERE id_sekolah=? AND id_parent=? AND agama=? AND nama=? AND alias=? AND kelompok=? AND semester=? AND kelas=? AND id_jurusan=?',array($this->session->userdata['user_authentication']['id_sekolah'],$mapelsm1['id_parent'],$mapelsm1['agama'],$mapelsm1['nama'],$mapelsm1['alias'],$mapelsm1['kelompok'],$id_sm[1]['id'],$mapelsm1['kelas'],$mapelsm1['id_jurusan']))->result_array();
			if($c_mpl[0]['c']==0){
				//search child
				$mapelchild=$this->db->query('SELECT * FROM ak_pelajaran WHERE id_sekolah=? AND semester=? AND id_parent=?',array($this->session->userdata['user_authentication']['id_sekolah'],$id_sm[1]['id'],$mapelsm1['id']))->result_array();
				unset($mapelsm1['id']);
				$mapelsm1['semester']=$id_sm[1]['id'];
				//pr($mapelsm1);
				//$this->db->insert('ak_pelajaran',$mapelsm1);
				$id_mapel=mysql_insert_id();
				if(!empty($mapelchild)){
					foreach($mapelchild as $mapelchild){
						unset($mapelchild['id']);
						$mapelchild['id_parent']=$id_mapel;
						$mapelchild['semester']=$id_sm[1]['id'];
						//$this->db->insert('ak_pelajaran',$mapelchild);
					}
				}
			}else{
				echo $this->db->last_query();
				pr($mapelsm1);
			}
		}
		
	}
	
	function copyMengajar(){ 
		//get id_semester 
		$id_sm=$this->db->query('SELECT * FROM ak_semester WHERE id_sekolah=? ORDER BY nama ASC',array($this->session->userdata['user_authentication']['id_sekolah']))->result_array();
		
		$c_mengajar=$this->db->query('SELECT * FROM ak_mengajar WHERE id_sekolah=?',array($this->session->userdata['user_authentication']['id_sekolah']))->result_array();
		
		foreach($c_mengajar as $mengajar){
			
			$pelajaran=$this->db->query('SELECT * FROM ak_pelajaran WHERE id=?',array($mengajar['id_pelajaran']))->result_array();
			//pr($pelajaran);
			$pelajaransm2=$this->db->query('SELECT * FROM `ak_pelajaran` WHERE  id_sekolah=? AND semester=? AND kelas=? AND id_jurusan=? AND nama=?',array($this->session->userdata['user_authentication']['id_sekolah'],$id_sm[1]['id'],$pelajaran[0]['kelas'],$pelajaran[0]['id_jurusan'],$pelajaran[0]['nama']))->result_array();
			//echo $this->db->last_query(); 
			//pr($pelajaran[0]['id']);
			//pr($pelajaransm2);
			unset($mengajar['id']);
			$mengajar['id_pelajaran']=$pelajaransm2[0]['id'];
			//$this->db->insert('ak_mengajar',$mengajar);
		}
	}
	
	function copyJadwal(){ 
		//get id_semester 
		$id_sm=$this->db->query('SELECT * FROM ak_semester WHERE id_sekolah=? ORDER BY nama ASC',array($this->session->userdata['user_authentication']['id_sekolah']))->result_array();
		
		$jadwal=$this->db->query('SELECT * FROM ak_jadwal WHERE id_sekolah=?',array($this->session->userdata['user_authentication']['id_sekolah']))->result_array();
		//echo $this->db->last_query(); pr($jadwal);
		foreach($jadwal as $jadwal){
			$mengajar=$this->db->query('SELECT * FROM ak_mengajar WHERE id=?',array($jadwal['id_mengajar']))->result_array();
			//pr($mengajar);
			
			$pelajaran=$this->db->query('SELECT * FROM ak_pelajaran WHERE id=?',array($mengajar[0]['id_pelajaran']))->result_array();
			//pr($pelajaran);
			$pelajaransm2=$this->db->query('SELECT * FROM `ak_pelajaran` WHERE  id_sekolah=? AND semester=? AND kelas=? AND id_jurusan=? AND nama=?',array($this->session->userdata['user_authentication']['id_sekolah'],$id_sm[1]['id'],$pelajaran[0]['kelas'],$pelajaran[0]['id_jurusan'],$pelajaran[0]['nama']))->result_array();
			
			$mengajar2=$this->db->query('SELECT am.* FROM `ak_mengajar` am JOIN ak_pelajaran ap ON ap.id=am.id_pelajaran WHERE  am.id_kelas=? AND am.id_sekolah=? AND am.id_pegawai=? AND am.id_pelajaran=? AND ap.semester=?',array($mengajar[0]['id_kelas'],$mengajar[0]['id_sekolah'],$mengajar[0]['id_pegawai'],$pelajaransm2[0]['id'],$id_sm[1]['id']))->result_array();
			//pr($pelajaran[0]['id']);
			//if(count($mengajar2)>1){pr($mengajar2);}
			unset($jadwal['Id']);
			//pr($jadwal);
			$jadwal['id_mengajar']=$mengajar2[0]['id'];
			pr($jadwal);
			//$this->db->insert('ak_jadwal',$jadwal);
			echo $this->db->last_query(); 
			$o++;
		}echo $o;
	}
}

?>