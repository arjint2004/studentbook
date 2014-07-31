<div id="main">
        <!-- **Container** -->
        <div class="container">
        
            <!-- **Content Full Width** -->
            <div class="content content-full-width">
                <h2>Daftar Pegawai</h2>
                <form class="sosial" method="POST" action="<?=site_url('sos/sekolah/pegawaidaftar')?>" enctype="multipart/form-data">
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
                    <label>Jenis Pegawai</label>
                    <?php
                        if(!empty($group)) {
                            echo '<select name="pegawai">';
                            foreach($group as $gr){
                                echo '<option value="'.$gr->id.'">'.$gr->otoritas.'</option>';
                            }
                            echo '</select>';
                        }
                    ?>
                    <br>
                    <label>NIP</label>
                    <input type="text" name="nip"/>
                    <label>nama</label>
                    <input type="text" name="nama"/>
                    <label>Alamat</label>
                    <input type="text" name="alamat"/>
                    <label>Kota</label>
                    <input type="text" name="kota"/>
                    <label>password</label>
                    <input type="password" name="password"/>
                    <label>Gender</label>
                    <input type="text" name="gender"/>
                    <label>Telp</label>
                    <input type="text" name="telp"/>
                    <label>Email</label>
                    <input type="text" name="email"/>
                    <label>Foto</label>
                    <input type="file" name="foto"/>
                    <input type="submit" name="tambah_pegawai" value="Save Data Pegawai"/>
                </form>
            </div>
        </div>
</div>