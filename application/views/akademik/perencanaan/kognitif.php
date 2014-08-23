<script>
	$(document).ready(function(){
		$("#kirimpr").each(function(){
			$container = $(this).next("div.error-container");
			//Validate Starts
			$(this).validate({
				onfocusout: function(element) {	$(element).valid();	},
				errorContainer: $container,
				rules:{
				  //id_kelas:{required:true,notEqual:'Pilih Kelas'},
				  <? if(isset($_POST['id_pelajaran'])){}else{?>id_pelajaran:{required:true,notEqual:'Pilih Pelajaran'}, <? } ?>
				  bab:{required:true,notEqual:''},
				  judul:{required:true,notEqual:''},
				  //file:{required:true,notEqual:''},
				  tanggal_kumpul:{required:true,notEqual:''},
				  keterangan:{required:true,notEqual:''}
				  /*,message:{required:true,minlength:10}*/
				}
			});//Validate End

		});
		
		$("table.adddata tr th a.cancelpr").click(function(){
				var obj=$(this);
				$.ajax({
					type: "POST",
					data: 'id_kelas='+$('select#kelas').val()+'&pelajaran='+$('select#pelajaran').val()+'&ajax=1',
					url: '<?=base_url('akademik/kirimpr/daftarprlist')?>',
					beforeSend: function() {
						$(obj).after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#wait").remove();
						$('select#kelas').val($('select#kelas_add').val());
						$('select#pelajaran').html($('select#pelajaran_add').html());
						$('select#pelajaran').val($('select#pelajaran_add').val());	
						$('#subjectlist').html(msg);
						
					}
				});
				return false;
		});
		//Submit Starts		   
		$(".addaccountclose").click(function(){
			$(".addaccount").remove();
		});
		$("#kirimpr").submit(function(e){
			$frm = $(this);
			if($('select#kelas_add').val()==null){
				$('select#kelas_add').css('border','1px solid red');
				return false;
			}
			//$id_kelas = $frm.find('*[name=id_kelas]').val();
			<? if(isset($_POST['id_pelajaran'])){}else{?>$id_pelajaran = $frm.find('*[name=id_pelajaran]').val();<? } ?>
			$bab = $frm.find('*[name=bab]').val();
			$judul = $frm.find('*[name=judul]').val();
			//$file = $frm.find('*[name=file]').val();
			$tanggal_kumpul = $frm.find('*[name=tanggal_kumpul]').val();
			$keterangan = $frm.find('*[name=keterangan]').val();
			if(<? if(isset($_POST['id_pelajaran'])){}else{?>$frm.find('*[name=id_pelajaran]').is('.valid') && <? } ?> $frm.find('*[name=bab]').is('.valid') && $frm.find('*[name=judul]').is('.valid') && $frm.find('*[name=tanggal_kumpul]').is('.valid') && $frm.find('*[name=keterangan]').is('.valid')) {
				$.ajax({
					type: "POST",
					data: $(this).serialize()+'&'+$('form#nilai').serialize(),
					url: $(this).attr('action'),
					beforeSend: function() {
						$("#simpanpr").after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#wait").remove();	
						
						ajaxupload("<? echo base_url();?>akademik/perencanaan/uploadfile/"+msg,"response","image-list","filekognitif");
						
						$.ajax({
							type: "POST",
							data: 'id_pelajaran='+$('select#pelajaran_add').val()+'&ajax=1&id_pembelajaran=<?=$id_pembelajaran?>',
							<? if($id_pelajaran==0){?>
							url: '<?=base_url('akademik/perencanaan/afektif')?>',
							<? }else{ ?>
							url: '<?=base_url('akademik/perencanaan/sukses/KOGNITIF')?>',
							<? } ?>
							beforeSend: function() {
								$("#simpanpr").after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$('#fancybox-content div').html(msg);
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


<script type="text/javascript">
function getadd(obj,date) {

}
$(function() {
	$('#datekirimpr').datepick();
});
</script>	
<div class="addaccount">
<form method="post" name="kirimpr" enctype="multipart/form-data" id="kirimpr"  style="width:700px;" action="<? echo base_url();?>akademik/perencanaan/kognitif/0/<?=$id_pelajaran?>">
	<div onclick="$('.addaccount').remove();" class="addaccountclose"></div>
		
		<table>
			<tbody>
				<tr>
					<td>
						<b>KOGNITIF</b>
					</td>
				</tr>
			</tbody>
		</table>
		<table class="adddata">
			<tbody>
			<tr>
				<th style="text-align:right;" colspan="3">
				<a onclick="$('#kirimpr').submit();" id="simpanpr" class="button small light-grey absenbutton" title=""> Simpan </a>
				</th>
			</tr>
			<tr>
				<td class="title">Simpan Sebagai</td>
				<td>:</td>
				<td>
					<input type="checkbox" name="type[pr]" value="pr"  /> PR <br />
					<input type="checkbox" name="type[tugas]" value="tugas"  checked /> TUGAS <br />
					<input type="checkbox" name="type[harian]" value="harian"   /> Ulangan Harian <br />
					<input type="checkbox" name="type[uas]" value="uas"   /> UAS <br />
					<input type="checkbox" name="type[uts]" value="uts"   /> UTS <br />
				</td>
			</tr>
			<tr>
				<td class="title">Pelajaran</td>
				<td>:</td>
				<td>
					<select <? if(isset($_POST['id_pelajaran'])){echo 'disabled';}?> class="selectfilter" id="pelajaran_add" name="id_pelajaran">
						<option value="">Pilih Pelajaran</option>
						<?
						if(!empty($pelajaran)){			
						foreach($pelajaran as $datapelajaran){?>
						<option <? if(@$_POST['id_pelajaran']==$datapelajaran['id']){echo 'selected';}?> value="<?=$datapelajaran['id']?>"><?=$datapelajaran['nama']?> [Kelas <?=$datapelajaran['kelas']?>]</option>
						<? }} ?>
					</select>
					<? if(isset($_POST['id_pelajaran'])){echo '<input type="hidden" name="id_pelajaran" value="'.$_POST['id_pelajaran'].'" />';}?>
				</td>
			</tr>
			<tr>
				<td class="title">Bab</td>
				<td>:</td>
				<td>
					<input type="text" value="" size="30" name="bab">				
				</td>
			</tr>
			<tr>
				<td class="title">Judul</td>
				<td>:</td>
				<td>
					<input type="text" value="" size="30" name="judul">				
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Lampiran Soal</td>
				<td width="1">:</td>
				<td>
					<input type="file" name="file" id="filekognitif" multiple />
					<div id="response" style="font-size:11px;">Anda bisa memilih banyak file dengan memencet tombol "Ctrl", kemudian klik file yang dipilih lebih dari satu</div>
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Tanggal Dikumpulkan</td>
				<td width="1">:</td>
				<td>
					<input type="text" name="tanggal_kumpul" style="width:100px;" value="<?=date('Y-m-d')?>" id="datekirimpr">
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Keterangan</td>
				<td width="1">:</td>
				<td>
					<textarea name="keterangan"></textarea>
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Berbagi</td>
				<td width="1">:</td>
				<td>
					<input type="checkbox" name="share" value="1" checked />
				</td>
			</tr>
			<tr>
				<th style="text-align:right;" colspan="3">
				<a onclick="$('#kirimpr').submit();" id="simpanpr" class="button small light-grey absenbutton" title=""> Simpan </a>
				</th>
			</tr>
		</tbody></table>

	<input type="hidden" value="1" name="ajax"> 
	<input type="hidden" value="<?=$id_pembelajaran?>" name="id_pembelajaran"> 

	<div style="display:none;" class="error-container"> Semua field harus di isi atau dipilih!  </div>
	</form>
</div>