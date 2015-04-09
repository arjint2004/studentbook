<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Raport extends CI_Controller {
    function __construct()
    {
		parent::__construct();
		$this->load->library('auth');
		$this->auth->logged_in();
    }
   
   function tanggal(){
		
		$this->load->model('ad_sekolah');
		$this->load->model('ad_setting');
		$id_sekolah=$this->session->userdata['user_authentication']['id_sekolah'];
		$setting=$this->ad_setting->getSetting('tanggal_raport',$id_sekolah);
		if(!empty($setting)){
			$settgl=unserialize($setting[0]['value']);
		}
			//echo $this->db->last_query();
			//pr($settgl);		
			//pr($_POST);
			//pr($settgl);
			
			//setting

			if(empty($setting)){
				unset($_POST['simpantglraport']);
				$settgl[0][$this->session->userdata['ak_setting']['ta']]=$_POST['tanggal_raport'][$this->session->userdata['ak_setting']['ta']];
				//insert;
				$inssetting=array(
							'id_sekolah'=>$id_sekolah,
							'key'=>'tanggal_raport_'.$id_sekolah,
							'value'=>serialize($settgl)
				);
	
				$this->db->insert('ak_setting',$inssetting);
				//echo $this->db->last_query().'<br />';
				//echo $_POST['tanggal_raport'].'<br />';
			}else{
				unset($_POST['simpantglraport']);
				$settgl[0][$this->session->userdata['ak_setting']['ta']]=$_POST['tanggal_raport'][$this->session->userdata['ak_setting']['ta']];
				//update
				$this->db->where(array('id_sekolah'=>$id_sekolah,'key'=>'tanggal_raport_'.$id_sekolah));
				$this->db->update('ak_setting',array('value'=>serialize($settgl)));
				//echo $this->db->last_query().'<br />';
				//echo $_POST['tanggal_raport'].'<br />';
			}
			redirect('admin/raport/setting');

   }
   function setting(){
		$this->load->model('ad_setting');
		$this->session->unset_userdata('setting_raport');
		
		$tampilanyes=array('akademik_kkm'=>1,
						'akademik_pengetahuan'=>1,
						'akademik_praktik'=>1,
						'akademik_afektif'=>1,
						'akademik_ketercapaian'=>1,
						'kepribadian_poin'=>1,
						'kepribadian_keterangan'=>1,
						'ekstrakurikuler_nilai'=>1,
						'ekstrakurikuler_keterangan'=>1
						);
		$tampilanno=array('akademik_kkm'=>0,
						'akademik_pengetahuan'=>0,
						'akademik_praktik'=>0,
						'akademik_afektif'=>0,
						'akademik_ketercapaian'=>0,
						'kepribadian_poin'=>0,
						'kepribadian_keterangan'=>0,
						'ekstrakurikuler_nilai'=>0,
						'ekstrakurikuler_keterangan'=>0
						);
		if(isset($_POST['select_all']) && $_POST['select_all']==1){
			$tampilan=$tampilanyes;
		}else{
			$tampilan=$tampilanno;
		}
		
		//RUMUS RAPORT
		$rumus=array('rumus_raport'=>'((25/100) * $UAS)+((25/100) * $UTS)+((20/100) * $PR)+((20/100) * $TUGAS)+((10/100) * $HARIAN)');
		if(isset($_POST['rumus_raport'])){$rumus=array('rumus_raport'=>$_POST['rumus_raport']);}
		$rumusraport=$this->ad_setting->getSetting('rumusraport',$this->session->userdata['user_authentication']['id_sekolah']);
		@$rumusraport2[0]['value']=unserialize(@$rumusraport[0]['value']);
		$insertrumus=array(
				'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
				'key'=>'rumusraport_'.$this->session->userdata['user_authentication']['id_sekolah'].'',
				'value'=>serialize($rumus)
		);
		//echo $this->db->last_query();
		if(isset($_POST['simpanrumus'])){
			if(empty($rumusraport)){
				$this->db->insert('ak_setting',$insertrumus);
				//echo $this->db->last_query();
			}else{
				$cond = array('key' => 'rumusraport_'.$this->session->userdata['user_authentication']['id_sekolah'].'', 'id_sekolah' => $this->session->userdata['user_authentication']['id_sekolah']);
				$this->db->where($cond);
				$this->db->update('ak_setting',$insertrumus);
				//echo $this->db->last_query();
				$rumusraport=$this->ad_setting->getSetting('rumusraport',$this->session->userdata['user_authentication']['id_sekolah']);
				@$rumusraport2[0]['value']=unserialize(@$rumusraport[0]['value']);
			}
		}	
		//pr($rumusraport2);
		
		$setingraport=$this->ad_setting->getSetting('showraportelemen',$this->session->userdata['user_authentication']['id_sekolah']);
		$setingraport2=$setingraport;
		@$setingraport2[0]['value']=unserialize(@$setingraport2[0]['value']);
		$insert=array(
				'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
				'key'=>'showraportelemen_'.$this->session->userdata['user_authentication']['id_sekolah'].'',
				'value'=>serialize($tampilan)
			);
		if(isset($_POST['show_all'])){
			
			
			if(empty($setingraport)){
				$this->db->insert('ak_setting',$insert);
			}else{
				$cond = array('key' => 'showraportelemen_'.$this->session->userdata['user_authentication']['id_sekolah'].'', 'id_sekolah' => $this->session->userdata['user_authentication']['id_sekolah']);
				$this->db->where($cond);
				$this->db->update('ak_setting',$insert);
				$setingraport=$this->ad_setting->getSetting('showraportelemen',$this->session->userdata['user_authentication']['id_sekolah']);
				$setingraport2=$setingraport;
				@$setingraport2[0]['value']=unserialize(@$setingraport2[0]['value']);
			}
			
			
		}elseif(isset($_POST['val'])){
			if($_POST['val']==0){
				$setingraport2[0]['value'][$_POST['name']]=1;
			}elseif($_POST['val']==1){
				$setingraport2[0]['value'][$_POST['name']]=0;
			}
			//pr($setingraport);echo $this->db->last_query();
			//pr($setingraport2[0]['value']);
			if(empty($setingraport)){
				$this->db->insert('ak_setting',$insert);
			}else{
				$update=array(
					'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
					'key'=>'showraportelemen_'.$this->session->userdata['user_authentication']['id_sekolah'].'',
					'value'=>serialize($setingraport2[0]['value'])
				);
				$cond = array('key' => 'showraportelemen_'.$this->session->userdata['user_authentication']['id_sekolah'].'', 'id_sekolah' => $this->session->userdata['user_authentication']['id_sekolah']);
				$this->db->where($cond);
				$this->db->update('ak_setting',$update);
			}
		}
		if(!empty($setingraport2)){
			$data['setting']=$setingraport2[0]['value'];
		}
		if(!empty($rumusraport2)){
			$data['rumus_raport']=$rumusraport2[0]['value'];
		}
		$setting_tanggal=$this->ad_setting->getSetting('tanggal_raport',$this->session->userdata['user_authentication']['id_sekolah']);
		$data['setting_tanggal']=unserialize($setting_tanggal[0]['value']);
   	    if ($this->input->post('ajax')) {
		   $data['main'] 	= 'schooladmin/raport/setting'; // memilih view
		   $this->load->view('layout/ad_blank',$data); // memilih layout
		} else {
		   $data['main'] 	= 'schooladmin/raport/setting';// memilih view
		   $this->load->view('layout/ad_adminsekolah',$data);
		}	
   }
    public function setkenaikanindex()
    {
		$this->load->model('ad_kelas');
		$data['kelas'] 	=$this->ad_kelas->getkelas($this->session->userdata['user_authentication']['id_sekolah']);
		$data['main']= 'schooladmin/raport/setkenaikanindex';
		$this->load->view('layout/ad_adminsekolah',$data);	
	}
    public function setkenaikan($id_kelas=null)
        {
			$siswa2=array();
			$this->load->model('ad_siswa');
			$this->load->model('ad_kelas');
			


			$jenjangbykelas=$this->ad_kelas->getJenjangByIdKelas(@$_POST['id_kelas']);
			$siswa=$this->ad_siswa->getsiswaByIdKelas(@$_POST['id_kelas']);
			foreach($siswa as $siswadata){
				$siswa2[$siswadata['id']]=$siswadata;
			}
			
			//indentify naik atau lulus
			switch($this->session->userdata['ak_setting']['jenjang'][0]['nama']){
				case"SD":
					
					if($jenjangbykelas[0]['kelas']==6){
						$set="kelulusan";
					}else{
						$set="kenaikan";
					}
					
				break;
				case"SMP":
					if($jenjangbykelas[0]['kelas']==9){
						$set="kelulusan";
					}else{
						$set="kenaikan";
					}
				
				break;
				case"SMA":
					if($jenjangbykelas[0]['kelas']==12){
						$set="kelulusan";
					}else{
						$set="kenaikan";
					}
				
				break;
				case"SMK":
					if($jenjangbykelas[0]['kelas']==12){
						$set="kelulusan";
					}else{
						$set="kenaikan";
					}
				break;
			}
			

			if($set=='kelulusan'){
				$datakelulusan2=array();
				$datakelulusan=$this->ad_siswa->getKelulusanByIdKelasTa(@$_POST['id_kelas']);
				foreach($datakelulusan as $datakelulusanrow){
					$datakelulusan2[$datakelulusanrow['id_siswa']]=$datakelulusanrow;
				}
				//pr($datakelulusan2);
				$data['datakelulusan']= $datakelulusan2;
			}elseif($set=='kenaikan'){
				$this->load->model('ad_setting');
				$nextTa=$this->ad_setting->getNextTa($this->session->userdata['ak_setting']['ta']);
				$kls2=$this->ad_kelas->getnextkelas($this->session->userdata['user_authentication']['id_sekolah'],@$_POST['id_kelas']);
				//pr($kls2);
				$siswasudahnaik=$this->ad_siswa->getSiswaTaBerikut($nextTa[0]['id'],@$_POST['id_kelas']);
				$siswasudahnaik2=array();
				foreach($siswasudahnaik as $siswadatanaik){
					$siswasudahnaik2[$siswadatanaik['id']]=$siswadatanaik;
				}	
				$data['kelasuntuknaik']= $kls2;
				$data['siswasudahnaik']= $siswasudahnaik2;				
			}
			
			//kenaikan proses
			if(isset($_POST['kelasuntuknaik'])){
				
				foreach($_POST['kelasuntuknaik'] as $id_siswa=>$id_kelasNaik){	 	 	 	 	 	
					$detjenjangInsert=array(
										'id_sekolah'=>$this->session->userdata['user_authentication']['id_sekolah'],
										'id_ta'=>$nextTa[0]['id'],
										'id_siswa'=>$id_siswa,
										'id_kelas'=>$id_kelasNaik,
										'parent_kelas'=>$_POST['id_kelas'],
										'kelulusan'=>0
					);
					if(isset($siswasudahnaik2[$id_siswa])){
						$this->db->where('id',$siswasudahnaik2[$id_siswa]['id_siswa_det_jenjang']);
						$this->db->update('ak_det_jenjang',$detjenjangInsert);
					}else{
						$this->db->insert('ak_det_jenjang',$detjenjangInsert);
					}
					//echo $this->db->last_query()."<br />";
					
				}
			//kelulusan proses
			}elseif(isset($_POST['kelulusan'])){
				foreach($_POST['kelulusan'] as $id_siswa=>$kelulusan){
					$this->db->query('UPDATE ak_det_jenjang SET kelulusan='.$kelulusan.' WHERE id_siswa='.$id_siswa.' AND id_ta='.$this->session->userdata['ak_setting']['ta'].'');
				}
				
			}
			

			$data['set']= $set;
			$data['siswa']= $siswa2;
			$data['main']= 'schooladmin/raport/setkenaikan';
            $this->load->view('layout/ad_blank',$data);	
		} 

}
?>