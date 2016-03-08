
<script>
$(document).ready(function(){
	$("form#kuncijawaban").submit(function(e){
					$.ajax({
						type: "POST",
						data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&'+$(this).serialize(),
						url: $(this).attr('action'),
						beforeSend: function() {
							$("#soalonline").append("<div class=\"error-box\" style='display: block; top: 50%; position: fixed; left: 46%;'></div>");
							$(".error-box").delay(1000).html('Memasukkan Data');
							//$("#simpanpr").after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
						},
						success: function(msg) {
							$(".error-box").delay(1000).fadeOut("slow",function(){
								$(this).remove();
							});		
							
						}
					});
					return false;
	});
});
</script>
<h3>Kunci Jawaban</h3>
<div class="hr"></div>
<br />
<style>
ul.kuncilist{
	float: left;
	width: 167px;
}
ul.kuncilist li div{
	float: left;
	margin: 0 0 0 11px !important;
	font-weight:bold;
}
ul.kuncilist li input[type="radio"]{
	
}
ul.kuncilist li{
	list-style: outside none none;
	padding: 0 0 5px;
	text-align: right;
	width: 100%;
}
</style>
<form style="width:700px;" method="post" name="kuncijawaban" enctype="multipart/form-data" id="kuncijawaban" action="<? echo base_url();?>akademik/soalonline/kuncijawaban">
	<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
		<ul class="kuncilistf" style="display:none;">
		<?php 
		$no=1;
		for($i=0;$i<=$jmlsoal-1;$i++){?>
		<?php if($i%10==0){?>
		</ul>
		<ul class="kuncilist">
		<?php }?>
			<li>
				<div><?php echo $no;?></div>
				A<input type="radio" name="kunci[]" value="A"/>
				B<input type="radio" name="kunci[]" value="B"/>
				C<input type="radio" name="kunci[]" value="C"/>
				D<input type="radio" name="kunci[]" value="D"/>
			</li>
		<?php $no++;} ?>
		</ul>
		<!--<li style="list-style:none;">
		<a id="simpansoalonline" class="button small light-grey absenbutton" title="" onclick="$('form#kuncijawaban').submit();"> Simpan </a>
		</li>-->
	
</form>