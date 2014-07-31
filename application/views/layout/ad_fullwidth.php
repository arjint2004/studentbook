<?=$this->load->view('layout/ad_headerak')?>
	<!-- ** Main** -->
    <div id="main">

				<!--<a href="<?=base_url('admin/schooladmin')?>">Kembali Ke Beranda</a>-->
				<?php
					if(isset($main)) {
						$this->load->view($main);     
					}
				?> 
  	

    </div><!-- **Main - End**-->
<?=$this->load->view('layout/ad_footer')?>