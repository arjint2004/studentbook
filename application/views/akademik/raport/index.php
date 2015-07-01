<script>
	$(document).ready(function(){
		/*$.ajax({
			type: "POST",
			data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1',
			url: base_url+'akademik/raport/ekstrakurikuler',
			beforeSend: function() {
				$("div#ekstrakurikuler").append("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
			},
			success: function(msg) {
				$("#wait").remove();
				$("div#ekstrakurikuler").html(msg);
			}
		});	*/							
	});
</script>
<h3>Nilai Raport</h3>
<div class="hr" style="margin-bottom:0;"></div>
<div id="content" class="raport">
<?=$this->load->view('akademik/raport/header')?>
<? //pr($raport);?>
	<table>
        <thead>
            <tr> 
                <th colspan="7"> Nilai hasil Belajar </th>
            </tr> 
            <tr> 
                <th>No</th>
                <th>Pelajaran</th>
                <th >KKM</th>
                <th > Kognitif </th>
                <th > Praktik </th>
                <th > Afektif </th>
                <th > Ketercapaian </th>
            </tr>                            
        </thead>
        <tbody>
			<? $no=1; 
			if(!empty($raport)){
			foreach($raport as $id_pelajaran=>$nilai){
			if($id_pelajaran!='submapel'){
			?>
                <tr> 
                    <td> <?=$no++;?> </td>
                    <td class="title"> <?=$nilai['pelajaran']?><?//=$id_pelajaran?> </td>
                    <td> <?=$nilai['kkm']?> </td>
                    <td> <?=$nilai['kognitif']?> </td>
                    <td> <?=$nilai['praktik']?> </td>
                    <td> <?=$nilai['afektif']?> </td>
                    <td> <?=$nilai['ketercapaian']?> </td>
                 </tr>   
			<? }  } } ?>
        </tbody>
    </table>
	<? if(!empty($raport['submapel'])){
	   foreach($raport['submapel'] as $sub=>$datasub){?>
	<table>
        <thead>
            <tr> 
                <th colspan="7"> <? $nms=explode("-",$sub);echo $nms[1];?> </th>
            </tr> 
            <tr> 
                <th>No</th>
                <th>Pelajaran</th>
                <th >KKM</th>
                <th > Kognitif </th>
                <th > Praktik </th>
                <th > Afektif </th>
                <th > Ketercapaian </th>
            </tr>                            
        </thead>
        <tbody>
			<? $no=1; 
			if(!empty($raport)){
			foreach($datasub as $id_pelajaran=>$nilai){?>
                <tr> 
                    <td> <?=$no++;?> </td>
                    <td class="title"> <?=$nilai['pelajaran']?><?//=$id_pelajaran?> </td>
                    <td> <?=$nilai['kkm']?> </td>
                    <td> <?=$nilai['kognitif']?> </td>
                    <td> <?=$nilai['praktik']?> </td>
                    <td> <?=$nilai['afektif']?> </td>
                    <td> <?=$nilai['ketercapaian']?> </td>
                 </tr>   
			<? }  } ?>
        </tbody>
    </table>
	<? } } ?>

</div>