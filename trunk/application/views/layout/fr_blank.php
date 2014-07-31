<?=$this->load->view('layout/ad_header')?>
        <?//=akademiknotif(0);?>
            <!-- **Content** -->
			<br class="clear" />
            <div class="content">
            	                    
                <?php
					if(!empty($main)) {
						$this->load->view('sosial/'.$main);
					}
				?>
                
            </div> <!-- **Content - End** -->   	
            <?//=$this->load->view('layout/sidebar');?>
<?=$this->load->view('layout/ad_footer')?>
