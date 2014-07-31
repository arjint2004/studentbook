<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ticker extends CI_Controller {
   
   private $validation_rules = array(
                
                
                array (
                        'field'    => 'email',
                        'label'    => 'Email',
                        'rules'    => 'required|valid_email'
                        )
            );

			
    public function __construct(){
            parent::__construct();
			date_default_timezone_set('America/Los_Angeles');
			$this->load->library('form_validation');
    }
		
	public function mailtickersend(){
		if(!$_POST) return false;
        
        $ret = array();
        
        $this->form_validation->set_rules($this->validation_rules);
        
        if($this->form_validation->run()){
		
				// multiple recipients
				$to  = ''.$_POST['email'].'' . ' '; // note the comma
				//$to .= 'wez@example.com';

				// subject
				$subject = 'Detail House Information';

				// message
				$message = '
				<html>
				<head>
				  <title></title>
				</head>
				<body>
				  <table>
						<tr>
							<td>Message</td>
							<td>:</td>
							<td>'.$_POST['message'].'</td>
						</tr>
						<tr>
							<td>Detail Url</td>
							<td>:</td>
							<td><a href="'.base64_decode($_POST['urlticker']).'">'.base64_decode($_POST['urlticker']).'</a></td>
						</tr>
				  </table>
				</body>
				</html>
				';

				// To send HTML mail, the Content-type header must be set
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

				// Additional headers
				$headers .= 'To: '.$_POST['email'].' <'.$_POST['email'].'>' . "\r\n";
				$headers .= 'From: 	VAM House Info <info@vamproperty.com>' . "\r\n";
				//$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
				//$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";

				// Mail it
				mail($to, $subject, $message, $headers);
                //Use data processing funtion
                return $this->_jsonSet(TRUE, 'Yor Email Sent');
        }
        
        return $this->_jsonSet(FALSE, validation_errors('<p>','</p>'));
	}
	
	private function _jsonSet($status,$message) {
        $this->jsonData['status'] = $status;
        $this->jsonData['message'] = $message;
        
        echo json_encode($this->jsonData);
    }
	
	public function mailticker(){
	
	$data=array();
	$this->load->view('mailticker',$data);
	}
	
	public function listdata(){
		$datax=$this->Ticker_model->getListData();
		$data['ticker']=$datax['data'];
		$data['page']=$datax['page'];
		$this->load->view('listdata',$data);
	}
	
	public function delete($id){
		$this->Ticker_model->deleteTicker($id);
		$bse=str_replace("ticker/","",base_url());
		echo "
		<script>
		function redir(theLocation){
								
								window.top.location.href=theLocation;
								window.parent.location.href=theLocation;
								window.top.location.replace(theLocation);

							}
		redir('".$bse."admin/index.php/admin_area/dataticker');</script>
		";die();
		redirect('index.php/ticker/listdata');
	}
	
	public function publish($publish,$id){
		$pub=$this->Ticker_model->publish($publish,$id);
		if($pub==1){$ck="checked";}else{$ck="";}
		//if($pub==1){
		
			echo '<input type="checkbox" value="'.$pub.'" '.$ck.' id="cek'.$id.'" onclick="publish('.$pub.','.$id.');" name="publish"/>';
			die();
		//}else{
		
		//}
	}	
	public function historysend($id=null){
		if($id==null){
			return $this->_jsonSet(TRUE, 'Data history not found. you must save new data');
		}
		if($_POST['history']=='' || $_POST['history']=='Write your post here'){
			return $this->_jsonSet(TRUE, 'Can not empty history.');
		}
		if($this->Ticker_model->savehistory($id,$_POST)){
			return $this->_jsonSet(TRUE, "Save data Success");
		}else{
			return $this->_jsonSet(TRUE, 'Save data failed');
		}
		
       
        
        //return $this->_jsonSet(FALSE, validation_errors('<p>','</p>'));
	}

	public function historydelpost($id){
		$this->Ticker_model->delhistorypost($id);
	}
	public function historydeltreply($id){
		$this->Ticker_model->delhistoryreply($id);
	}
	public function historyeditpost($id){
		if($_POST['historypost']=='' ||  $_POST['historypost']=='Write your post here'){
			return $this->_jsonSet(TRUE, 'Can not empty data.');
		}
		if($this->Ticker_model->edithistorypost($id,$_POST)){
			return $this->_jsonSet(TRUE, "Save data Success");
		}else{
			return $this->_jsonSet(TRUE, 'Save data failed');
		}		
	}
	public function historyeditreply($id){
		if($_POST['historyreply']=='' || $_POST['historyreply']=='Write your post here'){
			return $this->_jsonSet(TRUE, 'Can not empty data.');
		}
		if($this->Ticker_model->edithistoryreply($id,$_POST)){
			return $this->_jsonSet(TRUE, "Save data Success");
		}else{
			return $this->_jsonSet(TRUE, 'Save data failed');
		}		
	}	
	public function historysendreply($id=null){
		
		if($_POST['historyreply']=='' ||  $_POST['historyreply']=='Write your post here'){
			return $this->_jsonSet(TRUE, 'Can not empty data.');
		}
		if($this->Ticker_model->savehistoryreply($id,$_POST)){
			return $this->_jsonSet(TRUE, "Save data Success");
		}else{
			return $this->_jsonSet(TRUE, 'Save data failed');
		}
		
       
        
        //return $this->_jsonSet(FALSE, validation_errors('<p>','</p>'));
	}
	function getampm($beforetime){
		// Make it into a Unix TimeStamp
		$convertingtime = strtotime($beforetime);

		// Convert it to the format you desire
		$endtime = date("g:i:s A", $convertingtime); 
		return $endtime;
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
				return "Today ".$this->getampm($date22[1]);
			break;
			case 1:
				return "Yesterday ".$this->getampm($date22[1]);
			break;
			default:
				$epldate=explode("-",$tgl1);
				return date("F j, Y", mktime(0, 0, 0, $epldate[1], $epldate[2], $epldate[0]))." ".$this->getampm($date22[1]);
			break;
		}
	}
	public function history($id=null){
		
		if($id!=null){
			$data['history']=$this->Ticker_model->gethistory($id);
		}
		if(!empty($data['history'])){
			foreach($data['history'] as $idhis=>$datahis){
				$data['history'][$idhis]['reply']=$this->Ticker_model->gethistoryreply($datahis['id']);
			}
		}
		foreach($data['history'] as $ky=>$dt){
				$data['history'][$ky]['date']=$this->getday($dt['date']);
			foreach($dt['reply'] as $ky1=>$dt1){
				$data['history'][$ky]['reply'][$ky1]['date']=$this->getday($dt1['date']);
			}
		}
		//echo "<pre>";
		//print_r($data['history']);		
		//echo "</pre>";
		//echo $this->getday();
		$this->load->view('history',$data);
	}
	
	public function edit($id){

                $r=$this->Ticker_model->last_insert_id();
                if($r==null) :
                    $data['id'] = 1;
                else :
                    $data['id']=$r['id']+1;
                endif;
				
		$datax=$this->Ticker_model->getListData('','id='.$id.'');

		$data=$datax['data'][0];
		
		$data['options'][''] ='--Select--' ;
		$data['options']['House'] ='House' ;
		$data['options']['Apartment'] ='Apartment' ;
		//$data['options']['Retail'] ='Retail' ;
		$data['options']['Industrial'] ='Industrial' ;
		$data['options']['Commercial'] ='Commercial' ;
		//$data['options']['Warehouse'] ='Warehouse' ;
			
		$data['options0'][''] ='--Select--' ;
		if($data['selection']=='House'){
			$data['options0']['Condominium'] ='Condominium' ;
			$data['options0']['Townhouse'] ='Townhouse' ;
			$data['options0']['Single'] ='Single' ;
			$data['options0']['Duplexes'] ='Duplexes' ;
			$data['options0']['Tripexes'] ='Tripexes' ;
			$data['options0']['Fourplexes'] ='Fourplexes' ;
		}elseif($data['selection']=='Apartment'){
			$data['options0']['Single'] ='Single' ;
			$data['options0']['Bachelor'] ='Bachelor' ;
			$data['options0']['1 Bedroom'] ='1 Bedroom' ;
			$data['options0']['2 Bedroom'] ='2 Bedroom' ;
			$data['options0']['3 Bedroom'] ='3 Bedroom' ;		
			$data['options0']['4 Bedroom'] ='4 Bedroom' ;		
		}/*elseif($data['selection']=='Retail'){
			$data['options0']['Warehouse'] ='Warehouse' ;
			$data['options0']['Storage'] ='Storage' ;			
		}*/elseif($data['selection']=='Industrial'){
			$data['options0']['Warehouse'] ='Warehouse' ;
			$data['options0']['Storage'] ='Storage' ;			
			$data['options0']['Medical'] ='Medical' ;			
		}elseif($data['selection']=='Commercial'){
			$data['options0']['Office'] ='Office' ;
			$data['options0']['Retail'] ='Retail' ;
			$data['options0']['Shopping Center'] ='Shopping Center' ;		
		}/*elseif($data['selection']=='Warehozuse'){
			$data['options0']['Warehouse'] ='Warehouse' ;
			$data['options0']['Storage'] ='Storage' ;		
		}*/
		
		
		$data['options1'][''] ='--Select--' ;
		$data['options1']['For Lease'] ='For Lease' ;
		$data['options1']['For Sale'] ='For Sale' ;

			$data['options2'][''] ='--Select--' ;
/*			$data['options2']['Preparation'] ='Preparation' ;
			$data['options2']['Showing'] ='Showing' ;
			$data['options2']['Pending Application'] ='Pending Application' ;
			$data['options2']['Sale Pending'] ='Sale Pending' ;
			$data['options2']['In Escrow'] ='In Escrow' ;
			$data['options2']['Sold'] ='Sold' ;		
*/			
		if($data['listing1']=='For Lease'){
			$data['options2']['Preparation'] ='Preparation' ;
			$data['options2']['Showing'] ='Showing' ;
			$data['options2']['Pending Application'] ='Pending Application' ;
		}elseif($data['listing1']=='For Sale'){
			$data['options2']['Showing'] ='Showing' ;
			$data['options2']['Sale Pending'] ='Sale Pending' ;
			$data['options2']['In Escrow'] ='In Escrow' ;
			$data['options2']['Sold'] ='Sold' ;
		}
		
		$data['images']=$this->Ticker_model->get_album($id);
		$data['posturl']=base_url()."ticker/upload";	

		
		$this->load->view('editdata',$data);
	}
	public function index(){
		$data['options'][''] ='--Select--' ;
		$data['options']['House'] ='House' ;
		$data['options']['Apartment'] ='Apartment' ;
		//$data['options']['Retail'] ='Retail' ;
		$data['options']['Industrial'] ='Industrial' ;
		$data['options']['Commercial'] ='Commercial' ;
		//$data['options']['Warehouse'] ='Warehouse' ;
		$data['options0'][''] ='--Select--' ;
		
		$data['options1'][''] ='--Select--' ;
		$data['options1']['For Lease'] ='For Lease' ;
		$data['options1']['For Sale'] ='For Sale' ;

		
		$data['options2'][''] ='--Select--' ;
		$data['options2']['Sold'] ='Sold' ;
		$data['options2']['Listing Expired'] ='Listing Expired' ;
		$data['options2']['No Vacancy '] ='No Vacancy ' ;

		
                $r=$this->Ticker_model->last_insert_id();
                if($r==null) :
                    $data['id'] = 1;
                else :
                    $data['id']=$r['id']+1;
                endif;

		$data['posturl']=base_url()."ticker/upload";
		$this->load->view('form',$data);
	}
	
	public function post(){
            /*$rules = array(
            array(
                'field' => 'userfile',
                'label' => 'File',
                'rules' => 'trim|required'
            ));*/
            
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            $this->form_validation->set_rules('addres1',' ','required');
            $this->form_validation->set_rules('addres2',' ','');
            $this->form_validation->set_rules('unit',' ','');
            $this->form_validation->set_rules('city',' ','required');
            $this->form_validation->set_rules('state',' ','required');
            $this->form_validation->set_rules('zip_code',' ','required');
            $this->form_validation->set_rules('phone_number',' ','required');
            $this->form_validation->set_rules('bedroom',' ','');
            $this->form_validation->set_rules('bathroom',' ','');
            $this->form_validation->set_rules('selection',' ','required');
            $this->form_validation->set_rules('sub_selection',' ','required');
            $this->form_validation->set_rules('area_size',' ','required');
            $this->form_validation->set_rules('rent_amount',' ','required');
            $this->form_validation->set_rules('rent_amount_sub',' ','required');
            $this->form_validation->set_rules('description',' ','');
            $this->form_validation->set_rules('history',' ','');
            $this->form_validation->set_rules('available_date',' ','required');
            //$this->form_validation->set_rules($rules);            
            $this->form_validation->set_rules('security_deposite',' ','');
            $this->form_validation->set_rules('total_movein',' ','');
            $this->form_validation->set_rules('terms',' ','');
            $this->form_validation->set_rules('termscondition',' ','');
            $this->form_validation->set_rules('youtube_embed',' ','');
            $this->form_validation->set_rules('publish',' ','');

            if ($this->form_validation->run() == FALSE){
                //echo validation_errors(); exit;
                $this->index();
            }else{
                $data = array('addres1' => $this->input->post( "addres1", TRUE ) ,
                              'addres2' => $this->input->post( "addres2", TRUE ) ,
                              'unit' => $this->input->post( "unit", TRUE ) ,
                              'city' => $this->input->post( "city", TRUE ) ,
                              'state' => $this->input->post( "state", TRUE ) ,
                              'zip_code' => $this->input->post( "zip_code", TRUE ) ,
                              'phone_number' => $this->input->post( "phone_number", TRUE ) ,
                              'ext_phone_number' => $this->input->post( "ext_phone_number", TRUE ) ,
                              'selection' => $this->input->post( "selection", TRUE ) ,
                              'sub_selection' => $this->input->post( "sub_selection", TRUE ) ,
                              'bedroom' => $this->input->post( "bedroom", TRUE ) ,
                              'bathroom' => $this->input->post( "bathroom", TRUE ) ,
                              'kitchen' => $this->input->post( "kitchen", TRUE ) ,
                              'livingroom' => $this->input->post( "livingroom", TRUE ) ,
                              'familyroom' => $this->input->post( "familyroom", TRUE ) ,
                              'area_size' => $this->input->post( "area_size", TRUE ) ,
                              'rent_amount' =>str_replace(',','',str_replace('$', '', $this->input->post( "rent_amount", TRUE ))),
                              'rent_amount_sub' =>$this->input->post( "rent_amount_sub", TRUE ),
                              'security_deposite' =>str_replace(',','',str_replace('$', '', $this->input->post( "security_deposite", TRUE ))),
                              'total_movein' =>str_replace(',','',str_replace('$', '', $this->input->post( "total_movein", TRUE ))),
                              'description' => $this->input->post( "description", TRUE ) ,
                              'history' => $this->input->post( "history", TRUE ) ,
                              'available_date' => $this->input->post( "available_date", TRUE ) ,
                              'terms' => $this->input->post( "terms", TRUE ),
                              'termscondition' => $this->input->post( "termscondition", TRUE ),
                              'youtube_embed' => $this->input->post( "youtube_embed", TRUE ),
                              'publish' => $this->input->post( "publish", TRUE )
                );
                        
                $pesan=$this->Ticker_model->post($data);
                if($pesan['result']==1){
                    $r=$this->Ticker_model->last_insert_id();
                    $this->upload($r['id']);
                }else{
                    $this->session->set_flashdata('error',$pesan);
                    redirect('ticker');
                }
            }

	}
	function formUpload($id=""){
		$data['posturl']=base_url()."ticker/upload";
		$data['id']=$id;
		$this->load->view("form_upload",$data);
	}
	
	/*function upload($id=""){        
                $config['upload_path'] = './files/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['overwrite']=TRUE;
//		$config['max_size']     = '500';
		//$config['file_type'] = 'image/jpeg';
		$config['file_name']=$this->input->post( "id", TRUE ).".jpg";
                
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if($this->upload->do_upload()){
		    //Resize.................
				$config['image_library'] = 'gd2';
				$config['source_image'] = "./files/" .$this->input->post( "id", TRUE ).".jpg";
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 200;
				$config['height'] = 200;
				$this->load->library('image_lib', $config);
				$this->image_lib->resize();
				
			//create thumbnail
                                $image_data = $this->upload->data();
                                
				$config['image_library'] = 'gd2';
				$config['source_image'] = "./files/" .$this->input->post( "id", TRUE ).".jpg";
				$config['create_thumb'] = TRUE;
				$config['new_image'] = "./files/thumbs/";
				$config['maintain_ratio'] = TRUE;
				$config['width'] = 50;
				$config['height'] = 50;
				$this->load->library('image_lib', $config);
				//$this->image_lib->initialize($config);
				$this->image_lib->resize();
                                
                                //Saving Data
			$this->session->set_flashdata('succes', "Saving data succes..!!");
			redirect('ticker');
		}else{
                    $this->index();
		}
          }*/
        
        
         public function upload($id=null)
         {
		 
		 if(isset($_POST['id_ticker'])){$id=$_POST['id_ticker']; }
						//echo "<pre>";
						//print_r($_FILES);
						///echo "</pre>";
						//echo $id;die();
            $this->load->library('upload');
                
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            $this->form_validation->set_rules('addres1',' ','required');
            $this->form_validation->set_rules('addres2',' ','');
            $this->form_validation->set_rules('unit',' ','');
            $this->form_validation->set_rules('city',' ','required');
            $this->form_validation->set_rules('state',' ','required');
            $this->form_validation->set_rules('zip_code',' ','required');
            $this->form_validation->set_rules('phone_number',' ','required');
            $this->form_validation->set_rules('bedroom',' ','');
            $this->form_validation->set_rules('bathroom',' ','');
            $this->form_validation->set_rules('selection',' ','required');
            $this->form_validation->set_rules('sub_selection',' ','required');
            $this->form_validation->set_rules('area_size',' ','required');
            $this->form_validation->set_rules('rent_amount',' ','required');
            //$this->form_validation->set_rules('rent_amount_sub',' ','required');
            $this->form_validation->set_rules('description',' ','');
            $this->form_validation->set_rules('history',' ','');
            $this->form_validation->set_rules('available_date',' ','required');
            //$this->form_validation->set_rules($rules);            
            $this->form_validation->set_rules('security_deposite',' ','');
            $this->form_validation->set_rules('total_movein',' ','');
            $this->form_validation->set_rules('terms',' ','');
            $this->form_validation->set_rules('termscondition',' ','');
            $this->form_validation->set_rules('youtube_embed',' ','');
            $this->form_validation->set_rules('publish',' ','');

            if ($this->form_validation->run() == FALSE){
                $this->index();
            }else{
               
		$path = pathinfo($_SERVER['PHP_SELF']);
   		$destination = './files/';                
		$this->uploadedd=1;
		$allowimage=array('image/png','image/jpg','image/jpeg','image/gif');
		
		foreach($_FILES as $key1 => $value1)
		{
			if(!in_array($value1['type'], $allowimage) && $value1['type']!=''){
				exit("<script>window.alert('Denied. not supported file type');
					window.history.go(-1);</script>");
			}		
		}		
		foreach($_FILES as $key => $value)
		{	

			//if( ! empty($value['name'])){
                                $config['upload_path'] = $destination;
                                $config['allowed_types'] = 'png|jpg|gif|jpeg';
                                
                                $config['file_name'] = $this->input->post('id', TRUE);
                                //$config['width'] = 200;
				//$config['height'] = 200;
                                $config['max_size'] = '2048'; //2 mb

                                $this->upload->initialize($config);
                                $this->image_lib->resize();
				if($this->uploadedd<2){
						$this->Ticker_model->save($id);
						$id_ticker=$this->Ticker_model->last_insert_id();
				}
				if ( $this->upload->do_upload($key))
				{	

					
					if($id!=null){$id_ticker['id']=$id;}
						$this->Ticker_model->saveImage($this->upload->file_name,$id_ticker['id'],$key);       
						$this->uploadedd++;echo "upload<br />";
                    
				}    
				else
				{
					
					$this->index();echo "ora upload<br />";	
				}
			//}
			
		}
		
		if($id!=null){
			if($this->uploadedd<2){
			$this->Ticker_model->save($id);
			}      
			$this->uploadedd++;
		}
		die(); 
		
		if($id!=null){
			//redirect('index.php/ticker/listdata');
			$this->edit($id);
			redirect('/index.php/ticker/edit/'.$id.'');
		}else{
			redirect('ticker');
        }  


		   }
         }
}