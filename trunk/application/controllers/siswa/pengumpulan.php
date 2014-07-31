<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pengumpulan extends CI_Controller
    {
		var $upload_dir='upload/akademik/kumpul/';
		public $denied_mime_types = array('application/x-php','application/x-httpd-php', 'text/html', 'text/css', 'text/javascript'); //array of denied mime types used when check_file_type is set to denied
        public function __construct()
        {
            parent::__construct();
            $this->load->library('session');
            $this->load->library('auth');
            $this->auth->user_logged_in();
        }

        public function getDataDikumpul($id=0,$jenis='')
        {
            $this->load->model('ad_pengumpulan');
			$datadikumpul=$this->ad_pengumpulan->getdataByIdJenis($id,$this->session->userdata['user_authentication']['id_sekolah'],$jenis);
			foreach($datadikumpul as $datadikumpulkan){
			echo'
				<tr>
					<td class="title"><a>'.str_replace("upload/akademik/kumpul/".$this->session->userdata['user_authentication']['id_sekolah']."/".$jenis."/","",$datadikumpulkan['file']).'</a></td>
				</tr>
			';
			}
		}
        public function kumpulkanfile($id=0,$jenis='',$id_kelas=0)
        {
		
			if(isset($_FILES)){
			if(!empty($_FILES)){
				
				//cek folder exist
				$filename = $this->upload_dir.$this->session->userdata['user_authentication']['id_sekolah'].'/'.$jenis."/";
				
				if (!file_exists($filename)) {
					mkdir($filename, 0777, 1);
				}
				//pr($_FILES);
				//upload file
				foreach ($_FILES["file"]["error"] as $key => $error) {
					if ($error == UPLOAD_ERR_OK) {
						$name = date('Ymdhis').str_replace(" ","",$_FILES["file"]["name"][$key]);
						if(!in_array($_FILES["file"]["type"][$key], $this->denied_mime_types)){
							if(move_uploaded_file( $_FILES["file"]["tmp_name"][$key], $filename . $name)){
								$this->db->insert('ak_pengumpulan_'.$jenis.'', array('id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
																					 'id_siswa'=>$this->session->userdata['user_authentication']['id_pengguna'],
																					 'id_siswa_det_jenjang'=>$this->session->userdata['user_authentication']['id_siswa_det_jenjang'],
																					 'id_kelas'=>$id_kelas,
																					 'id_'.$jenis.''=>$id,
																					 'file'=>$filename.$name,
																					 'waktu'=>date('Y-m-d H:i:s')
																					 ));
							}
						}else{
							echo "Anda tidak diperbolehkan mengunggah file type ini. Silahkan edit data anda dan masukkan file yang benar.";
							die();
						}
						

						
					}
				}				
			}
			}

        }
    }
?>