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
            url:'<?=site_url('sos/user/upload_foto/')?>',
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
        function last_msg_funtion() 
        { 
            var ID=$(".status_parent:last").attr("id");
            ID = ID.split('_');
            $.post("<?=site_url('sos/user/last_message/')?>/"+ID[1],
            function(data){
            if (data != "") {
                $('div#last_message').html('<img src="<?=$this->config->item('images').'loading.gif';?>">');
                $(".status_parent:last").after(data); 
            }
            $('div#last_message').empty();
            });
        }; 
            
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
        
        $(".delete_foto").live('click',function(){
            $(this).parent().fadeOut(500,function(){
                $(this).remove();
            });
        });
        
        $(".multi_foto").live('click',function(event){
            $("form#form_upload").prepend('<input type="hidden" name="album" value="'+$("#album").val()+'">');
            $.each($("form#demo-upload").find('textarea'),function(idx,val){
                $("form#form_upload").prepend('<textarea name="ket_foto[]" style="opacity:0;" class="foto_properti">'+$(this).val()+'</textarea>'); 
            })
            $("form#demo-upload input").attr('style','opacity:0').addClass('foto_properti').clone().appendTo($("form#form_upload"));
        })
        
        $("form#update_status").live('submit',function(event){
            event.preventDefault();
            var id = $(this).find('input[name=id_user]').val();
            var jenis_user = $(this).find('input[name=user]').val();
            var stat = $(this).find('textarea').val();
            var gambar = $('#gambar').val();
            $(this).find('textarea').val('');
            $("#gambar").val('');
            $("#file_upload").html('');
            if(stat!='') {
                $.post("<?=site_url('sos/user/set_status')?>", { id_user : id, status : stat, user:jenis_user, images : gambar }).done(function(data) {
                    $(".show_status").prepend($(data).fadeIn('slow'));
                    $("#icon_upload").show();
                });
            }
        });
        

        
        //$('a.prev_image').live('click', function() {
        //    $this = $(this);
        //    $.fancybox({
        //        'opacity'       : true,
        //        'overlayShow'	: false,
        //        'transitionIn'	: 'elastic',
        //        'transitionOut'	: 'none'
        //    });
        //    return false;
        //});
        //
        //add komentar
        $(".send_pesan").live('click',function(){
            $("#send_pesan").click();    
        });
        
        $("form#komentar").live('submit',function(e){
            e.preventDefault();
            var jenis_user = $(this).find('input[name=user]').val();
            var id_user = $(this).find('input[name=id_user]').val();
            var id_status = $(this).find('input[name=id_status]').val();
            var komentar = $(this).find('textarea').val();
            $(this).find('textarea').val('');
            if(komentar!='') {
                $.post("<?=site_url()?>sos/user/set_komentar", {id_user:id_user,user:jenis_user,id_status:id_status,komentar:komentar}).done(function(data) {
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
                $.post("<?=site_url('sos/user/del_status')?>", { id_status : result[1] }).done(function(data) {
                    console.log('sukses');    
                });
            });
               
           }else{
            $("#hapuskomentar_"+result[1]).fadeOut( 200, function() { 
                $("#hapuskomentar_"+result[1]).remove(); 
                $.post("<?=site_url('sos/user/del_komentar')?>", { id_komen : result[1] }).done(function(data) {
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
                    autocomplete_url:'<?=site_url('sos/user/cari_teman')?>' // jquery ui autocomplete requires a json endpoint
                });
                
                $(".add").live('click',function(){
                    var id = $(this).attr('id');
                    if(id!=''){
                        $.post('<?=site_url('sos/user/tambah_teman/')?>', {id_user : id }, function(data){
                             if(data=='sukses'){
                                $('a#'+id).text('Menunggu Konfirmasi'); 
                                $('a#'+id).removeAttr('id');
                             }
                        });
                    }
                });
                
                $("#button_acara").live('click',function(){
                    $(".button_acara").fadeOut('slow');
                    $(".form_acara").fadeIn('slow');
                    $(".list_acara").fadeOut('slow');
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
                
                $("#check_all_group").live('click',function(){
                    $(".group_check").attr('checked',this.checked); 
                });
                
                $(".lihat_pesan").live('click',function(){
                    var id_pesan = $(this).attr('id');
                    var id_pesan = id_pesan.split('_');
                    if(id_pesan[0]=='belum') {
                        $(this).parent('td').parent('tr').children('td').removeClass('bold_teks');
                        $(this).parent('td').parent('tr').children('td:last').text('sudah');
                        $.post('<?=site_url('sos/user/baca_pesan')?>',{id_pesan : id_pesan[1]},function(data){
                            $(this).parent('tr').find('<strong></strong>').replaceWith('');
                        });
                    }
                });
            });

    </script>
     <!-- endscroll-->