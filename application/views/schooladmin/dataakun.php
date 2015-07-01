<!-- **Styled Elements** --> 
 					<script>
					jQuery(document).ready(function($){	
						function loadExcell(listtype){
							$('#import'+listtype+'').load('<?php echo base_url(); ?>admin/schooladmin/importform?akun='+listtype);
						}
						function loadAdd(listtype){
							$.ajax({
							type: "POST",
							data: "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1",
							url: '<?php echo base_url(); ?>admin/schooladmin/adduser/'+listtype+'',
							beforeSend: function() {
								$("#adduser"+listtype+"").html("<img src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#adduser"+listtype+"").html(msg);			
							}
							});
						}
						function loaddata(listtype){
							$.ajax({
							type: "POST",
							data: "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1",
							url: '<?php echo base_url(); ?>admin/schooladmin/dataakun/'+listtype+'/0',
							beforeSend: function() {
								$("#ajax"+listtype+"").html("<img src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#ajax"+listtype+"").html(msg);			
							}
							});
						}
						
						loaddata('guru');
						loadExcell('guru');
						loaddata('siswa');
						loaddata('ortu');
						//loaddata('karyawan');
						//guru
						$('a#clickguru').bind('click', function() {
							loadExcell('guru');
						});
						
						//siswa
						$('a#clicksiswa').bind('click', function() {
							loadExcell('siswa');
						});
						
						//ortu
						$('a#clickortu').bind('click', function() {
							//loadExcell('ortu');
						});
						
						//pegawai
						$('a#clickkaryawan').bind('click', function() {
							//loadExcell('karyawan');
						});
						
						//add account
						
						$('#addsiswa,#addguru,#addortu,#addkaryawan').bind('click', function() {
							loadAdd($(this).attr('title'));
						});
					});	
						
					</script>
					<h1 class="with-subtitle"> Data Account </h1>
					<h6 class="subtitle"> Pengaturan dan Otorisasi Account </h6>
                <div class="styled-elements">
                    <div class="tabs-container">
                        <ul class="tabs-frame">
                            <li><a href="#" id="clickguru" >Guru</a></li>
                            <li><a href="#" id="clicksiswa">Siswa</a></li>
                            <li><a href="#" id="clickortu"  >Orang Tua</a></li>
                            <!--<li><a href="#" id="clickkaryawan" >Karyawan Lain</a></li>-->
                        </ul>
						
                        <div class="tabs-frame-content">
							<a class="readmore readmoreasb" title="guru" id="addguru"> <span> Tambah Data </span></a>
							<div id="importguru"></div>
							<div id="adduserguru"></div>
							<div id="ajaxguru"></div>
                        </div>
                        <div class="tabs-frame-content">
							<a class="readmore readmoreasb" title="siswa" id="addsiswa" > <span> Tambah Data </span></a>
							<div id="importsiswa"></div>
                            <div id="addusersiswa"></div>
                            <div id="ajaxsiswa"></div>
                        </div>
                        <div class="tabs-frame-content">
							<div id="importortu"></div>
                            <div id="ajaxortu"></div>
                        </div>
                        <!--<div class="tabs-frame-content">
							<a class="readmore readmoreasb" title="karyawan" id="addkaryawan" > <span> Tambah Data </span></a>
							<div id="importkaryawan"></div>
                            <div id="adduserkaryawan"></div>
                            <div id="ajaxkaryawan"></div>
                        </div>-->
                    </div>
                    
                    <div class="hr"> </div>
                    <div class="clear"> </div> 
                    
                </div> <!-- **Styled Elements - End** -->  