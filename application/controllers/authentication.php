<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Authentication extends CI_Controller {
    function __construct()
    {
	parent::__construct();
	$this->load->model('auth_user');
    }
   
    public function index()
    {
        $user = $this->session->userdata('user');
        if ( !empty($user) )
            redirect();
    }
    
    public function auth($usernamein=null,$passwordin=null) {
        if(isset($_POST['username']) && isset($_POST['password'])){ 
			$username = $this->input->post('username');
			$password = $this->input->post('password');
		}elseif($usernamein!=null && $passwordin!=null){
			$username = $usernamein;
			$password = $passwordin;		
		}
		
        $user   = $this->auth_user->get_user($username,$password);
        $auth   = $this->auth_user->get_auth($username,$password);
		
        if (!empty($user)) {
			$this->load->model('ad_setting');
			$this->load->model('ad_kelas');
			$this->load->model('ad_sekolah');
			$kepsek=$this->ad_sekolah->getKepsek($user->id_sekolah);
			$settingSmTa   = $this->ad_setting->getTaSemesterAktif($user->id_sekolah);
			$fitursekolah   = $this->ad_setting->getFiturSekolah($user->id_sekolah);
			$jenjang=$this->ad_kelas->thisjenjang($user->id);
			
            $sessionsettings = array(
                'jenjang' => $jenjang,
                'semester' => $settingSmTa['semester']['id'],
                'semester_nama' => $settingSmTa['semester']['nama'],
                'ta' => $settingSmTa['ta']['id'],
                'ta_nama' => $settingSmTa['ta']['nama'],
                'ta_mulai' => $settingSmTa['ta']['mulai'],
                'nama_sekolah' => $user->nama_sekolah,
                'alamat_sekolah' => $user->alamat_sekolah,
                'logo_sekolah' => $user->logo,
                'ta_selesai' => $settingSmTa['ta']['selesai'],
                'fitursekolah' => $fitursekolah,
                'nama_kepsek' => $kepsek[0]['nama'],
                'id_kepsek' => $kepsek[0]['id']
            );
			
            $this->session->set_userdata('ak_setting', $sessionsettings);
			
			if($user->nama_peg ==''){
				$namapengguna=$user->nama_siswa;
			}elseif($user->nama_siswa == ''){
				$namapengguna=$user->nama_peg;
			}
			
			$detgroup=$this->auth_user->get_det_group($user->id);
			foreach($detgroup as $dtg){
				$detgroup2[]=$dtg['id_group'];
			}
			unset($detgroup);
			//pr($detgroup2);die();
            $sessiondata = array(
                'id' => $user->id,
                'id_group'=>$user->id_group,
                'id_pengguna'=>$user->id_pengguna,
                'id_sekolah'=>$user->id_sekolah,
                'username' => $user->username,
                'nama' => $namapengguna,
                'password'=>$user->password,
                'images'=>$user->images,
                'otoritas'=>$user->otoritas,
                'det_group'=>$detgroup2,
                'auth'=>$auth
            );
			
	    if($user->otoritas=='siswa' || $user->otoritas=='ortu'){
			if($user->id_siswa==0){$idsiswa=$user->id_pengguna;}else{$idsiswa=$user->id_siswa;}
		    $this->load->model('ad_siswa');
		    $siswa=$this->ad_siswa->getSiswaIdDetJenjang($user->id_sekolah,$settingSmTa['ta']['id'],$idsiswa);
		    $sessiondata['id_siswa_det_jenjang'] = $siswa[0]['id_siswa_det_jenjang'];
		    $sessiondata['id_kelas_siswa_det_jenjang'] = $siswa[0]['id_kelas_siswa_det_jenjang'];
		    $sessiondata['kelas'] = $siswa[0]['kelas'];
		    $sessiondata['nama_kelas'] = $siswa[0]['nama_kelas'];
		    $sessiondata['id_siswa'] = $idsiswa;
	    }
		//cek konek facebook
		
		/*if ($user->fb_id=='') {
			$this->load->library('ak_facebook');
			$userfbid=$this->ak_facebook->getuserid();
			//echo $userfbid;die();
			if ($userfbid) {
				$this->db->query("UPDATE users SET fb_id='".$userfbid."' WHERE id=".$user->id."");
				$sessiondata['fb_id'] = $userfbid;
			}
		} else {
			$sessiondata['fb_id'] = $user->fb_id;
		}*/	
		$sessiondata['fb_id'] = $user->fb_id;
        $this->session->set_userdata('user', $sessiondata);
	    $this->session->set_userdata('user_authentication', $sessiondata); 
			/* decide what the content should be up here .... */

			/* AJAX check  */
			
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
				/* special ajax here */
				echo 1;
				die();
			}
			/* not ajax, do more.... */

			//set_blue_notification('Welcome to Studentbook');
            //redirect('home');
			$session = session_data();
			$group = $session['otoritas'];
			if(!empty($group)) {
				if($group=='siswa') {
					redirect('siswa/mainsiswa');
				}elseif($group=='ortu') {
					redirect('siswa/mainsiswa');
				}elseif($group=='admin sekolah'){
					redirect('admin/schooladmin');
				}elseif($group=='superadmin'){
					redirect('superadmin/super');
				}elseif($group=='admin'){
					redirect('adminsb/admin');
				}else{
					redirect('akademik/mainakademik/index');
				}
			}
        } else {
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
				/* special ajax here */
				echo 0;
				die();
			}
			/* not ajax, do more.... */
            //set_red_notification('Password dan Username tidak terdaftar, mohon ulangi lagi');
			//print_notification();
			
			echo "<script>alert('Username atau Password anda tidak terdaftar');window.location='".base_url()."';</script>";
			
        }
    }
    
    public function logout() {
        $this->session->unset_userdata('user');
        $this->session->unset_userdata('setting_raport');
        $this->session->unset_userdata('ak_setting');
        $this->session->unset_userdata('det_group');
        $this->session->unset_userdata('user_authentication');
		session_destroy();
        //redirect('homepage');
		echo "<script>window.location = '".base_url()."';</script>";
    }
}
?>