<script>
	$(document).ready(function(){
		$("#catatanraportform").submit(function(e){
			$.ajax({
				type: "POST",
				data: $(this).serialize(),
				url: '<?=base_url()?>akademik/raport/catatan/'+$('select#siswaraport').val(),
				beforeSend: function() {
					$("#simpancatatanraport").after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
				},
				success: function(msg) {
					$("#wait").remove();	
					$.ajax({
						type: "GET",
						data: '',
						url: '<?=base_url()?>akademik/raport/catatan/'+$('select#siswaraport').val(),
						beforeSend: function() {
							$("#simpancatatanraport").after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
						},
						success: function(msg) {
							$("#wait").remove();
							$("#catatanload").html(msg);	
						}
					});
					return false;
				}
			});
			return false;
		});
	});
</script>				
<div id="content" class="raport">
	<?=$this->load->view('akademik/raport/header')?>
	
	<form action="<? echo base_url();?>" id="catatanraportform" name="catatanraportform" method="post" >
	<table>
		<thead>
			<tr>
				<th colspan="6" style="text-align:right;">
					<a title="" class="button small light-grey absenbutton" id="simpancatatanraport" onclick="$('#catatanraportform').submit();"> Simpan </a>
				</th>
			</tr>                           
        </thead>
		<tbody>
			<tr> 
			   <td><textarea style="width: 97%; height: 200px; margin: 0px;" name="catatan[<?=$id_det_jenjang?>]" ><?=@$catatan[0]['catatan']?></textarea></td>
			</tr>
		</tbody>
	</table>
	</form>
</div>