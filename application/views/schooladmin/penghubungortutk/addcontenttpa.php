<script>
	$(document).ready(function(){
		
			var tr2='<tr baris="1" sub_baris="1" class="sub_2 ncls ncsub2">1<td>&nbsp;</td><td style="width: 1%; border-right: medium none; " >1.1</td><td style="border-right: medium none;"><input type="text" name2 /></td><td><div class="add_sub_2" ></div></td><td class="aspekpenilai"><input type="text" /></td><td class="aspekpenilai"><input type="text" /></td><td class="aspekpenilai"><input type="text"  /></td><td class="aspekpenilai"><input type="text" /></td><td><a class="button small light-grey hapustkx" title="" style="float:none;"  href="#">X</a></td></tr>';
			
			var tr1='<tr baris="1" class="sub_1 ncls"><td>noxx</td><td colspan="2" style="width: 1%; border-right: medium none;"><input type="text" name1 /></td><td style="width:1%;"><div class="add_sub_1" ></div></td><td></td><td></td><td></td><td></td><td><a class="button small light-grey hapustkx" title=""  style="float:none;" href="#">X</a></td></tr>'+tr2;

			var tr3='<tr baris="111" class="sub_3 ncls"><td>&nbsp;</td><td style="width: 1%; border-right: medium none; padding: 2px ! important;" ></td><td style="border-right: medium none;"><input type="text" name3 style="margin-left: 20px; width: 91%;" /></td><td><div class="add_sub_3" ></div></td><td></td><td></td><td></td><td></td><td><a class="button small light-grey hapustkx" title=""  style="float:none;" href="#">X</a></td></tr>';
			
			var tr4='<tr baris="1111" class="sub_4 ncls"><td>&nbsp;</td><td style="width: 1%; border-right: medium none; padding: 2px ! important;" ></td><td style="border-right: medium none;"><input type="text" name4 style="margin-left: 40px; width: 87%;" /></td><td>&nbsp;</td><td></td><td></td><td></td><td></td><td><a class="button small light-grey hapustkx" title=""  style="float:none;" href="#">X</a></td></tr>';

		$("a.addbaristk").live('click', function() {
			var tr1x=tr1;
			tr1x=tr1x.replace("hapustkx", "hapustk");
			tr1x=tr1x.replace("hapustkx", "hapustk");
			//jumlah baris sub_1
			var baris=$("table.penghubungortutk tr.sub_1").length;
			baris++;
			tr1x=tr1x.replace("ncls", "");
			$("table.penghubungortutk tbody").append(tr1x);
			$("table.penghubungortutk tr.sub_1").last().children('td').first().html(baris);
			$("table.penghubungortutk tr.sub_1").last().attr('baris',baris);
			$("table.penghubungortutk tr.sub_2").last().children('td').first().next().html(baris+'.1');
			$("table.penghubungortutk tr.sub_2").last().attr('baris',1);
			$("table.penghubungortutk tr.sub_2").last().attr('sub_baris',baris);
			$("table.penghubungortutk tr.sub_2").last().addClass('par_'+baris);
			$("table.penghubungortutk tr.sub_2").last().addClass('par0_'+baris);
			// naming input
			var obinput=$("table.penghubungortutk tr.sub_1").last().children('td').first().next('td').children('input[type="text"]');
			var obinputsub2=$("table.penghubungortutk tr.sub_1").last().next('tr').children('td').first().next('td').next('td').children('input[type="text"]');
			$(obinput).attr('name','program['+baris+'][nama]');
			$(obinputsub2).attr('name','program['+baris+'][child]['+baris+'_1][nama]');
			//naming aspek
			var obinputaspek1=$("table.penghubungortutk tr.sub_2").last().children('td').first().next('td').next('td').next('td').next('td').children('input[type="text"]');
			var obinputaspek2=$("table.penghubungortutk tr.sub_2").last().children('td').first().next('td').next('td').next('td').next('td').next('td').children('input[type="text"]');
			var obinputaspek3=$("table.penghubungortutk tr.sub_2").last().children('td').first().next('td').next('td').next('td').next('td').next('td').next('td').children('input[type="text"]');
			var obinputaspek4=$("table.penghubungortutk tr.sub_2").last().children('td').first().next('td').next('td').next('td').next('td').next('td').next('td').next('td').children('input[type="text"]');
			
			$(obinputaspek1).attr('name','program['+baris+'][child]['+baris+'_1][aspek][]');
			$(obinputaspek2).attr('name','program['+baris+'][child]['+baris+'_1][aspek][]');
			$(obinputaspek3).attr('name','program['+baris+'][child]['+baris+'_1][aspek][]');
			$(obinputaspek4).attr('name','program['+baris+'][child]['+baris+'_1][aspek][]');
			haps();
			return false;
		});			
		$("table.penghubungortutk tr td div.add_sub_1").live('click', function() {
			var tr2x=tr2;
			tr2x=tr2x.replace("hapustkx", "hapustk");
			var barispar	=$(this).parent('td').parent('tr').attr('baris');
			var classbaris	='par_'+barispar;
			var classbaris0	='par0_'+barispar;
			var lastobj		= $("table.penghubungortutk tr."+classbaris).last();
			var subbaris		= $("table.penghubungortutk tr."+classbaris).attr('sub_baris');
			
			var baris		= $("table.penghubungortutk tr."+classbaris0).length;
			baris++;
			tr2x=tr2x.replace(classbaris, "");
			tr2x=tr2x.replace("ncsub2", "ncsub2 "+classbaris);
			tr2x=tr2x.replace("ncsub2", "ncsub2 "+classbaris0);
			$(lastobj).after(tr2x);
			$("table.penghubungortutk tr."+classbaris).last().attr('sub_baris',subbaris);
			$("table.penghubungortutk tr."+classbaris).last().attr('baris',baris);
			$("table.penghubungortutk tr."+classbaris).last().children('td').first().next().html(subbaris+'.'+baris);
			// naming input
			var obinputsub2=$("table.penghubungortutk tr."+classbaris).last().children('td').first().next().next().children('input');
			$(obinputsub2).attr('name','program['+subbaris+'][child]['+subbaris+'_'+baris+'][nama]');
			
			//naming aspek
			var obinputaspek1=$("table.penghubungortutk tr.sub_2").last().children('td').first().next('td').next('td').next('td').next('td').children('input[type="text"]');
			var obinputaspek2=$("table.penghubungortutk tr.sub_2").last().children('td').first().next('td').next('td').next('td').next('td').next('td').children('input[type="text"]');
			var obinputaspek3=$("table.penghubungortutk tr.sub_2").last().children('td').first().next('td').next('td').next('td').next('td').next('td').next('td').children('input[type="text"]');
			var obinputaspek4=$("table.penghubungortutk tr.sub_2").last().children('td').first().next('td').next('td').next('td').next('td').next('td').next('td').next('td').children('input[type="text"]');
			
			$(obinputaspek1).attr('name','program['+subbaris+'][child]['+subbaris+'_'+baris+'][aspek][]');
			$(obinputaspek2).attr('name','program['+subbaris+'][child]['+subbaris+'_'+baris+'][aspek][]');
			$(obinputaspek3).attr('name','program['+subbaris+'][child]['+subbaris+'_'+baris+'][aspek][]');
			$(obinputaspek4).attr('name','program['+subbaris+'][child]['+subbaris+'_'+baris+'][aspek][]');
			
			haps();
			return false;

		});
		$("table.penghubungortutk tr td div.add_sub_2").live('click', function() {
			var tr3x=tr3;
			tr3x=tr3x.replace("hapustkx", "hapustk");
			
			var barispar_sub	=$(this).parent('td').parent('tr').attr('sub_baris');
			var barispar		=$(this).parent('td').parent('tr').attr('baris');

			var classbaris_sub	='par_'+barispar_sub;
			var classbaris	='par_'+barispar_sub+'_'+barispar;
			
			//tr3x=tr3x.replace("sub_3", "sub_3 ncsub3 "+classbaris_sub+" "+classbaris);
			tr3x=tr3x.replace("sub_3", "sub_3 ncsub3 "+classbaris_sub+" "+classbaris);
			tr3x=tr3x.replace('baris="111"', ' baris_sub="1" baris="'+barispar+'" sub_baris="'+barispar_sub+'"');
			if(typeof $("table.penghubungortutk tr."+classbaris).attr('class') === 'undefined'){
				$(this).parent('td').parent('tr').after(tr3x);
				// naming input
				var obinputsub2=$("table.penghubungortutk tr."+classbaris).last().children('td').first().next().next().children('input');
				$(obinputsub2).attr('name','program['+barispar_sub+'][child]['+barispar_sub+'_'+barispar+'][child]['+barispar_sub+'_'+barispar+'_1][nama]');
				$(obinputsub2).val(''+barispar_sub+'.'+barispar+'.1');
				haps();
				//alert('undf');
				return false;
			}else{
				var lastobj		= $("table.penghubungortutk tr."+classbaris).last();
				var subbaris	= $("table.penghubungortutk tr."+classbaris).attr('sub_baris');
				var baris		= $("table.penghubungortutk tr."+classbaris).length;
				baris++;
				$(lastobj).after(tr3x);
				$("table.penghubungortutk tr."+classbaris).last().attr('sub_baris',subbaris);
				$("table.penghubungortutk tr."+classbaris).last().attr('baris',barispar);
				$("table.penghubungortutk tr."+classbaris).last().attr('baris_sub',baris);
				// naming input
				var obinputsub2=$("table.penghubungortutk tr."+classbaris).last().children('td').first().next().next().children('input');
				$(obinputsub2).attr('name','program['+subbaris+'][child]['+subbaris+'_'+barispar+'][child]['+subbaris+'_'+barispar+'_'+baris+'][nama]');
				$(obinputsub2).val(''+subbaris+'.'+barispar+'.'+baris+'');
				haps();	
				//alert("table.penghubungortutk tr."+classbaris);	
			}

			
			return false;
		});
		$("table.penghubungortutk tr td div.add_sub_3").live('click', function() {
			var tr4x=tr4;
			tr4x=tr4x.replace("hapustkx", "hapustk");
			
			var barispar_sub			=$(this).parent('td').parent('tr').attr('sub_baris');
			var barispar				=$(this).parent('td').parent('tr').attr('baris');
			var barispar_sub_sub		=$(this).parent('td').parent('tr').attr('baris_sub');

			var classbaris_sub	='par_'+barispar_sub;
			var classbaris	='par_'+barispar_sub+'_'+barispar;
			var classbaris_sub_sub	='par_'+barispar_sub+'_'+barispar+'_'+barispar_sub_sub;
			
			//tr4x=tr4x.replace("sub_4", "sub_4 ncsub4 "+classbaris_sub+" "+classbaris);
			tr4x=tr4x.replace("sub_4", "sub_4 ncsub4 "+classbaris_sub+" "+classbaris+" "+classbaris_sub_sub);
			tr4x=tr4x.replace('baris="1111"', ' baris_sub_sub="1" baris_sub="'+barispar_sub_sub+'" baris="'+barispar+'" sub_baris="'+barispar_sub+'"');
			if(typeof $("table.penghubungortutk tr."+classbaris_sub_sub).attr('class') === 'undefined'){
				$(this).parent('td').parent('tr').after(tr4x);
				// naming input
				var obinputsub2=$("table.penghubungortutk tr."+classbaris_sub_sub).last().children('td').first().next().next().children('input');
				$(obinputsub2).attr('name','program['+barispar_sub+'][child]['+barispar_sub+'_'+barispar+'][child]['+barispar_sub+'_'+barispar+'_1][child]['+barispar_sub+'_'+barispar+'_'+barispar_sub_sub+'_1][nama]');
				$(obinputsub2).val(''+barispar_sub+'.'+barispar+'.'+barispar_sub_sub+'.1');
				haps();
				//alert('undf');
				return false;
			}else{
				//alert("table.penghubungortutk tr."+classbaris_sub_sub);
				var lastobj				= $("table.penghubungortutk tr."+classbaris_sub_sub).last();
				var subbaris			= $("table.penghubungortutk tr."+classbaris_sub_sub).attr('sub_baris');
				var baris				= $("table.penghubungortutk tr."+classbaris_sub_sub).attr('baris_sub');
				var baris_sub_sub		= $("table.penghubungortutk tr."+classbaris_sub_sub).length;
				baris_sub_sub++;
				$(lastobj).after(tr4x);
				$("table.penghubungortutk tr."+classbaris_sub_sub).last().attr('sub_baris',subbaris);
				$("table.penghubungortutk tr."+classbaris_sub_sub).last().attr('baris',barispar);
				$("table.penghubungortutk tr."+classbaris_sub_sub).last().attr('baris_sub',baris);
				$("table.penghubungortutk tr."+classbaris_sub_sub).last().attr('baris_sub_sub',baris_sub_sub);
				// naming input
				var obinputsub2=$("table.penghubungortutk tr."+classbaris_sub_sub).last().children('td').first().next().next().children('input');
				$(obinputsub2).attr('name','program['+subbaris+'][child]['+subbaris+'_'+barispar+'][child]['+subbaris+'_'+barispar+'_'+baris+'][child]['+subbaris+'_'+barispar+'_'+baris+'_'+baris_sub_sub+'][nama]');
				$(obinputsub2).val(''+subbaris+'.'+barispar+'.'+baris+'.'+baris_sub_sub+'');
				haps();	
				//alert("table.penghubungortutk tr."+classbaris_sub_sub);	
			}

			
			return false;
		});
		$("a#simpanprg").live('click', function() {
			$('form#penghubungortutkform').submit();
			return false;
		});
		haps();
		function haps(){
			$("table.penghubungortutk tbody tr td a.hapustk").live('click', function() {
				$(this).parent('td').parent('tr').remove();
				return false;
			});		
		}

	});
</script>
<? //pr($_POST);?>
<h1 class="with-subtitle">  Setting Buku Penghubung orang Tua </h1>
<h6 class="subtitle"> Data ini nanti akan muncul di akun guru untuk digunakan mencatat kegiatan siswa </h6>
<div class="styled-elements">
		<div id="ajaxside"></div>
		<div id="listpenghubungortutk">
			<form action="<? echo base_url();?>admin/penghubungortutk/addcontenttpa" id="penghubungortutkform" name="penghubungortutkform" method="post" >
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                            <!--<table class="tableprofil penghubungortutkh" border="1">

								  <tr>
									<td>
									<input placeholder="TEMA" type="text" name="textfield"></td>
									<td>
									<input placeholder="SUB TEMA" type="text" name="textfield"></td>
								  </tr>
							</table>-->
							<table class="tableprofil penghubungortutk" border="1">
								  <tbody>
								  <tr>
								    <th style="width:1%;" >No</th>
								    <th colspan="3"><?=$titlefield?></th>
								    <th colspan="4"><?=$titlefield2?></th>
								    <th style="width:1%;"></th>
								    </tr>
								  <tr>
								    <th style="width:1%;" >&nbsp;</th>
									<th colspan="3">&nbsp;</th>
									<th>1</th>
									<th>2</th>
									<th>3</th>
									<th>4</th>
									<th>&nbsp;</th>
								  </tr>

								  <? if(!empty($content[0]['contarr'])){foreach($content[0]['contarr'] as $baris => $data){?>
								  
								  <tr class="sub_1 " baris="<?=$baris?>">
									  <td><?=$baris?></td>
									  <td style="width: 1%; border-right: medium none;" colspan="2"><input type="text" name1="" value="<?=$data['nama']?>" name="program[<?=$baris?>][nama]"></td>
									  <td style="width:1%;"><div  class="add_sub_1"></div></td>
									  <td></td>
									  <td></td>
									  <td></td>
									  <td></td>
									  <td><a href="#" baris="<?=$baris?>" style="float:none;" title="" class="button small light-grey hapustk">X</a>
									  </td>
								  </tr>
										<? if(!empty($data['child'])){foreach($data['child'] as $baris_2 => $data_2){
											$sub2=explode("_",$baris_2);
										?>
										  <tr class="sub_2 ncls ncsub2 par_<?=$sub2[0]?> par0_<?=$sub2[0]?>" sub_baris="<?=$sub2[0]?>" baris="<?=$sub2[1]?>">
											  <td>&nbsp;</td>
											  <td style="width: 1%; border-right: medium none; "><?=$sub2[0]?>.<?=$sub2[1]?></td>
											  <td style="border-right: medium none;"><input type="text" name2="" value="<?=$data_2['nama']?>" name="program[<?=$sub2[0]?>][child][<?=$sub2[0]?>_<?=$sub2[1]?>][nama]"></td>
											  <td><div  class="add_sub_2"></div><? //pr($data_2);?></td>
												<td class="aspekpenilai"><input type="text" name="program[<?=$sub2[0]?>][child][<?=$sub2[0]?>_<?=$sub2[1]?>][aspek][]" value="<?=$data_2['aspek'][0]?>"></td>
												<td class="aspekpenilai"><input type="text" name="program[<?=$sub2[0]?>][child][<?=$sub2[0]?>_<?=$sub2[1]?>][aspek][]" value="<?=$data_2['aspek'][1]?>"></td>
												<td class="aspekpenilai"><input type="text" name="program[<?=$sub2[0]?>][child][<?=$sub2[0]?>_<?=$sub2[1]?>][aspek][]" value="<?=$data_2['aspek'][2]?>"></td>
												<td class="aspekpenilai"><input type="text" name="program[<?=$sub2[0]?>][child][<?=$sub2[0]?>_<?=$sub2[1]?>][aspek][]" value="<?=$data_2['aspek'][3]?>"></td>
											  <td><a href="#"  style="float:none;" title="" class="button small light-grey hapustk">X</a></td>
										  </tr>
												<? if(!empty($data_2['child'])){foreach($data_2['child'] as $baris_3 => $data_3){
													$sub3=explode("_",$baris_3);
												?> 
													<tr class="sub_3 ncsub3 par_<?=$sub3[0]?> par_<?=$sub3[0]?>_<?=$sub3[1]?> ncls" sub_baris="<?=$sub3[0]?>" baris="<?=$sub3[1]?>" baris_sub="<?=$sub3[2]?>">
														<td>&nbsp;</td>
														<td style="width: 1%; border-right: medium none; padding: 2px ! important;"></td>
														<td style="border-right: medium none;"><input type="text" style="margin-left: 20px; width: 91%;" name3="" value="<?=$data_3['nama']?>" name="program[<?=$sub3[0]?>][child][<?=$sub3[0]?>_<?=$sub3[1]?>][child][<?=$sub3[0]?>_<?=$sub3[1]?>_<?=$sub3[2]?>][nama]"></td>
														<td><div  class="add_sub_3"></div></td>
														<td></td>
														<td></td>
														<td></td>
														<td></td>
														<td><a href="#" style="float:none;" title="" class="button small light-grey hapustk">X</a></td>
													</tr>	

														<? if(!empty($data_3['child'])){foreach($data_3['child'] as $baris_4 => $data_4){
															$sub4=explode("_",$baris_4);
														?> 
															<tr class="sub_4 ncsub4 par_<?=$sub4[0]?> par_<?=$sub4[0]?>_<?=$sub4[1]?> ncls" sub_baris="<?=$sub4[0]?>" baris="<?=$sub4[1]?>" baris_sub="<?=$sub4[2]?>">
																<td>&nbsp;</td>
																<td style="width: 1%; border-right: medium none; padding: 2px ! important;"></td>
																<td style="border-right: medium none;"><input type="text" style="margin-left: 40px; width: 87%;" name4="" value="<?=$data_4['nama']?>" name="program[<?=$sub4[0]?>][child][<?=$sub4[0]?>_<?=$sub4[1]?>][child][<?=$sub4[0]?>_<?=$sub4[1]?>_<?=$sub4[2]?>][nama]"></td>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
																<td></td>
																<td><a href="#" style="float:none;" title="" class="button small light-grey hapustk">X</a></td>
															</tr>	

																		
														<? }  } ?> 
																
												<? }  } ?> 
										<? } } ?> 
								  <? } }?> 
								  </tbody>
							</table>
							<a class="button small grey addbaristk" title="" href=""> Tambah Perkembangan </a>
							<a class="button small light-grey" title="" id="simpanprg" style="float:none;" href=""> Simpan </a>
							<input type="hidden" name="type" value="perkembangan_tk"/> 
			</form>					
			<div class="error-container" style="display:none;"> Semua field harus di isi atau dipilih!  </div>
		</div>
    <div class="clear"> </div>
</div> <!-- **Styled Elements - End** -->  