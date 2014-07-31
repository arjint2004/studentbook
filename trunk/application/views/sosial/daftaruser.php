<div id="main">
        <!-- **Container** -->
        <div class="container">
        
            <!-- **Content Full Width** -->
            <div class="content content-full-width">
                <h2>Daftar Siswa</h2>
                <form class="sosial" method="POST" action="<?=site_url('sos/sekolah/daftaruser')?>" enctype="multipart/form-data">
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
                    <label>NIS</label>
                    <input type="text" name="nis"/>
                    <label>nama</label>
                    <input type="text" name="nama"/>
                    <label>password</label>
                    <input type="password" name="password"/>
                    <label>Gender</label>
                    <input type="text" name="gender"/>
                    <label>Alamat</label>
                    <input type="text" name="alamat"/>
                    <label>Kota</label>
                    <input type="text" name="kota"/>
                    <label>Telp</label>
                    <input type="text" name="telp"/>
                    <label>Email</label>
                    <input type="text" name="email"/>
                    <label>Foto</label>
                    <input type="file" name="foto"/>
                    <input type="submit" name="Tambah Siswa" value="Save Data"/>
                </form>
            </div>
        </div>
</div>