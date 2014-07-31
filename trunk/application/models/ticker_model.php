<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ticker_model extends CI_Model{
        
        function __construct(){
            parent::__construct();
        }
        
        public function generate_code($length = 10){
    
                if ($length <= 0)
                {
                    return false;
                }
            
                $code = "";
                $chars = "abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ123456789";
                srand((double)microtime() * 1000000);
                for ($i = 0; $i < $length; $i++)
                {
                    $code = $code . substr($chars, rand() % strlen($chars), 1);
                }
                return $code;
            
        }

        function post($data){
		if($this->db->insert('table_information', $data)){
			
			$pesan['result']= 1;
			$pesan['id']= $this->db->insert_id() ;
			
		}else{
			$pesan= $this->db->_error_message();
		}
		return $pesan;
	}
//	function getData($q=""){
//		if($q==""){
//			return $this->db->get("table_information")->result_array();
//		}else{
//			$this->db->like("addres1",$q);
//			$this->db->or_like('addres2',$q);
//			$this->db->or_like('unit',$q);
//			$this->db->or_like('city',$q);
//			$this->db->or_like('state',$q);
//			$this->db->or_like('selection',$q);
//			$this->db->or_like('rent_amount',$q);
//			$this->db->or_like('security_deposite',$q);
//			$this->db->or_like('total_movein',$q);
//                        $this->db->or_like('photo_url',$q);
//			$this->db->or_like('description',$q);
//			$this->db->or_like('terms',$q);
//			return $this->db->get("table_information")->result_array();
//		}
//	}	
        
        public function getData()
        {
            $this->db->select('*');
            $this->db->from('table_information');
            return $this->db->get()->result_array();
        }
	
	function showData($q=""){
			$this->db->where("id",$q);
			$dataimg=$this->db->query("SELECT * FROM table_album WHERE id_ticker=".$q."");
			//echo "SELECT * FROM table_album WHERE id_ticker=".$q."";
			$data['img']=$dataimg->result_array();
			$data['row']=$this->db->get("table_information")->row_array();
			return $data;
	}	
	function get_album($q=""){
			$dataimg=$this->db->query("SELECT * FROM table_album WHERE id_ticker=".$q." ORDER BY `order` ASC");
			$data=$dataimg->result_array();
			return $data;
	}	

	function getListData($qs="",$where=""){

			
			// how many records should be displayed on a page?
			$records_per_page = 10;

			// include the pagination class
			require 'Zebra_Pagination.php';

			// instantiate the pagination object
			$pagination = new Zebra_Pagination();

			// the MySQL statement to fetch the rows
			// note how we build the LIMIT
			// also, note the "SQL_CALC_FOUND_ROWS"
			// this is to get the number of rows that would've been returned if there was no LIMIT
			// see http://dev.mysql.com/doc/refman/5.0/en/information-functions.html#function_found-rows
			
			//if($qs!=""){$limit='' . (($pagination->get_page() - 1) * $records_per_page) . ', ' . $records_per_page . '';}else{$limit="";}
			$limit='LIMIT ' . (($pagination->get_page() - 1) * $records_per_page) . ', ' . $records_per_page . '';
			if($where!=""){$where="WHERE ".$where."";}else{$where="";}
			
			$data=$this->db->query("SELECT * FROM table_information ".$where." ".$limit."");

			// pass the total number of records to the pagination class
			$pagination->records(11);

			// records per page
			$pagination->records_per_page($records_per_page);
			$out['data']=$data->result_array();
			$out['page']=$pagination->render();
			//echo $pagination->render(true); die();
			return $out;
	}
        
        public function gethistory($id)
        {
			return $this->db->query("SELECT * FROM table_history WHERE	id_information=".$id." ORDER BY date DESC")->result_array();
		}
        public function gethistoryreply($id)
        {
			return $this->db->query("SELECT * FROM table_historyreply WHERE	id_history=".$id." ORDER BY date DESC")->result_array();
		}
        public function savehistory($id,$data)
        {
             if($this->db->query("INSERT INTO table_history SET id_information=".$id." , history='".mysql_real_escape_string($data['history'])."' ,`date`='".date("Y-m-d H:i:s")."', publish=1")){
				return true;
			 }else{
				return false;
			 }
        }
        public function delhistorypost($id){
			if($this->db->query("DELETE FROM table_history WHERE id=".$id."")){
				$this->db->query("DELETE FROM table_historyreply WHERE id_history=".$id."");
				return true;
			 }else{
				return false;
			 }		
		}
        public function delhistoryreply($id){
			if($this->db->query("DELETE FROM table_historyreply WHERE id=".$id."")){
				return true;
			 }else{
				return false;
			 }		
		}
        public function edithistorypost($id,$reply){
			 if($this->db->query("UPDATE table_history SET history='".mysql_real_escape_string($reply['historypost'])."' ,`date`='".date("Y-m-d  H:i:s")."', publish=1 WHERE id=".$id."")){
				return true;
			 }else{
				return false;
			 }		
		}
        public function edithistoryreply($id,$reply){
			 if($this->db->query("UPDATE table_historyreply SET history='".mysql_real_escape_string($reply['historyreply'])."' ,`date`='".date("Y-m-d  H:i:s")."', publish=1 WHERE id=".$id."")){
				return true;
			 }else{
				return false;
			 }		
		}
        public function savehistoryreply($id,$reply)
        {
		if($this->db->query("INSERT INTO table_historyreply SET id_history=".$id." , history='".mysql_real_escape_string($reply['historyreply'])."' ,`date`='".date("Y-m-d  H:i:s")."', publish=1")){
				return true;
			 }else{
				return false;
			 }
        }
        public function last_insert_id()
        {
            return $this->db->query("SELECT id FROM table_information ORDER BY id DESC LIMIT 1")->row_array();
        }
        public function publish($publish,$id)
        {
			if($publish==0){$pub=1;}else{$pub=0;}
            $this->db->query("UPDATE table_information SET publish=".$pub." WHERE id=".$id."");
			return  $pub;
        }
        
        function get_coordinates($id)
        {
//            $return = array();
//            $this->db->select("CONCAT(addres1,' ', city) as address, state");
//            $this->db->from("table_information");
//            $this->db->where('id',$id);
//            $query = $this->db->get();
//            if ($query->num_rows()>0) {
//            foreach ($query->result() as $row) {
//            array_push($return, $row);
//            }
//            }
//            return $return;
            
            //return $this->db->query("SELECT CONCAT(zip_code, ' ', addres1, ' ', city) as address, state FROM table_information WHERE id='".$id."'")->result();
            return $this->db->query("SELECT CONCAT(addres1, ' ', zip_code) as address, CONCAT(city, ' ', state) as region FROM table_information WHERE id='".$id."'")->result();
        }
        
        public function saveImage($filename,$id_ticker,$inputname)
        {
				$id_album=explode("_",$inputname);
				
				
				if(isset($id_album[2])){
				$path=pathinfo($_SERVER['SCRIPT_FILENAME']);
				
				$dtdel=$this->db->query('SELECT * FROM table_album WHERE id='.$id_album[2].'');
				$dtdelarr=$dtdel->result_array();//print_r($dtdelarr);
				//unlink($path['dirname']."/files/".$dtdelarr[0]['img_url']);
				$this->db->query('DELETE FROM table_album WHERE id='.$id_album[2].'');
				}
				//echo $filename.",".$id_ticker."<br>";
			    // Save to Database
                $datax = array(
				   'id_ticker' => $id_ticker ,
				   'order' => $id_album[1] ,
				   'img_url' => $filename
				);

				$this->db->insert('table_album', $datax); 
		}
        public function deleteTicker($id_ticker=null)
        {
		$this->db->query('DELETE FROM table_information WHERE id='.$id_ticker.'');
		$this->db->query('DELETE FROM table_album WHERE id_ticker='.$id_ticker.'');
		}
        public function save($id_ticker=null)
        {
            $uploads = array($this->upload->data());
        
            $this->load->library('image_lib');

            //Move Files To User Folder
            foreach($uploads as $key[] => $value)
            {

                //Gen Random code for new file name
                $randomcode = $this->generate_code(12);

                $newimagename = $this->input->post('id', TRUE).$value['file_ext'];

                $destination = './files/thumbs/';
                $destination2 = './image/thumbs/';
                $destination3 = './image/showdata/';

                //Creat Thumbnail
                $config['image_library'] = 'GD2';
                $config['source_image'] = $value['full_path'];
                $config['create_thumb'] = TRUE;
                $config['thumb_marker'] = '';
                $config['master_dim'] = 'width';
                $config['quality'] = 75;
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 50;
                $config['height'] = 50;
                $config['new_image'] = $destination . $newimagename;
                
                $this->image_lib->initialize($config);
                //$this->load->library('image_lib', $config);
                $this->image_lib->resize();
                
                //Creat Thumbnail2
                $config['image_library'] = 'GD2';
                $config['source_image'] = $value['full_path'];
                $config['create_thumb'] = TRUE;
                $config['thumb_marker'] = '';
                $config['master_dim'] = 'width';
                $config['quality'] = 75;
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 50;
                $config['height'] = 50;
                $config['new_image'] = $destination2 . $newimagename;
                
                $this->image_lib->initialize($config);
                //$this->load->library('image_lib', $config);
                $this->image_lib->resize();

                //Creat Thumbnail 3
                $config['image_library'] = 'GD2';
                $config['source_image'] = $value['full_path'];
                $config['create_thumb'] = TRUE;
                $config['thumb_marker'] = '';
                $config['master_dim'] = 'width';
                $config['quality'] = 85;
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 200;
                $config['height'] = 200;
                $config['new_image'] = $destination3 . $newimagename;
                
                $this->image_lib->initialize($config);
                //$this->load->library('image_lib', $config);
                $this->image_lib->resize();

                //Make Some Variables for Database
                $imagename = $newimagename;
                $thumbnail = $randomcode.'_tn'.$value['file_ext'];
                $filesize = $value['file_size'];
                $width = $value['image_width'];
                $height = $value['image_height'];
                $timestamp = time();



				//echo $id_ticker;
                if($id_ticker!=null){
				
				$data = $_POST;
				//$where = array(
				//	'id' => $id_ticker
				//);
				if($value['file_name']!='' && isset($value['file_name'])){
					$data['photo_url']=$value['file_name'];
				}else{
					unset($data['photo_url']);
				}
				
				if($_POST['selection']!='Apartment' && $_POST['selection']!='House'){ 	 	 	 	 	 	
					$data['bedroom']=0;
					$data['bathroom']=0;
					$data['kitchen']=0;
					$data['livingroom']=0;
					$data['familyroom']=0;
					$data['single']=0;
					$data['bachelor']=0;
				}

				if(isset($data['id_del'])){
					foreach($data['id_del'] as $idImage=>$imagesnya){
						unlink(str_replace("index.php","",$_SERVER['SCRIPT_FILENAME']).'files/'.$imagesnya.'');
						$this->db->query('DELETE FROM table_album WHERE id='.$idImage.'');
					}
				}
				unset($data['id_ticker']);
				unset($data['id_del']);
				unset($data['type']);
				unset($data['submit']);
				unset($data['termsconditioncek']);
				$data['rent_amount']=str_replace(',','',str_replace('$', '',$data['rent_amount'] ));
				$data['security_deposite']=str_replace(',','',str_replace('$', '',$data['security_deposite'] ));
				$data['total_movein']=str_replace(',','',str_replace('$', '',$data['total_movein'] ));
				$data['expired_date']=str_replace("-","/",$data['expired_date']);
				$set='';
				foreach($data as $col=>$val){
					$set .="`".$col."`='".$val."' ,";
				}
				$set=substr($set, 0, -1);
				//echo "<pre>";
				//print_r($data);
				//echo 'UPDATE table_information set '.$set.' WHERE id="'.$id_ticker.'"'; die();
				//$this->db->where($where);
				//$this->db->update('table_information',$data);
				//Update Info Into Database
				$this->db->query('UPDATE table_information set '.$set.' WHERE id="'.$id_ticker.'"');

				}else{
				                // Save to Database
                $this->db->set('listing1', $this->input->post( "listing1", TRUE ));
                $this->db->set('listing2', $this->input->post( "listing2", TRUE ));
                $this->db->set('expired_date', str_replace("-","/",$this->input->post( "expired_date", TRUE )));
                $this->db->set('addres1', $this->input->post( "addres1", TRUE ));
                $this->db->set('addres2', $this->input->post( "addres2", TRUE ));
                $this->db->set('unit', $this->input->post( "unit", TRUE ));
                $this->db->set('city', $this->input->post( "city", TRUE ));
                $this->db->set('state', $this->input->post( "state", TRUE ));
                $this->db->set('zip_code', $this->input->post( "zip_code", TRUE ));
                $this->db->set('phone_number', $this->input->post( "phone_number", TRUE ));
                $this->db->set('ext_phone_number', $this->input->post( "ext_phone_number", TRUE ));
                $this->db->set('selection', $this->input->post( "selection", TRUE ));
                $this->db->set('sub_selection', $this->input->post( "sub_selection", TRUE ));
                $this->db->set('bedroom', $this->input->post( "bedroom", TRUE ));
                $this->db->set('bathroom', $this->input->post( "bathroom", TRUE ));
                $this->db->set('kitchen', $this->input->post( "kitchen", TRUE ));
                $this->db->set('livingroom', $this->input->post( "livingroom", TRUE ));
                $this->db->set('familyroom', $this->input->post( "familyroom", TRUE ));
                $this->db->set('single', $this->input->post( "single", TRUE ));
                $this->db->set('bachelor', $this->input->post( "bachelor", TRUE ));
                $this->db->set('area_size', $this->input->post( "area_size", TRUE ));
                $this->db->set('rent_amount', str_replace(',','',str_replace('$', '', $this->input->post( "rent_amount", TRUE ))));
                $this->db->set('rent_amount_sub', $this->input->post( "rent_amount_sub", TRUE ));
                $this->db->set('security_deposite', str_replace(',','',str_replace('$', '', $this->input->post( "security_deposite", TRUE ))));
                $this->db->set('total_movein', str_replace(',','',str_replace('$', '', $this->input->post( "total_movein", TRUE ))));
                $this->db->set('description', $this->input->post( "description", TRUE ));
                $this->db->set('history', $this->input->post( "history", TRUE ));
                $this->db->set('available_date', $this->input->post( "available_date", TRUE ));
                $this->db->set('photo_url', $value['file_name']);
                $this->db->set('terms', $this->input->post( "terms", TRUE ));
                $this->db->set('termscondition', $this->input->post( "termscondition", TRUE ));
                $this->db->set('youtube_embed', $this->input->post( "youtube_embed", TRUE ));
                $this->db->set('publish', $this->input->post( "publish", TRUE ));
                //Insert Info Into Database
                $this->db->insert('table_information');
				}
                 $this->session->set_flashdata('succes', "Saving data succes..!!");
                // redirect('ticker');
                            //$this->db->update('item_type', $this, array('id' => $id));

            }
        }
}

