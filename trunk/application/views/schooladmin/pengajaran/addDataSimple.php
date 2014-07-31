<script>
$(document).ready(function(){
		$("#mengajarform").each(function(){
			$container = $(this).next("div.error-container");
			//Validate Starts
			$(this).validate({
				onfocusout: function(element) {	$(element).valid();	},
				errorContainer: $container,
				rules:{
				  kelas:{required:true,notEqual:'Pilih Kelas'},
				  id_jurusan:{required:true,notEqual:'Pilih Jurusan'},
				  id_pegawai:{required:true,notEqual:'Pilih Guru'},
				  /*,message:{required:true,minlength:10}*/
				}
			});//Validate End

		});

	
//Submit Starts	
	   
		$("select#id_kelas,select#id_jurusan,select#id_pegawai").change(function(){
			var obj=$(this);
			$.ajax({
				type: "POST",
				data: $('#mengajarform').serialize()+'&semester=<?=$semester[0]['id']?>&id_kelas='+$('select#id_kelas').find(":selected").attr('id_kelas'),
				url: base_url+'admin/pengajaran/getPelajaranCekbox',
				beforeSend: function() {
					//$(obj).after("<img id='wait' src='"+config_images+"loading.png' />");
				},
				success: function(msg) {
					$('img#wait').remove();
					$("ul#sm1").html(msg);			
				}
			});
			$.ajax({
				type: "POST",
				data: $('#mengajarform').serialize()+'&semester=<?=$semester[1]['id']?>&id_kelas='+$('select#id_kelas').find(":selected").attr('id_kelas'),
				url: base_url+'admin/pengajaran/getPelajaranCekbox',
				beforeSend: function() {
					$(obj).after("<img id='wait' src='"+config_images+"loading.png' />");
				},
				success: function(msg) {
					$('img#wait').remove();
					$("ul#sm2").html(msg);			
				}
			});
		});
		$(".addaccountclose").click(function(){
			$(".addaccount").remove();
		});
		$("#mengajarform").submit(function(e){
		
			$frm = $(this);
			$kelas = $frm.find('*[name=kelas]').val();
			$id_jurusan = $frm.find('*[name=id_jurusan]').val();
			$id_pegawai = $frm.find('*[name=id_pegawai]').val();
			if($frm.find('*[name=kelas]').is('.valid') && $frm.find('*[name=id_jurusan]').is('.valid') && $frm.find('*[name=id_pegawai]').is('.valid')) {
				$.ajax({
					type: "POST",
					data: $(this).serialize()+'&id_kelas='+$('select#id_kelas').find(":selected").attr('id_kelas'),
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
<form action="<? echo base_url();?>admin/pengajaran/adddataSimple" id="mengajarform" name="mengajarform" method="post" >
	<div class="addaccountclose" onclick="$('.addaccount').remove();"></div>
	<h3> Tambah data Pengajaran </h3>
		<table  class="adddata">
		  <thead>
			  <tr>
				<th>Filter</th>
				<th>Semester Ganjil </th>
				<th>Semester Genap 	</th>
			  </tr>
		  </thead>
		  <tbody>
		  <tr>
		    <td><select name="id_pegawai" id="id_pegawai"  class="selectadddata">
              <option value="">Pilih Guru</option>
              <? foreach($pegawai as $oppeg){?>
              <option value="<?=$oppeg['id']?>">
              <?=$oppeg['nama']?>
              </option>
              <? } ?>
            </select></td>
	        <td rowspan="3">
				<ul  class="setotoritas" id="sm1">
					
				</ul>
			</td>
		    <td rowspan="3">
				<ul class="setotoritas" id="sm2">
					
				</ul>
			</td>
		  </tr>
		  <tr>
			<td>
			<select id="id_kelas" name="kelas"  class="selectadddata">
				<option value="">Pilih Kelas</option>
				<? foreach($kelas as $datakelas){?>
				<option id_kelas="<?=$datakelas['id']?>" value="<?=$datakelas['kelas']?>"><?=$datakelas['kelas']?><?=$datakelas['nama']?></option>
				<? } ?>
			</select>
			</td>
		  </tr>
		  <tr>
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
			<td class="title" colspan="3"><input type="submit" name="simpan" value="Simpan"/></td>
		  </tr>
		  </tbody>
		</table>
	<input type="hidden" name="addpengajaran" value="1"/> 
	<input type="hidden" name="ajax" value="1"/> 
  </form>
	<div class="error-container" style="display:none;"> Semua field harus di isi atau dipilih!  </div>
</div>