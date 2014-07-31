<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Otoritas extends CI_Controller {
	 function __construct()
	 {
		  parent::__construct();
		  $this->load->library('auth');
		  $this->load->library('ak_akademik');
		  $this->auth->logged_in();
	 }
	 
	 function disableakun($dataId=null)
	 {	
		$this->load->model('ad_akun');
		$dataIdArray=unserialize(base64_decode($dataId));
		$this->ad_akun->disableakun($dataIdArray['id_user']);
		echo "Aktifkan";
		//redirect('admin/schooladmin/dataakun');
	 }
	 function enableakun($dataId=null)
	 {	
		$this->load->model('ad_akun');
		$dataIdArray=unserialize(base64_decode($dataId));
		$this->ad_akun->enableakun($dataIdArray['id_user']);
		echo "Non Aktifkan";
		//redirect('admin/schooladmin/dataakun');
	 }
	 function setotoritas($dataId=null)
	 {
		 if($dataId==null && isset($_POST['otoren'])){
			$dataId=$_POST['otoren'];
		 }
		 $currentotoritasoto=array();
		 $this->load->model('ad_akun');
		 $this->load->helper('akademik');
		 $dataIdArray=unserialize(base64_decode($dataId));

		 if(isset($_POST['submit'])){
			
			$dataIdArray=unserialize(base64_decode($_POST['dataId']));
			$this->db->query('DELETE FROM det_group WHERE id_user='.$dataIdArray['id_user'].''); 
			//pr($_POST);
			if(!isset($_POST['otoritas'][17]) && isset($_POST['id_kelas'])){
				$this->db->where('id_pegawai',$dataIdArray['id_pengguna']);
				$this->db->update('ak_kelas',array('id_pegawai'=>0));
				//echo $this->db->last_query();
			}
			if(isset($_POST['otoritas'])){
				foreach($_POST['otoritas'] as $id_group=>$nama_jabatan){
						$detauth=array(
									'id'=>'',
									'id_group'=>$id_group,
									'id_user'=>$dataIdArray['id_user']
								);

						
						$this->db->insert('det_group',$detauth);
						if($id_group==17 && isset($_POST['id_kelas'])){
							$this->db->where('id_pegawai',$dataIdArray['id_pengguna']);
							$this->db->update('ak_kelas',array('id_pegawai'=>0));
							
							$this->db->where('id',$_POST['id_kelas']);
							$this->db->update('ak_kelas',array('id_pegawai'=>$dataIdArray['id_pengguna']));
						}
					
				}
				redirect('/admin/schooladmin/dataakun');
			}
		 }
		 $currentotoritas=$this->ad_akun->getCurrentOtoritas($dataIdArray['id_user']);
		 $pegawai=$this->ad_akun->getdataById($dataIdArray['id'],$listtype=13,$aktif=1);
		 foreach($currentotoritas as $id_groupoto){
			$currentotoritasoto[$id_groupoto['id_group']]=$id_groupoto['id_group'];
		 }
		 
		 $data['otoritas'] 	= $dataIdArray['otoritas'];
		 $data['dataId'] 	= $dataId;
		 $data['dataIdArray']=$dataIdArray;
		 $data['pegawai'] 	= $pegawai;
		 $data['currentotoritas'] 	= $currentotoritasoto;
		 $data['page_title'] 	= 'Set otoritas Akun';
		 
		 $this->load->model('ad_sekolah');
		 $data['kepsek']=$this->ad_sekolah->getKepsek($this->session->userdata['user_authentication']['id_sekolah']);
		 
		 if ($this->input->post('ajax')) {
		   $data['main'] 	= 'schooladmin/otoritas/setotoritas';
		   $this->load->view('layout/ad_blank',$data); // memilih layout
		} else {
		   $data['main'] 	= 'schooladmin/otoritas/setotoritas';
		   $this->load->view('layout/ad_adminsekolah',$data);
		} 
	 }
}

?>