<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Comment extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->model('Commentmodel');
            $this->load->library('session');
            $this->load->library('ak_notifikasi');
           // $this->load->library('auth');
            //$this->auth->user_logged_in();
        }
        
        public function index($id=null,$first=null,$jenis=''){
		
		if($id!=null){
			$data['comment']=$this->Commentmodel->getcomment($id,$jenis);
			
		}
		if(!empty($data['comment'])){
			
			foreach($data['comment'] as $idhis=>$datahis){
				
				$data['comment'][$idhis]['reply']=$this->Commentmodel->getcommentreply($datahis['id']);
			}
		}
		foreach($data['comment'] as $ky=>$dt){
				if($dt['id_group']==12){
					$id_siswa[]=$dt['id_user'];
				}else{
					$id_pegawai[]=$dt['id_user'];
				}
				$data['comment'][$ky]['date']=$this->getday($dt['date']);
			foreach($dt['reply'] as $ky1=>$dt1){
				if($dt1['id_group']==12){
					$id_siswa[]=$dt1['id_user'];
				}else{
					$id_pegawai[]=$dt1['id_user'];
				}
				$data['comment'][$ky]['reply'][$ky1]['date']=$this->getday($dt1['date']);
			}
		}
		//echo "<pre>";
		//pr($id_siswa);		
		//pr($id_pegawai);
		
		//dapatkan foto
		$foto=$this->Commentmodel->getcommentfoto($id_siswa,$id_pegawai);
		//pr($foto);
		//echo "</pre>";
		//echo $this->getday();
		$data['first']=$first;
		$data['jenis']=$jenis;
		$data['foto']=$foto;
		$data['id']=$id;
		$data['main']= 'akademik/comment/index';
		if(isAjax()){
			$this->load->view('layout/ad_blank',$data);
		}else{
			$this->load->view('layout/ad_adminsekolah',$data);			
		}

		}
		public function getday($date=null){
				$date22=explode(" ",$date);
				$tgl1 = $date22[0];  // 1 Oktober 2010
				$tgl2 = date("Y-m-d");  // 24 Oktober 2010

				$pecah1 = explode("-", $tgl1);
				$date1 = $pecah1[2];
				$month1 = $pecah1[1];
				$year1 = $pecah1[0];

				$pecah2 = explode("-", $tgl2);
				$date2 = $pecah2[2];
				$month2 = $pecah2[1];
				$year2 =  $pecah2[0];

				$jd1 = GregorianToJD($month1, $date1, $year1);
				$jd2 = GregorianToJD($month2, $date2, $year2);

				// hitung selisih hari kedua tanggal
				$selisih = $jd2 - $jd1;
				//echo $selisih;
				switch($selisih){
					case 0:
						return "Hari ini ".$this->getampm($date22[1]);
					break;
					case 1:
						return "Kemarin ".$this->getampm($date22[1]);
					break;
					default:
						$epldate=explode("-",$tgl1);
						return date("F j, Y", mktime(0, 0, 0, $epldate[1], $epldate[2], $epldate[0]))." ".$this->getampm($date22[1]);
					break;
				}
			}
		function getampm($beforetime){
			// Make it into a Unix TimeStamp
			$convertingtime = strtotime($beforetime);

			// Convert it to the format you desire
			$endtime = date("g:i:s A", $convertingtime); 
			return $endtime;
		}
	private function _jsonSet($status,$message) {
			$this->jsonData['status'] = $status;
			$this->jsonData['message'] = $message;
			
			echo json_encode($this->jsonData);
	}
    public function commentsend($id=null){
		if($id==null){
			return $this->_jsonSet(TRUE, 'Data comment not found. you must save new data');
		}
		if($_POST['comment']=='' || $_POST['comment']=='Tulis komentar anda'){
			return $this->_jsonSet(TRUE, 'Can not empty comment.');
		}
		if($this->Commentmodel->savecomment($id,$_POST)){
			$this->set_notifcomment($id,$_POST);
			return $this->_jsonSet(TRUE, "Save data Success");
		}else{
			return $this->_jsonSet(TRUE, 'Save data failed');
		}
        //return $this->_jsonSet(FALSE, validation_errors('<p>','</p>'));
	}
	function set_notifcomment($id){
			$yangdikirimikomentar=$this->Commentmodel->getcommentGroupByIdUser($_POST['id_information'],$_POST['jenis']);
			foreach($yangdikirimikomentar as $ky=>$dt){
				if($dt['id_group']==12){
					$id_siswa[]=$dt['id_user'];
				}else{
					$id_pegawai[]=$dt['id_user'];
				}
				$yangdikirimikomentar[$ky]['date']=$this->getday($dt['date']);
			}
			
			$yangdikirimikomentar2=$this->Commentmodel->getDataOwnerComment($_POST['id_information'],$_POST['jenis']);
			foreach($yangdikirimikomentar2 as $ky2=>$dt2){
				if($dt2['id_group']==12){
					$id_siswa[]=$dt2['id_user'];
				}else{
					$id_pegawai[]=$dt2['id_user'];
				}
				//$yangdikirimikomentar2[$ky2]['date']=$this->getday($dt2['date']);
			}
			$foto=$this->Commentmodel->getcommentfoto($id_siswa,$id_pegawai);
			if(isset($_POST['commentreply'])){$_POST['comment']=$_POST['commentreply'];}
			$keterangan='<b>'.strtoupper($_POST['jenis']).'</b> : "'.$_POST['comment'].'"';
			
			//pr($foto[$this->session->userdata['user_authentication']['id_pengguna']]['nama']);
			//kirim notif untuk owner
			if($yangdikirimikomentar2[0]['id_user']!=$this->session->userdata['user_authentication']['id_pengguna']){
				$this->ak_notifikasi->set_notifikasi($yangdikirimikomentar2[0]['id_user'],'komentar',$yangdikirimikomentar2[0]['id_group'],$foto[$this->session->userdata['user_authentication']['id_pengguna']]['nama'],$keterangan,$_POST['id_information'],$_POST['jenis']);
			}
			
			//kirim notif untuk  folowwer
			foreach($yangdikirimikomentar as $yangdikirimi){
				//echo $yangdikirimi['id_user'].'=='.$this->session->userdata['user_authentication']['id_pengguna'];
				if($yangdikirimi['id_user']!=$this->session->userdata['user_authentication']['id_pengguna']){
					$this->ak_notifikasi->set_notifikasi($yangdikirimi['id_user'],'komentar',$yangdikirimi['id_group'],$foto[$this->session->userdata['user_authentication']['id_pengguna']]['nama'],$keterangan,$_POST['id_information'],$_POST['jenis']);
				}
			}	
	}
	public function commentdelpost($id){
		$this->Commentmodel->delcommentpost($id);
	}
	public function commentdeltreply($id){
		$this->Commentmodel->delcommentreply($id);
	}
	public function commenteditpost($id){
		if($_POST['commentpost']=='' ||  $_POST['commentpost']=='Tulis komentar anda'){
			return $this->_jsonSet(TRUE, 'Can not empty data.');
		}
		if($this->Commentmodel->editcommentpost($id,$_POST)){
			return $this->_jsonSet(TRUE, "Save data Success");
		}else{
			return $this->_jsonSet(TRUE, 'Save data failed');
		}		
	}
	public function commenteditreply($id){
		if($_POST['commentreply']=='' || $_POST['commentreply']=='Tulis komentar anda'){
			return $this->_jsonSet(TRUE, 'Can not empty data.');
		}
		if($this->Commentmodel->editcommentreply($id,$_POST)){
			return $this->_jsonSet(TRUE, "Save data Success");
		}else{
			return $this->_jsonSet(TRUE, 'Save data failed');
		}		
	}	
	public function commentsendreply($id=null){
		
		if($_POST['commentreply']=='' ||  $_POST['commentreply']=='Tulis komentar anda'){
			return $this->_jsonSet(TRUE, 'Can not empty data.');
		}
		if($this->Commentmodel->savecommentreply($id,$_POST)){
			$this->set_notifcomment($id,$_POST);
			return $this->_jsonSet(TRUE, "Save data Success");
		}else{
			return $this->_jsonSet(TRUE, 'Save data failed');
		}
		
       
        
        //return $this->_jsonSet(FALSE, validation_errors('<p>','</p>'));
	}
        
    }
?>