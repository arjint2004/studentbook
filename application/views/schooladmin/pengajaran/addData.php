<script>
$(document).ready(function(){


		$("#mengajarform").each(function(){
			$container = $(this).next("div.error-container");
			//Validate Starts
			$(this).validate({
				onfocusout: function(element) {	$(element).valid();	},
				errorContainer: $container,
				rules:{
				  kelas:{required:true,notEqual:'Pilih Jenjang Kelas'},				  				  
				  id_kelas:{required:true,notEqual:'Pilih Kelas'},
				  id_jurusan:{required:true,notEqual:'Pilih Jurusan'},
				  semester:{required:true,notEqual:'Pilih Semester'},
				  id_pelajaran:{required:true,notEqual:'Pilih Pelajaran'},
				  id_pegawai:{required:true,notEqual:'Pilih Guru'},
				  /*,message:{required:true,minlength:10}*/
				}
			});//Validate End

		});


	
	function loaddatamengajar(){
		$.ajax({
			type: "POST",
			data: "ajax=1",
			url: base_url+'admin/pengajaran/listData',
			beforeSend: function() {
				$("#listmengajarloading").html("<img src='"+config_images+"loading.png' />");
			},
			success: function(msg) {
				$("#listmengajar").html(msg);			
			}
		});
	}
	
//Submit Starts	
	   
		$("select#kelas,select#id_jurusan,select#semester").change(function(){
			var obj=$(this);
			$.ajax({
				type: "POST",
				data: $('#mengajarform').serialize(),
				url: base_url+'admin/pengajaran/getPelajaran',
				beforeSend: function() {
					$(obj).after("<img id='wait' src='"+config_images+"loading.png' />");
				},
				success: function(msg) {
					$('img#wait').remove();
					$("#pelajaran").html(msg);			
				}
			});
			if($(obj).attr('name')=='kelas'){
			$.ajax({
				type: "POST",
				data: $('#mengajarform').serialize(),
				url: base_url+'admin/pengajaran/getKelas',
				beforeSend: function() {
					$('img#wait').remove();
					$(obj).after("<img id='wait' src='"+config_images+"loading.png' />");
				},
				success: function(msg) {
					$('img#wait').remove();
					$("#id_kelas").html(msg);			
				}
			});
			}
		});
		$(".addaccountclose").click(function(){
			$(".addaccount").remove();
		});
		$("#mengajarform").submit(function(e){
		
			$frm = $(this);
			$kelas = $frm.find('*[name=kelas]').val();
			$id_jurusan = $frm.find('*[name=id_jurusan]').val();
			$semester = $frm.find('*[name=semester]').val();
			$id_pelajaran = $frm.find('*[name=id_pelajaran]').val();
			$id_pegawai = $frm.find('*[name=id_pegawai]').val();
			if($frm.find('*[name=id_kelas]').is('.valid') && $frm.find('*[name=kelas]').is('.valid') && $frm.find('*[name=id_jurusan]').is('.valid') && $frm.find('*[name=semester]').is('.valid') && $frm.find('*[name=id_pelajaran]').is('.valid') && $frm.find('*[name=id_pegawai]').is('.valid')) {
				$.ajax({
					type: "POST",
					data: $(this).serialize(),
					url: $(this).attr('action'),
					beforeSend: function() {
						$("#adduser").html("<img src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						if(msg==1){
							$(".addaccount").remove();	
							$.ajax({
								type: "POST",
								data: "ajax=1&id_pegawai="+$id_pegawai,
								url: '<?php echo base_url(); ?>admin/pengajaran/listData',
								beforeSend: function() {
									$("#listmengajarloading").html("<img src='<?=$this->config->item('images').'loading.png';?>' />");
								},
								success: function(msg) {
									$("#listpengajaran").html(msg);			
								}
							});		
						}else{
							alert('Guru ini sudah mengajar di kelas, jurusan, semester, pelajaran yang anda pilih.');
						}
								
					}
				});
				return false;
			}
			
			return false;
		});//Submit End
});
</script>
<div class="addaccount">
<form action="<? echo base_url();?>admin/pengajaran/adddata" id="mengajarform" name="mengajarform" method="post" >
	<div class="addaccountclose" onclick="$('.addaccount').remove();"></div>
	<h3> Tambah data Pengajaran </h3>
		<table class="adddata">

			<tr>
				<td class="title">Jenjang Kelas</td>
				<td>:</td>
				<td>
					<select id="kelas" name="kelas"  class="selectadddata">
						<option value="">Pilih Jenjang Kelas</option>
						<? foreach($grade as $datagrade){?>
						<option value="<?=$datagrade?>"><?=$datagrade?></option>
						<? } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="title">Kelas</td>
				<td>:</td>
				<td>
					<select id="id_kelas" name="id_kelas"  class="selectadddata">
						<option value="">Pilih Kelas</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="title">Semester</td>
				<td>:</td>
				<td>
					<select id="semester" name="semester"  class="selectadddata">
						<option value="">Pilih Semester</option>
						<? foreach($semester as $datasemester){?>
							<option <? if(@$_POST['semester']==$datasemester['id']){echo 'selected';}?> value="<?=$datasemester['id']?>"><?=$datasemester['nama']?></option>
						<? } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="title">Jurusan</td>
				<td>:</td>
				<td>
					<select id="id_jurusan" name="id_jurusan" class="selectadddata">
						<option value="">Pilih Jurusan</option>
						<? foreach($jurusan as $datajur){?>
						<option value="<?=$datajur['id']?>"><?=$datajur['nama']?></option>
						<? } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="title">Pelajaran</td>
				<td>:</td>
				<td>
					<select name="id_pelajaran" id="pelajaran"  class="selectadddata">
						<option value="">Pilih Pelajaran</option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="title">Guru</td>
				<td>:</td>
				<td>
				
					<select name="id_pegawai" id="id_pegawai"  class="selectadddata">
						<option value="">Pilih Guru</option>
						<? foreach($pegawai as $oppeg){?>
						<option value="<?=$oppeg['id']?>"><?=$oppeg['nama']?></option>
						<? } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="title" colspan="3"><input type="submit" name="simpan" value="Simpan"/></td>
			</tr>
		</table>

	<input type="hidden" name="addpengajaran" value="1"/> 
	<input type="hidden" name="ajax" value="1"/> 
	</form>
	<div class="error-container" style="display:none;"> Semua field harus di isi atau dipilih!  </div>
</div>