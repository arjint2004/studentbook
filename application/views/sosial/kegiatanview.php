<div id="main">
        <!-- **Container** -->
        <div class="container">
        
            <!-- **Content Full Width** -->
            <div class="content content-full-width">
                <h2>Kegiatan Siswa</h2>
                <form class="sosial" method="POST" action="<?=site_url('sos/sekolah/simpan_kegiatan')?>" enctype="multipart/form-data">
                    <label>Sekolah</label>
                    <?php
                        if(!empty($sekolah)) {
                            echo '<select name="sekolah">';
                            foreach($sekolah as $item){
                                echo '<option value="'.$item->id.'">'.$item->nama_sekolah.'</option>';
                            }
                            echo '</select>';
                        }
                    ?><br>
                    <label>Judul</label>
                    <input type="text" name="judul"/>
                    <label>Tgl</label>
                    <input type="text" name="tgl_kegiatan"/>
                    <label>Jam</label>
                    <input type="text" name="jam"/>
                    <label>Tempat</label>
                    <input type="text" name="tempat"/>
                    <label>Keterangan</label>
                    <textarea name="keterangan" cols="8" rows="15">
                        
                    </textarea>
                    <label>Foto</label>
                    <input type="file" name="foto"/>
                    <input type="submit" name="Tambah Siswa" value="Save Data"/>
                </form>
            </div>
        </div>
</div>