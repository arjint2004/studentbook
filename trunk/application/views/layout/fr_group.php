<?php $this->load->view('layout/fr_head_group'); ?>
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
        <div class="sidebar">
            <div class="inner-sidebar"></div>
            <div class="widget widget_recent_entries">
                <p style="height: 187px;">&nbsp;</p>
            </div>
            <div class="hr"></div>
	    <?php
		if(!empty($sidebar)) {
			$this->load->view($sidebar);
			echo '<div class="hr" style="margin-top: 65px;"></div>';
		}
	    ?>
        </div>
        <!-- **Sidebar - End** -->
    </div>
    <!-- **Container - End** -->
</div>
<!-- **Main - End**-->
<?php $this->load->view('layout/fr_footer'); ?>