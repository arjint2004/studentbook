<h2 class="float-left">SMS BROADCAST</h2> 
	<script> 
	$(function(){
	
		var box='<div id="tagsinputnotmn" class="tagsinputnotmn" style="width: auto;margin-top:10px;"></div>';
		$('div.tagsinputnotmn').remove();
		$('div#id_pesan').before(box);
		$('input#hiddenjenis').remove();
		$('div.tagsinputnotmn').after('<input type="hidden" id="hiddenjenis" name="siswadanorangtua" value="guru" />');
		getAllGuru();
		$('div.tagsinput').hide();
		
		function getAllKelas(){
			$.ajax({
						type: "POST",
						data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
						url: base_url+'sos/pegawai/getAllKelas',
						beforeSend: function() {
							$('div#tagsinputnotmn').after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
						},
						success: function(datanya) {
							$("#wait").remove();
							$('div#tagsinputnotmn').html('<div  id="kelassuratdiv" style="width: 30%; display: inline-block; vertical-align: middle; float: left;"> Kelas : <select name="id_kelas" onchange="$(\'select#siswasurat\').load(\'<?=base_url()?>sos/pegawai/getSiswaByKelas/\'+$(this).val())" id="kelassurat"  required>'+datanya+'</select></div>');
							$('div#kelassuratdiv').after('<div id="kelassuratdivsiswa" style="display: inline-block; float: left; vertical-align: middle;  width: 66%;">Siswa : <br /><select name="untuk[]" id="siswasurat" multiple required ><option id="title">Pilih Siswa</option></select></div>');
						}
			});
		}
		function getAllGuru(){
			$.ajax({
						type: "POST",
						data: '<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash(); ?>&',
						url: base_url+'admin/sms/getAllGuru',
						beforeSend: function() {
							$('div#tagsinputnotmn').after("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
						},
						success: function(datanya) {
							$("#wait").remove();
							$('div#tagsinputnotmn').html('<div   style="width: 100%; display: inline-block; vertical-align: middle; float: left;"> <select id="untuk" name="untuk[]" multiple id="kelassurat"  style="width:100%;height:300px;" required>'+datanya+'</select></div>');
							
						}
			});
		}
		
		
		$('form#form_dialog input[type=radio]').click(function(){
			$('div#id_pesan').html('');
			if($(this).val()=='teman'){
				$('div.tagsinput').show();
				$('div.tagsinputnotmn').remove();
			}else if($(this).val()=='siswa'){
				$('div.tagsinputnotmn').remove();
				$('div#id_pesan').before(box);
				$('input#hiddenjenis').remove();
				$('div.tagsinputnotmn').after('<input type="hidden" id="hiddenjenis" name="siswa" value="siswa" />');
				getAllKelas();
				$('div.tagsinput').hide();
			}else if($(this).val()=='orangtua'){
				$('div.tagsinputnotmn').remove();
				$('div#id_pesan').before(box);
				$('input#hiddenjenis').remove();
				$('div.tagsinputnotmn').after('<input type="hidden" id="hiddenjenis" name="orangtua" value="orangtua" />');
				getAllKelas();
				$('div.tagsinput').hide();
			}else if($(this).val()=='siswadanorangtua'){
				$('div.tagsinputnotmn').remove();
				$('div#id_pesan').before(box);
				$('input#hiddenjenis').remove();
				$('div.tagsinputnotmn').after('<input type="hidden" id="hiddenjenis" name="siswadanorangtua" value="siswadanorangtua" />');
				getAllKelas();
				$('div.tagsinput').hide();
			}else if($(this).val()=='guru'){
				$('div.tagsinputnotmn').remove();
				$('div#id_pesan').before(box);
				$('input#hiddenjenis').remove();
				$('div.tagsinputnotmn').after('<input type="hidden" id="hiddenjenis" name="siswadanorangtua" value="guru" />');
				getAllGuru();
				$('div.tagsinput').hide();
			}
			
		});
		
		$('a#pilihAll').click(function(){ //alert('pilih');
			$('div#tagsinputnotmn div select#untuk option').prop('selected', true);
			$('div#kelassuratdivsiswa select#siswasurat option').prop('selected', true);
		});
		$('a#hapusAll').click(function(){ //alert('unpilih');
			$('div#tagsinputnotmn div select#untuk option').prop('selected', false);
			$('div#kelassuratdivsiswa select#siswasurat option').prop('selected', false);		
		});
		
	});
	</script>
    <div class="tabs-container">
        <div class="tabs-frame-content" style="display: block;">
							SMS Tersedia <b><?=$jml_sms?></b> sms
							<ul class="check-list">
								<? if(!empty($status)){
								foreach($status as $nohp=>$statusnya){?>
									<li <? if($statusnya!='Terkirim'){ echo'style="color:red;"';}?>><?=$nohp.'=>'.$statusnya?></li>
								<? } } ?>
							</ul>
						<div class="clear"></div>
                        <form id="form_dialog" class="span6" method="post" action="" enctype="multipart/form-data">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                            <input type="file" name="lampiran" id="lampiran" style="opacity: 0;">
                            <label style="float:left;"><b>Kepada :</b></label><br />
                            
                            <input type="radio" class="kepada" name="kepada" value="guru" checked />Guru
                            <!--<input type="radio" class="kepada" name="kepada" value="siswa" />Siswa-->
                            <input type="radio" class="kepada" name="kepada" value="orangtua" />Orang Tua
                            <!--<input type="radio" class="kepada" name="kepada" value="siswadanorangtua" />Siswa dan Orang Tua<br />--><br />
							<div class="hr-border"> </div>
                            <div class="id_pesan" id="id_pesan"  ></div>
							<a style="cursor:pointer;" id="pilihAll">Select All</a> | <a style="cursor:pointer;" id="hapusAll">Clear All</a>
							<div class="hr-border"> </div>
                            <br /><label><b>Pesan :</b></label>
                            <textarea name="pesan" style="width: 96%;background:white;min-height: 100px;" maxlength="320" required></textarea>
							<i>Untuk menghindari terpotongya SMS maximal 480 character</i>
							<br />
							<input class="button small grey" type="submit" value="Kirim Pesan" id="kirimsurat" name="kirim">
                        </form>
        </div>
        <div class="tabs-frame-content" style="display: none;">
           
    </div>
	