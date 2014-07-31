<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Catatanguru extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->helper('global');
            $this->load->library('session');
            $this->load->library('auth');
            $this->auth->user_logged_in();
        }
		
        //AREA catatanguru catatanguru 
        public function index(){
			$this->load->model('ad_kelas');
			$data['catatanguru']=array();
			
			$group=$this->auth->get_det_group($this->session->userdata['user_authentication']['id']);
			$bk=$this->auth->array_searchRecursive( 19, $group, $strict=false, $path=array() );
			$kepsek=$this->auth->array_searchRecursive( 16, $group, $strict=false, $path=array() );
			$wali=$this->auth->array_searchRecursive( 17, $group, $strict=false, $path=array() );
			
		    if(!empty($bk) || !empty($kepsek)){
				$data['kelas'] 	=$this->ad_kelas->getkelas($this->session->userdata['user_authentication']['id_sekolah']);
			}elseif(!empty($wali)){
				$kelaspengajar=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
				$kelaswali=$this->ad_kelas->getKelasByWali($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
				$data['kelas']=array_merge($kelaspengajar,$kelaswali);
			}else{
				$data['kelas'] 	=$this->ad_kelas->getkelasByPengajar($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
			}
            $data['main']= 'akademik/catatanguru/catatanguru';
            $this->load->view('layout/ad_blank',$data);
        }
		
        public function delete($id){
			$this->db->query('DELETE FROM ak_catatanguru WHERE id='.$id.'');
		}
        public function catatangurulist(){
			$this->load->model('ad_catatanguru');
			$this->load->model('ad_aspek_kepribadian');
			
			if(isset($_POST['simpan'])){
				//pr($_POST);
				foreach($_POST['data']['id_aspek_kepribadian'] as $key=>$datacatatan){ 	 	 	 	 	 	 	 	 
					
					$insert=array(
								'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
								'id_siswa_det_jenjang'=>$_POST['id_siswa_det_jenjang'],
								'id_pegawai'=>$this->session->userdata['user_authentication']['id_pengguna'],
								'id_kelas'=>$_POST['id_kelas'],
								'ta'=>$this->session->userdata['ak_setting']['ta'],
								'semester'=>$this->session->userdata['ak_setting']['semester'],
								'id_aspek_kepribadian'=>$_POST['data']['id_aspek_kepribadian'][$key],
								'tanggal'=>$_POST['tanggal'],
								'apresiasi'=>$_POST['data']['apresiasi'][$key],
								'pelanggaran'=>$_POST['data']['pelanggaran'][$key]
					);
					
					if($_POST['data']['id'][$key]!='' && isset($_POST['data']['id'][$key])){
						$this->db->where('id',$_POST['data']['id'][$key]);
						$this->db->update('ak_catatanguru',$insert);
					}else{
						$this->db->insert('ak_catatanguru',$insert);
					}
					
				}
			}
			
			$data['aspek']=$this->ad_aspek_kepribadian->getAllAspekByIdSekolah($this->session->userdata['user_authentication']['id_sekolah']);
			if(isset($_POST['id_kelas']) && isset($_POST['id_siswa_det_jenjang']) && isset($_POST['tanggal'])){
				$data['catatanguru']=$this->ad_catatanguru->getCatatanguruByKelasTanggalIdPegawai($_POST['id_kelas'],$_POST['id_siswa_det_jenjang'],$_POST['tanggal']);
			}
            $data['main']= 'akademik/catatanguru/catatangurulist';
            $this->load->view('layout/ad_blank',$data);
        }
        public function getOptionSiswaByIdKelas($id_kelas){
			$this->load->library('ak_siswa');
			$optionsiswa=$this->ak_siswa->createOptionSiswaByIdKelas($id_kelas);
			echo $optionsiswa;
        }
		
     
        
    }
?>