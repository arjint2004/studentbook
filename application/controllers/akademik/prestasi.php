<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Prestasi extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->helper('global');
            $this->load->library('session');
            $this->load->library('auth');
            $this->auth->user_logged_in();
        }
		
        //AREA prestasi prestasi 
        public function index(){
			$this->load->model('ad_kelas');
			$data['kelas'] 	=$this->ad_kelas->getKelasByWali($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
			$data['prestasi']=array();
            $data['main']= 'akademik/prestasi/prestasi';
            $this->load->view('layout/ad_blank',$data);
        }
		
        public function delete($id){
			$this->db->query('DELETE FROM ak_prestasi WHERE id='.$id.'');
		}
        public function prestasilist(){
			$this->load->model('ad_prestasi');
			
			if(isset($_POST['simpan'])){
				//pr($_POST);
				foreach($_POST['data']['prestasi'] as $key=>$datacatatan){ 	 	 	 	 	 	 	 	 
					
					$insert=array(
								'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
								'id_siswa_det_jenjang'=>$_POST['id_siswa_det_jenjang'],
								'id_pegawai'=>$this->session->userdata['user_authentication']['id_pengguna'],
								'id_kelas'=>$_POST['id_kelas'],
								'ta'=>$this->session->userdata['ak_setting']['ta'],
								'semester'=>$this->session->userdata['ak_setting']['semester'],
								'kejuaraan'=>$_POST['data']['kejuaraan'][$key],
								'tahun'=>$_POST['data']['tahun'][$key],
								'prestasi'=>$_POST['data']['prestasi'][$key]
					);
					
					if($_POST['data']['id'][$key]!='' && isset($_POST['data']['id'][$key])){
						$this->db->where('id',$_POST['data']['id'][$key]);
						$this->db->update('ak_prestasi',$insert);
					}else{
						$this->db->insert('ak_prestasi',$insert);
					}
					
				}
			}
			
			
			if(isset($_POST['id_kelas']) && isset($_POST['id_siswa_det_jenjang'])){
				$data['prestasi']=$this->ad_prestasi->getprestasiByKelasIdPegawaiIdSiswaDetJenjang($_POST['id_kelas'],$_POST['id_siswa_det_jenjang']);
			}
            $data['main']= 'akademik/prestasi/prestasilist';
            $this->load->view('layout/ad_blank',$data);
        }
        public function getOptionSiswaByIdKelas($id_kelas){
			$this->load->library('ak_siswa');
			$optionsiswa=$this->ak_siswa->createOptionSiswaByIdKelas($id_kelas);
			echo $optionsiswa;
        }
		
     
        
    }
?>