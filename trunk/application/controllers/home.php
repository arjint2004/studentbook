<?php
class Home extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->library('auth');
        $this->load->helper('global');
        $this->auth->user_logged_in();
    }
    
    public function login() {
		$this->load->view('homedata/login');
	}
    public function index() {
        $session = session_data();
        $group = $session['otoritas'];
        if(!empty($group)) {
            if($group=='siswa') {
                redirect('siswa');
            }elseif($group=='ortu') {
                redirect('ortu');
            }elseif($group=='admin sekolah'){
                redirect('admin/schooladmin');
            }elseif($group=='superadmin'){
                redirect('superadmin/super');
            }elseif($group=='admin'){
                redirect('adminsb/admin');
            }else{
                redirect('sos/pegawai');
            }
        }
    }
    
    
}
?>