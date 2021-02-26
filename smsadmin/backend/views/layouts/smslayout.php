<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $page_title ?></title>
<link rel="shortcut icon" type="image" href="<?php echo base_url().'uploads/logo/school_logo_1614301637_thumb.png'?>"/>
<script type="text/javascript">
	var SITE_URL = '<?php echo site_url(); ?>';
</script>
<link rel="stylesheet" media="all" type="text/css" href="<?php echo $css_url?>style.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $css_url?>theme.css" />
<!--[if IE]>
<link rel="stylesheet" type="text/css" href="<?php echo $css_url?>ie.css" />
<![endif]-->
<?php echo $html_for_head ; ?>
</head>
<body>
	<div id="container">
    	<div id="header">
        	<h2>Omar Kindergarten School & Omar Garten Academy</h2>
                <?php if($this->session->userdata('logged_in')): ?>
                <div class="login-info"> <a href="<?php echo site_url('profile')?>" title="View profile details"><?php echo $this->auth->get_user()->get_full_name().' ('.$this->auth->get_user()->group_title.')' ?></a> </div>
                <?php endif; ?>
        	<?php $mt_tpl->load_element('main_menu')?>
        </div>
        <?php $mt_tpl->load_element('sub_menu')?>
        <div id="wrapper">
            <div id="content">
               <?php echo $content_for_layout; ?>
            </div>
        </div>
       
</div>
 <div id="footer">
     <div class="content">
   	  Copyright &copy; <a href='http://www.aimictacademy.com' title="Visit AIM ICT Academy." target="_blank">AIM ICT Academy.</a> <?php echo date('Y') -1 .'-' .date('Y') ?>
     </div>
</div>
</body>
</html>