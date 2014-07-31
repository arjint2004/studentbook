<script type="text/javascript">
    function ajaxFileUpload()
    {
        $("#loading").ajaxStart(function(){
            $(this).show();
            $("#icon_upload").hide('fast');
        })
        .ajaxComplete(function(){
            $(this).hide();
        });

        $.ajaxFileUpload
        (
        {
            url:'<?=site_url('sos/siswa/upload_foto/')?>',
            secureuri:false,
            fileElementId:'image_upload',
            dataType: 'json',
            data:{name:'logan', id:'id'},
            success: function (data, status)
            {
                $("#file_upload").append(data.msg);
                $("#gambar").val(data.file);
                if(typeof(data.error) != 'undefined')
                {
                    if(data.error != '')
                    {
                        console.log(data.error);
                    }else
                    {
                        console.log(data.msg);
                    }
                }
            },
            error: function (data, status, e)
            {
                console.log(e);
            }
        }
        )        
        return false;
    }
    
    $(document).ready(function(){
        //function last_msg_funtion() 
        //{ 
        //    var ID=$(".status_parent:last").attr("id");
        //    ID = ID.split('_');
        //    $.post("<?=site_url('sos/group/last_message/')?>/"+ID[1],
        //    function(data){
        //    if (data != "") {
        //        $('div#last_message').html('<img src="<?=$this->config->item('images').'loading.gif';?>">');
        //        $(".status_parent:last").after(data); 
        //    }
        //    $('div#last_message').empty();
        //    });
        //}; 
        //    
        //$(window).scroll(function(){
        //    if ($(window).scrollTop() == $(document).height() - $(window).height()){
        //        last_msg_funtion();
        //    }
        //})
            
        //add status
        $('#status_text').keyup(function (event) {
            if (event.keyCode == 13 && event.shiftKey) {
                var content = this.value;
                var caret = getCaret(this);
                this.value = content.substring(0,caret)+
                "\n"+content.substring(carent,content.length-1);
                event.stopPropagation();
            }else if(event.keyCode==13){
                $("form#update_status").submit(); 
            }
            
        });

        $('.komentar_teks').live('keyup',function (event) {
            if (event.keyCode == 13 && event.shiftKey) {
                var content = this.value;
                var caret = getCaret(this);
                this.value = content.substring(0,caret)+"\n"+content.substring(carent,content.length-1);
                event.stopPropagation();
            }else if(event.keyCode==13){
                $(this).parent().submit();
            }
            
        });
        
        
        $("form#update_status").live('submit',function(event){
            event.preventDefault();
            var id = $(this).find('input[name=id_group]').val();
            var stat = $(this).find('textarea').val();
            var gambar = $('#gambar').val();
            $(this).find('textarea').val('');
            $("#gambar").val('');
            $("#file_upload").html('');
            if(stat!='') {
                $.post("<?=site_url('sos/group/set_status')?>", { id_group : id, status : stat, images : gambar }).done(function(data) {
                    $(".show_status").prepend($(data).fadeIn('slow'));
                    $("#icon_upload").show();
                });
            }
        });
        
        //add komentar
        $("form#komentar").live('submit',function(e){
            e.preventDefault();
            var id_group    = $(this).find('input[name=id_group]').val();
            var id_status   = $(this).find('input[name=id_status]').val();
            var komentar    = $(this).find('textarea').val();
            $(this).find('textarea').val('');
            if(komentar!='') {
                $.post("<?=site_url()?>sos/group/set_komentar", {id_group:id_group,id_status:id_status,komentar:komentar}).done(function(data) {
                    $("#"+id_status).before($(data).fadeIn('slow'));    
                });
            }
        });
        
        //delete
        $(".delete_status").live('click',function(){
            var keterangan = $(this).attr('id');
            var result = keterangan.split('_');
            if(result[0]=='status') {
               $("#hapusstatus_"+result[1]).fadeOut( 200, function() { 
                $("#hapusstatus_"+result[1]).remove();
                $.post("<?=site_url('sos/group/del_status')?>", { id_status : result[1] }).done(function(data) {
                    console.log('sukses');    
                });
            });
               
           }else{
            $("#hapuskomentar_"+result[1]).fadeOut( 200, function() { 
                $("#hapuskomentar_"+result[1]).remove(); 
                $.post("<?=site_url('sos/siswa/del_komentar')?>", { id_komen : result[1] }).done(function(data) {
                    console.log('sukses');    
                });
            });
        }
    });
        
        // $("#cari_nama").live('keypress',function(){
        //     $.post("<?=site_url('siswa/cari_teman')?>", { nama : $(this).val() },function(data) {
        //         $.each(data,function(idx,nil){
        //             $(".show_nama").prepend('<div>'+nil.nama+'</div>').fadeIn('slow');
        //         })
        //     },"json");
        // });

        $("#icon_upload").live('click',function(){
            $("#image_upload").click();
        });

        $("#image_upload").live('change',function(){
            return ajaxFileUpload();  
        })
});
</script>
    
    <script type="text/javascript">
            $(function() {
                $('#tags_3').tagsInput({
                    width: 'auto',
                    //autocomplete_url:'test/fake_plaintext_endpoint.html' //jquery.autocomplete (not jquery ui)
                    autocomplete_url:'<?=site_url('sos/siswa/cari_teman')?>' // jquery ui autocomplete requires a json endpoint
                });
                
                $(".add").live('click',function(){
                    var id = $(this).attr('id');
                    if(id!=''){
                        $.post('<?=site_url('sos/siswa/tambah_teman/')?>', {id_user : id }, function(data){
                             if(data=='sukses'){
                                $('a#'+id).text('Menunggu Konfirmasi'); 
                                $('a#'+id).removeAttr('id');
                             }
                        });
                    }
                });
                
                $("#button_acara").live('click',function(){
                    $(this).fadeOut('slow');
                    $("#back_acara").fadeIn('slow');
                    $(".form_acara").fadeIn('slow');
                    $(".list_acara").fadeOut('slow');
                });
                
                $(".multi_foto").live('click',function(event){
                    $("form#form_upload").prepend('<input type="hidden" name="album" value="'+$("#album").val()+'">');
                    $.each($("form#demo-upload").find('textarea'),function(idx,val){
                        $("form#form_upload").prepend('<textarea name="ket_foto[]" style="opacity:0;" class="foto_properti">'+$(this).val()+'</textarea>'); 
                    })
                    $("form#demo-upload input").attr('style','opacity:0').addClass('foto_properti').clone().appendTo($("form#form_upload"));
                })
                
                $(".view_detail_foto").live('click',function(){
                    var id  = $(this).attr('id');
                    id  = id.split('_');
                    $(".list_foto_group").fadeOut(500);
                    $(".show_foto_group").html('');
                    $(".button_back").fadeIn(500);
                    $.post('<?=site_url('sos/group/list_group_foto')?>',{id_album : id[0]},function(data){
                        $.each(data,function(idx,val){
                            $(".show_foto_group").append('<div class="stack twisted">'+	
                                                        '<a href="<?=base_url()?>'+val.large+'" title="'+val.keterangan+'" class="album_image" rel="group_'+val.id_album+'"><img src="<?=base_url()?>'+val.small+'" /></a>'+
                                                    '</div>');
                        });
                    },"json");
                });
                
                $(".kembali_list_foto").live('click',function(){
                    $(".list_foto_group").fadeIn(500);
                    $(".show_foto_group").html('');
                    $(".button_back").fadeOut(500);
                });
                
                $("#back_acara").live('click',function(){
                    $(".list_acara").fadeIn('slow');
                    $("#button_acara").fadeIn('slow');
                    $(".form_acara").fadeOut('slow');
                    $(this).fadeOut('slow');
                });
                
                 $("#check_all_group").live('click',function(){
                    $(".group_check").attr('checked',this.checked); 
                });
                
                $(".check_all_user").live('click',function(){
                    $(".id_user_undangan").attr('checked',this.checked); 
                });
                
                $("#buat_group").live('click',function(){
                    $(".list_group").fadeOut('slow');
                    $(".form_group").fadeIn('slow');
                    $("#back_group").fadeIn('slow');
                    $(this).fadeOut('slow');
                });
                
                $("#back_group").live('click',function(){
                   $(".list_group").fadeIn('slow');
                   $(".form_group").fadeOut('slow');
                   $("#buat_group").fadeIn('slow');
                   $(this).fadeOut('slow');
                });
            });
    
    </script>