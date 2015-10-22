<?

$dirup=str_replace(base_url(),"",base64_decode($uploadeddir));
if(is_image('/home/studoid1/public_html/studentbook/trunk'.$dirup)){

?>
<div style="text-align:center;">
<img src="<?=base64_decode($uploadeddir)?>" />
</div>
<?
}else{
?>
<iframe src="https://docs.google.com/viewer?url=<?=$urlfile?>" width="100%" height="2000" style="border: none;"></iframe>
<? } ?>
