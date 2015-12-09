<?

$dirup=str_replace(base_url(),"",$params['file']);
// pr($dirup);die();
if(is_image('D:/webdevel/studentbookgit/'.$dirup)){
?>
<div style="text-align:center;">
<img src="<?=base64_decode($uploadeddir)?>" />
</div>
<?
}else{
?>
<iframe src="https://docs.google.com/viewer?url=<?=$params['file']?>" width="100%" height="2000" style="border: none;"></iframe>
<? } ?>
