<?php $this->load->view('layout/ak_header'); ?>
		        
        <!-- **Content** -->
            <div class="content content-full-width" >
				<?php
					if(!empty($main)) {
						$this->load->view($main);
					}
				?>
			</div> 
		<!-- **Content - End** -->  
		<?//=$this->load->view('layout/sidebar');?>
<?php $this->load->view('layout/ak_footer'); ?>