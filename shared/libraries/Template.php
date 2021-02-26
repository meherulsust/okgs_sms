<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @ Author      Reza Ahmed <coder.reza@gmail.com>
 * @ Created    Jun 12, 2011
 */
class Template{
	
	protected $template_name;
	protected $image_dir = 'images';
	protected $css_dir   = 'css';
	protected $js_dir    = 'js'; 
	protected $image_url;
	protected $js_url;
	protected $css_url;
	protected $CI;
	protected $active_module;
	protected $active_action;
	private   $_template_var=array();
	protected $css = array();
	protected $js = array();
	protected $embedded_css = '';
	protected $embedded_js = '';
	protected $layout = 'default';
	protected $view_file='';
	protected $view_ext='php';
	protected $view_sufix ='_tpl';
	
	function __construct()
	{
		$this->CI = &get_instance();
		$this->CI->load->helper('url');
	}
	/**
	 * 
	 * assign template variables which
	 * will be available in the view
	 */
	function get_template_name()
	{
	    return $this->template_name;	
	}
	function set_template_name($name)
	{
		$this->template_name = $name;
		$this->set_template_vars();
	}
	public function set_page_title($str)
	{
		 $this->_template_var['page_title'] = $str;
	}
	
	
	
	/*
	 * set class variable to exact value
	 */
	protected function set_template_vars()
	{
		$base_url = base_url();
		if($this->template_name == '')
		{
			$this->image_url = $base_url.$this->image_dir.'/';
			$this->css_url = $base_url.$this->css_dir.'/';
			$this->js_url = $base_url.$this->js_dir.'/';
		}
		else
		{
			$this->image_url = $base_url.$this->template_name.'/'.$this->image_dir.'/';
			$this->css_url = $base_url.$this->template_name.'/'.$this->css_dir.'/';
			$this->js_url = $base_url.$this->template_name.'/'.$this->js_dir.'/';
		}	
		
	}
	
	protected function assign_template_vars()
	{
		$this->set_template_vars();
		$this->assign('mt_tpl',$this);
		$this->assign('mt_ci',$this->CI);
		$this->assign('css_url', $this->css_url);
		$this->assign('js_url', $this->js_url);
		$this->assign('image_url',$this->image_url);
		$this->assign('active_module', $this->CI->router->class);
		$this->assign('active_action', $this->CI->router->method);
		$this->assign('admin_url', str_replace('teacher/','',base_url().'smsadmin/'));
		return true;
		
	}
	
	public function __get($name)
	{
		if($this->is_class_property($name))
		return $this->{$name};
		else
		{
			return '';
		}
	}
	
	public function __set($name,$val)
	{
		if($this->is_class_property($name))
		 $this->{$name} = $val;
	}
	
	/**
	 * 
	 * magic function will be used
	 * as geter and seter
	 */
	
	public function __call($name,$args)
	{
		 $cvar = str_replace(array('get_','set_'),array('',''),$name);
		 if(!empty($cvar) && $this->is_class_property($cvar))
		 {
		 	if(strpos($name,'get')!==FALSE)
		 		return $this->{$cvar}; 
		 	elseif(strpos($name,'set') !== FALSE)
		 	{
		 		if(empty($args))
		 		{
		 			log_message('error', "No argument is supplied in ".get_class($this).'::'.$name.'()');
					show_error("No argument is supplied in ".get_class($this).'::'.$name.'()');
		 		}
		 		else
		 		{
		 			$this->{$cvar} = $args[0];
		 		}
		 	    return true;
		 	}
		 }
		 
		 log_message('error',get_class($this).'::'.$name.'() is not defined');
		 show_error(get_class($this).'::'.$name.'() is not defined');
	}
	
 function set_css($files)
  {
  	if(is_array($files))
  	{
  		$this->css=array_merge($this->css,$files);
  	}
  	elseif(strpos($files,',')===TRUE)
  	{
  		$this->css=array_merge($this->css,explode(',',$files));
  	}
  	else
  	{
  		array_push($this->css,$files);
  	}	
  }
  
  function set_js($files)
  {
  	if(is_array($files))
  	{
  		$this->js=array_merge($this->js,$files);
  	}
  	elseif(strpos($files,',')===TRUE)
  	{
  		$this->js=array_merge($this->js,explode(',',$files));
  	}
  	else
  	{
  		array_push($this->js,$files);
  	}	
  }
  
 function embed_css($text)
  {
  	 $this->embedded_css .=$text."\n";
  }
  function embed_js($text)
  {
  	$this->embedded_js .=$text."\n";
  }
  /**
   * Include jquery ui js files
   * it is assumed that query ui js files exist in ui directory
   * of js path.
   * @param Mix $js
   * @return Object
   */ 
  public function set_jquery_ui($js='')
  {
		$this->set_js(array('ui/jquery.ui.core','ui/jquery.ui.widget'));
		$this->set_css(array('ui/redmond/jquery.ui.all'));
		if(is_array($js))
		{
			 foreach($js as &$val)
			 {
			 	$val = 'ui/jquery.ui.'.$val;
			 }
		}
		//else
		//$js = 'ui/jquery.ui.'.$js;
		
		$this->set_js($js);
		
		return $this;
  }
	public function assign($key, $val='')
	{
		if(is_array($key))
	     $this->_template_var=array_merge($this->_template_var,$key);
	     else
		$this->_template_var[$key] = $val;
	}
	public function get_assigned_var($name)
	{
		if(isset($this->_template_var[$name]))
			return $this->_template_var[$name];
		else
			return false;
	}
	/**
	 * embed file from view/elements
	 * directory where it will be called. 
	 * @arg  String  
	 * @return NULL
	 */
	public function load_element($element_name)
	{
		$this->CI->load->view('elements/'.$element_name.'.'.$this->view_ext);
	}
  /**
   * returns current template path
   * if no template is set it will return
   * view path.
   * @return String
   */
  public function get_template_path()
  {
  	 $path = $this->CI->load->_ci_view_path.$this->template_name;
  	 $path = trim($path,'/');
  	 return $path.'/';
  }
  
  /**
   * returns current layout path
   * @return String
   */
  public function get_layout_path()
  {
  	 return $this->get_template_path().'layouts/';
  }
	/*
	 * check for class variable
	 * @arg String
	 * @return boolean
	 */
	private function is_class_property($var)
	{
		if(empty($var))
		return false;
		$vars = get_class_vars(__CLASS__);
		return array_key_exists($var,$vars);
	}
	
	/**
	 * print dynamic js and
	 * css when it is called
	 */
  function dynamic_head_content()
   {
	   	$custom_head="\n";
		foreach($this->css as $css)
		{
			$custom_head .= '<link rel="stylesheet" type="text/css" href="'.$this->css_url.$css.'.css" />'."\n"; 
			
		}
		foreach($this->js as $js)
		{
			if($js !=""){
				$custom_head .= '<script language="javascript" type="text/javascript" src="'.$this->js_url.$js.'.js"></script>'."\n"; 
			}	
			
			
		}
		unset($this->css);
		unset($this->css);
		if($this->embedded_css)
		{
		      $custom_head .="\n".'<style type="text/css">'."\n";	
		      $custom_head .=$this->embedded_css."\n";
		      $custom_head .='</style>';
		      unset($this->embedded_css);
		}
		
		if($this->embedded_js)
		{
		      $custom_head .="\n".'<script type="text/javascript">'."\n";	
		      $custom_head .=$this->embedded_js."\n";
		      $custom_head .='</script>';
		      unset($this->embedded_js);
		}
		return  $custom_head."\n";
   }
   
   /**
    * set view file to render
    * within layout
    * @param string 
    * @return none
    */
   public function set_view($view_file,$absolute=false)
   {
   	  if($view_file)
   	  {
	   	  if($absolute)
	   	  { 
	   	  	$this->view_file = $view_file;
	   	  }
	   	  else
	   	  {
	   	  		$this->view_file =  $this->CI->router->class.'/'.$view_file.$this->view_sufix.'.'.$this->view_ext;;
	   	  }	
   	  }
   	  else 
   	  $this->view_file = false;	  
   }
   public function render()
   {
   	  $this->assign_template_vars();
   	 // if view is already loaded in controller.
   	  $output = $this->CI->output->get_output() ;
   	  if($output)
   	  {
   	  	return true;
   	  }
   	  $layout = $this->get_layout();
   	  $layout_file = $this->get_layout().'.'.$this->view_ext;
   	  $layout_path = $this->get_layout_path();
   	  $view_file_name ='';
      if($this->view_file)
      {
      	$view_file_name = $this->view_file;
      }
      elseif($this->view_file === '')
      {
      	   $view_file_name = $this->CI->router->class.'/'.$this->CI->router->method.$this->view_sufix.'.'.$this->view_ext;
      }
      elseif($this->view_file === false)
      {
      	return true;
      }
     if($layout!==FALSE)
     {
     	if(file_exists($layout_path.$layout_file))
     	{
   	  	 $content_for_layout = $this->CI->load->view($view_file_name,$this->_template_var,TRUE);
   	  	 $this->assign('content_for_layout',$content_for_layout);
   	  	 $this->assign('html_for_head',$this->dynamic_head_content());
   	  	 $this->CI->load->view('layouts/'.$layout_file,$this->_template_var);
     	} 
     	else
     	{
   	  	 log_message('error', "No layout exists at ".$this->get_layout_path());
		 show_error("No layout exists ".$this->get_layout_path());
		} 	 
     }
     else
     {
     	$this->CI->load->view($view_file_name,$this->_template_var);
     } 	   
   }
   
   private function _set_view_path($path)
   {
   	 $path = trim($path,'/').'/';
   	 $this->CI->load->_ci_view_path = $path;
   }
   
   public function get_view_path()
   {
   	 return  $this->CI->load->_ci_view_path;
   }
	
	public function __toString()
	{
		return 'i am from '.__FILE__;
	}
}

?>