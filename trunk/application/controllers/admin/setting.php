<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Setting extends CI_Controller {
    function __construct()
    {
		parent::__construct();
		$this->load->library('auth');
		$this->auth->logged_in();
    }
   
    public function aktifasitahunAjaran()
    {
		if($_POST['aktif']==1){
			$this->db->query('UPDATE ak_tahun_ajaran SET aktif=0 WHERE id='.$_POST['id'].' AND id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'');		
			$this->db->query('UPDATE ak_tahun_ajaran SET aktif=1 WHERE id!='.$_POST['id'].' AND id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'');		
		}
		if($_POST['aktif']==0){
			$this->db->query('UPDATE ak_tahun_ajaran SET aktif=1 WHERE id='.$_POST['id'].' AND id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'');		
			$this->db->query('UPDATE ak_tahun_ajaran SET aktif=0 WHERE id!='.$_POST['id'].' AND id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'');		
		}
		echo $this->db->last_query();
	}   
    public function aktifasiSemester()
    {
		if($_POST['aktif']==1){
			$this->db->query('UPDATE ak_semester SET aktif=0 WHERE id='.$_POST['id'].' AND id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'');		
			$this->db->query('UPDATE ak_semester SET aktif=1 WHERE id!='.$_POST['id'].' AND id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'');		
		}
		if($_POST['aktif']==0){
			$this->db->query('UPDATE ak_semester SET aktif=1 WHERE id='.$_POST['id'].' AND id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'');		
			$this->db->query('UPDATE ak_semester SET aktif=0 WHERE id!='.$_POST['id'].' AND id_sekolah='.$this->session->userdata['user_authentication']['id_sekolah'].'');		
		}
		
	}
    public function semestercekreg()
    { 	
		$this->load->model('ad_setting');
		$this->load->model('ad_kelas');
		$jenjang=$this->ad_kelas->thisjenjang($this->session->userdata['user_authentication']['id']);
        $data['semester'] 	= $this->ad_setting->getSemester($this->session->userdata['user_authentication']['id_sekolah']);
		if(empty($data['semester'])){
			$smdata='a:2:{i:0;a:3:{s:10:"id_sekolah";s:1:"1";s:4:"nama";s:6:"Ganjil";s:5:"aktif";s:1:"1";}i:1;a:3:{s:10:"id_sekolah";s:1:"1";s:4:"nama";s:5:"Genap";s:5:"aktif";s:1:"0";}}';
			$sminsert=unserialize($smdata);
			foreach($sminsert as $k=>$sm){
				$sm['id_sekolah']=$this->session->userdata['user_authentication']['id_sekolah'];
				$this->db->insert('ak_semester',$sm);
			}
			$this->db->where('id_sekolah',$this->session->userdata['user_authentication']['id_sekolah']);
			$this->db->update('ak_step_registrasi',array('set_tahun_ajaran'=>1,'set_semester'=>1,'set_jurusan'=>1));
			
			
			$settingSmTa   = $this->ad_setting->getTaSemesterAktif($this->session->userdata['user_authentication']['id_sekolah']);
			
			if($jenjang[0]['nama']=='SD' || $jenjang[0]['nama']=='SMP' || $jenjang[0]['nama']=='SMA'){
				$this->db->where('id_sekolah',$this->session->userdata['user_authentication']['id_sekolah']);
				$this->db->update('ak_step_registrasi',array('set_tahun_ajaran'=>1,'set_semester'=>1,'set_jurusan'=>1,'set_kelas'=>1));
			}else{
				$this->db->where('id_sekolah',$this->session->userdata['user_authentication']['id_sekolah']);
				$this->db->update('ak_step_registrasi',array('set_tahun_ajaran'=>1,'set_semester'=>1,'set_jurusan'=>1));
			}
			$this->load->model('ad_kelas');
			$jenjang=$this->ad_kelas->thisjenjang($this->session->userdata['user_authentication']['id']);
            $sessionsettings = array(
                'jenjang' => $jenjang,
                'semester' => $settingSmTa['semester']['id'],
                'ta' => $settingSmTa['ta']['id'],
                'ta_nama' => $settingSmTa['ta']['nama'],
                'ta_mulai' => $settingSmTa['ta']['mulai'],
                'ta_selesai' => $settingSmTa['ta']['selesai']
            );
            $this->session->set_userdata('ak_setting', $sessionsettings);
		}
		$data['semester'] 	= $this->ad_setting->getSemester($this->session->userdata['user_authentication']['id_sekolah']);
		$data['page_title'] 	= 'Data Semester';
		
	    if ($this->input->post('ajax')) {
		   $data['main'] 	= 'schooladmin/setting/semester'; // memilih view
		   $this->load->view('layout/ad_blank',$data); // memilih layout
		} else {
		   $data['main'] 	= 'schooladmin/setting/semester';// memilih view
		   $this->load->view('layout/ad_adminsekolah',$data);
		}
    }
	
    public function semester()
    { 	
		$this->load->model('ad_setting');
		
        $data['semester'] 	= $this->ad_setting->getSemester($this->session->userdata['user_authentication']['id_sekolah']);

		$data['page_title'] 	= 'Data Semester';
		
	    if ($this->input->post('ajax')) {
		   $data['main'] 	= 'schooladmin/setting/semester'; // memilih view
		   $this->load->view('layout/ad_blank',$data); // memilih layout
		} else {
		   $data['main'] 	= 'schooladmin/setting/semester';// memilih view
		   $this->load->view('layout/ad_adminsekolah',$data);
		}
    }
	
    public function addta()
    {
        $data['main'] 	= 'schooladmin/setting/addta';
		$data['page_title'] 	= 'Tambah Tahun Ajaran';
		$this->load->view('layout/ad_adminsekolah',$data);		
	}
	
    public function addaspek()
    {
		$data['page_title'] 	= 'Tambah Aspek Kepribadian';
		
		if(isset($_POST['addaspek'])){
			$insertarray=array(
							'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
							'nama'=>$_POST['nama']
						);
			$this->db->insert('ak_aspek_kepribadian',$insertarray);
		}
	    if ($this->input->post('ajax')) {
		   $data['main'] 	= 'schooladmin/setting/addaspek'; // memilih view
		   $this->load->view('layout/ad_blank',$data); // memilih layout
		} else {
		   $data['main'] 	= 'schooladmin/setting/addaspek';// memilih view
		   $this->load->view('layout/ad_adminsekolah',$data);
		}		
	}
	function deleteaspek($id_aspek=null)
	{
		$this->load->model('ad_setting');
		$freekelas=$this->ad_setting->getFreeAspek($id_aspek,$this->session->userdata['user_authentication']['id_sekolah']);
		if($freekelas==0){
			$this->db->query('DELETE FROM ak_aspek_kepribadian WHERE id='.$id_aspek.'');
		}
		echo $freekelas;
		//return $freekelas;
	}
    public function aspekkepribadian()
    {
		$data['page_title'] 	= 'Aspek Kepribadian';
		$this->load->model('ad_setting');
		if(isset($_POST['simpleupdate'])){
			$dataupdate=$_POST;
			$dataupdate['id']=$_POST['id_aspek'];
			unset($dataupdate['id_aspek']);
			unset($dataupdate['ajax']);
			unset($dataupdate['simpleupdate']);
			$this->db->where('id', $_POST['id_aspek']);
			$this->db->update('ak_aspek_kepribadian', $dataupdate);
		}
		$aspek=$this->ad_setting->getaspek($this->session->userdata['user_authentication']['id_sekolah']);
		$data['aspekkepribadian']=$aspek;
	    if ($this->input->post('ajax')) {
		   $data['main'] 	= 'schooladmin/setting/aspekkepribadian'; // memilih view
		   $this->load->view('layout/ad_blank',$data); // memilih layout
		} else {
		   $data['main'] 	= 'schooladmin/setting/aspekkepribadian';// memilih view
		   $this->load->view('layout/ad_adminsekolah',$data);
		}		
	}
    public function tahunAjaran()
    {
		$this->load->model('ad_setting');
		
        $data['tahunAjaran'] 	= $this->ad_setting->getTa($this->session->userdata['user_authentication']['id_sekolah']);

		$data['page_title'] 	= 'Data Tahun Ajaran';
		
	    if ($this->input->post('ajax')) {
		   $data['main'] 	= 'schooladmin/setting/ta'; // memilih view
		   $this->load->view('layout/ad_blank',$data); // memilih layout
		} else {
		   $data['main'] 	= 'schooladmin/setting/ta';// memilih view
		   $this->load->view('layout/ad_adminsekolah',$data);
		}	        
    }
    public function tahunAjarancekreg()
    {
		$tadata='a:32:{i:0;a:4:{s:4:"nama";s:9:"2010/2011";s:5:"mulai";s:10:"2010-07-01";s:7:"selesai";s:10:"2011-07-01";s:5:"aktif";s:1:"0";}i:1;a:4:{s:4:"nama";s:9:"2011/2012";s:5:"mulai";s:10:"2011-07-01";s:7:"selesai";s:10:"2012-07-01";s:5:"aktif";s:1:"0";}i:2;a:4:{s:4:"nama";s:9:"2012/2013";s:5:"mulai";s:10:"2012-07-01";s:7:"selesai";s:10:"2013-07-01";s:5:"aktif";s:1:"0";}i:3;a:4:{s:4:"nama";s:9:"2013/2014";s:5:"mulai";s:10:"2013-07-01";s:7:"selesai";s:10:"2014-07-01";s:5:"aktif";s:1:"0";}i:4;a:4:{s:4:"nama";s:9:"2014/2015";s:5:"mulai";s:10:"2014-07-01";s:7:"selesai";s:10:"2015-07-01";s:5:"aktif";s:1:"0";}i:5;a:4:{s:4:"nama";s:9:"2015/2016";s:5:"mulai";s:10:"2015-07-01";s:7:"selesai";s:10:"2016-07-01";s:5:"aktif";s:1:"0";}i:6;a:4:{s:4:"nama";s:9:"2016/2017";s:5:"mulai";s:10:"2016-07-01";s:7:"selesai";s:10:"2017-07-01";s:5:"aktif";s:1:"0";}i:7;a:4:{s:4:"nama";s:9:"2017/2018";s:5:"mulai";s:10:"2017-07-01";s:7:"selesai";s:10:"2018-07-01";s:5:"aktif";s:1:"0";}i:8;a:4:{s:4:"nama";s:9:"2018/2019";s:5:"mulai";s:10:"2018-07-01";s:7:"selesai";s:10:"2019-07-01";s:5:"aktif";s:1:"0";}i:9;a:4:{s:4:"nama";s:9:"2019/2020";s:5:"mulai";s:10:"2019-07-01";s:7:"selesai";s:10:"2020-07-01";s:5:"aktif";s:1:"0";}i:10;a:4:{s:4:"nama";s:9:"2020/2021";s:5:"mulai";s:10:"2020-07-01";s:7:"selesai";s:10:"2021-07-01";s:5:"aktif";s:1:"0";}i:11;a:4:{s:4:"nama";s:9:"2021/2022";s:5:"mulai";s:10:"2021-07-01";s:7:"selesai";s:10:"2022-07-01";s:5:"aktif";s:1:"0";}i:12;a:4:{s:4:"nama";s:9:"2022/2023";s:5:"mulai";s:10:"2022-07-01";s:7:"selesai";s:10:"2023-07-01";s:5:"aktif";s:1:"0";}i:13;a:4:{s:4:"nama";s:9:"2023/2024";s:5:"mulai";s:10:"2023-07-01";s:7:"selesai";s:10:"2024-07-01";s:5:"aktif";s:1:"0";}i:14;a:4:{s:4:"nama";s:9:"2024/2025";s:5:"mulai";s:10:"2024-07-01";s:7:"selesai";s:10:"2025-07-01";s:5:"aktif";s:1:"0";}i:15;a:4:{s:4:"nama";s:9:"2025/2026";s:5:"mulai";s:10:"2025-07-01";s:7:"selesai";s:10:"2026-07-01";s:5:"aktif";s:1:"0";}i:16;a:4:{s:4:"nama";s:9:"2026/2027";s:5:"mulai";s:10:"2026-07-01";s:7:"selesai";s:10:"2027-07-01";s:5:"aktif";s:1:"0";}i:17;a:4:{s:4:"nama";s:9:"2027/2028";s:5:"mulai";s:10:"2027-07-01";s:7:"selesai";s:10:"2028-07-01";s:5:"aktif";s:1:"0";}i:18;a:4:{s:4:"nama";s:9:"2028/2029";s:5:"mulai";s:10:"2028-07-01";s:7:"selesai";s:10:"2029-07-01";s:5:"aktif";s:1:"0";}i:19;a:4:{s:4:"nama";s:9:"2029/2030";s:5:"mulai";s:10:"2029-07-01";s:7:"selesai";s:10:"2030-07-01";s:5:"aktif";s:1:"0";}i:20;a:4:{s:4:"nama";s:9:"2030/2031";s:5:"mulai";s:10:"2030-07-01";s:7:"selesai";s:10:"2031-07-01";s:5:"aktif";s:1:"0";}i:21;a:4:{s:4:"nama";s:9:"2031/2032";s:5:"mulai";s:10:"2031-07-01";s:7:"selesai";s:10:"2032-07-01";s:5:"aktif";s:1:"0";}i:22;a:4:{s:4:"nama";s:9:"2032/2033";s:5:"mulai";s:10:"2032-07-01";s:7:"selesai";s:10:"2033-07-01";s:5:"aktif";s:1:"0";}i:23;a:4:{s:4:"nama";s:9:"2033/2034";s:5:"mulai";s:10:"2033-07-01";s:7:"selesai";s:10:"2034-07-01";s:5:"aktif";s:1:"0";}i:24;a:4:{s:4:"nama";s:9:"2034/2035";s:5:"mulai";s:10:"2034-07-01";s:7:"selesai";s:10:"2035-07-01";s:5:"aktif";s:1:"0";}i:25;a:4:{s:4:"nama";s:9:"2035/2036";s:5:"mulai";s:10:"2035-07-01";s:7:"selesai";s:10:"2036-07-01";s:5:"aktif";s:1:"0";}i:26;a:4:{s:4:"nama";s:9:"2036/2037";s:5:"mulai";s:10:"2036-07-01";s:7:"selesai";s:10:"2037-07-01";s:5:"aktif";s:1:"0";}i:27;a:4:{s:4:"nama";s:9:"2037/2038";s:5:"mulai";s:10:"2037-07-01";s:7:"selesai";s:10:"2038-07-01";s:5:"aktif";s:1:"0";}i:28;a:4:{s:4:"nama";s:9:"2038/2039";s:5:"mulai";s:10:"2038-07-01";s:7:"selesai";s:10:"2039-07-01";s:5:"aktif";s:1:"0";}i:29;a:4:{s:4:"nama";s:9:"2039/2040";s:5:"mulai";s:10:"2039-07-01";s:7:"selesai";s:10:"2040-07-01";s:5:"aktif";s:1:"0";}i:30;a:4:{s:4:"nama";s:9:"2040/2041";s:5:"mulai";s:10:"2040-07-01";s:7:"selesai";s:10:"2041-07-01";s:5:"aktif";s:1:"0";}i:31;a:4:{s:4:"nama";s:9:"2041/2042";s:5:"mulai";s:10:"2041-07-01";s:7:"selesai";s:10:"2042-07-01";s:5:"aktif";s:1:"0";}}';
		
		$this->load->model('ad_setting');
        $data['tahunAjaran'] 	= $this->ad_setting->getTa($this->session->userdata['user_authentication']['id_sekolah']);
		if(empty($data['tahunAjaran'])){
			$tainsert=unserialize($tadata);
			foreach($tainsert as $k=>$d){
				$d['id_sekolah']=$this->session->userdata['user_authentication']['id_sekolah'];
				$th=explode("-",$d['mulai']);
				if($th[0]==date('Y')){
					$d['aktif']=1;
				}
				$this->db->insert('ak_tahun_ajaran',$d);
			}
			$this->db->where('id_sekolah',$this->session->userdata['user_authentication']['id_sekolah']);
			$this->db->update('ak_step_registrasi',array('set_tahun_ajaran'=>1,'set_semester'=>1));
			
			
			$settingSmTa   = $this->ad_setting->getTaSemesterAktif($this->session->userdata['user_authentication']['id_sekolah']);
			
            $sessionsettings = array(
                'semester' => $settingSmTa['semester']['id'],
                'ta' => $settingSmTa['ta']['id'],
                'ta_nama' => $settingSmTa['ta']['nama'],
                'ta_mulai' => $settingSmTa['ta']['mulai'],
                'ta_selesai' => $settingSmTa['ta']['selesai']
            );
            $this->session->set_userdata('ak_setting', $sessionsettings);
			//$this->db->update('ak_step_registrasi',array('set_tahun_ajaran'=>1,'set_semester'=>0,'set_jurusan'=>0,'set_kelas'=>0,'set_pelajaran'=>0,'set_pegawai'=>0,'set_profil_sekolah'=>0,'set_siswa'=>0,'set_akun'=>0));
		}
		$data['tahunAjaran'] 	= $this->ad_setting->getTa($this->session->userdata['user_authentication']['id_sekolah']);
		$data['page_title'] 	= 'Data Tahun Ajaran';
		
	    if ($this->input->post('ajax')) {
		   $data['main'] 	= 'schooladmin/setting/ta'; // memilih view
		   $this->load->view('layout/ad_blank',$data); // memilih layout
		} else {
		   $data['main'] 	= 'schooladmin/setting/ta';// memilih view
		   $this->load->view('layout/ad_adminsekolah',$data);
		}	        
    }

}
?>