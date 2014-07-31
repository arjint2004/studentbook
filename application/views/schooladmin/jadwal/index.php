<script>
	$(document).ready(function() {  	
		$('#kelas').load("<?=base_url()?>admin/jadwal/getKelas/<?=@$_POST['kelas']?>");	
	});

</script>
<div class="contentjadwal">
	<form action="" method="post" >
		Pilih Kelas <select onchange="return submit()" name="kelas" id="kelas"></select>
	</form>
	<?
	
	if(isset($_POST['kelas'])){
		$id_kelas="&id_kelas=".$_POST['kelas'];
	}else{
		$id_kelas="&id_kelas=".$kelas[0]['id']."";
	}
	?>
	<iframe width="100%" height="1200" src="<?=base_url('jadwal');?>/index.php?semester=<?=$ak_setting['semester']?>&ta=<?=$ak_setting['ta']?><?=$id_kelas?>"></iframe>
</div>