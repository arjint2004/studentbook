<br class="clear" />
<br class="clear" />
<link id="default-css" href="<?=$this->config->item('css');?>sms.css" rel="stylesheet" type="text/css" media="all" />
<? //pr($response);?>
<div class="containersms">
    <form id="signup" action="<?=site_url('admin/sms/index')?>" method="POST">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
        <div class="header">
            <h3>Kirim SMS</h3> 
        </div>
        <div class="sep"></div>
        <div class="inputs">
            <input type="hidden" name="jumlah" value="1"/>
            <input type="hidden" name="from" value="<?=$sendername?>"/>
            <!--<input type="text" name="from" placeholder="Nama Pengirim"/>
            <input type="text" name="phone" placeholder="No Hp, Dipisahkan dengan koma" autofocus />-->
			<textarea name="phone" placeholder="No Hp, Dipisahkan dengan koma" autofocus ></textarea>
			<textarea name="pesan" placeholder="Pesan" cols="40" ></textarea>
            <input type="text" name="password" placeholder="Masukkan Password"/>
            <input type="submit" id="submit" name="kirimsms" value="Kirim"/>
        </div>
    </form>
</div>
​
