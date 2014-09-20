	<!--<form method="post" id="frmimport" enctype="multipart/form-data" action="<?=base_url()?>admin/schooladmin/importexcell">
		<input name="akun" class="file" type="hidden" value="<?=$_GET['akun']?>">
		<input class="button small light-grey" type='submit' name="submit" value="export" />
		<div id='file_browse_wrapper'>Pilih File
			<input type='file' name="userfile" id='file_browse'  onchange="$('#filenamexls').html($(this).val());" />
	    </div>
		<div id="filenamexls"></div>onclick="if($('.importkelas').val()==''){alert('kelas harus di isi');}"
	</form>-->
	<? if($listtype=='siswa'){?>
	<script>
	$(document).ready(function(){
		$.validator.addMethod("notEqual", function(value, element, param) {
		  return this.optional(element) || value != param;
		}, "Please choose a value!");

		$(".frmimports").each(function(){
			$container = $(this).next("div.error-container");
			//Validate Starts
			$(this).validate({
				onfocusout: function(element) {	$(element).valid();	},
				errorContainer: $container,
				rules:{
				  kelas:{required:true,notEqual:'Pilih Kelas'}
				  /*,message:{required:true,minlength:10}*/
				}
			});//Validate End

		});
	});
	</script>
	<? } ?>
	<form method="post" class="frmimports" enctype="multipart/form-data" action="<?=base_url()?>admin/schooladmin/importexcell">
		<input name="akun" class="file" type="hidden" value="<?=$_GET['akun']?>">
		<? if($listtype=='siswa'){?>
		<input class="button small light-grey" type='button' name="submit" onclick="window.location='<?=base_url('homepage/send_download/'.base64_encode("upload/akademik/template/FormDataSiswadanOrangTua.xls").'')?>'"   id="buttondownloadsiswa" value="Download File" />
		<? }else{ ?>
		<input class="button small light-grey" type='button' name="submit" onclick="window.location='<?=base_url('homepage/send_download/'.base64_encode("upload/akademik/template/FormDataGuru.xls").'')?>'"  id="buttondownloadguru" onclick="window.location='<?=base_url()?>'" value="Download File" />
		<? } ?>
		<input class="button small light-grey" type='submit' name="submit"  style="margin-right:5px;" id="buttonimport" value="Import Excell" />
		<? if($listtype=='siswa'){?>
		<select name="kelas" class="importkelas">
			<option value="" >Pilih Kelas</option>
			<? foreach($kelas as $datakelas){?>
			<option value="<?=$datakelas['id']?>" ><?=$datakelas['kelas'].$datakelas['nama']?></option>
			<? } ?>
		</select>
		<? } ?>
			<input type='file' name="userfile" id='file_browse' size="15" onchange="$('#filenamexls').html($(this).val());" />
	</form>
	<div class="error-container frmimport"  style="display:none;"> Kelas harus dipilih  </div>