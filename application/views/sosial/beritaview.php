<div id="main">
    <!-- **Container** -->
    <div class="container">    
        <!-- **Content Full Width** -->
        <div class="content content-full-width">
             <h2>Berita Sekolah</h2>
            <form class="sosial" method="POST" action="<?=site_url('sekolah/simpan_berita')?>" enctype="multipart/form-data">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                <label>Sekolah</label>
                <?php
                    if(!empty($sekolah)) {
                        echo '<select name="sekolah">';
                        foreach($sekolah as $item){
                            echo '<option value="'.$item->id.'">'.$item->nama_sekolah.'</option>';
                        }
                        echo '</select>';
                    }
                ?>
                <br>
                <label>Judul</label>
                <input type="text" name="judul"/>
                <label>Berita</label>
                <textarea name="berita" cols="10" rows="15">
                    
                </textarea>
                <label>Foto</label>
                <input type="file" name="foto"/>
                <input type="submit" name="Tambah Siswa" value="Save Data"/>
            </form>
        <div>
    </div>
</div>
            