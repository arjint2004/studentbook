<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sms extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url','form','file'));
        $this->load->library(array('session','email','smsprivate'));
    }

    public function index()
    {	$this->load->model('ad_sekolah');
		$this->load->model('ad_setting');
		$pulsa=$this->ad_sekolah->getSekolahdata($this->session->userdata['user_authentication']['id_sekolah'],array('jml_pulsa'));
		$data['jml_sms']=$pulsa[0]['jml_pulsa']/100;
		/*if(isset($_POST['untuk'])){ 
		pr(json_decode(base64_decode($_POST['untuk'][0])));
		}*/
 
		if(isset($_POST['pesan']) && isset($_POST['kirim'])){
			$setting=$this->ad_setting->getSetting('sms_modem',$this->session->userdata['user_authentication']['id_sekolah']);
			$modem=unserialize($setting[0]['value']);
			foreach($_POST['untuk'] as $datauntuks){
				$datauntuk=base64_decode($datauntuks);
				$datauntuk=json_decode($datauntuk,true);
				
				if($_POST['kepada']=='orangtua'){
					$id_user=$datauntuk['id_ortu'];
					//create IN
					if(strlen($datauntuk['hp'])>10){
						$inser_sms=array('nama'=>$datauntuk['nama'],
							 'no_hp'=>$datauntuk['hp'],
							 'pesan'=>$_POST['pesan'],
							 'jenis'=>'sms_broadcast',
							 'waktu'=> date('Y-m-d H:i:s')
						);
					}
					unset($datauntuk);
				}elseif($_POST['kepada']=='guru'){
					$id_user=$datauntuk['id_user'];
					if(strlen($datauntuks)>10){
						$inser_sms=array('nama'=>$datauntuk['nama'],
							 'no_hp'=>$datauntuk['hp'],
							 'pesan'=>$_POST['pesan'],
							 'jenis'=>'sms_broadcast',
							 'waktu'=> date('Y-m-d H:i:s')
						);
					}
					//pr($datauntuk);
					unset($datauntuks);
				}
				//pr($id_user);die();
				if(!empty($inser_sms)){					
				if($inser_sms['no_hp']!='' && strlen($inser_sms['no_hp'])>8){
						//pr($inser_sms['no_hp']);
						if($pulsa[0]['jml_pulsa']>100){
							/*$this->smsprivate->setTo($inser_sms['no_hp']);
							$this->smsprivate->setText($inser_sms['pesan']);
							$sts=$this->smsprivate->send();*/
							if($inser_sms['no_hp']!='' && strlen($inser_sms['no_hp'])>8){
								if(!isset($modem[0]) || $modem[0]==''){$modem[0]='';}
								$insert_sms=array(
												'nama_siswa'=>'',
												'no_hp'=>''.$inser_sms['no_hp'].'',
												'pesan'=>$inser_sms['pesan']." ".base_url()."u/".base64_encode($id_user)." \n@".$this->session->userdata['ak_setting']['nama_sekolah'],
												'jenis'=>$inser_sms['jenis'],
												'id_jenis'=>0,
												'id_kelas'=>0,
												'id_pegawai'=>0,
												'kelas'=>0,
												'waktu'=>date('Y-m-d H:i:s'),
												'SenderID'=>$modem[0]
								);
								//pr($insert_sms);die();
								$this->db->insert('ak_sms',$insert_sms);
								$stsn[0]='0';
								//echo $this->db->last_query();
								//die();
							}
							//$stsn=explode("=",$sts);
							if($stsn[0]=='0'){
								$this->db->query("UPDATE `ak_sekolah` SET `jml_pulsa` = jml_pulsa-100 WHERE `id` = ? ",array($this->session->userdata['user_authentication']['id_sekolah']));
								$data['status'][$inser_sms['nama']]='Terkirim';
							}else{
								$data['status'][$inser_sms['nama']]='SMS Error (Tidak Terkirim) / No HP salah';
							}
						}else{
							$data['status'][$inser_sms['nama']]='Pulsa tinggal '.$pulsa[0]['jml_pulsa'].' tidak cukup untuk mengirim sms';
						}
					}				}
				unset($inser_sms);
			}
		}
		$data['main'] 	= 'schooladmin/sms/index';// memilih view
		$this->load->view('layout/ad_adminsekolah',$data);	
	}
    public function welcome()
    { 
		$this->load->model('ad_siswa');
		$siswa=$this->ad_siswa->getsiswaByIdSekTa('ap.nama as nama_ortu,s.nama,ap.hp,u.id as id_user');
		//pr($siswa);
		//$tmp='Selamat Bergabung di Sekolah Digital '.strtoupper($this->session->userdata['ak_setting']['nama_sekolah']).' Anda akan menerima notifikasi tentang progress akademik putra/i Anda dari nomor ini';
		$tmp='Informasi Akademik Ananda ';

		foreach($siswa as $datasiswa){
			//$tmpx =$tmp.strtoupper($datasiswa['nama']).'. '.base_url().' Username: '.$datasiswa['username'].' Password: '.$datasiswa['password'].' @'.strtoupper($this->session->userdata['ak_setting']['nama_sekolah']).'';
			$tmpx =$tmp.strtoupper($datasiswa['nama']).'. Bisa Dilihat di '.base_url().'u/'.base64_encode($datasiswa['id_user']).' atau login dengan akun yang sudah diinformasikan. Ingatkan kami "Bp/Ibu Guru" untuk selalu memberikan informasi melalui STUDENTBOOK @'.strtoupper($this->session->userdata['ak_setting']['nama_sekolah']).'';
			echo $tmpx.'<br />';
			$inser_sms=array('no_hp'=>$datasiswa['hp'],
							 'pesan'=>$tmpx,
							 'jenis'=>'sms_broadcast',
							 'waktu'=> date('Y-m-d H:i:s')
						);
			//pr($inser_sms);			
			//$this->db->insert('ak_sms',$inser_sms);
		}
		//pr($siswa);
	}
    public function sendguru()
    { 
		$this->load->model('pegawaimodel');
        $guru=$this->pegawaimodel->getGuruByIdSekolah($this->session->userdata['user_authentication']['id_sekolah']);
		$tmp='selalu menggunakan studentbook. Banyak WALI/ORTU SISWA yang menanyakan informasi di STUDENTBOOK. Buka link';
			
		foreach($guru as $dataguru){
			//$tmpx =$tmp.strtoupper($dataguru['nama']).'. www.studentbook.co Username: '.$dataguru['username'].' Password: '.$dataguru['password'].' @'.strtoupper($this->session->userdata['ak_setting']['nama_sekolah']).'';
			$tmpx ='Mohon Bp/Ibu '.strtoupper($dataguru['nama']).' '.$tmp.' '.base_url().'u/'.base64_encode($dataguru['id']).' Jika gagal login dengan Username: '.$dataguru['username'].' Password: '.$dataguru['password'].'';
			echo $tmpx.'<br />';
			$inser_sms=array('no_hp'=>$dataguru['hp'],
							 'pesan'=>$tmpx,
							 'jenis'=>'sms_broadcast',
							 'waktu'=> date('Y-m-d H:i:s')
						);
			pr($inser_sms);		
			$this->db->insert('ak_sms',$inser_sms);
		}
		
	}
	
    public function getAllGuru()
    {
		$this->load->library('ak_pegawai');
		 $siswa=$this->ak_pegawai->createOptionGuruByIdSekolahHp2($this->session->userdata['user_authentication']['id_sekolah']);
		
		echo $siswa;
	}
    public function menu()
    {
		if ($this->input->post('ajax')) {
			$data['main'] 	= 'schooladmin/sms/menu'; // memilih view
			$this->load->view('layout/ad_blank',$data); // memilih layout
		} else {
			$data['main'] 	= 'schooladmin/sms/menu';// memilih view
			$this->load->view('layout/ad_adminsekolah',$data);
		}
	}
    public function sendername()
    {
		if(isset($_POST['sendername'])){
			$this->db->where(array('id'=>$this->session->userdata['user_authentication']['id_sekolah']));
			$this->db->update('ak_sekolah',array('sendername'=>$_POST['sendername']));
		}
			//echo $this->db->last_query();
			$this->load->model('ad_sekolah');
			$data['sendername']=$this->ad_sekolah->getSekolahdata($this->session->userdata['user_authentication']['id_sekolah'],array('sendername','aktifasisendername'));
		if ($this->input->post('ajax')) {
			$data['main'] 	= 'schooladmin/sms/sendername'; // memilih view
			$this->load->view('layout/ad_blank',$data); // memilih layout
		} else {
			$data['main'] 	= 'schooladmin/sms/sendername';// memilih view
			$this->load->view('layout/ad_adminsekolah',$data);
		}
	}
    public function indexold()
    {
		$response='';
        if(isset($_POST['kirimsms'])) {
			if($_POST['password']=='studentbookjoss') {
            //echo 'pos ada';exit;
            // load library
            $this->load->library('nexmo');
            // set response format: xml or json, default json
            $this->nexmo->set_format('json');
            
            // **********************************Text Message*************************************
            $phone  = str_replace(" ","",$this->input->post('phone'));
            $jumlah = $this->input->post('jumlah'); 
            $phone = explode(',',$phone);
            if(is_array($phone)) {
                foreach($phone as $no) {
                    for($i=1;$i<=$jumlah;$i++) {
                        $from = $this->input->post('from');
                        $to = $no;
                        $pesan = $this->input->post('pesan');
                        $message = array(
                            'text' => $pesan
                        );
                        $response = $this->nexmo->send_message($from, $to, $message);
                        //echo "<h1>Text Message</h1>";
                        //$this->nexmo->d_print($response);
                        //echo "<h3>Response Code: " . $this->nexmo->get_http_status() . "</h3>";   
						$data['response']=$response;
                    }    
                }
            }
            }else{
				$data['response']="Password Salah";
			}
        }
			$this->load->model('ad_sekolah');
			$sendername=$this->ad_sekolah->getSekolahdata($this->session->userdata['user_authentication']['id_sekolah'],array('sendername','aktifasisendername'));
			//pr($sendername);
			if($sendername[0]['aktifasisendername']==0 || $sendername[0]['sendername']==''){
				$data['sendername']='STUDENTBOOK';
			}else{
				$data['sendername']=$sendername[0]['sendername'];
			}
			if ($this->input->post('ajax')) {
			   $data['main'] 	= 'schooladmin/sms/viewnexmo'; // memilih view
			   $this->load->view('layout/ad_blank',$data); // memilih layout
			} else {
			   $data['main'] 	= 'schooladmin/sms/viewnexmo';// memilih view
			   $this->load->view('layout/ad_adminsekolah',$data);
			}
    }
}

