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
						<img src="<?php echo $admin_url.'uploads/logo/'.$logo_file;?>" style="width:80px;"/>
					</a>
				</div>
				<div style="float:left;padding:25px 0 0 10px;">
					<a href="<?php echo site_url(); ?>"><?php echo $name;?></a>
				</div>					
			</div>
			<div class="welcome">
                         
				<ul>
					<li class="icon_user"><?php echo $this->auth->get_user()->get_full_name(); ?> |</li>
					<li class="icon_logout"><a href="<?php echo site_url('login/logout') ?>">Logout</a></li>
				</ul>
			</div>
						
			
		 </div>	
		<div class="clear"></div>
		
		<div id="content">
			<div class="contentright1">		
				 <?php echo $content_for_layout; ?>				
			</div>
			<!-- First top-->
			
			<div class="contentleft" width="90%">
				
				<h1>Profile Menu</h1>
				<div id="profile_menu">
					<ul>
						<li class="icon_home"><a href="<?php echo site_url('home'); ?>">Home</a></li>
						<li class="icon_user"><a href="<?php echo site_url('home/myprofile'); ?>">View Profile</a></li>
						<li class="icon_list"><a href="<?php echo site_url('home/class_routine'); ?>">Class Routine</a></li>
						<li class="icon_list"><a href="<?php echo site_url('book_list'); ?>">Book List</a></li>
						<li class="icon_list"><a href="<?php echo site_url('syllabus_list'); ?>">Syllabus List</a></li>
						<li class="icon_list"><a href="<?php echo site_url('book_list/notebook'); ?>">Note List</a></li>
						<li class="icon_list"><a href="<?php echo site_url('result'); ?>">Results</a></li>
						<li class="icon_user"><a href="<?php echo site_url('student_list/student'); ?>">View Student Profile</a></li>
						<li class="icon_list"><a href="<?php echo site_url('comment'); ?>">Comment Here</a></li>
						<li class="icon_login"><a href="<?php echo site_url('home/change_password'); ?>">Change Password</a></li>
					</ul>
				</div>
				
			</div>


		</div>	
		
		<div id="footer">		
			<div id="footer_menu"> 
			</div>
			<p align="right" style="color:#fff;" class="text">Copyright &copy; <?php echo $name;?></p>
		</div>
	</div>
</body>
</html>