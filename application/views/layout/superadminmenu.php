					
					<script>
							$(document).ready(function(){
								$('.breadcrumb span.current-crumb').html('SELAMAT DATANG SUPER ADMIN');
								//$('ul.menu li:first a').attr('href','<?=base_url()?>');
								$('ul.menu li:first').next().children('a').attr('href','<?=base_url('superadmin/super')?>');
							});
					</script>
					
					<ul class="side-nav">
                        <li <? if($this->router->class=='sekolah' && $this->router->method=='index'){echo 'class="current_page_item"';}?>> <a href="<?=site_url()?>superadmin/sekolah" title="" id="ta"> SEKOLAH <span> </span> </a> </li>
                        <li <? if($this->router->class=='sekolah' && $this->router->method=='smssender'){echo 'class="current_page_item"';}?>> <a href="<?=site_url()?>superadmin/sekolah/smssender" title="" id="ta"> NAMA PENGIRIM SMS <span> </span> </a> </li>
                        <li <? if($this->router->class=='super' && $this->router->method=='accountindex'){echo 'class="current_page_item"';}?>> <a href="<?=site_url()?>superadmin/super/accountindex" title="" id="ta"> DATA ACCOUNT <span> </span> </a> </li>
                    </ul>