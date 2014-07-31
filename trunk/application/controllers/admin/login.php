<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
    function __construct()
    {
      parent::__construct();
     // $this->load->model('auth');
    }
   
    public function index()
    {
        $user = $this->session->userdata('user_authentication');
        if ( !empty($user) )
            redirect('admin/schooladmin/');
        $data['page_title'] = 'studentbook';
        $this->load->view('schooladmin/loginadmin',$data);
    }
    
    public function auth() {
        $user   = $this->auth->get_user();
		
        if (!empty($user)) {
			$this->load->model('ad_setting');
			$settingSmTa   = $this->ad_setting->getTaSemesterAktif($user->id_sekolah);
			
            $sessionsettings = array(
                'semester' => $settingSmTa['semester']['id'],
                'ta' => $settingSmTa['ta']['id'],
                'ta_nama' => $settingSmTa['ta']['nama'],
                'ta_mulai' => $settingSmTa['ta']['mulai'],
                'ta_selesai' => $settingSmTa['ta']['selesai']
            );
            $this->session->set_userdata('ak_setting', $sessionsettings);
            $sessiondata = array(
                'id' => $user->id,
                'id_group' => $user->id_group,
                'id_sekolah' => $user->id_sekolah,
                'username' => $user->username,
                'images' => $user->images
            );
			
            $this->session->set_userdata('user_authentication', $sessiondata);//pr($this->session->userdata);die();
            redirect('admin/schooladmin/');
        } else {
            redirect('/');
        }
    }
    
    public function logout() {
        $this->session->unset_userdata('user_authentication');
        $this->session->unset_userdata('ak_setting');
        $this->session->unset_userdata('user');
		session_destroy();
        redirect('/');
    }
}
?>