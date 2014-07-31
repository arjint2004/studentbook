<?

$dirup=str_replace("https://studentbook.co","",base64_decode($uploadeddir));
if(is_image('/home/studoid1/public_html/studentbook.co'.$dirup)){

?>
<div style="text-align:center;">
<img src="<?=base64_decode($uploadeddir)?>" />
</div>
<?
}else{
?>
<iframe src="https://docs.google.com/viewer?url=<?=$urlfile?>" width="100%" height="2000" style="border: none;"></iframe>
<? } ?>
