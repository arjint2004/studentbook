<?php $this->load->view('layout/fr_header'); ?>
		<!-- MAIN FRONT END --->
		<?php
		
			if(!empty($main)) {
				$this->load->view($main);
			}
		?>
		<!-- END MAIN FRONT END -->
        </div>
        <!-- **Content - End** -->
        <!-- **Sidebar** -->
	    <?php
		/*if(!empty($sidebar)) {
			$this->load->view($sidebar);
			echo '<div class="hr" style="margin-top: 65px;"></div>';
		}*/?>
		<?//=$this->load->view('layout/sidebar');?>
        <!-- **Sidebar - End** -->
    <!-- **Container - End** -->
</div>
<!-- **Main - End**-->
<?php $this->load->view('layout/ak_footer'); ?>