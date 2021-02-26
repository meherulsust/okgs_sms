<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Authentication user table
|--------------------------------------------------------------------------
|
|
| Table name from where user will be selected to authenticate
| id, useranme, passwd is mandatory field for authentication
*/
  $config['auth_table'] = 'teacher st';
  
/*
|--------------------------------------------------------------------------
| Authentication user group/role/responsibility table and relation
|--------------------------------------------------------------------------
|
|
| Table name where user goup is defined and there will be a one to
| many relation with the user table.
*/
  $config['auth_group_table'] = 'designation d';
  $config['auth_goup_relation'] = 'designation_id = d.id';
  
/*
|--------------------------------------------------------------------------
| Login information available in auth
|--------------------------------------------------------------------------
|
| Login information available to display in auth
| 
*/
  $config['auth_display_fields'] = 'st.id id,username,name as full_name,email,mobile_no';
 

/*
|--------------------------------------------------------------------------
| Authentication session variable mapping
|--------------------------------------------------------------------------
|
|
|this will be set as session session variables and auth table column mapping
|in case of successful login.  
*/
  $config['auth_session_vars'] = array('user_id'=>'id','username'=>'username');
  

  /*
   * DB table fields which will be used to authenticate the user. 
   */
  $config['credential_fields'] = array('st.username','passwd','st.status'); 
  
?>