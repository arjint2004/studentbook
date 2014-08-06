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
				  id_pelajaran:{required:true,notEqual:'Pilih Pelajaran'},
				  topik:{required:true,notEqual:''},
				  waktu:{required:true,notEqual:''},
				  pertemuan_ke:{required:true,notEqual:''},
				  tanggal:{required:true,notEqual:''}
				}
			});//Validate End

		});
		$("table.adddata tr th a#cancelpemb").click(function(){
				var obj=$(this);
				$.ajax({
					type: "POST",
					data: 'id_kelas='+$('select#kelas').val()+'&pelajaran='+$('select#pelajaran').val()+'&ajax=1',
					url: '<?=base_url('akademik/instrumen/pembelajaranlist')?>',
					beforeSend: function() {
						$(obj).after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					success: function(msg) {
						$("#wait").remove();
						$('select#pelajaran').html($('select#pelajaran_addpert').html());
						$('select#pelajaran').val($('select#pelajaran_addpert').val());	
						$('#subjectlist').html(msg);
					}
				});
				return false;
		});
		
		//Submit Starts		   
		$(".addaccountclose").click(function(){
			$(".addaccount").remove();
		});
		$("#pembelajaranadd").submit(function(e){
			
			$("#subjectevaluasi").append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
			$(".error-box").html("Memproses Data").fadeIn("slow");
			$frm = $(this);
			$id_pelajaran = $frm.find('*[name=id_pelajaran]').val();
			$topik = $frm.find('*[name=topik]').val();
			$waktu = $frm.find('*[name=waktu]').val();
			$pertemuan_ke = $frm.find('*[name=pertemuan_ke]').val();
			$tanggal = $frm.find('*[name=tanggal]').val();
			if($('select#kelas_addpert').val()==null){
				$('select#kelas_addpert').css('border','1px solid red');
				return false;
			}else{
				$('select#kelas_addpert').css('border','1px solid #D8D8D8');
			}
			if($frm.find('*[name=id_pelajaran]').is('.valid') &&   $frm.find('*[name=topik]').is('.valid') && $frm.find('*[name=waktu]').is('.valid') && $frm.find('*[name=pertemuan_ke]').is('.valid') && $frm.find('*[name=tanggal]').is('.valid')) {
				$.ajax({
					type: "POST",
					data: $(this).serialize()+'&'+$('form#nilai').serialize(),
					url: $(this).attr('action'),
					beforeSend: function() {
						$("#simpanpr").after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
					},
					error	: function(){
								$(".error-box").delay(1000).html('Pemrosesan data gagal');
								$(".error-box").delay(1000).fadeOut("slow",function(){
									$(this).remove();
								});
													
					},
					success: function(msg) {
								$("#wait").remove();
								$(".error-box").delay(1000).html('Data berhasil di simpan');
								$(".error-box").delay(1000).fadeOut("slow",function(){
									$(this).remove();
									$('#subjectevaluasi').load('<?=base_url('akademik/instrumen/pembelajaranlist')?>');
									$('a#addpertemuan').attr('class','readmore');
									$('a#datapertemuan').attr('class','readmore selected');
								});	
					}
				});
				return false;
			}
			
			return false;
		});//Submit End	
		$("select#pelajaran_addpert").change(function(e){
			$.ajax({
				type: "POST",
				data: '',
				url: '<?=base_url()?>admin/pelajaran/getKelasByPelajaranAndPegawai/'+$(this).val(),
				beforeSend: function() {
					$('select#kelas_addpert').after("<img class='wait' src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$('.wait').remove();
					$("select#kelas_addpert").html(msg);	
					
				}
			});
		});//Submit End
	});
</script>		
<link type="text/css" href="<?=$this->config->item('css');?>datepick.css" rel="stylesheet">
<script type="text/javascript" src="<?=$this->config->item('js');?>jquery.datepick.js"></script>
<script type="text/javascript" src="<?=$this->config->item('js');?>jquery.datepick-id.js"></script>

<script type="text/javascript">
function getadd(obj,date) {

}
$(function() {
	$('#tanggalevaluasi').datepick();
});
</script>	
<div class="addaccount">
<form method="post" name="pembelajaran" enctype="multipart/form-data" id="pembelajaranadd" action="<? echo base_url();?>akademik/instrumen/addpertemuan">
		<h3>Tambah Evaluasi Otentik</h3>
		<div class="hr"></div>
		<table class="adddata adddatapemb">
			<tbody>
			<tr>
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
				<td class="title">Pelajaran</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="pelajaran_addpert" name="id_pelajaran">
						<option value="">Pilih Pelajaran</option>
						<?
						if(!empty($pelajaran)){			
						foreach($pelajaran as $datapelajaran){?>
						<option <? //if(@$_POST['pelajaran']==$datapelajaran['id']){echo 'selected';}?> value="<?=$datapelajaran['id']?>"><?=$datapelajaran['nama']?> [Kelas <?=$datapelajaran['kelas']?>]</option>
						<? }} ?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="title">Untuk Kelas</td>
				<td>:</td>
				<td>
					<select class="selectfilter" id="kelas_addpert" name="id_kelas[]" multiple>
						<option value="">Pilih Kelas</option>
						<? foreach($kelas as $datakelas){?>
						<option <? //if(@$_POST['kelas']==$datakelas['id']){echo 'selected';}?> value="<?=$datakelas['id']?>"><?=$datakelas['kelas']?><?=$datakelas['nama']?></option>
						<? } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td width="30%" class="title" >Tanggal Pelaksanaan</td> 
				<td width="1">:</td>
				<td>
					<input type="text" style="width:100px" readonly name="tanggal" id="tanggalevaluasi" size="10" value="">
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Lama Pelaksanaan</td> 
				<td width="1">:</td>
				<td>
					<input type="text" name="waktu" size="30" value="">
					<div style="font-size:11px;" id="response">*) Contoh: 2 x 45 Menit</div>
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Evaluasi Ke</td> 
				<td width="1">:</td>
				<td>
					<input type="text" name="pertemuan_ke" size="20" style="width:50px" value="">
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Topik</td> 
				<td width="1">:</td>
				<td>
					<textarea name="topik"></textarea>
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Keterangan ke Wali/Ortu</td> 
				<td width="1">:</td>
				<td>
					<textarea name="sms"></textarea>
					<div style="font-size:11px;" id="response">*) Jika di isi, keterangan akan dikirim ke Wali/ortu melalui SMS</div>
				</td>
			</tr>
			<tr>
				<th style="text-align:right;" colspan="3">
				<a onclick="$('#pembelajaranadd').submit();" id="simpanpr" class="button small light-grey absenbutton" title=""> Simpan </a>
				</th>
			</tr>
		</tbody></table>

	<input type="hidden" value="1" name="ajax"> 

	<div style="display:none;" class="error-container"> Semua field yang merah harus di isi atau dipilih!  </div>
	</form>
</div>