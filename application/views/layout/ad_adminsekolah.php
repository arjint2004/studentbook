<?=$this->load->view('layout/ad_headerak')?>
<? //pr($this->router);?>
<div class="breadcrumb">
    	<div class="breadcrumb-bg">
            <div class="container">
                <span style="font-size:13px;" class="current-crumb"> Selamat datang admin! <?//=$this->session->userdata['user_authentication']['username']?> Silahkan lengkapi data-data akademik di bawah ini:</span>
            </div> 
        </div>
    </div>
	<!-- ** Main** -->
    <div id="main">
        <!-- **Container** -->
        <div class="container">
            <!-- **Content** -->
            <div class="content content-full-width">
		    <div class="side-nav-container">
			<script>
				/*$(document).ready(function(){
					//Submit Starts		   
					$("ul.side-nav li a#semester, ul.side-nav li a#ta, ul.side-nav li a#jurusanmenu, ul.side-nav li a#kelas, ul.side-nav li a#pelajaranmenu").click(function(){
						
						var thisobj=$(this);
						$.ajax({
							type: "POST",
							data: 'ajax=1',
							url: $(thisobj).attr('href'),
							beforeSend: function() {
								$(thisobj).append("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();	
								$('div.main-content').html(msg);
							}
						});

						return false;
					});
				});*/
			</script>
			<?//pr($this->session->userdata['ak_setting']['jenjang']);?>
                	<? if($this->session->userdata['user_authentication']['id_group']==11){
						$this->load->view('layout/adminsekolahmenu');
						}elseif($this->session->userdata['user_authentication']['id_group']==10){
						$this->load->view('layout/superadminmenu');
						}elseif($this->session->userdata['user_authentication']['id_group']==30){
						$this->load->view('layout/adminmenu');
						}
					?>
					
                    <div class="side-nav-bottom"> </div>
                </div>
            
            	<div class="main-content">
				
                        <?php
							if(isset($main)) {
								$this->load->view($main);     
							}
						?> 
                </div>
            </div> <!-- **Content - End** -->   	
        </div><!-- **Container - End** -->
    </div><!-- **Main - End**-->
<?=$this->load->view('layout/ad_footer')?>