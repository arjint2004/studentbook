  <script>
	$(document).ready(function(){
		$('table.adddatapemb textarea').attr('style','height:50px;');
		$("#pembelajaranadd").each(function(){
			$container = $(this).next("div.error-container");
			//Validate Starts
			$(this).validate({
				onfocusout: function(element) {	$(element).valid();	},
				errorContainer: $container,
				rules:{
				  id_kelas:{required:true,notEqual:'Pilih Kelas'},
				  id_pelajaran:{required:true,notEqual:'0'},
				  topik:{required:true,notEqual:''},
				  waktu:{required:true,notEqual:''},
				  pertemuan_ke:{required:true,notEqual:''}
				}
			});//Validate End

		});
		//Submit Starts		   
		$(".addaccountclose").click(function(){
			$(".addaccount").remove();
		});
		$("#pembelajaranadd").submit(function(e){
			$frm = $(this);
			$id_kelas = $frm.find('*[name=id_kelas]').val();
			$id_pelajaran = $frm.find('*[name=id_pelajaran]').val();
			$topik = $frm.find('*[name=topik]').val();
			$waktu = $frm.find('*[name=waktu]').val();
			$pertemuan_ke = $frm.find('*[name=pertemuan_ke]').val();
			
			if($frm.find('*[name=id_kelas]').is('.valid') && $frm.find('*[name=id_pelajaran]').is('.valid') &&   $frm.find('*[name=topik]').is('.valid') && $frm.find('*[name=waktu]').is('.valid') && $frm.find('*[name=pertemuan_ke]').is('.valid')) {
				$.ajax({
					type: "POST",
					data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$(this).serialize()+'&'+$('form#nilai').serialize(),
					url: $(this).attr('action'),
					beforeSend: function() {
						$("#simpanpr").after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#wait").remove();
						$.fancybox.close();
						$.ajax({
							type: "POST",
							data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&id_kelas='+$('select#kelas_add').val()+'&pelajaran='+$('select#pelajaran_add').val()+'&ajax=1',
							url: '<?=base_url('akademik/perencanaan/pertemuanlist')?>',
							beforeSend: function() {
								$("#simpanpr").after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$('select#kelas').val($('select#kelas_add').val());
								$('select#pelajaran').html($('select#pelajaran_add').html());
								$('select#pelajaran').val($('select#pelajaran_add').val());
								$('#subjectlist').html(msg);
							}
						});
					}
				});
				return false;
			}
			
			return false;
		});//Submit End	
		
		$("select#kelas_add").change(function(e){
			$.ajax({
				type: "POST",
				data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
				url: '<?=base_url()?>admin/pelajaran/getMapelByKelasAndPegawai/'+$(this).val(),
				beforeSend: function() {
					$('select#kelas_add').after("<img class='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('.wait').remove();
					$("#pelajaran_add").html(msg);	
				}
			});
		});//Submit End
	});
</script>
<div class="addaccount" style="width:800px;">
<form method="post" name="pembelajaran" enctype="multipart/form-data" id="pembelajaranadd" action="<? echo base_url();?>akademik/perencanaan/editpertemuan">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		<h3>Edit Pertemuan Pembelajaran</h3>
		<div class="hr"></div>
		<table class="adddata adddatapemb">
			<tbody><tr>
				<th style="text-align:right;" colspan="3">
				<a onclick="$('#pembelajaranadd').submit();" id="simpanpr" class="button small light-grey absenbutton" title=""> Simpan </a>
				</th>
			</tr>
			<tr>
				<td width="30%" class="title">Guru</td> 
				<td width="1">:</td>
				<td>
				<input type="text" name="nama" disabled style="width:90%;" value="<?=$this->session->userdata['user_authentication']['nama']?>">	
				</td>
			</tr>
			<tr>
				<td class="title">Kelas</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="kelas_add" name="id_kelas">
						<option value="">Pilih Kelas</option>
						<? foreach($kelas as $datakelas){?>
						<option <? if(@$pertemuan[0]['id_kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?=$datakelas['kelas']?><?=$datakelas['nama']?></option>
						<? } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="title">Pelajaran</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="pelajaran_add" name="id_pelajaran">
						<option value="">Pilih Pelajaran</option>
						<?
						if(!empty($pelajaran)){			
						foreach($pelajaran as $datapelajaran){?>
						<option <? if(@$pertemuan[0]['id_pelajaran']==$datapelajaran['id']){echo 'selected';}?> value="<?=$datapelajaran['id']?>"><?=$datapelajaran['nama']?></option>
						<? }} ?>
					</select>
				</td>
			</tr>

			<tr>
				<td width="30%" class="title">Topik</td> 
				<td width="1">:</td>
				<td>
					<textarea name="topik"><?=$pertemuan[0]['topik']?></textarea>
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Waktu</td> 
				<td width="1">:</td>
				<td>
					<input type="text" name="waktu" size="30" value="<?=$pertemuan[0]['waktu']?>">
					<div style="font-size:11px;" id="response">*) Contoh: 2 x 45 Menit</div>
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Pertemuan Ke</td> 
				<td width="1">:</td>
				<td>
					<input type="text" name="pertemuan_ke" size="20" style="width:50px" value="<?=$pertemuan[0]['pertemuan_ke']?>">
					<input type="hidden" name="id" size="20" value="<?=$pertemuan[0]['id']?>">
				</td>
			</tr>
			
		</tbody></table>

	<input type="hidden" value="1" name="ajax"> 

	<div style="display:none;" class="error-container"> Semua field yang merah harus di isi atau dipilih!  </div>
	</form>
</div>