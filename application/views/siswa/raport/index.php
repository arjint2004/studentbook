<script>
	$(document).ready(function(){
		/*$.ajax({
			type: "POST",
			data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1',
			url: base_url+'siswa/raport/ekstrakurikuler',
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

<?=$this->load->view('siswa/raport/header')?>
<? //pr($this->session->userdata['setting_raport']);?>
	<table>
        <thead>
            <tr> 
                <th colspan="7"> Nilai hasil Belajar </th>
            </tr> 
            <tr>

                <th>No</th>
                <th>Pelajaran</th>
				<? if($this->session->userdata['setting_raport'][0]['value']['akademik_kkm']==1){?>
                <th >KKM</th>
				<? } ?>
				<? if($this->session->userdata['setting_raport'][0]['value']['akademik_pengetahuan']==1){?>
                <th > Kognitif </th>
				<? } ?>
				<? if($this->session->userdata['setting_raport'][0]['value']['akademik_praktik']==1){?>
                <th > Praktik </th>
				<? } ?>
				<? if($this->session->userdata['setting_raport'][0]['value']['akademik_afektif']==1){?>
                <th > Afektif </th>
				<? } ?>
				<? if($this->session->userdata['setting_raport'][0]['value']['akademik_ketercapaian']==1){?>
                <th > Ketercapaian </th>
				<? } ?>
            </tr>                            
        </thead>
        <tbody>
			<? $no=1; foreach($raport as $id_pelajaran=>$nilai){?>
                <tr> 
                    <td> <?=$no++;?> </td>
                    <td class="title"> <?=$nilai['pelajaran']?> </td>
					<? if($this->session->userdata['setting_raport'][0]['value']['akademik_kkm']==1){?>
                    <td> <?=$nilai['kkm']?> </td>
					<? } ?>
					<? if($this->session->userdata['setting_raport'][0]['value']['akademik_pengetahuan']==1){?>
                    <td> <?=$nilai['kognitif']?> </td>
					<? } ?>
					<? if($this->session->userdata['setting_raport'][0]['value']['akademik_praktik']==1){?>
                    <td> <?=$nilai['praktik']?> </td>
					<? } ?>
					<? if($this->session->userdata['setting_raport'][0]['value']['akademik_afektif']==1){?>
                    <td> <?=$nilai['afektif']?> </td>
					<? } ?>
					<? if($this->session->userdata['setting_raport'][0]['value']['akademik_ketercapaian']==1){?>
                    <td> <?=$nilai['ketercapaian']?> </td>
					<? } ?>
					
                 </tr>   
			<? } ?>
        </tbody>
    </table>
	

</div>