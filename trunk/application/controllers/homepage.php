<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Homepage extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 
	 
	function __construct()
	{
		parent::__construct();
		$this->load->helper('global');

		#the models
		$this->load->model('ad_home', 'martikel');

		#the libraries
        $this->load->library('session');
	//parent::set_theme('new');
	}

	public function index($id_kat=0)
	{


		//$artikel= $this->martikel->get_artikel_by_rand();
		
		$this->load->model('ad_artikel');
		$data['artikelkat']=$this->ad_artikel->getkathomebyIdkat($id_kat);
		$data['rubrik']=$this->ad_artikel->getkathomeisslide();
		
		/*$data['slide']['box1']=array($artikel[0],$artikel[1],$artikel[2]);
		$data['slide']['box2']=array($artikel[3]);
		$data['slide']['box3']=array($artikel[4],$artikel[5],$artikel[6]);
		$data['slide']['box4']=array($artikel[7]);
		$data['slide']['box5']=array($artikel[8],$artikel[9],$artikel[10]);*/
		$data['page_title'] 	= 'StudentBook';
		$data['main']= 'layout/homepagealmera';
		$this->load->view('layout/ad_default',$data);
	}

	public function login()
    {
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
        }else{
		
		$data['main']= 'homedata/login';
        $this->load->view('layout/login',$data);
		}
    }
	public function logindcs()
    {
		$data['main']= 'homedata/logindcs';
        $this->load->view('layout/logindcs',$data);
    }

	function tentang_studentbook(){
		$data['main'] 	= 'homedata/tentang_studentbook';
		$data['page_title'] 	= 'Tentang Studentbook';
		$this->load->view('layout/ad_fullwidth',$data);
	}

	function kebijakan(){
		$this->load->view('homedata/kebijakan');
	}

	function ketentuan(){
		$this->load->view('homedata/ketentuan');		
	}

	function standar_etika(){
		$this->load->view('homedata/standar_etika');		
	}

	function iklan(){
		$this->load->view('homedata/iklan');		
	}

	function hubungi_kami(){
		if ($_POST){
        	$this->load->library('form_validation');

        	$data_pesan = array(
        		'id_kontak'		=> $this->input->post("id_kontak"),
        		'nama_peserta'		=> $this->input->post("nama_peserta"),
        		'email'		=> $this->input->post("email"),
        		'pesan'		=> $this->input->post("pesan"),
        		);

				// $this->pasien->insert_pasien($data_pasien);
				// redirect('pasien');
			$this->form_validation->set_rules('email', 'Email', 'required');
			$this->form_validation->set_rules('pesan', 'Pesan', 'required');
			if ($this->form_validation->run() == TRUE)
			{
				$this->home->contact_us($data_pesan);
				redirect('homepage');
			}
			else
			{
				redirect('homepage/hubungi_kami');
			}
		}else{
			$this->load->view('homedata/hubungi_kami');
		}
	}

	public function profile($id=null){
		$session = session_data();
        if($session){
            $data['siswa_edit']     = $this->siswamodel->edit_data_siswa($id);
            $data['siswa']          = $this->siswamodel->get_siswa($id);  
            $data['main']           = 'sosial/editsiswa';
            $this->load->view('layout/fr_default',$data);
        }else{
        	redirect('homepage/login');
            // $data['page_title'] = 'studentbook';
            // $this->load->view('layout/ad_login',$data);
        }
        
    }
	public function send_download($path='',$filename=null)
        {
			$filename=base64_decode($filename);
			$path=base64_decode($path);
			redirect(base_url($path.$filename));
			
			//$this->load->library('ak_file');
			//$this->ak_file->send_download($path,$filename);	
		}
	function cekusername($username=''){
		if(isset($_POST['username'])){
			$username=$_POST['username'];
		}
		$this->load->model('user');
		$status=$this->user->cekusername($username);
		//if($status>0){
		//	echo "Email sudah terdaftar";
		//}
		echo $status;
	}
	
	function sidebar(){
		$data['main']= 'homepage/sidebar';
		$this->load->view('layout/ad_blank',$data);
	}
}