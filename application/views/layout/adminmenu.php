					
					<script>
							$(document).ready(function(){
								$('.breadcrumb span.current-crumb').html('SELAMAT DATANG ADMIN');
								//$('ul.menu li:first a').attr('href','<?=base_url()?>');
								$('ul.menu li:first').next().children('a').attr('href','<?=base_url('adminsb/admin')?>');
							});
					</script>
					<ul class="side-nav">
                        <li <? if($this->router->class=='artikel' && $this->router->method=='index'){echo 'class="current_page_item"';}?>> <a href="<?=site_url()?>adminsb/artikel/index" title="" id="ta"> KONTENT ARTIKEL <span> </span> </a> </li>
                        <li <? if($this->router->class=='admin' && $this->router->method=='homecontrol'){echo 'class="current_page_item"';}?>> <a href="<?=site_url()?>adminsb/admin/homecontrol" title="" id="ta"> HOME CONTROL <span> </span> </a> </li>
                    </ul>