<?php
class Sekolah extends CI_Model {
    public function create_user() {
        if(isset($_POST)) {
            $nama       = $this->input->post('nama');
            $alamat     = $this->input->post('alamat');
            $telp       = $this->input->post('telp');
            $email      = $this->input->post('email');
            $website    = $this->input->post('website');
            $deskripsi  = $this->input->post('deskripsi');
            $logo       = './upload/images/larger/'.$_FILES['logo']['name'];
            
            $data = array('nama_sek'=>$nama,
                          'deskripsi'=>$deskripsi,
                          'tgl_daftar'=>date('Y-m-d'),
                          'logo'=>$logo,
                          'nama_sek'=>$nama,
                          'alamat'=>$alamat,
                          'telp'=>$telp,
                          'email'=>$email);
            $this->db->insert('sc_sekolah',$data);
        }
    }
}

?>