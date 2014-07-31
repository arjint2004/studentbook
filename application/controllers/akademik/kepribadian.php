<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Kepribadian extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->helper('global');
            $this->load->library('session');
            $this->load->library('auth');
            $this->auth->user_logged_in();
        }
		
        //AREA kepribadian kepribadian 
        public function index(){
			$this->load->model('ad_kelas');
			$data['kepribadian']=array();
			$data['kelas'] 	=$this->ad_kelas->getKelasByWali($this->session->userdata['user_authentication']['id_sekolah'],$this->session->userdata['user_authentication']['id_pengguna']);
            $data['main']= 'akademik/kepribadian/kepribadian';
            $this->load->view('layout/ad_blank',$data);
        }
		
        public function delete($id){
			$this->db->query('DELETE FROM ak_catatanguru WHERE id='.$id.'');
		}
        public function kepribadianlist(){
			$this->load->model('ad_kepribadian');
			$this->load->model('ad_aspek_kepribadian');
			
			
			if(isset($_POST['simpan'])){
				//pr($_POST);
				//die();
				foreach($_POST['data']['id'] as $key=>$datacatatan){ 	 
					$insert=array(
						'keterangan'=>$_POST['data']['keterangan'][$key]
					);
					$this->db->where('id',$_POST['data']['id'][$key]);
					$this->db->update('ak_catatanguru',$insert);
				}
				//echo $this->db->last_query()."<br />";
				//pr($_POST);
				foreach($_POST['data']['poin'] as $id_aspek=>$nilaipoint){ 
						foreach($nilaipoint as $id_nilai=>$nilai){
							if($id_nilai=='null'){ 	 
								$insert=array(
									'id_aspek_kepribaian'=>$id_aspek,
									'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
									'id_siswa_det_jenjang'=>$_POST['id_siswa_det_jenjang'],
									'ta'=>$this->session->userdata['ak_setting']['ta'],
									'semester'=>$this->session->userdata['ak_setting']['semester'],
									'point'=>$nilai
								);

								$this->db->insert('ak_nilai_kepribadian',$insert);							
							}else{						
								$update=array(
									/*'id_aspek_kepribaian'=>$id_aspek,
									'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
									'id_siswa_det_jenjang'=>$_POST['id_siswa_det_jenjang'],
									'ta'=>$this->session->userdata['ak_setting']['ta'],
									'semester'=>$this->session->userdata['ak_setting']['semester'],*/
									'point'=>$nilai
								);
								
								$this->db->where('id',$id_nilai);
								$this->db->update('ak_nilai_kepribadian',$update);
							}
					
						}
						
				}
			}
			
			$data['nilai']=$this->ad_aspek_kepribadian->getCurrentNilaiPoint(@$_POST['id_siswa_det_jenjang']);
			$data['aspek']=$this->ad_aspek_kepribadian->getAllAspekByIdSekolah($this->session->userdata['user_authentication']['id_sekolah']);
			//pr($data['aspek']);
			if(isset($_POST['id_kelas']) && isset($_POST['id_siswa_det_jenjang'])){
				$data['kepribadian']=$this->ad_kepribadian->getkepribadianByKelasIdPegawaiIdSiswaDetJenjang($_POST['id_kelas'],$_POST['id_siswa_det_jenjang']);
			}
            $data['main']= 'akademik/kepribadian/kepribadianlist';
            $this->load->view('layout/ad_blank',$data);
        }
		
        public function getOptionSiswaByIdKelas($id_kelas){
			$this->load->library('ak_siswa');
			$optionsiswa=$this->ak_siswa->createOptionSiswaByIdKelas($id_kelas);
			echo $optionsiswa;
        }
    }
?>