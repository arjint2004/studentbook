<script>
				$(document).ready(function(){
					<? if($jenis==''){?>
					$.ajax({
							type: "POST",
							data: 'filter=1&jenis=<?=$_POST['jenis']?>',
							url: '<?=base_url()?>akademik/kepsek/statistik/<?=$_POST['jenis']?>',
							beforeSend: function() {
								$("select#filterrppstat").after("<img id='waitfilterrppstat<?=$_POST['jenis']?>' src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#waitfilterrppstat<?=$_POST['jenis']?>").remove();
								$("#cnt<?=$_POST['jenis']?>").html(msg);	
							}
					});
					<? } ?>
					$("select#filterrppstat").change(function(e){
						if($(this).val()!=''){
							$.ajax({
								type: "POST",
								data: 'filter='+$(this).val()+'&jenis=<?=$_POST['jenis']?>',
								url: '<?=base_url()?>akademik/kepsek/statistik/<?=$_POST['jenis']?>',
								beforeSend: function() {
									$("select#filterrppstat").after("<img id='waitfilterrppstat<?=$_POST['jenis']?>' src='<?=$this->config->item('images').'loading.png';?>' />");
								},
								success: function(msg) {
									$("#waitfilterrppstat<?=$_POST['jenis']?>").remove();
									$("#cnt<?=$_POST['jenis']?>").html(msg);	
								}
							});
						}
						return false;
					});
				});
</script>	
<? //pr($this->session->userdata['user_authentication']['id_pengguna']);?>			
<table class="tabelfilter">
	<tr>
		<td>
			Filter :
			<select class="selectfilter" id="filterrppstat" name="filter">
				<!--<option  value="">Pilih Waktu</option>-->
				<option <? if($filter==1){echo'selected';}?> value="1">Hari Ini</option>
				<option <? if($filter==7){echo'selected';}?> value="7">Minggu Ini</option>
				<option <? if($filter==30){echo'selected';}?> value="30">Bulan Ini</option>
				<option <? if($filter==180){echo'selected';}?> value="180">Semester Ini</option>
				<option <? if($filter==365){echo'selected';}?> value="365">Tahun Ini</option>
			</select>
			<input type="hidden" value="<?=$_POST['jenis']?>" name="jenis" />
		</td>
	</tr>
</table>
<? //pr($rpp);?>
<table class="noborder">
	<tr>
		<th class="title" style="width:30%;">Nama</th>
		<th style="width:10%;">Jumlah</th>
		<th style="width:10%;">Lihat</th>
		<th>Chart</th>
	</tr>
		<? foreach($guru as $dataguru){?>
			<tr>
				<td class="title"><?=$dataguru['nama']?></td>
				<td style="text-align:center;" class="title"><?=count($rpp[$dataguru['id_peg']])?> POST</td>
				<td style="text-align:center;" class="title"><a class="modal" href="<?=base_url('akademik/kepsek/lihat/'.$_POST['jenis'].'/'.$this->myencrypt->encode(serialize($dataguru)).'')?>">Lihat</a></td>
				<td>
					<? graph(count($rpp[$dataguru['id_peg']]),$totrpp);?>
				</td>
			</tr>
		<? } ?>
</table>