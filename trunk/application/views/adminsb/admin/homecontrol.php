
			<!-- TinyMCE -->
	<script type="text/javascript" src="<?=$this->config->item('js');?>ckfinder/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="<?=$this->config->item('js');?>ckfinder/ckfinder.js"></script>
			<script>
				$(document).ready(function(){

					
					$("table.hm tr td").click(function(e){
						//e.stopImmediatePropagation();
						//$('#addartikelok').load('<?=base_url()?>adminsb/admin/addslide/'+$(this).attr('id')+'/'+$(this).parent('tr').attr('id')+'/'+$(this).attr('id_artikel'));
						var obj=$(this);
						var judul=$(this).html();
						$.ajax({
							type: "GET",
							data: '',
							url: '<?=base_url()?>adminsb/admin/flow/'+$(obj).attr('id')+'/'+$(obj).parent('tr').attr('id')+'/'+$(obj).attr('id_artikel'),
							beforeSend: function() {
								$(obj).append("<img id='wait' style='margin:0;float:right;'  src='<?=$this->config->item('images').'loading.png';?>' />");
							},
							success: function(msg) {
								$("#wait").remove();
								$('#addartikelok'+$(obj).parent('tr').attr('id')).html(msg);
								
							}
						});
						$('#addartikelok'+$(obj).parent('tr').attr('id')).scrollintoview({ speed:'1100'});
					});

				});
			</script>
<? //pr($artikelkat);?>
<? foreach($artikelkat as $dataartikelkat){?>
					<h5><?=$dataartikelkat['nama_kategori']?></h5>
					<div id="addartikelok<?=$dataartikelkat['id_kategori']?>"></div>
					<div class="hr"> </div>
					<table class="hm" >
                        <tbody>
                        	<tr id="<?=$dataartikelkat['id_kategori']?>"> 
                            	<td height="60" id="1" id_artikel="<?=$dataartikelkat['data'][1]['id_artikel']?>"><div class="no">1</div><div class="cnt"><?=$dataartikelkat['data'][1]['judul']?></div></td>
                                <td id="2" id_artikel="<?=$dataartikelkat['data'][2]['id_artikel']?>"><div class="no">2</div><div class="cnt"><?=$dataartikelkat['data'][2]['judul']?></div></td>
                                <td rowspan="2" id="3" id_artikel="<?=$dataartikelkat['data'][3]['id_artikel']?>"><div class="no">3</div><div class="cnt"><?=$dataartikelkat['data'][3]['judul']?></div></td>
                                <td colspan="2" id="4" id_artikel="<?=$dataartikelkat['data'][4]['id_artikel']?>"><div class="no">4</div><div class="cnt"><?=$dataartikelkat['data'][4]['judul']?></div></td>
                                <td rowspan="2" id="5" id_artikel="<?=$dataartikelkat['data'][5]['id_artikel']?>"><div class="no">5</div><div class="cnt"><?=$dataartikelkat['data'][5]['judul']?></div></td>
                                <td id="6" id_artikel="<?=$dataartikelkat['data'][6]['id_artikel']?>"><div class="no">6</div><div class="cnt"><?=$dataartikelkat['data'][6]['judul']?></div></td>
                                <td id="7" id_artikel="<?=$dataartikelkat['data'][7]['id_artikel']?>"><div class="no">7</div><div class="cnt"><?=$dataartikelkat['data'][7]['judul']?></div></td>
                                <td colspan="2" id="12" id_artikel="<?=$dataartikelkat['data'][12]['id_artikel']?>"><div class="no">12</div><div class="cnt"><?=$dataartikelkat['data'][12]['judul']?></div></td>
                            </tr>  
                            <tr id="<?=$dataartikelkat['id_kategori']?>"> 
                            	<td height="60" colspan="2" id="8" id_artikel="<?=$dataartikelkat['data'][8]['id_artikel']?>"><div class="no">8</div><div class="cnt"><?=$dataartikelkat['data'][8]['judul']?></div></td>
                                <td id="9" id_artikel="<?=$dataartikelkat['data'][9]['id_artikel']?>"><div class="no">9</div><div class="cnt"><?=$dataartikelkat['data'][9]['judul']?></div></td>
                                <td id="10" id_artikel="<?=$dataartikelkat['data'][10]['id_artikel']?>"><div class="no">10</div><div class="cnt"><?=$dataartikelkat['data'][10]['judul']?></div></td>
                                <td colspan="2" id="11" id_artikel="<?=$dataartikelkat['data'][11]['id_artikel']?>"><div class="no">11</div><div class="cnt"><?=$dataartikelkat['data'][11]['judul']?></div></td>
                                <td id="13" id_artikel="<?=$dataartikelkat['data'][13]['id_artikel']?>"><div class="no">13</div><div class="cnt"><?=$dataartikelkat['data'][13]['judul']?></div></td>
                                <td id="14" id_artikel="<?=$dataartikelkat['data'][14]['id_artikel']?>"><div class="no">14</div><div class="cnt"><?=$dataartikelkat['data'][14]['judul']?></div></td>
                            </tr>                             
                        </tbody>
                    </table>
<? } ?>