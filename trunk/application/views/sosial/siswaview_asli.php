<div class="inner-with-sidebar"></div>
<?php if(!empty($siswa)): ?>
    <script type="text/javascript">
    window.onload=function(){
        $.get("<?=site_url('siswa/get_all_status')?>",function(data) {
            $.each(data['status'], function(idx,val) {
                $.each(data['komen_siswa'], function(index,nilai) {
                    $.each(nilai, function(key,nil){
                        if(nil.id_status==val.id_status) {
                            $('ul').append($('li'));
                        }else{
                            
                            
                        }
                    })
                })
            })
        }, "json");
    };
    
    $(function ()
    {
        $(".wall_update").click(function ()
        {
            var element = $(this);
            var boxval = $("#content").val();
            var dataString = 'content=' + boxval;
            if (boxval == '')
            {
                alert("Please Enter Some Text");
            }
            else
            {
                $("#flash").show();
                $("#flash").fadeIn(400).html('<img src="ajax.gif" align="absmiddle">&nbsp;<span class="loading">Loading Update...</span>');
                $.ajax(
                {
                    type: "POST",
                    url: "update_ajax.php",
                    data: dataString,
                    cache: false,
                    success: function (html)
                    {
                        $("ol#update").prepend(html);
                        $("ol#update li:first").slideDown("slow");
                        document.getElementById('content').value = '';
                        $('#content').value = '';
                        $('#content').focus();
                        $("#flash").hide();
                    }
                });
            }
            return false;
        });
    
    
        // Delete Wall Update
    
        $('.delete_update').live("click", function ()
        {
            var ID = $(this).attr("id");
            var dataString = 'msg_id=' + ID;
            if (confirm("Sure you want to delete this update? There is NO undo!"))
            {
                $.ajax(
                {
                    type: "POST",
                    url: "delete_update.php",
                    data: dataString,
                    cache: false,
                    success: function (html)
                    {
                        $(".bar" + ID).slideUp();
                    }
                });
            }
        });
    
        //Comment Box Slide
        $('.comment').live("click", function ()
        {
            var ID = $(this).attr("id");
            $(".fullbox" + ID).show();
            $("#c" + ID).slideToggle(300);
        });
    
    
        //Wall commment Submit
    
        $('.comment_submit').live("click", function ()
        {
            var ID = $(this).attr("id");
            var comment_content = $("#textarea" + ID).val();
            var dataString = 'comment_content=' + comment_content + '&msg_id=' + ID;
            alert(dataString);
            if (comment_content == '')
            {
                alert("Please Enter Comment Text");
            }
            else
            {
                $.ajax(
                {
                    type: "POST",
                    url: "comment_ajax.php",
                    data: dataString,
                    cache: false,
                    success: function (html)
                    {
                        $("#commentload" + ID).append(html);
                        document.getElementById("textarea" + ID).value = '';
                        $("#textarea" + ID).focus();
                    }
                });
            }
            return false;
        });
    
        //Wall comment delete
    
        $('.cdelete_update').live("click", function ()
        {
            var ID = $(this).attr("id");
            var dataString = 'com_id=' + ID;
            if (confirm("Sure you want to delete this update? There is NO undo!"))
            {
                $.ajax(
                {
                    type: "POST",
                    url: "delete_comment.php",
                    data: dataString,
                    cache: false,
                    success: function (html)
                    {
                        $("#comment" + ID).slideUp();
                    }
                });
            }
        });
    });
    </script>
    <div class="column one-fourth">
        <div class="thumb">
            <a href="portfolio-single.html" title="">
                <img src="<?=base_url($siswa->foto);?>" alt="" title="" width="142" height="155" />
            </a>
        </div>
    </div>
    <div class="column three-fourth last left">
        <a href="#">
            <h2><?=$siswa->nama?></h2>
        </a>
        <div class="row-fluid">
            <div class="span3" style="text-align: left;">
                Sekolah
                <br>Status
                <br>Alamat
                <br>
            </div>
            <div class="span1">:
                <br>:
                <br>:
                <br>
            </div>
            <div class="span8" style="margin-left: 0px;text-align: left;">
                <a href="#" id="sekolah"><?=$siswa->nama_sekolah?></a>
                <br>Siswa
                <br><?=$siswa->alamat?></div>
            </div>
            <div class="buttons" style="float: right;">
                <form method="POST" action="<?=site_url('siswa/edit_siswa')?>">
                    <input type="hidden" name="id_siswa" value="<?=$siswa->id?>"/>
                    <input type="submit" value="Edit" name="submit" class="readmore"/>
                </form>
            </div>
        </div>
    <?php endif ?>
    <div class="hr" style="margin-bottom: 0px;"></div>
    <div class="column one-half">
        <div class="buttons">
            <a href="#" title="" class="tombol_parent button medium light-grey">AKADEMIK</a>
        </div>
    </div>
    <div class="column one-half last">
        <div class="buttons">
            <a href="#" title="" class="button medium tombol_parent light-grey">JEJARING SOSIAL</a>
        </div>
    </div>
    <div class="portfolio column-one-half-with-sidebar">
        <?=print_iklan(); ?>
        <div class="row-fluid">
            <div class="span12">
                <h2 class="float-left">JEJARING SOSIAL</h2>	
            </div>
        </div>
        <div class="tabs-container">
            <ul class="tabs-frame">
                <li>
                    <a href="#" class="current">Status</a>
                </li>
                <li>
                    <a href="#">Update Foto</a>
                </li>
                <li>
                    <a href="#">Teman</a>
                </li>
                <li>
                    <a href="#">Group</a>
                </li>
                <li>
                    <a href="#">Acara</a>
                </li>
                <li>
                    <a href="#">Catatan</a>
                </li>
            </ul>
            <div class="tabs-frame-content back_berita" style="display: block;">
                <div id="status" class="row-fluid span12">
                    <div class="span2">
                        <img src="<?=base_url($siswa->foto)?>" alt="" title="" style="margin-top: 0px;" width="85%">
                    </div>
                    <div class="span10">
                        <form method="post" action="<?=site_url('siswa/set_status')?>">
                            <input type="hidden" name="id_siswa" value="<?=$siswa->id?>"/>
                            <textarea style="width: 94%;height: 70px;" placeholder="Aktifitas Terbaru Anda .." name="status_text"></textarea>
                            <div class="float-right">
                                <input type="submit" class="button small lightblue" value="Bagikan">
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- **Comment Entries** -->   	
                <div class="commententries"> 
                    
                    <ul class="commentlist" id="status_siswa">
                        <li>
                            tes
                        </li>
                        <!--<li> 
                            <div class="comment-author">
                                <img src="images/avatar.jpg" alt="" title="">
                                <a href="" title=""> Master </a>
                            </div>
                            <div class="comment-body">
                                <p> Morbi eu libero justo. Nulla eros dui, eleifend vitae elementum sed, scelerisque eu neque. Cras ac ullamcorper arcu. Proin nisl urna, pellentesque et lobortis id, ornare sit amet magna. Morbi auctor placerat pulvinar. Aenean at diam eget libero faucibus vestibulum. </p>
                            </div>
                            <div class="comment-meta">
                                <div class="commentmetadata"> <a href="" title=""> Wed Feb 02, 2011 at 12 pm </a>  </div>
                                <div class="reply"> <a href="" title=""> [Reply] </a> </div>
                            </div>
                            
                            
                            <ul class="children">
                                <li> 
                                    <div class="comment-author">
                                        <img src="images/avatar.jpg" alt="" title="">
                                        <a href="" title=""> Master </a>
                                    </div>
                                    <div class="comment-body">
                                        <p> Morbi eu libero justo. </p>
                                    </div>
                                    <div class="comment-meta">
                                        <div class="commentmetadata"> <a href="" title=""> Wed Feb 02, 2011 at 12 pm </a>  </div>
                                        <div class="reply"> <a href="" title=""> [Reply] </a> </div>
                                    </div>
                                </li> 
                                <li> 
                                    <div class="comment-author">
                                        <img src="images/avatar.jpg" alt="" title="">
                                        <a href="" title=""> Master </a>
                                    </div>
                                    <div class="comment-body">
                                        <p> Morbi eu libero justo. Nulla eros dui, eleifend vitae elementum sed, scelerisque eu neque. Cras ac ullamcorper arcu. </p>
                                    </div>
                                    <div class="comment-meta">
                                        <div class="commentmetadata"> <a href="" title=""> Wed Feb 02, 2011 at 12 pm </a>  </div>
                                        <div class="reply"> <a href="" title=""> [Reply] </a> </div>
                                    </div>
                                </li>
                            </ul>
                        </li>-->
                    </ul>
                </div>  
                      
                </div>
                <div class="tabs-frame-content" style="display: none;">
                    <p>Tab #2 Content – Donec sed tellus eget sapien fringilla nonummy. Mauris
                        a ante. Suspendisse quam sem, consequat at, commodo vitae, feugiat in,
                        nunc. Morbi imperdiet augue quis tellus. Lorem ipsum dolor sit amet. Quisque
                        aliquam. Donec faucibus. Donec sed tellus eget sapien fringilla nonummy.
                        Mauris a ante. Suspendisse quam sem, consequat at, commodo vitae, feugiat
                        in, nunc. Morbi imperdiet augue quis tellus. Lorem ipsum dolor sit amet.
                        Quisque aliquam. Donec faucibus.</p>
                    </div>
                    <div class="tabs-frame-content" style="display: none;">
                        <p>Tab #3 Content – Donec sed tellus eget sapien fringilla nonummy. Mauris
                            a ante. Suspendisse quam sem, consequat at, commodo vitae, feugiat in,
                            nunc. Morbi imperdiet augue quis tellus. Lorem ipsum dolor sit amet. Quisque
                            aliquam. Donec faucibus.</p>
                        </div>
                    </div>
                    <?=print_iklan()?>
                </div>