<script>

	$(document).ready(function(){
		
		//Submit Starts	
		var breadcumb=$('div.breadcrumb')[0].outerHTML;
		$('div.breadcrumb').remove();
		$('div#top-menu').after(breadcumb);
		$("div.tooltipcekreg a.tooltip-top").click(function(){
			var id=$(this).attr('id');
			if(id=='disable'){return false;}
			var thisobj=$(this);
			var url='';
			switch(id){
				case "set_tahun_ajaran":
					url='<?=site_url()?>admin/setting/tahunAjarancekreg';
				break;
				case "set_semester":
					url='<?=site_url()?>admin/setting/semestercekreg';
				break;
				case "set_jurusan":
					url='<?=site_url()?>admin/jurusan/index';
				break;
				case "set_kelas":
					url='<?=site_url()?>admin/kelas/index';
				break;
				case "set_pelajaran":
					url='<?=site_url()?>admin/pelajaran/index';
				break;
				case "selesai":
					$('div#step').load('<?=site_url()?>admin/schooladmin/completeregoption');
					return false;
				break;
				
			}
			
			$.ajax({
				type: "POST",
				data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&ajax=1',
				url: url,
				beforeSend: function() {
					$(thisobj).attr('class','tooltip-top tooltiphover');
					$(thisobj).append("<img id='wait' style='margin: 0px; float: right; position: absolute; left: 162px;'  src='<?=$this->config->item('images').'loaderhover.gif';?>' />");
				},
				success: function(msg) {
					$("#wait").remove();
					$(thisobj).attr('class','tooltip-top');	
					$('div.main-content').html(msg);
					$('div#step').load('<?=site_url()?>admin/schooladmin/completeregoption');
				}
			});
			return false;
		});
	});
</script>
	<div class="breadcrumb">
    	<div class="breadcrumb-bg">
            <div class="container">
                <span class="current-crumb" style="font-size:13px;"> Langkah 2 : Lengkapi data awal </span>
            </div> 
        </div>
    </div>
	<? 
	unset($cekcompletereg[0]['id']);
	unset($cekcompletereg[0]['id_sekolah']);
	unset($cekcompletereg[0]['set_pegawai']);
	unset($cekcompletereg[0]['set_profil_sekolah']);
	unset($cekcompletereg[0]['set_siswa']);
	unset($cekcompletereg[0]['set_akun']);
	unset($cekcompletereg[0]['finish']);
	if($jenjang[0]['nama']=='SD' || $jenjang[0]['nama']=='SMP' || $jenjang[0]['nama']=='SMA'){
		unset($cekcompletereg[0]['set_jurusan']);	
	}
	unset($cekcompletereg[0]['finish']);
	$i=1;
	foreach($cekcompletereg[0] as $title=>$status ){?>                   
	<div class="column one-fourth tooltip tooltipcekreg" style="width:18%">
		<? 
			if($status==0 && $title!='set_tahun_ajaran'){$titleid='id="disable"';$titleclass='disable';}else{$titleid='id="'.$title.'"';$titleclass='enable';}
			if($status!=0 && $title=='finish'){$titleid='id="finish"';}
		?>
		<a href="" <?=$titleid?>  class="tooltip-top <?=$titleclass?>" title="<?=str_replace("_"," ",$title);?>"><?=$i++?>. <?=str_replace("_"," ",$title);?> </a>
		
	</div>       
	<? } ?>                   
	<div class="column one-fourth tooltip tooltipcekreg" style="width:18%">
		<? 
		//echo $status;
		//echo $title;
		if($status!=0 && $title=='finish'){?>
			<a href="" id="selesai"  class="tooltip-top" title="Selesai"><?=$i++?>. Selesai </a>
		<? }else{ ?>
		<?if($jenjang[0]['nama']=='SD' || $jenjang[0]['nama']=='SMP' || $jenjang[0]['nama']=='SMA'){?>
			<a href="" id="selesai"  class="tooltip-top" title="Selesai"><?=$i++?>. Selesai </a>
		<? }} ?>
	</div>  