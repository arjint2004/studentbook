<?

// $dirup=str_replace(base_url(),"",$params['file']);
// pr($dirup);die();
if(is_image('/home/studoid1/public_html/studentbook/trunk/upload/akademik/soalonline/'.$params['file'])){
?>
<div style="text-align:center;">
<img src="<?=$params['url']?>" />
</div>
<?
}else{
?>
<iframe src="https://docs.google.com/viewer?url=<?=$params['url']?>" width="100%" height="2000" style="border: none;"></iframe>
<? } ?>
