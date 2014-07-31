<?=$this->load->view('layout/ad_header')?>
   
    <!-- **Breadcrumb** 
    <div class="breadcrumb">
    	<div class="breadcrumb-bg">
            <div class="container">
                <a href="" title=""> Home </a>
                <span class="arrow"> </span>
                <a href="" title=""> Blog </a>
                <span class="arrow"> </span>
                <span class="current-crumb"> Blog Single </span>
            </div> 
        </div>
    </div> **Breadcrumb - End** -->
    

        <?//=akademiknotif(0);?>
            <!-- **Content** -->
            <div class="content">
            	                    
                <?php
					if(!empty($main)) {
						$this->load->view($main);
					}
				?>
                
            </div> <!-- **Content - End** -->   	
            <?=$this->load->view('layout/sidebar');?>
<?=$this->load->view('layout/ad_footer')?>
