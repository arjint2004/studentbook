<?=$this->load->view('layout/ad_main')?>

<?php
    if(isset($main)) {
        $this->load->view('schooladmin/'.$main);
    }
?>

<?=$this->load->view('layout/ad_main')?>
