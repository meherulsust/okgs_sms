<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo $page_title ?></title>
	<link rel="shortcut icon" type="image" href="<?php echo $admin_url.'uploads/logo/'.$logo_file;?>"/>	
	<link href="<?php echo $css_url;?>style.css" rel="stylesheet" media="all" />
        <script type="text/javascript">
            var SITE_URL = '<?php echo site_url(); ?>';
        </script>
	<script src="<?php echo $js_url;?>jquery-1.7.js"></script>	
        <?php echo $html_for_head ; ?>
</head>
<body>

	<div id="pagewrap">	
	
		<div id="header">
			<div id="logo">				
				<div style="float:left;">
					<a href="<?php echo site_url(); ?>">
						<img src="<?php echo base_url().'smsadmin/uploads/logo/'.$logo_file;?>" style="width:80px;"/>
					</a>
				</div>
				<div style="float:left;padding:25px 0 0 10px;">
					<a href="<?php echo site_url(); ?>"><?php echo $name;?></a>
				</div>					
			</div>	
			
		 </div>	
		<div class="clear"></div>
		
		<div id="content">
			<div class="contentright1">		
				 <?php echo $content_for_layout; ?>				
			</div>
			<div class="contentleft">			
				<img src="<?php echo $image_url."/student.jpg" ?>" border="none"/>
				
			</div>			
		</div>	
		
		<div id="footer">		
			<div id="footer_menu"> 
				<ul>
					<?php // echo $footer_menu_html; ?>		
				</ul>
			</div>
			<p align="right" style="color:#fff;" class="text">Copyright &copy; <?php echo $name;?></p>
		</div>
	</div>
</body>
</html>