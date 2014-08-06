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
			$("#pembelajaranadd").append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
			$(".error-box").html("Memproses Data").fadeIn("slow");
			$frm = $(this);
			$topik = $frm.find('*[name=topik]').val();
			$waktu = $frm.find('*[name=waktu]').val();
			$pertemuan_ke = $frm.find('*[name=pertemuan_ke]').val();
			
			if($frm.find('*[name=topik]').is('.valid') && $frm.find('*[name=waktu]').is('.valid') && $frm.find('*[name=pertemuan_ke]').is('.valid')) {
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
									$.fancybox.close();
									$.ajax({
										type: "POST",
										//data: 'id_kelas='+$('select#kelas_add').val()+'&pelajaran='+$('select#pelajaran_add').val()+'&ajax=1',
										data: '',
										url: '<?=base_url('akademik/instrumen/pembelajaranlist')?>',
										beforeSend: function() {
											$("#simpanpr").after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
										},
										success: function(msg) {
											$("#wait").remove();
											$('select#kelas').val($('select#kelas_add').val());
											$('select#pelajaran').html($('select#pelajaran_add').html());
											$('select#pelajaran').val($('select#pelajaran_add').val());
											$('#subjectevaluasi').html(msg);
										}
									});
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
				data: '',
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
<form method="post" name="pembelajaran" enctype="multipart/form-data" id="pembelajaranadd" action="<? echo base_url();?>akademik/instrumen/editpertemuan">
		<h3>Edit Evaluasi</h3>
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
				<?=$this->session->userdata['user_authentication']['nama']?>
				</td>
			</tr>
			<tr>
				<td class="title">Kelas</td>
				<td>:</td>
				<td>
					<? foreach($kelas as $datakelas){?>
						<? if(@$pertemuan[0]['id_kelas']==$datakelas['id']){echo $datakelas['kelas'].$datakelas['nama'];}?>
					<? } ?>
				</td>
			</tr>
			<tr>
				<td class="title">Pelajaran</td>
				<td>:</td>
				<td>
					<?
						if(!empty($pelajaran)){			
						foreach($pelajaran as $datapelajaran){?>
						 <? if(@$pertemuan[0]['id_pelajaran']==$datapelajaran['id']){echo $datapelajaran['nama'];}?>
					<? }} ?>
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Tanggal Pelaksanaan</td> 
				<td width="1">:</td>
				<td>
					<input type="text" style="width:100px"  name="tanggal" readonly id="tanggalevaluasi" size="10" value="<?=$pertemuan[0]['tanggal']?>">
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Lama pelaksanaan</td> 
				<td width="1">:</td>
				<td>
					<input type="text" name="waktu" size="30" value="<?=$pertemuan[0]['waktu']?>">
					<div style="font-size:11px;" id="response">*) Contoh: 2 x 45 Menit</div>
				</td>
			</tr>
			<tr>
				<td width="30%" class="title">Evaluasi Ke</td> 
				<td width="1">:</td>
				<td>
					<input type="text" name="pertemuan_ke" size="20" style="width:50px" value="<?=$pertemuan[0]['pertemuan_ke']?>">
					<input type="hidden" name="id" size="20" value="<?=$pertemuan[0]['id']?>">
				</td>
			</tr>

			<tr>
				<td width="30%" class="title">Topik</td> 
				<td width="1">:</td>
				<td>
					<textarea name="topik"><?=$pertemuan[0]['topik']?></textarea>
				</td>
			</tr>
			<!--<tr>
				<td width="30%" class="title">Keterangan ke Wali/Ortu</td> 
				<td width="1">:</td>
				<td>
					<textarea name="sms"></textarea>
					<div style="font-size:11px;" id="response">*) Jika di isi, keterangan akan dikirim ke Wali/ortu melalui SMS</div>
				</td>
			</tr>-->
		</tbody></table>

	<input type="hidden" value="1" name="ajax"> 

	<div style="display:none;" class="error-container"> Semua field yang merah harus di isi atau dipilih!  </div>
	</form>
</div>