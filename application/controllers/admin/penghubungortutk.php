<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class penghubungortutk extends CI_Controller
    {
		public function __construct()
        {
            parent::__construct();
            $this->load->library('session');
            $this->load->library('auth');
            $this->auth->user_logged_in();
        }
		
        public function index()
        {		
		
		}
		
        public function addcontent()
        {
			$content=array(
							array(
								'tema'=>'Nama Tema',
								'sub tema'=>'Nama Sub Tema',
								'content'=>array(
												array(
													'no'=>1,
													'cek'=>1,
													'deskripsi'=>1,
													'keterangan'=>1,
												),
												array(
													'no'=>1,
													'cek'=>1,
													'deskripsi'=>1,
													'keterangan'=>1,
												),
												array(
													'no'=>1,
													'cek'=>1,
													'deskripsi'=>1,
													'keterangan'=>1,
												)
								)
							),
							array(
								  'ganjil'=>array(
												'judul'=>'Hafalan Doa',
												'content'=>array(
																array(
																	'cek'=>1,
																	'deskripsi'=>1,
																	'keterangan'=>1,
																),
																array(
																	'cek'=>1,
																	'deskripsi'=>1,
																	'keterangan'=>1,
																)
												)
											),
											array(
												'judul'=>'Hafalan hadist',
												'content'=>array(
																array(
																	'cek'=>1,
																	'deskripsi'=>1,
																	'keterangan'=>1,
																),
																array(
																	'cek'=>1,
																	'deskripsi'=>1,
																	'keterangan'=>1,
																)
												)
											),
											array(
												'judul'=>'Hafalan surat',
												'content'=>array(
																array(
																	'cek'=>1,
																	'deskripsi'=>1,
																	'keterangan'=>1,
																),
																array(
																	'cek'=>1,
																	'deskripsi'=>1,
																	'keterangan'=>1,
																)
												)
											),
								  'genap'=>array(
												'judul'=>'Hafalan Doa',
												'content'=>array(
																array(
																	'cek'=>1,
																	'deskripsi'=>1,
																	'keterangan'=>1,
																),
																array(
																	'cek'=>1,
																	'deskripsi'=>1,
																	'keterangan'=>1,
																)
												)
											),
											array(
												'judul'=>'Hafalan hadist',
												'content'=>array(
																array(
																	'cek'=>1,
																	'deskripsi'=>1,
																	'keterangan'=>1,
																),
																array(
																	'cek'=>1,
																	'deskripsi'=>1,
																	'keterangan'=>1,
																)
												)
											),
											array(
												'judul'=>'Hafalan surat',
												'content'=>array(
																array(
																	'cek'=>1,
																	'deskripsi'=>1,
																	'keterangan'=>1,
																),
																array(
																	'cek'=>1,
																	'deskripsi'=>1,
																	'keterangan'=>1,
																)
												)
											)

							),
							array(
								'judul'=>'Menu Harian',
								'content'=>array(
												array(
													'no'=>1,
													'cek'=>1,
													'deskripsi'=>1,
													'keterangan'=>1,
												),
												array(
													'no'=>1,
													'cek'=>1,
													'deskripsi'=>1,
													'keterangan'=>1,
												)
								)							
							)
							
			);
			//pr($content);			
			

			
            $data['main']= 'schooladmin/penghubungortutk/addcontent';
            $this->load->view('layout/ad_adminsekolah',$data);
		}
		
    }
?>