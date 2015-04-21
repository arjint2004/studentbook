<?=$this->load->view('akademik/mainakademik/topindex')?>	
	<script>
		$(document).ready(function() {
			$('#nilaikepribadianbk').load('<?=base_url('akademik/nilaikepribadian/kesiswaanindex/bk')?>');
		});
	</script>
	<h3 id="PembinaKesiswaan"> Penilaian Kepribadian Siswa </h3>

	<div class="hr"></div>
	<div class="tabs-container">

		<ul class="tabs-frame">
			<!--<li>
				<a>Nilai Kegiatan / Pengembangan Diri</a>
			</li>-->
		</ul>
		
		<div class="tabs-frame-content" style="display: none;" id="nilaikepribadianbk">
			
		</div>
	</div>
