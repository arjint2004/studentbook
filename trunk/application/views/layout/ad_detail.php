<?=$this->load->view('layout/ad_headerak')?>
	<!-- ** Main** -->
    <div id="main">
        <!-- **Container** -->
        <div class="container">
            <!-- **Content** -->
            <div class="content content-full-width">
				<?php
					if(isset($main)) {
						$this->load->view($main);     
					}
				?> 
            </div> <!-- **Content - End** -->   	
        </div><!-- **Container - End** -->
    </div><!-- **Main - End**-->
<?=$this->load->view('layout/ad_footer')?>