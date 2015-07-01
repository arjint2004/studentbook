<script>

$(document).ready(function(){
		var completergnya=$('a#set_pelajaran').attr('id');
		if(completergnya=='set_pelajaran'){
			$('form#mapelform').append('<input type="hidden" name="set_pelajaran" value="set_pelajaran" />');
		}
		var jurusan='<tr id="jurusan"><td class="title">Jurusan</td><td>:</td><td><select name="id_jurusan" class="selectadddata"><option value="">Pilih Jurusan</option><? foreach($jurusan as $datajur){?><option value="<?=$datajur['id']?>"><?=$datajur['nama']?></option><? } ?></select></td></tr>';
		$("#mapelform").each(function(){
			$container = $(this).next("div.error-container");
			//Validate Starts
			$(this).validate({
				onfocusout: function(element) {	$(element).valid();	},
				errorContainer: $container,
				rules:{
				  nama:{required:true,notEqual:''},
				  alias:{required:true,notEqual:''},
				  id_jurusan:{required:true,notEqual:'Pilih Jurusan'},
				  kelompok:{required:true,notEqual:'Pilih Kelompok'}
				  /*,message:{required:true,minlength:10}*/
				}
			});//Validate End

		});


	
	function loaddatamapel(){
		$.ajax({
			type: "POST",
			data: "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1",
			url: base_url+'admin/pelajaran/listData',
			beforeSend: function() {
				$("#listmapelloading").html("<img src='"+config_images+"loading.png' />");
			},
			success: function(msg) {
				$("#listmapel").html(msg);			
			}
		});
	}
	
//Submit Starts		   
		$(".addaccountclose").click(function(){
			$(".addaccount").remove();
		});
		<? if($this->session->userdata['ak_setting']['jenjang'][0]['nama']=='SMA'){?>
		$("select#id_jurusan").load('<?php echo base_url(); ?>admin/pelajaran/getjurusanByjenjang/');
		$("select#jenjangkelas").change(function(){
			$("select#id_jurusan").load('<?php echo base_url(); ?>admin/pelajaran/getjurusanByjenjang/'+$(this).val());
		});
		<? } ?>
		$("#mapelform").submit(function(e){
			if($('select#semester').val()==null){
				$('select#semester').css('border','1px solid red');
				return false;
			}
			if($('select#jenjangkelas').val()==null){
				$('select#jenjangkelas').css('border','1px solid red');
				return false;
			}
			$frm = $(this);
			$nama = $frm.find('*[name=nama]').val();
			$alias = $frm.find('*[name=alias]').val();
			$id_jurusan = $frm.find('*[name=id_jurusan]').val();
			$kelompok = $frm.find('*[name=kelompok]').val();
			if($frm.find('*[name=nama]').is('.valid') <? if($this->session->userdata['ak_setting']['jenjang'][0]['nama']!='SD' && $this->session->userdata['ak_setting']['jenjang'][0]['nama']!='SMP'){?> && $frm.find('*[name=id_jurusan]').is('.valid')<? } ?>  && $frm.find('*[name=kelompok]').is('.valid') && $frm.find('*[name=alias]').is('.valid')) {
				$.ajax({
					type: "POST",
					data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$(this).serialize(),
					url: $(this).attr('action'),
					beforeSend: function() {
						$("input#simpanpelajaran").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$(".addaccount").remove();	
							$.ajax({
								type: "POST",
								data: "<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1",
								url: '<?php echo base_url(); ?>admin/pelajaran/listData',
								beforeSend: function() {
									$("input#simpanpelajaran").after("<img id='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
								},
								success: function(msg) {
								
									//$("#wait").remove();			
									$("#listpelajaran").html(msg);	
									$('div#step').load('<?=site_url()?>admin/schooladmin/completeregoption');		
								}
							});			
					}
				});
				return false;
			}
			
			return false;
		});//Submit End
});
</script>
<div class="addaccount">
<form action="<? echo base_url();?>admin/pelajaran/adddata" id="mapelform" name="mapelform" method="post" >
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
	<div class="addaccountclose" onclick="$('.addaccount').remove();"></div>
	<h3> <?=$page_title?> </h3><?// pr($pelajaran);?>
		<table class="adddata">
		
			<tr>
				<td width="30%" class='title'>Nama Pelajaran</td>
				<td width="1">:</td>
				<td><textarea  name="nama" cols="51%" rows="5" ></textarea></td>
			</tr>
			<tr>
				<td width="30%" class='title'>Alias</td>
				<td width="1">:</td>
				<td>
				<textarea  name="alias" cols="51%" rows="5" ></textarea>
				<br /><br />
				<div style="font-size:11px;" id="response">*) Singkatan nama pelajarang yang akan digunakan untuk SMS notifikasi</div>
				</td>
			</tr>
			<tr id="jenjang">
				<td class="title">Jenjang</td>
				<td>:</td>
				<td>
					<select name="jenjang[]" id="jenjangkelas" class="selectadddata" multiple>
						<option disabled value="">Pilih Jenjang</option>
						<? foreach($grade as $datagrade){?>
						<option <?if($datagrade==@$selected['jenjang']){echo "selected";}?>  value="<?=$datagrade?>"><?=$datagrade?></option>
						<? } ?>
					</select>
				</td>
			</tr>
			<? if($this->session->userdata['ak_setting']['jenjang'][0]['nama']=='SD' || $this->session->userdata['ak_setting']['jenjang'][0]['nama']=='SMP'){?>
				<script>
				$(document).ready(function(){
					$('.addaccountclose').after('<input type="hidden" name="id_jurusan" value="<?=$jurusan[0]['id']?>">');
				});
				</script>
			<? }else{ ?>
			<tr id="jurusan">
				<td class="title">Jurusan</td>
				<td>:</td>
				<td>
					<select name="id_jurusan" id="id_jurusan" class="selectadddata">
						<option value="">Pilih Jurusan</option>
						<? foreach($jurusan as $datajur){?>
						<option <?if($datajur['id']==@$selected['jurusan']){echo "selected";}?> value="<?=$datajur['id']?>"><?=$datajur['nama']?></option>
						<? } ?>
					</select>
				</td>
			</tr>
			<? } ?>
			<tr>
				<td class="title">Semester</td>
				<td>:</td>
				<td>
					<select name="semester[]" id="semester"  class="selectadddata" multiple>
						<? //if($this->session->userdata['ak_setting']['jenjang'][0]['nama']=='SMK'){?>
							<option value="" disabled>Pilih Semester</option>
							<? foreach($semester as $datasemester){?>
							<option selected <?//if($datasemester['id']==@$selected['semester']){echo "selected";}?>  value="<?=$datasemester['id']?>"><?=$datasemester['nama']?></option>
							<? } ?>
						<? //} ?>
					</select>
				</td>
			</tr>
			
			<? //if($this->session->userdata['ak_setting']['jenjang'][0]['nama']=='SD' || $this->session->userdata['ak_setting']['jenjang'][0]['nama']=='SMP'){?>
				<script>
				/*$(document).ready(function(){
					$('.addaccountclose').after('<input type="hidden" name="kelompok" value="Normatif">');
				});*/
				</script>
			<? //}else{ ?>
			<tr>
				<td class="title">Kelompok</td>
				<td>:</td>
				<td>
					<select name="kelompok"  class="selectadddata">
						<option value="">Pilih Kelompok</option>
						<? if($this->session->userdata['ak_setting']['jenjang'][0]['nama']=='SD' || $this->session->userdata['ak_setting']['jenjang'][0]['nama']=='SMP'){?>
						<option value="Normatif">Normatif ( Muatan Nasional )</option>
						<option value="Adaptif">Adaptif ( Muatan Lokal )</option>
						<? }else{ ?>
						<option value="Normatif">Normatif ( Muatan Nasional )</option>
						<option value="Adaptif">Adaptif ( Muatan Lokal )</option>						
						<option value="Produktif">Produktif ( Muatan Jurusan )</option>
						<? } ?>
					</select>
				</td>
			</tr>
			<? //} ?>
			<tr>
				<td class="title" colspan="3"><input id="simpanpelajaran" type="submit" name="simpan" value="Simpan"/></td>
			</tr>
		</table>

	<input type="hidden" name="addpelajaran" value="1"/> 
	<?if($addjenis=='sub'){?>
		<input type="hidden" name="id_parent" value="<?=$pelajaran[0]['id']?>"/> 
	<? } ?>
	<input type="hidden" name="ajax" value="1"/> 
	</form>
	<div class="error-container" style="display:none;"> Semua field harus di isi atau dipilih!  </div>
</div>