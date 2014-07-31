<?php $this->load->view('sosial/function_pegawai'); ?>
<div class="portfolio column-one-half-with-sidebar">
 <?=print_iklan(); ?>
    <h2 class="float-left">Hasil Pencarian</h2>
    <div class="tabs-container">
        <div class="row-fluid">
        <?php
            if(!empty($data)) {
                $no=0;
                $master_teman = '';
                $friend = '';
                echo '<div class="scrollbar_upload span12" id="style-6">';
                echo '<div class="status_style">
                        <div class="workplace">
                            <div class="head clearfix">
                                <div class="isw-users"></div>
                                <h1><input type="checkbox" class="check_all_user"/> Semua | Orang Yang Mungkin Anda Kenal</h1>
                            </div>
                        </div>
                    </div>';
                echo '<table cellpadding="0" cellspacing="0" width="100%" class="table listUsers" style="overflow:auto;">';
                echo '<tbody>';
                foreach($data as $dt) {
                    $friend .= '<td width="40">
                                    <a href="#"><img src="'.base_url('asset/default/images/no_profile.jpg').'" width="32" class="img-polaroid"></a>
                                </td>
                                <td>
                                    <a href="'.site_url('sos/user/view_profile/'.$dt->id).'" target="_blank" class="user">'.(!empty($dt->nama_pegawai) ? $dt->nama_pegawai : $dt->nama_siswa).'</a><br>';
                                    if($cek){
                                        $friend.='<span>Menunggu Konfirmasi</span>';
                                    }else{
                                        $friend.='<span><input type="checkbox" name="id_undangan[]" class="id_user_undangan float-left" value="'.$dt->id.'"/>&nbsp;<a class="add" id="'.$dt->id.'" style="cursor:pointer;">Tambahkan Teman</a></span>';
                                    }    
                    $friend .= '</td>';    
                    $no++;
                    if($no==3){
                        $master_teman.='<tr>'.$friend.'</tr>';
                        $friend = '';
                        $no=0;
                    }
                }
                
                if($no==1){
                    echo $master_teman;
                    echo '<tr>'.$friend.'<td><td><td><td></tr>';
                }elseif($no==2){
                    echo $master_teman;
                    echo '<tr>'.$friend.'<td></td></tr>';
                }else{
                    echo $master_teman;
                }
                echo '</tbody>';
                echo '</table>';
                echo '</div>';
                
              if(!empty($pagination)) {
                 echo '<div class="row-fluid">';
                     echo '<div class="span12">';
                         echo '<div class="pagination">';
                             echo '<ul>';
                                 echo $pagination;
                             echo '</ul>';
                         echo '</div>';
                     echo '</div>';
                 echo '</div>';
             }
            }else{
                echo 'Pencarian Tidak Ditemukan';
            }
        ?>
        </div>
    </div>
</div>