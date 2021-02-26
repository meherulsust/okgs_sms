<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<title><?php echo $page_title ?></title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<link rel="stylesheet" media="all" type="text/css" href="<?php echo $css_url?>style.css" />
</head>
<body>
<div id="main">
	<?php $mt_tpl->load_element('tab')?>
	<div id="middle">
	   <?php $mt_tpl->load_element('left_menu')?>
		<div id="center-column">
		
			<?php echo $content_for_layout ;?>
		</div>
	
		
	</div>
	
	<div id="footer">
		<p>All rights preserved by <a href='http://www.phpmistri.bengaltech.us'>Reza Ahmed</a> 2011-12</p>
	</div>
</div>


</body>
</html>